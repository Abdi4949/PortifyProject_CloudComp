<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Template;
use Symfony\Component\HttpFoundation\Response;

class CheckPremiumAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ambil ID template dari request (misal: ?template_id=5)
        $templateId = $request->query('template_id') ?? $request->route('template');
        
        if ($templateId) {
            $template = Template::find($templateId);

            // 2. Logic Proteksi
            // Jika Template PRO DAN User TIDAK Subscription
            if ($template && $template->type === 'pro' && !auth()->user()->subscription_status) {
                // Redirect ke halaman upgrade dengan pesan error
                return redirect()->route('upgrade.index')
                    ->with('error', 'This is a PRO template. Please upgrade to access it.');
            }
        }

        return $next($request);
    }
}