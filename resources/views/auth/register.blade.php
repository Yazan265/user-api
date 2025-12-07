@extends('layouts.app')

@section('title', 'تسجيل حساب جديد')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i> إنشاء حساب جديد
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i> الاسم الكامل
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">يجب أن يكون بين 2 و 100 حرف</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i> البريد الإلكتروني
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
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
                                <div id="passwordRequirements" class="mt-2">
                                    <small class="text-muted">متطلبات كلمة المرور:</small>
                                    <ul class="list-unstyled mb-0" style="font-size: 0.8rem;">
                                        <li id="reqLength" class="text-danger">
                                            <i class="fas fa-times me-1"></i> 8 أحرف على الأقل
                                        </li>
                                        <li id="reqUpper" class="text-danger">
                                            <i class="fas fa-times me-1"></i> حرف كبير واحد على الأقل
                                        </li>
                                        <li id="reqLower" class="text-danger">
                                            <i class="fas fa-times me-1"></i> حرف صغير واحد على الأقل
                                        </li>
                                        <li id="reqNumber" class="text-danger">
                                            <i class="fas fa-times me-1"></i> رقم واحد على الأقل
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i> تأكيد كلمة المرور
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="password_confirmation" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="passwordMatch" class="mt-2">
                                    <small id="matchText" class="text-danger">
                                        <i class="fas fa-times me-1"></i> كلمات المرور غير متطابقة
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag me-1"></i> الدور
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">لأغراض الاختبار فقط، في الإنتاج سيتم تعيين المستخدمين الجدد كـ "مستخدم عادي"</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror"
                                   id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                أوافق على <a href="#" class="text-decoration-none">الشروط والأحكام</a> و <a href="#" class="text-decoration-none">سياسة الخصوصية</a>
                            </label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i> إنشاء حساب
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-center">
                    <p class="mb-0">
                        لديك حساب بالفعل؟
                        <a href="{{ route('login') }}" class="text-decoration-none">سجل الدخول الآن</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .requirement-met {
        color: #28a745 !important;
    }

    .requirement-not-met {
        color: #dc3545 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        const passwordInput = $('#password');
        const confirmPasswordInput = $('#password_confirmation');
        const requirements = {
            length: $('#reqLength'),
            upper: $('#reqUpper'),
            lower: $('#reqLower'),
            number: $('#reqNumber')
        };
        const matchText = $('#matchText');

        function checkPasswordRequirements() {
            const password = passwordInput.val();

            // التحقق من الطول
            if (password.length >= 8) {
                requirements.length.removeClass('requirement-not-met').addClass('requirement-met')
                    .find('i').removeClass('fa-times').addClass('fa-check');
            } else {
                requirements.length.removeClass('requirement-met').addClass('requirement-not-met')
                    .find('i').removeClass('fa-check').addClass('fa-times');
            }

            // التحقق من الحرف الكبير
            if (/[A-Z]/.test(password)) {
                requirements.upper.removeClass('requirement-not-met').addClass('requirement-met')
                    .find('i').removeClass('fa-times').addClass('fa-check');
            } else {
                requirements.upper.removeClass('requirement-met').addClass('requirement-not-met')
                    .find('i').removeClass('fa-check').addClass('fa-times');
            }

            // التحقق من الحرف الصغير
            if (/[a-z]/.test(password)) {
                requirements.lower.removeClass('requirement-not-met').addClass('requirement-met')
                    .find('i').removeClass('fa-times').addClass('fa-check');
            } else {
                requirements.lower.removeClass('requirement-met').addClass('requirement-not-met')
                    .find('i').removeClass('fa-check').addClass('fa-times');
            }

            // التحقق من الأرقام
            if (/[0-9]/.test(password)) {
                requirements.number.removeClass('requirement-not-met').addClass('requirement-met')
                    .find('i').removeClass('fa-times').addClass('fa-check');
            } else {
                requirements.number.removeClass('requirement-met').addClass('requirement-not-met')
                    .find('i').removeClass('fa-check').addClass('fa-times');
            }

            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const password = passwordInput.val();
            const confirmPassword = confirmPasswordInput.val();

            if (password && confirmPassword) {
                if (password === confirmPassword) {
                    matchText.removeClass('text-danger').addClass('text-success')
                        .find('i').removeClass('fa-times').addClass('fa-check')
                        .end().text(' كلمات المرور متطابقة');
                } else {
                    matchText.removeClass('text-success').addClass('text-danger')
                        .find('i').removeClass('fa-check').addClass('fa-times')
                        .end().text(' كلمات المرور غير متطابقة');
                }
            }
        }

        passwordInput.on('input', checkPasswordRequirements);
        confirmPasswordInput.on('input', checkPasswordMatch);

        $('#registerForm').on('submit', function(e) {
            const name = $('#name').val();
            const email = $('#email').val();
            const password = $('#password').val();
            const confirmPassword = $('#password_confirmation').val();
            const terms = $('#terms').is(':checked');

            // التحقق من جميع الحقول
            if (!name || !email || !password || !confirmPassword) {
                e.preventDefault();
                alert('يرجى ملء جميع الحقول المطلوبة');
                return false;
            }

            // التحقق من صحة البريد الإلكتروني
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('يرجى إدخال بريد إلكتروني صحيح');
                return false;
            }

            // التحقق من توافق كلمات المرور
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('كلمات المرور غير متطابقة');
                return false;
            }

            // التحقق من متطلبات كلمة المرور
            const hasLength = password.length >= 8;
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);

            if (!hasLength || !hasUpper || !hasLower || !hasNumber) {
                e.preventDefault();
                alert('كلمة المرور لا تستوفي جميع المتطلبات');
                return false;
            }

            // التحقق من قبول الشروط
            if (!terms) {
                e.preventDefault();
                alert('يجب الموافقة على الشروط والأحكام');
                return false;
            }

            return true;
        });
    });
</script>
@endpush
@endsection
