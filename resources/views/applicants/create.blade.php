@extends('layouts.app')

@section('title', 'استمارة تقديم طلب توظيف')

@push('styles')
<style>
    /* Google-Forms Inspired Modern Card Sectioning */
    .form-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Top Hero Header Card */
    .hero-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
        position: relative;
    }

    .hero-top-strip {
        height: 10px;
        background: linear-gradient(90deg, var(--brand-primary), #10b981, #d97706);
    }

    .hero-body {
        padding: 2rem 2.25rem;
    }

    .hero-title {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .hero-desc {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .required-notice {
        margin-top: 1.25rem;
        padding: 0.65rem 1rem;
        background-color: #fffbeb;
        border-right: 4px solid #f59e0b;
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Form Section Cards */
    .section-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 1.75rem 2.25rem;
        box-shadow: var(--shadow-card);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .section-card:focus-within {
        border-color: var(--border-focus);
        box-shadow: var(--shadow-hover);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px dashed var(--border-color);
    }

    .section-number {
        width: 32px;
        height: 32px;
        background-color: var(--brand-primary-light);
        color: var(--brand-primary);
        font-weight: 700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--brand-primary);
    }

    /* Form Fields & Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .field-label {
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .field-label .required-star {
        color: #dc2626;
        font-size: 0.9rem;
    }

    .field-hint {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .input-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        background-color: var(--bg-subtle);
        color: var(--text-main);
        transition: all 0.2s ease;
        outline: none;
    }

    .input-control:focus {
        background-color: #ffffff;
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(14, 91, 68, 0.12);
    }

    .input-control.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .error-feedback {
        font-size: 0.82rem;
        color: #dc2626;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 2px;
    }

    /* Gender Custom Radio Pills */
    .radio-pills {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .radio-pill-label {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0.75rem 1rem;
        background-color: var(--bg-subtle);
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-md);
        cursor: pointer;
        font-weight: 600;
        color: var(--text-secondary);
        transition: all 0.2s ease;
    }

    .radio-pill-label input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .radio-pill-label:hover {
        border-color: #cbd5e1;
        background-color: #ffffff;
    }

    .radio-pill-label.active,
    .radio-pill-label input[type="radio"]:checked + span {
        color: var(--brand-primary);
    }

    .radio-pill-label:has(input[type="radio"]:checked) {
        background-color: var(--brand-primary-light);
        border-color: var(--brand-primary);
        color: var(--brand-primary);
        box-shadow: 0 2px 8px rgba(14, 91, 68, 0.1);
    }

    /* Custom Interactive File Upload Box */
    .file-dropzone {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-lg);
        background-color: var(--bg-subtle);
        padding: 1.75rem 1.5rem;
        text-align: center;
        cursor: pointer;
        position: relative;
        transition: all 0.25s ease;
    }

    .file-dropzone:hover {
        border-color: var(--brand-primary);
        background-color: #ffffff;
    }

    .file-dropzone.dragover {
        border-color: var(--border-focus);
        background-color: var(--brand-primary-light);
    }

    .file-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 5;
    }

    .file-icon {
        font-size: 2.2rem;
        color: var(--brand-primary);
        margin-bottom: 0.6rem;
    }

    .file-main-text {
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-main);
        margin-bottom: 0.2rem;
    }

    .file-sub-text {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .file-preview-card {
        display: none;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: var(--radius-md);
        margin-top: 0.75rem;
        font-size: 0.85rem;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #065f46;
        font-weight: 600;
    }

    .file-name {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .file-size {
        font-size: 0.75rem;
        color: #047857;
    }

    /* Submit Section */
    .submit-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        padding: 1.5rem 2.25rem;
        box-shadow: var(--shadow-card);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--brand-primary), #15803d);
        color: #ffffff;
        border: none;
        padding: 0.9rem 2.5rem;
        border-radius: var(--radius-md);
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(14, 91, 68, 0.25);
        transition: all 0.25s ease;
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, var(--brand-primary-hover), #166534);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(14, 91, 68, 0.35);
    }

    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .terms-text {
        font-size: 0.82rem;
        color: var(--text-muted);
        max-width: 400px;
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
        .hero-body, .section-card, .submit-card {
            padding: 1.5rem 1.25rem;
        }
        .submit-card {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        .submit-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<form action="{{ route('applicant.store') }}" method="POST" enctype="multipart/form-data" id="employmentForm" class="form-container">
    @csrf

    <!-- Hero / Title Card -->
    <div class="hero-card">
        <div class="hero-top-strip"></div>
        <div class="hero-body">
            <h1 class="hero-title">
                <i class="fa-solid fa-file-signature text-emerald-700"></i>
                استمارة التقديم على الوظائف
            </h1>
            <p class="hero-desc">
                يسعدنا اهتمامك بالانضمام إلى فريق عملنا المتميز. يرجى تعبئة كافة الحقول المطلوبة وإرفاق المستندات بدقة ليتسنى لفريق الموارد البشرية مراجعة طلبكم والتواصل معكم.
            </p>
            <div class="required-notice">
                <i class="fa-solid fa-circle-info"></i>
                <span>الحقول الموسومة بعلامة النجمة الحمراء (<strong class="text-red-600">*</strong>) إلزامية ويجب إكمالها.</span>
            </div>
        </div>
    </div>

    <!-- Section 1: Personal Info -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">١</div>
            <h2 class="section-title">المعلومات الشخصية والأساسية</h2>
        </div>

        <div class="form-grid">
            <!-- Full Name -->
            <div class="form-group full-width">
                <label for="full_name" class="field-label">
                    الاسم الكامل (ثلاثي أو رباعي) <span class="required-star">*</span>
                </label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       value="{{ old('full_name') }}" 
                       class="input-control @error('full_name') is-invalid @enderror" 
                       placeholder="مثال: محمد عبدالله الشمري" 
                       required>
                @error('full_name')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- National ID -->
            <div class="form-group">
                <label for="national_id" class="field-label">
                    رقم الهوية الوطنية / الإقامة <span class="required-star">*</span>
                </label>
                <input type="text" 
                       id="national_id" 
                       name="national_id" 
                       value="{{ old('national_id') }}" 
                       maxlength="10" 
                       pattern="[0-9]{10}"
                       class="input-control @error('national_id') is-invalid @enderror" 
                       placeholder="10 أرقام (مثال: 1089543210)" 
                       required>
                <span class="field-hint">يجب أن يتكون من 10 أرقام متصلة دون مسافات</span>
                @error('national_id')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label class="field-label">
                    الجنس <span class="required-star">*</span>
                </label>
                <div class="radio-pills">
                    <label class="radio-pill-label">
                        <input type="radio" name="gender" value="ذكر" {{ old('gender', 'ذكر') == 'ذكر' ? 'checked' : '' }} required>
                        <i class="fa-solid fa-person text-lg"></i>
                        <span>ذكر</span>
                    </label>
                    <label class="radio-pill-label">
                        <input type="radio" name="gender" value="أنثى" {{ old('gender') == 'أنثى' ? 'checked' : '' }} required>
                        <i class="fa-solid fa-person-dress text-lg"></i>
                        <span>أنثى</span>
                    </label>
                </div>
                @error('gender')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Birth Date -->
            <div class="form-group">
                <label for="birth_date" class="field-label">
                    تاريخ الميلاد <span class="required-star">*</span>
                </label>
                <input type="date" 
                       id="birth_date" 
                       name="birth_date" 
                       value="{{ old('birth_date') }}" 
                       max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                       class="input-control @error('birth_date') is-invalid @enderror" 
                       required>
                @error('birth_date')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Nationality -->
            <div class="form-group">
                <label for="nationality" class="field-label">
                    الجنسية <span class="required-star">*</span>
                </label>
                <input type="text" 
                       id="nationality" 
                       name="nationality" 
                       value="{{ old('nationality', 'سعودي') }}" 
                       class="input-control @error('nationality') is-invalid @enderror" 
                       placeholder="مثال: سعودي، مصري، أردني..." 
                       required>
                @error('nationality')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Section 2: Upload Attachments -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">٢</div>
            <h2 class="section-title">المستندات والمرفقات الرسمية</h2>
        </div>

        <div class="form-grid">
            <!-- CV Upload (PDF only) -->
            <div class="form-group">
                <label class="field-label">
                    السيرة الذاتية (CV) <span class="required-star">*</span>
                </label>
                <div class="file-dropzone @error('cv_path') is-invalid @enderror" id="cvDropzone">
                    <input type="file" 
                           id="cv_path" 
                           name="cv_path" 
                           accept=".pdf" 
                           required 
                           onchange="handleFileSelect(this, 'cvPreview', 'cvName', 'cvSize')">
                    <div class="file-icon">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <div class="file-main-text">اضغط لرفع ملف السيرة الذاتية أو اسحبه هنا</div>
                    <div class="file-sub-text">صيغة PDF فقط — الحد الأقصى 5 ميجابايت</div>
                </div>
                <!-- File Selection Preview -->
                <div class="file-preview-card" id="cvPreview">
                    <div class="file-info">
                        <i class="fa-solid fa-check-circle text-emerald-600"></i>
                        <span class="file-name" id="cvName"></span>
                    </div>
                    <span class="file-size" id="cvSize"></span>
                </div>
                @error('cv_path')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- National ID Document Upload -->
            <div class="form-group">
                <label class="field-label">
                    مستند الهوية الوطنية / الإقامة <span class="required-star">*</span>
                </label>
                <div class="file-dropzone @error('id_path') is-invalid @enderror" id="idDropzone">
                    <input type="file" 
                           id="id_path" 
                           name="id_path" 
                           accept=".pdf,image/png,image/jpeg,image/jpg" 
                           required 
                           onchange="handleFileSelect(this, 'idPreview', 'idName', 'idSize')">
                    <div class="file-icon">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div class="file-main-text">اضغط لرفع صورة/مستند الهوية أو اسحبه هنا</div>
                    <div class="file-sub-text">صيغ PDF أو صور (JPG, PNG) — الحد الأقصى 5 ميجابايت</div>
                </div>
                <!-- File Selection Preview -->
                <div class="file-preview-card" id="idPreview">
                    <div class="file-info">
                        <i class="fa-solid fa-check-circle text-emerald-600"></i>
                        <span class="file-name" id="idName"></span>
                    </div>
                    <span class="file-size" id="idSize"></span>
                </div>
                @error('id_path')
                    <div class="error-feedback">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Submit Section -->
    <div class="submit-card">
        <div class="terms-text">
            <i class="fa-solid fa-lock text-emerald-700 ml-1"></i>
            بالضغط على إرسال الطلب، فإنك تؤكد صحة البيانات المدخلة وموافقتك على سياسة معالجة بيانات التوظيف.
        </div>
        <button type="submit" class="submit-btn" id="submitBtn">
            <i class="fa-regular fa-paper-plane"></i>
            <span>إرسال طلب التوظيف</span>
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Live File Preview Helper
    function handleFileSelect(input, previewId, nameId, sizeId) {
        const preview = document.getElementById(previewId);
        const nameEl = document.getElementById(nameId);
        const sizeEl = document.getElementById(sizeId);

        if (input.files && input.files[0]) {
            const file = input.files[0];
            nameEl.textContent = file.name;
            
            // Format size
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
            sizeEl.textContent = sizeInMB + ' MB';
            
            preview.style.display = 'flex';
        } else {
            preview.style.display = 'none';
        }
    }

    // Drag and drop visuals
    ['cvDropzone', 'idDropzone'].forEach(id => {
        const dropzone = document.getElementById(id);
        if (dropzone) {
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => dropzone.classList.add('dragover'), false);
            });
            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, () => dropzone.classList.remove('dragover'), false);
            });
        }
    });

    // Form submission state
    document.getElementById('employmentForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>جاري إرسال الطلب...</span>';
    });
</script>
@endpush
