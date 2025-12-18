<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Template;
use App\Models\UserPortfolio;
use App\Models\Transaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_users' => User::count(),
            'free_users' => User::where('subscription_type', 'free')->count(),
            'pro_users' => User::where('subscription_type', 'pro')->count(),
            'total_portfolios' => UserPortfolio::count(),
            'total_templates' => Template::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('status', 'success')->sum('total_amount'),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
        ];
        
        // Recent Users
        $recentUsers = User::latest()->take(5)->get();
        
        // Recent Transactions
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Activity Logs (Export Attempts & Limit Reached)
        $exportLogs = ActivityLog::whereIn('type', ['export_limit_reached', 'premium_template_attempt'])
            ->with('user')
            ->latest()
            ->take(10)
            ->get();
        
        // Chart Data: Users Growth (Last 7 days)
        $usersGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentTransactions',
            'exportLogs',
            'usersGrowth'
        ));
    }
}