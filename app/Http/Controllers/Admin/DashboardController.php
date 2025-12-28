<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Template;
use App\Models\UserPortfolio;
use App\Models\Transaction;
use App\Models\ActivityLog;
use App\Models\Visit; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; 

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            
            // FIX 1: User dicek berdasarkan kolom 'account_type' (sesuai screenshot tabel users)
            'free_users' => User::where('account_type', 'free')->count(),
            'pro_users' => User::where('account_type', 'pro')->count(),

            'total_portfolios' => UserPortfolio::count(),
            
            // FIX 2: Template dicek berdasarkan kolom 'is_published' bernilai 1 (sesuai screenshot tabel templates)
            'total_templates' => Template::where('is_published', 1)->count(),
            
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('status', 'success')->sum('total_amount'),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
        ];
        
        $recentUsers = User::latest()->take(5)->get();
        
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        $exportLogs = ActivityLog::whereIn('type', ['export_limit_reached', 'premium_template_attempt'])
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        // Chart Kunjungan (Tetap menggunakan perbaikan DATE)
        $startDate = Carbon::now()->subDays(7)->startOfDay();

        $visits = Visit::select(
                DB::raw('DATE(visit_date) as date'), 
                DB::raw('count(*) as count')
            )
            ->where('visit_date', '>=', $startDate)
            ->groupBy(DB::raw('DATE(visit_date)')) 
            ->orderBy('date', 'ASC')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayDate = Carbon::now()->subDays($i)->format('d M'); 
            
            $found = $visits->firstWhere('date', $date);

            $labels[] = $displayDate;           
            $data[] = $found ? $found->count : 0; 
        }
        
        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentTransactions',
            'exportLogs',
            'labels', 
            'data'    
        ));
    }
}