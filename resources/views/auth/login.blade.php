@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> البريد الإلكتروني
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> كلمة المرور
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">تذكرني</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> تسجيل الدخول
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="#" class="text-decoration-none">نسيت كلمة المرور؟</a>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <p class="mb-0">
                        ليس لديك حساب؟
                        <a href="{{ route('register') }}" class="text-decoration-none">سجل الآن</a>
                    </p>
                </div>
            </div>

            <!-- معلومات الحسابات التجريبية -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i> معلومات الحسابات التجريبية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>مدير النظام:</strong></p>
                            <p class="mb-1">البريد: admin@example.com</p>
                            <p class="mb-0">كلمة المرور: Admin@123</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>مستخدم عادي:</strong></p>
                            <p class="mb-1">البريد: user@example.com</p>
                            <p class="mb-0">كلمة المرور: User@123</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            const email = $('#email').val();
            const password = $('#password').val();

            // تحقق بسيط من صحة البيانات
            if (!email || !password) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }

            // تحقق من صحة البريد الإلكتروني
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('يرجى إدخال بريد إلكتروني صحيح');
                return false;
            }

            return true;
        });
    });
</script>
@endpush
@endsection
