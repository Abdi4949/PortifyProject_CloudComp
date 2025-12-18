<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by subscription
        if ($request->has('subscription') && $request->subscription !== 'all') {
            $query->where('subscription_type', $request->subscription);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Order
        $query->latest();
        
        $users = $query->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::with(['portfolios', 'transactions', 'activityLogs'])
            ->findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Show edit form
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'subscription_type' => 'required|in:free,pro',
            'status' => 'required|in:active,suspended',
        ]);
        
        $user->update($validated);
        
        // Log admin action
        ActivityLog::logAdminAction(
            auth()->user(),
            'user_updated',
            "Admin updated user: {$user->name}",
            ['user_id' => $user->id]
        );
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }
    
    /**
     * Suspend user
     */
    public function suspend(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'suspend_reason' => 'required|string|max:500'
        ]);
        
        $user->update([
            'status' => 'suspended',
            'suspend_reason' => $validated['suspend_reason']
        ]);
        
        // Log admin action
        ActivityLog::logAdminAction(
            auth()->user(),
            'user_suspended',
            "Admin suspended user: {$user->name}",
            ['user_id' => $user->id, 'reason' => $validated['suspend_reason']]
        );
        
        return redirect()
            ->back()
            ->with('success', 'User suspended successfully!');
    }
    
    /**
     * Activate user
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        
        $user->update([
            'status' => 'active',
            'suspend_reason' => null
        ]);
        
        // Log admin action
        ActivityLog::logAdminAction(
            auth()->user(),
            'user_activated',
            "Admin activated user: {$user->name}",
            ['user_id' => $user->id]
        );
        
        return redirect()
            ->back()
            ->with('success', 'User activated successfully!');
    }
    
    /**
     * Upgrade user to Pro (Manual)
     */
    public function upgradeToPro(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'duration_months' => 'required|integer|min:1|max:12'
        ]);
        
        $user->update([
            'subscription_type' => 'pro',
            'subscription_started_at' => now(),
            'subscription_expired_at' => now()->addMonths($validated['duration_months'])
        ]);
        
        // Log admin action
        ActivityLog::logAdminAction(
            auth()->user(),
            'user_upgraded_manually',
            "Admin upgraded user to Pro: {$user->name}",
            ['user_id' => $user->id, 'duration' => $validated['duration_months']]
        );
        
        return redirect()
            ->back()
            ->with('success', "User upgraded to Pro for {$validated['duration_months']} months!");
    }
    
    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting admin
        if ($user->isAdmin()) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete admin user!');
        }
        
        $userName = $user->name;
        $user->delete();
        
        // Log admin action
        ActivityLog::logAdminAction(
            auth()->user(),
            'user_deleted',
            "Admin deleted user: {$userName}",
            ['user_id' => $id]
        );
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}