@extends('layouts.app')

@section('title', 'لوحة تحكم إدارة طلبات التوظيف')
@section('container_class', 'container-wide')

@push('styles')
<style>
    /* Admin Dashboard Custom Styles */
    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .dash-title-group h1 {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dash-title-group p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-top: 2px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-muted);
    }

    .stat-value {
        font-size: 1.85rem;
        font-weight: 700;
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .stat-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .icon-total { background-color: var(--brand-primary-light); color: var(--brand-primary); }
    .icon-new { background-color: var(--status-new-bg); color: var(--status-new-text); }
    .icon-review { background-color: var(--status-review-bg); color: var(--status-review-text); }
    .icon-accepted { background-color: var(--status-accept-bg); color: var(--status-accept-text); }
    .icon-rejected { background-color: var(--status-reject-bg); color: var(--status-reject-text); }

    /* Filter Toolbar Card */
    .filter-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        box-shadow: var(--shadow-card);
        margin-bottom: 1.75rem;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 1rem;
        align-items: center;
    }

    .filter-input-wrap {
        position: relative;
    }

    .filter-input-wrap i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
    }

    .filter-input {
        width: 100%;
        padding: 0.65rem 2.4rem 0.65rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        background-color: var(--bg-subtle);
        outline: none;
        transition: all 0.2s;
    }

    .filter-input:focus {
        border-color: var(--brand-primary);
        background-color: #ffffff;
    }

    .filter-select {
        width: 100%;
        padding: 0.65rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 0.9rem;
        background-color: var(--bg-subtle);
        outline: none;
        cursor: pointer;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        padding: 0.65rem 1.25rem;
        background-color: var(--brand-primary);
        color: #ffffff;
        border: none;
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    .btn-filter:hover {
        background-color: var(--brand-primary-hover);
    }

    .btn-reset {
        padding: 0.65rem 1rem;
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-reset:hover {
        background-color: #e2e8f0;
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: right;
    }

    .custom-table thead {
        background-color: #f8faf9;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table th {
        padding: 1rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-secondary);
        white-space: nowrap;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid #edf2ef;
        transition: background-color 0.15s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #f6faf8;
    }

    .custom-table td {
        padding: 1.1rem 1.25rem;
        font-size: 0.9rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Applicant Profile Cell */
    .applicant-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-initials {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, var(--brand-primary), #059669);
        color: #ffffff;
        font-weight: 700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .applicant-name {
        font-weight: 700;
        color: var(--text-main);
    }

    .applicant-sub {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .id-tag {
        font-family: 'Plus Jakarta Sans', monospace;
        font-weight: 600;
        background-color: #f1f5f9;
        padding: 0.2rem 0.6rem;
        border-radius: var(--radius-sm);
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    /* Attachment Buttons */
    .file-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.4rem 0.8rem;
        border-radius: var(--radius-sm);
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .file-btn-cv {
        background-color: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }
    .file-btn-cv:hover {
        background-color: #fee2e2;
    }

    .file-btn-id {
        background-color: #f0fdf4;
        color: #15803d;
        border-color: #bbf7d0;
    }
    .file-btn-id:hover {
        background-color: #dcfce7;
    }

    /* Actions */
    .table-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-action-sm {
        padding: 0.45rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.82rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }

    .btn-manage {
        background-color: var(--brand-primary-light);
        color: var(--brand-primary);
    }
    .btn-manage:hover {
        background-color: #d0e8e0;
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .btn-delete:hover {
        background-color: #fca5a5;
    }

    /* Pagination */
    .pagination-box {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Modal Backdrop and Box */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(19, 39, 34, 0.6);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
        padding: 1rem;
    }

    .modal-backdrop.active {
        display: flex;
    }

    .modal-box {
        background: #ffffff;
        border-radius: var(--radius-xl);
        width: 100%;
        max-width: 650px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: modalIn 0.25s ease;
    }

    .modal-header {
        padding: 1.25rem 1.75rem;
        background: #f8faf9;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .modal-close {
        background: transparent;
        border: none;
        font-size: 1.25rem;
        color: var(--text-muted);
        cursor: pointer;
        padding: 4px;
    }

    .modal-body {
        padding: 1.75rem;
        max-height: 80vh;
        overflow-y: auto;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
        background-color: var(--bg-subtle);
        padding: 1.25rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .detail-item-full {
        grid-column: span 2;
    }

    .detail-k {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 600;
    }

    .detail-v {
        font-size: 0.95rem;
        color: var(--text-main);
        font-weight: 700;
    }

    .status-update-box {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 1.25rem;
    }

    .modal-footer {
        padding: 1rem 1.75rem;
        background: #f8faf9;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-icon {
        font-size: 3.5rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.4rem;
    }

    .empty-text {
        font-size: 0.9rem;
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto 1.5rem auto;
    }

    @keyframes modalIn {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 768px) {
        .filter-form {
            grid-template-columns: 1fr;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <div class="dash-title-group">
        <h1>
            <i class="fa-solid fa-layer-group text-emerald-800"></i>
            لوحة إدارة طلبات التوظيف
        </h1>
        <p>متابعة واستعراض كافة المتقدمين، مراجعة ملفات السير الذاتية، وتحديث حالات القبول والرفض.</p>
    </div>
    <a href="{{ route('applicant.create') }}" class="btn-filter" target="_blank">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        فتح نموذج التقديم العام
    </a>
</div>

<!-- Stats Counter Metrics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">إجمالي الطلبات</span>
            <span class="stat-value">{{ number_format($stats['total']) }}</span>
        </div>
        <div class="stat-icon-wrap icon-total">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">طلبات جديدة</span>
            <span class="stat-value">{{ number_format($stats['new']) }}</span>
        </div>
        <div class="stat-icon-wrap icon-new">
            <i class="fa-solid fa-sparkles"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">قيد المراجعة</span>
            <span class="stat-value">{{ number_format($stats['review']) }}</span>
        </div>
        <div class="stat-icon-wrap icon-review">
            <i class="fa-solid fa-clock"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">المقبولين</span>
            <span class="stat-value">{{ number_format($stats['accepted']) }}</span>
        </div>
        <div class="stat-icon-wrap icon-accepted">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-label">المرفوضين</span>
            <span class="stat-value">{{ number_format($stats['rejected']) }}</span>
        </div>
        <div class="stat-icon-wrap icon-rejected">
            <i class="fa-solid fa-circle-xmark"></i>
        </div>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="filter-card">
    <form action="{{ route('admin.dashboard') }}" method="GET" class="filter-form">
        <div class="filter-input-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   class="filter-input" 
                   placeholder="البحث بالاسم الكامل، رقم الهوية، أو الجنسية...">
        </div>

        <select name="status" class="filter-select">
            <option value="">جميع الحالات</option>
            <option value="جديد" {{ request('status') == 'جديد' ? 'selected' : '' }}>جديد</option>
            <option value="قيد المراجعة" {{ request('status') == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة</option>
            <option value="مقبول" {{ request('status') == 'مقبول' ? 'selected' : '' }}>مقبول</option>
            <option value="مرفوض" {{ request('status') == 'مرفوض' ? 'selected' : '' }}>مرفوض</option>
        </select>

        <select name="gender" class="filter-select">
            <option value="">كافة الأجناس</option>
            <option value="ذكر" {{ request('gender') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
            <option value="أنثى" {{ request('gender') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
        </select>

        <div class="filter-actions">
            <button type="submit" class="btn-filter">
                <i class="fa-solid fa-filter"></i>
                تصفية
            </button>
            @if(request()->hasAny(['search', 'status', 'gender']))
                <a href="{{ route('admin.dashboard') }}" class="btn-reset" title="إعادة تعيين">
                    <i class="fa-solid fa-rotate-right"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Applicants Table Card -->
<div class="table-card">
    @if($applicants->count() > 0)
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>بيانات المتقدم</th>
                        <th>رقم الهوية</th>
                        <th>الجنس والسن</th>
                        <th>الجنسية</th>
                        <th>الحالة</th>
                        <th>الملفات المرفقة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicants as $applicant)
                        <tr>
                            <td>
                                <span class="id-tag">#{{ $applicant->id }}</span>
                            </td>
                            <td>
                                <div class="applicant-cell">
                                    <div class="avatar-initials">
                                        {{ mb_substr($applicant->full_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="applicant-name">{{ $applicant->full_name }}</div>
                                        <div class="applicant-sub">
                                            <i class="fa-regular fa-calendar-days text-xs ml-1"></i>
                                            {{ $applicant->created_at->format('Y/m/d H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="id-tag">{{ $applicant->national_id }}</span>
                            </td>
                            <td>
                                <div>
                                    <span class="font-semibold">{{ $applicant->gender }}</span>
                                    <span class="text-xs text-gray-500 block">
                                        {{ $applicant->birth_date ? $applicant->birth_date->format('Y-m-d') : '-' }} 
                                        @if($applicant->birth_date)
                                            ({{ \Carbon\Carbon::parse($applicant->birth_date)->age }} سنة)
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span>{{ $applicant->nationality }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $applicant->status_badge_class }}">
                                    <i class="fa-solid fa-circle text-xs"></i>
                                    {{ $applicant->status }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                    <a href="{{ route('admin.applicants.cv', $applicant->id) }}" class="file-btn file-btn-cv" target="_blank" title="تحميل السيرة الذاتية">
                                        <i class="fa-solid fa-file-pdf"></i>
                                        السيرة الذاتية
                                    </a>
                                    <a href="{{ route('admin.applicants.id_doc', $applicant->id) }}" class="file-btn file-btn-id" target="_blank" title="معاينة مستند الهوية">
                                        <i class="fa-solid fa-id-card"></i>
                                        الهوية
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <button type="button" 
                                            class="btn-action-sm btn-manage" 
                                            onclick='openManageModal(@json($applicant), "{{ route('admin.applicants.update_status', $applicant->id) }}")'>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        إدارة الطلب
                                    </button>

                                    <form action="{{ route('admin.applicants.destroy', $applicant->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف طلب المتقدم {{ $applicant->full_name }} نهائياً؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-sm btn-delete" title="حذف">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-box">
            <span class="text-sm text-gray-500">
                عرض {{ $applicants->firstItem() }} إلى {{ $applicants->lastItem() }} من أصل {{ $applicants->total() }} طلب
            </span>
            {{ $applicants->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fa-regular fa-folder-open"></i>
            </div>
            <h3 class="empty-title">لا توجد طلبات تقديم مطابقة</h3>
            <p class="empty-text">لم يتم العثور على أي طلبات توظيف مسجلة حالياً وفقاً لمعايير البحث المحددة.</p>
            <a href="{{ route('applicant.create') }}" class="btn-filter" target="_blank">
                <i class="fa-solid fa-plus"></i>
                إضافة طلب تجريبي الآن
            </a>
        </div>
    @endif
</div>

<!-- Manage / Details Modal -->
<div class="modal-backdrop" id="manageModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title" id="modalApplicantName">تفاصيل طلب المتقدم</h3>
            <button type="button" class="modal-close" onclick="closeManageModal()">&times;</button>
        </div>

        <form id="modalUpdateForm" method="POST">
            @csrf
            @method('PATCH')

            <div class="modal-body">
                <!-- Details Grid -->
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-k">الاسم الكامل:</span>
                        <span class="detail-v" id="modalFullName">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-k">رقم الهوية:</span>
                        <span class="detail-v" id="modalNationalId">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-k">الجنس:</span>
                        <span class="detail-v" id="modalGender">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-k">الجنسية:</span>
                        <span class="detail-v" id="modalNationality">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-k">تاريخ الميلاد:</span>
                        <span class="detail-v" id="modalBirthDate">-</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-k">تاريخ التقديم:</span>
                        <span class="detail-v" id="modalCreatedAt">-</span>
                    </div>
                    <div class="detail-item detail-item-full" style="margin-top: 8px;">
                        <span class="detail-k">المستندات:</span>
                        <div style="display: flex; gap: 10px; margin-top: 6px;">
                            <a id="modalCvBtn" href="#" target="_blank" class="file-btn file-btn-cv">
                                <i class="fa-solid fa-file-pdf"></i>
                                فتح ملف السيرة الذاتية (CV)
                            </a>
                            <a id="modalIdBtn" href="#" target="_blank" class="file-btn file-btn-id">
                                <i class="fa-solid fa-id-card"></i>
                                فتح مستند الهوية
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Update Status & Admin Notes -->
                <div class="status-update-box">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--brand-primary); margin-bottom: 0.85rem;">
                        <i class="fa-solid fa-sliders ml-1"></i>
                        تحديث حالة الطلب والملاحظات الإدارية
                    </h4>

                    <div style="margin-bottom: 1rem;">
                        <label for="statusSelect" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px;">
                            حالة الطلب:
                        </label>
                        <select name="status" id="statusSelect" class="filter-select" style="background-color: #fff;" required>
                            <option value="جديد">جديد</option>
                            <option value="قيد المراجعة">قيد المراجعة</option>
                            <option value="مقبول">مقبول</option>
                            <option value="مرفوض">مرفوض</option>
                        </select>
                    </div>

                    <div>
                        <label for="adminNotes" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px;">
                            ملاحظات داخلية للإدارة (اختياري):
                        </label>
                        <textarea name="admin_notes" 
                                  id="adminNotes" 
                                  rows="3" 
                                  class="input-control" 
                                  style="resize: vertical; font-size: 0.88rem;" 
                                  placeholder="سجل أي ملاحظات أو نتائج مقابلة هنا..."></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-reset" onclick="closeManageModal()">إلغاء</button>
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-floppy-disk"></i>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openManageModal(applicant, updateRoute) {
        document.getElementById('modalUpdateForm').action = updateRoute;
        document.getElementById('modalApplicantName').textContent = 'إدارة طلب: ' + applicant.full_name;
        document.getElementById('modalFullName').textContent = applicant.full_name;
        document.getElementById('modalNationalId').textContent = applicant.national_id;
        document.getElementById('modalGender').textContent = applicant.gender;
        document.getElementById('modalNationality').textContent = applicant.nationality;
        document.getElementById('modalBirthDate').textContent = applicant.birth_date ? applicant.birth_date.split('T')[0] : '-';
        document.getElementById('modalCreatedAt').textContent = applicant.created_at ? applicant.created_at.replace('T', ' ').substring(0, 16) : '-';
        
        // Status & Notes
        document.getElementById('statusSelect').value = applicant.status;
        document.getElementById('adminNotes').value = applicant.admin_notes || '';

        // Attachment URLs
        document.getElementById('modalCvBtn').href = "{{ url('/admin/applicants') }}/" + applicant.id + "/cv";
        document.getElementById('modalIdBtn').href = "{{ url('/admin/applicants') }}/" + applicant.id + "/id-doc";

        // Show Modal
        document.getElementById('manageModal').classList.add('active');
    }

    function closeManageModal() {
        document.getElementById('manageModal').classList.remove('active');
    }

    // Close on backdrop click
    document.getElementById('manageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeManageModal();
        }
    });
</script>
@endpush
