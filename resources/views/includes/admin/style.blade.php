{{-- cdn datatable css --}}
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
{{-- Bootstrap CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
{{-- style css --}}
<link href="{{ url('backend/css/styles.css') }}" rel="stylesheet" />
{{-- fontawesome js --}}
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

<script src="{{ url('backend/js/dselect.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

{{-- Custom Modern Styles --}}
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --info-gradient: linear-gradient(135deg, #667eea 0%, #f093fb 100%);
        --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .bg-gradient-primary {
        background: var(--primary-gradient) !important;
    }

    .navbar {
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .navbar-brand {
        font-size: 1.4rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .nav-link {
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 0.5rem;
        margin: 0 2px;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        transform: translateY(-2px);
    }

    .nav-link.active {
        background: rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .dropdown-menu {
        border: none !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        margin-top: 0.5rem;
    }

    .dropdown-item {
        transition: all 0.3s ease;
        border-radius: 0.4rem;
        margin: 2px 8px;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateX(5px);
    }

    .dropdown-item.active {
        background: var(--primary-gradient);
        color: white;
    }

    .main-wrapper {
        min-height: calc(100vh - 80px);
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
        padding: 2rem 0;
    }

    /* Card Improvements */
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .border-left-primary {
        border-left: 5px solid var(--bs-primary) !important;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .border-left-success {
        border-left: 5px solid var(--bs-success) !important;
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);
    }

    .border-left-info {
        border-left: 5px solid var(--bs-info) !important;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
    }

    .border-left-warning {
        border-left: 5px solid var(--bs-warning) !important;
        background: linear-gradient(135deg, rgba(255, 236, 210, 0.3) 0%, rgba(252, 182, 159, 0.3) 100%);
    }

    /* Breadcrumb */
    .breadcrumb {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        padding: 1rem 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* DataTable improvements */
    .datatable-wrapper {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    /* Button improvements */
    .btn {
        font-weight: 500;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Footer */
    footer {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(0,0,0,0.05);
        margin-top: auto;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .navbar-brand {
            font-size: 1.2rem;
        }

        .main-content {
            padding: 1rem 0;
        }

        .card {
            margin-bottom: 1rem;
        }
    }

    /* Animation for page load */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease forwards;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    }
</style>
