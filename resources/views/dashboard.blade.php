@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="row">
    <!-- الشريط الجانبي -->
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4e73df&color=fff&size=200"
                     class="user-avatar mb-3" alt="صورة المستخدم">
                <h4>{{ auth()->user()->name }}</h4>
                <p class="text-muted">{{ auth()->user()->email }}</p>
                <span class="badge bg-{{ auth()->user()->role === 'admin' ? 'danger' : 'secondary' }} p-2">
                    {{ auth()->user()->role === 'admin' ? 'مدير النظام' : 'مستخدم' }}
                </span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-cog me-2"></i> الإعدادات</h6>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-user me-2"></i> الملف الشخصي
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-key me-2"></i> تغيير كلمة المرور
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-bell me-2"></i> الإشعارات
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-users me-2"></i> إدارة المستخدمين
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="col-md-9">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">المهام المكتملة</h6>
                                <h3 class="mb-0">42</h3>
                            </div>
                            <div class="bg-white-25 rounded-circle p-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">المهام قيد التنفيذ</h6>
                                <h3 class="mb-0">18</h3>
                            </div>
                            <div class="bg-white-25 rounded-circle p-3">
                                <i class="fas fa-tasks fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">المهام المعلقة</h6>
                                <h3 class="mb-0">7</h3>
                            </div>
                            <div class="bg-white-25 rounded-circle p-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-tasks me-2"></i> المهام الأخيرة</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان المهمة</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>تطوير واجهة المستخدم</td>
                                <td><span class="badge bg-success">مكتمل</span></td>
                                <td><span class="badge bg-danger">عالي</span></td>
                                <td>2024-01-15</td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>اختبار نظام المصادقة</td>
                                <td><span class="badge bg-warning">قيد التنفيذ</span></td>
                                <td><span class="badge bg-warning">متوسط</span></td>
                                <td>2024-01-14</td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>إصلاح الأخطاء</td>
                                <td><span class="badge bg-secondary">معلق</span></td>
                                <td><span class="badge bg-info">منخفض</span></td>
                                <td>2024-01-13</td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-outline-primary">عرض جميع المهام</a>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i> إحصائيات النظام</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="userStatsChart" width="400" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="taskStatsChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if(auth()->user()->role === 'admin')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // مخطط إحصائيات المستخدمين
        const userCtx = document.getElementById('userStatsChart').getContext('2d');
        new Chart(userCtx, {
            type: 'doughnut',
            data: {
                labels: ['المدراء', 'المستخدمون'],
                datasets: [{
                    data: [8, 142],
                    backgroundColor: ['#e74a3b', '#4e73df'],
                    hoverBackgroundColor: ['#d52a1a', '#2e59d9'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'توزيع المستخدمين'
                    }
                }
            }
        });

        // مخطط إحصائيات المهام
        const taskCtx = document.getElementById('taskStatsChart').getContext('2d');
        new Chart(taskCtx, {
            type: 'bar',
            data: {
                labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                datasets: [{
                    label: 'عدد المهام',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: 'rgba(78, 115, 223, 0.5)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'المهام خلال الأشهر الستة الماضية'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
@endif
@endsection
