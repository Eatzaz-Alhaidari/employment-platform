<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'بوابة التوظيف الإلكتروني')</title>

    <!-- Google Fonts: IBM Plex Sans Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            /* Bespoke Custom Color Palette (Deep Emerald & Warm Slate) */
            --brand-primary: #0e5b44;
            --brand-primary-hover: #094332;
            --brand-primary-light: #e8f4f0;
            --brand-accent: #b45309;
            --brand-accent-soft: #fef3c7;
            
            --bg-canvas: #f4f7f5;
            --bg-card: #ffffff;
            --bg-subtle: #f8faf9;
            
            --text-main: #132722;
            --text-secondary: #4a5d58;
            --text-muted: #798d87;
            
            --border-color: #e0e7e4;
            --border-focus: #10b981;
            
            /* Status Colors */
            --status-new-bg: #e0f2fe;
            --status-new-text: #0369a1;
            --status-review-bg: #fef3c7;
            --status-review-text: #b45309;
            --status-accept-bg: #dcfce7;
            --status-accept-text: #15803d;
            --status-reject-bg: #fee2e2;
            --status-reject-text: #b91c1c;

            --radius-xl: 20px;
            --radius-lg: 14px;
            --radius-md: 10px;
            --radius-sm: 6px;
            
            --shadow-subtle: 0 3px 12px rgba(14, 91, 68, 0.04);
            --shadow-card: 0 10px 30px -5px rgba(14, 91, 68, 0.07), 0 4px 10px -3px rgba(14, 91, 68, 0.03);
            --shadow-hover: 0 20px 35px -10px rgba(14, 91, 68, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'IBM Plex Sans Arabic', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }

        /* Top Navigation Bar */
        .site-header {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-subtle);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.9rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--brand-primary);
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--brand-primary), #16a34a);
            color: #ffffff;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 10px rgba(14, 91, 68, 0.25);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.2px;
            color: var(--brand-primary);
        }

        .brand-subtitle {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.55rem 1.1rem;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link-btn.primary {
            background-color: var(--brand-primary);
            color: #ffffff;
        }
        .nav-link-btn.primary:hover {
            background-color: var(--brand-primary-hover);
            transform: translateY(-1px);
        }

        .nav-link-btn.secondary {
            background-color: var(--brand-primary-light);
            color: var(--brand-primary);
        }
        .nav-link-btn.secondary:hover {
            background-color: #d8ede6;
        }

        /* Main Content Container */
        .main-wrapper {
            flex: 1;
            padding: 2.5rem 1.25rem;
        }

        .container {
            max-width: 820px;
            margin: 0 auto;
        }

        .container-wide {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Alerts & Feedback */
        .alert-box {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
        }
        .badge-new { background-color: var(--status-new-bg); color: var(--status-new-text); }
        .badge-review { background-color: var(--status-review-bg); color: var(--status-review-text); }
        .badge-accepted { background-color: var(--status-accept-bg); color: var(--status-accept-text); }
        .badge-rejected { background-color: var(--status-reject-bg); color: var(--status-reject-text); }
        .badge-default { background-color: #f1f5f9; color: #475569; }

        /* Footer */
        .site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 1.25rem;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 640px) {
            .header-container {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
            .main-wrapper {
                padding: 1.5rem 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navigation -->
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('applicant.create') }}" class="brand-logo">
                <div class="brand-icon">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-title">منظومة التوظيف الرقمية</span>
                    <span class="brand-subtitle">بوابة استقطاب الكفاءات والكوادر</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="{{ route('applicant.create') }}" class="nav-link-btn {{ request()->routeIs('applicant.create') ? 'primary' : 'secondary' }}">
                    <i class="fa-regular fa-paper-plane"></i>
                    تقديم طلب وظيفة
                </a>
                <a href="{{ route('admin.dashboard') }}" class="nav-link-btn {{ request()->routeIs('admin.*') ? 'primary' : 'secondary' }}">
                    <i class="fa-solid fa-shield-halved"></i>
                    لوحة الإدارة
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-wrapper">
        <div class="@yield('container_class', 'container')">
            @if(session('success'))
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-box alert-danger">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <p>© {{ date('Y') }} منصة التوظيف الإلكتروني — جميع الحقوق محفوظة</p>
    </footer>

    @stack('scripts')
</body>
</html>
