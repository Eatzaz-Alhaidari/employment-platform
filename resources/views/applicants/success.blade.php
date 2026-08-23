@extends('layouts.app')

@section('title', 'تم استلام طلب التوظيف بنجاح')

@push('styles')
<style>
    .success-card {
        background: #ffffff;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
        padding: 3rem 2.5rem;
        text-align: center;
        margin-top: 1rem;
    }

    .success-icon-wrap {
        width: 84px;
        height: 84px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.75rem;
        margin: 0 auto 1.5rem auto;
        box-shadow: 0 10px 25px rgba(16, 185, 129, 0.35);
        animation: scaleUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .success-title {
        font-size: 1.85rem;
        font-weight: 700;
        color: var(--brand-primary);
        margin-bottom: 0.75rem;
    }

    .success-subtitle {
        color: var(--text-secondary);
        font-size: 1.05rem;
        max-width: 540px;
        margin: 0 auto 2rem auto;
    }

    /* Summary Details Box */
    .receipt-box {
        background-color: var(--bg-subtle);
        border: 1.5px dashed var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem 2rem;
        max-width: 580px;
        margin: 0 auto 2rem auto;
        text-align: right;
    }

    .receipt-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        font-size: 0.95rem;
    }

    .receipt-row:last-child {
        border-bottom: none;
    }

    .receipt-label {
        color: var(--text-muted);
        font-weight: 500;
    }

    .receipt-value {
        color: var(--text-main);
        font-weight: 700;
    }

    .reference-badge {
        font-family: 'Plus Jakarta Sans', monospace;
        background-color: var(--brand-primary-light);
        color: var(--brand-primary);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-sm);
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Actions */
    .success-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.8rem 1.8rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-action.primary {
        background-color: var(--brand-primary);
        color: #ffffff;
    }
    .btn-action.primary:hover {
        background-color: var(--brand-primary-hover);
        transform: translateY(-2px);
    }

    .btn-action.outline {
        background-color: transparent;
        color: var(--brand-primary);
        border: 1.5px solid var(--brand-primary);
    }
    .btn-action.outline:hover {
        background-color: var(--brand-primary-light);
    }

    @keyframes scaleUp {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 640px) {
        .success-card {
            padding: 2rem 1.25rem;
        }
        .receipt-box {
            padding: 1.25rem 1rem;
        }
        .success-actions {
            flex-direction: column;
        }
        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="success-card">
    <div class="success-icon-wrap">
        <i class="fa-solid fa-check"></i>
    </div>

    <h1 class="success-title">تم استلام طلبكم بنجاح!</h1>
    <p class="success-subtitle">
        شكراً لك يا <strong>{{ $applicant->full_name }}</strong>. تم تسجيل طلبك في قاعدة بيانات التوظيف وسيتم فحصه من قبل لجنة الموارد البشرية.
    </p>

    <!-- Receipt Summary Box -->
    <div class="receipt-box">
        <div class="receipt-row">
            <span class="receipt-label">الرقم المرجعي للطلب:</span>
            <span class="receipt-value reference-badge">#APP-{{ str_pad($applicant->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">اسم المتقدم:</span>
            <span class="receipt-value">{{ $applicant->full_name }}</span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">رقم الهوية / الإقامة:</span>
            <span class="receipt-value">{{ $applicant->national_id }}</span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">الجنسية:</span>
            <span class="receipt-value">{{ $applicant->nationality }}</span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">حالة الطلب الأولية:</span>
            <span class="receipt-value">
                <span class="badge badge-new">
                    <i class="fa-solid fa-circle text-xs"></i>
                    {{ $applicant->status }}
                </span>
            </span>
        </div>
        <div class="receipt-row">
            <span class="receipt-label">تاريخ ووقت التقديم:</span>
            <span class="receipt-value">{{ $applicant->created_at->translatedFormat('Y/m/d - h:i A') }}</span>
        </div>
    </div>

    <!-- Navigation Actions -->
    <div class="success-actions">
        <a href="{{ route('applicant.create') }}" class="btn-action primary">
            <i class="fa-solid fa-plus"></i>
            تقديم طلب آخر
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn-action outline">
            <i class="fa-solid fa-gauge-high"></i>
            الانتقال للوحة التحكم (عرض العميل)
        </a>
    </div>
</div>
@endsection
