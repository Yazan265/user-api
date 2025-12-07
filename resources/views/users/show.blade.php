@extends('layouts.app')

@section('title', 'عرض المستخدم')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i> بيانات المستخدم
                    </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=fff&size=200"
                                 class="user-avatar mb-3" alt="{{ $user->name }}">
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th>الاسم الكامل</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>البريد الإلكتروني</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>الدور</th>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">
                                            {{ $user->role === 'admin' ? 'مدير' : 'مستخدم' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاريخ التسجيل</th>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ آخر تحديث</th>
                                    <td>{{ $user->updated_at->format('Y-m-d') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i> تعديل
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i> رجوع للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
