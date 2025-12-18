<?php

namespace App\Http\Controllers;

use App\Models\UserPortfolio;
use App\Models\PortfolioExport;
use App\Services\ExportLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    protected $exportLimitService;
    
    public function __construct(ExportLimitService $exportLimitService)
    {
        $this->exportLimitService = $exportLimitService;
    }
    
    /**
     * Check if user can export (API endpoint for frontend)
     */
    public function checkLimit()
    {
        $user = auth()->user();
        $limitCheck = $this->exportLimitService->canExport($user);
        
        return response()->json([
            'subscription_type' => $user->subscription_type,
            'allowed' => $limitCheck['allowed'],
            'remaining' => $limitCheck['remaining'],
            'message' => $limitCheck['message'],
            'export_count' => $user->export_count,
            'limit' => ExportLimitService::FREE_EXPORT_LIMIT
        ]);
    }
    
    /**
     * Export portfolio to PDF
     */
    public function export(Request $request, $portfolioId)
    {
        $user = auth()->user();
        $portfolio = UserPortfolio::where('id', $portfolioId)
            ->where('user_id', $user->id)
            ->with('template')
            ->firstOrFail();
        
        // 1. CHECK EXPORT LIMIT
        $limitCheck = $this->exportLimitService->canExport($user);
        
        if (!$limitCheck['allowed']) {
            return back()->with('error', $limitCheck['message']);
        }
        
        // 2. GENERATE PDF
        try {
            // For now, use a generic PDF view
            // Later, we'll create specific views per template
            $pdf = Pdf::loadView('pdf.portfolio', [
                'portfolio' => $portfolio,
                'user' => $user
            ])->setPaper('a4', 'portrait');
            
            $fileName = Str::slug($portfolio->title) . '-' . time() . '.pdf';
            
            // 3. INCREMENT COUNTER
            $this->exportLimitService->incrementExportCount($user);
            
            // 4. SAVE EXPORT HISTORY
            PortfolioExport::create([
                'user_id' => $user->id,
                'user_portfolio_id' => $portfolio->id,
                'file_name' => $fileName,
                'file_size' => strlen($pdf->output()),
                'format' => 'pdf',
                'status' => 'completed',
                'ip_address' => $request->ip()
            ]);
            
            // Update portfolio export count
            $portfolio->incrementExportCount();
            
            // 5. RETURN PDF
            return $pdf->download($fileName);
            
        } catch (\Exception $e) {
            \Log::error('Export failed', [
                'user_id' => $user->id,
                'portfolio_id' => $portfolio->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Failed to generate PDF. Please try again.');
        }
    }
    
    /**
     * Show export history
     */
    public function history()
    {
        $exports = auth()->user()->exports()
            ->with('portfolio')
            ->latest()
            ->paginate(20);
        
        return view('exports.history', compact('exports'));
    }
}