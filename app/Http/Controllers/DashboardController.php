<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        // محاكاة البيانات للإحصائيات (يمكن استبدالها ببيانات حقيقية من قاعدة البيانات)
        $stats = [
            'total_tasks' => 75,
            'completed_tasks' => 42,
            'pending_tasks' => 18,
            'overdue_tasks' => 15,
        ];

        // محاكاة بيانات المهام (يمكن استبدالها ببيانات حقيقية)
        $recent_tasks = [
            [
                'id' => 1,
                'title' => 'تطوير واجهة المستخدم',
                'status' => 'completed',
                'priority' => 'high',
                'created_at' => '2024-01-15'
            ],
            [
                'id' => 2,
                'title' => 'اختبار نظام المصادقة',
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_at' => '2024-01-14'
            ],
            [
                'id' => 3,
                'title' => 'إصلاح الأخطاء',
                'status' => 'pending',
                'priority' => 'low',
                'created_at' => '2024-01-13'
            ],
        ];

        return view('dashboard', compact('user', 'isAdmin', 'stats', 'recent_tasks'));
    }
}
