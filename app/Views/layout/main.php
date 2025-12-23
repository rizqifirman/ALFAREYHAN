<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ALFA REYHAN | MANAGEMENT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQZAdnq1NuG+IvXQEzJ/yWK9NBS9f+tZ+jF6k=" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/css/adminlte.min.css" crossorigin="anonymous">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    
    <div class="app-wrapper">

        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-flex align-items-center me-3">
                        <span class="fw-bold">
                            Halo, <?= session()->get('nama') ?> 
                            (<?= session()->get('role') ?>)
                        </span>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= base_url('/') ?>" class="brand-link">
            <span class="brand-text fw-bold">ALFA REYHAN</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center border-bottom border-secondary">
            <div class="image ms-3">
                <span class="badge rounded-circle text-bg-warning p-2">
                    <i class="bi bi-person-fill fs-5"></i>
                </span>
            </div>
            <div class="info ms-2">
                <a href="#" class="d-block text-decoration-none fw-bold text-white">
                    <?= session()->get('nama') ? session()->get('nama') : 'Guest' ?>
                </a>
                <span class="badge text-bg-secondary text-uppercase" style="font-size: 0.7rem;">
                    <?= session()->get('role') ? session()->get('role') : 'Guest' ?>
                </span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="<?= base_url('/') ?>" class="nav-link <?= (uri_string() == '/' || uri_string() == '') ? 'active bg-warning text-dark' : '' ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active bg-secondary">
                        <i class="nav-icon bi bi-collection-fill"></i>
                        <p>
                            Produksi
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="<?= base_url('workers') ?>" class="nav-link <?= (uri_string() == 'workers') ? 'active' : '' ?>">
                            <i class="nav-icon bi bi-person-badge-fill"></i>
                            <p>
                                Data Tukang
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('ongkos') ?>" class="nav-link <?= (uri_string() == 'ongkos') ? 'active' : '' ?>">
                            <i class="nav-icon bi bi-cash-coin"></i> <p>Ongkos Tukang</p>
                        </a>
                    </li>
                        <li class="nav-item">
                            <a href="<?= base_url('materials') ?>" class="nav-link <?= (str_contains(uri_string(), 'materials')) ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Material</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('products') ?>" class="nav-link <?= (str_contains(uri_string(), 'products')) ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-circle-fill"></i> <p>Data Produk & Stok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Manajemen Garapan</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>

        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">V 4.0</div>
            <strong>Copyright &copy; <?= date('Y') ?>.</strong>
        </footer>

    </div> 
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/css/adminlte.min.css">
   <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/js/adminlte.min.js"></script>

    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined") {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
</body>
</html>