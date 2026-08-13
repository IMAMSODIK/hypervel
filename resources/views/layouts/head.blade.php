<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin Dashboard Templates - Unify Admin Template</title>

    <meta name="description" content="Marketplace for Bootstrap Admin Dashboards" />
    <meta name="author" content="Bootstrap Gallery" />
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <link rel="shortcut icon" href="{{ asset('dashboard_assets/images/favicon.svg') }}" />

    <link rel="stylesheet" href="{{ asset('dashboard_assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard_assets/css/main.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('dashboard_assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('dashboard_assets/vendor/toastify/toastify.css') }}" />

    {{-- DataTables via CDN (Bootstrap 5 styling) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css" />

    {{-- SweetAlert2 untuk konfirmasi hapus --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

</head>
