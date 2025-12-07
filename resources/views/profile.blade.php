@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i> الملف الشخصي
                    </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4e73df&color=fff&size=200"
                                 class="user-avatar mb-3" alt="صورة المستخدم">
                            <button class="btn btn-outline-primary btn-sm mb-3">
                                <i class="fas fa-camera me-1"></i> تغيير الصورة
                            </button>
                        </div>

                        <div class="col-md-8">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">الاسم الكامل</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ auth()->user()->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ auth()->user()->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">الدور</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge bg-{{ auth()->user()->role === 'admin' ? 'danger' : 'secondary' }}">
                                            {{ auth()->user()->role === 'admin' ? 'مدير النظام' : 'مستخدم عادي' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">تاريخ التسجيل</label>
                                    <p class="form-control-plaintext">
                                        {{ auth()->user()->created_at->format('Y-m-d') }}
                                    </p>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- قسم تغيير كلمة المرور -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i> تغيير كلمة المرور
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i> تغيير كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
                        <div class="card mt-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-trash-alt me-2"></i> حذف الحساب
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <p class="text-danger mb-4">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>تنبيه:</strong> حذف الحساب نهائي ولا يمكن التراجع عنه
                                </p>

                                <button type="button" class="btn btn-danger btn-lg" id="deleteAccountBtn">
                                    <i class="fas fa-trash-alt me-2"></i> حذف حسابي
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal تأكيد الحذف -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteConfirmModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i> تأكيد حذف الحساب
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger mb-3">
                                <h6 class="alert-heading mb-2">هل أنت متأكد من حذف حسابك؟</h6>
                                <ul class="mb-0 ps-3">
                                    <li>سيتم حذف جميع بياناتك الشخصية</li>
                                    <li>لن تتمكن من استعادة حسابك</li>
                                    <li>سيتم تسجيل خروجك فوراً</li>
                                </ul>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="confirmDeleteCheckbox">
                                <label class="form-check-label text-danger" for="confirmDeleteCheckbox">
                                    <strong>نعم، أريد حذف حسابي نهائياً</strong>
                                </label>
                            </div>

                            <p class="text-muted small mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                اضغط على زر "نعم، أحذف حسابي" أدناه للموافقة النهائية
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i> إلغاء
                            </button>
                            <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" id="finalDeleteBtn" disabled>
                                    <i class="fas fa-trash-alt me-2"></i> نعم، أحذف حسابي
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        const deleteBtn = $('#deleteAccountBtn');
        const confirmCheckbox = $('#confirmDeleteCheckbox');
        const finalDeleteBtn = $('#finalDeleteBtn');
        const deleteForm = $('#deleteAccountForm');
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

        // فتح نافذة التأكيد
        deleteBtn.on('click', function() {
            deleteModal.show();
        });

        // تفعيل/تعطيل زر الحذف النهائي بناءً على checkbox
        confirmCheckbox.on('change', function() {
            finalDeleteBtn.prop('disabled', !$(this).is(':checked'));
        });

        // تأكيد نهائي قبل الإرسال
        deleteForm.on('submit', function(e) {
            if (!confirm('هذا هو التأكيد النهائي! هل أنت متأكد تماماً؟')) {
                e.preventDefault();
                return false;
            }
            return true;
        });

        // إعادة تعطيل checkbox عند إغلاق النافذة
        $('#deleteConfirmModal').on('hidden.bs.modal', function() {
            confirmCheckbox.prop('checked', false);
            finalDeleteBtn.prop('disabled', true);
        });
    });
</script>
@endpush
@endsection
