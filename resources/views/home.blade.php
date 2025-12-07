@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')

@section('content')
    <div class="hero-section text-center rounded-3 mb-5">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">مرحباً بك في نظام إدارة المستخدمين</h1>
            <p class="lead mb-4">نظام متكامل لإدارة المستخدمين والمهام باستخدام أحدث التقنيات</p>

            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-tachometer-alt me-2"></i> الانتقال إلى لوحة التحكم
                </a>
            @else
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="fas fa-user-plus me-2"></i> تسجيل جديد
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- الميزات -->
    <div class="container">
        <h2 class="text-center mb-5">ميزات النظام</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h4 class="card-title">المصادقة الآمنة</h4>
                        <p class="card-text">
                            نظام مصادقة متقدم باستخدام JWT لحماية بيانات المستخدمين وضمان أمن المعلومات.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4 class="card-title">إدارة المهام</h4>
                        <p class="card-text">
                            نظام متكامل لإدارة المهام مع إمكانية تتبع التقدم وإدارة الأولويات.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4 class="card-title">تقارير وإحصائيات</h4>
                        <p class="card-text">
                            لوحة تحكم متقدمة مع إحصائيات وتقارير مفصلة عن نشاط المستخدمين والأداء.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات -->
    @auth
        @if(auth()->user()->role === 'admin')
            <div class="container mt-5">
                <h2 class="text-center mb-4">الإحصائيات</h2>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4 text-primary" id="totalUsers">0</h1>
                                <p class="text-muted">إجمالي المستخدمين</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4 text-success" id="activeUsers">0</h1>
                                <p class="text-muted">المستخدمين النشطين</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4 text-warning" id="adminUsers">0</h1>
                                <p class="text-muted">المدراء</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h1 class="display-4 text-danger" id="totalTasks">0</h1>
                                <p class="text-muted">إجمالي المهام</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
            <script>
                $(document).ready(function() {
                    // محاكاة تحميل البيانات
                    setTimeout(() => {
                        $('#totalUsers').text('150');
                        $('#activeUsers').text('120');
                        $('#adminUsers').text('8');
                        $('#totalTasks').text('450');
                    }, 500);
                });
            </script>
            @endpush
        @endif
    @endauth
@endsection
