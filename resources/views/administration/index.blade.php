<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Cabinet PHAOS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-phaos.webp') }}" rel="icon">
  <link href="{{ asset('assets/img/logo-phaos.webp') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .admin-header {
            background: linear-gradient(135deg, #343a40 0%, #6c757d 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px 8px 0 0;
        }
        .admin-nav {
            background: #495057;
            padding: 1rem;
        }
        .nav-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 1px;
            text-align: center;
        }
        .nav-item_a {
            padding: 0.75rem 0.5rem;
            background: #6c757d;
            color: white;
            text-decoration: none;
            transition: background-color 0.2s;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .nav-item_a:hover {
            background: #5a6268;
            color: white;
        }
        .nav-item_a.active {
            background: #343a40;
        }
        .user-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            background: white;
        }
        .user-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .user-name {
            font-weight: 600;
            color: #495057;
        }
        .user-role {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .user-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-active {
            background: #d4edda;
            color: #155724;
        }
        .user-actions {
            display: flex;
            gap: 0.5rem;
        }
        .config-section {
            background: #f8f9fa;
            padding: 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .config-item {
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e9ecef;
        }
        .config-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .config-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.25rem;
        }
        .config-value {
            color: #6c757d;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.25rem;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .storage-bar {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        .storage-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
            border-radius: 4px;
        }
        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }





        .notifications-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 80vh; /* Hauteur limitée pour la page */
        }
        .notifications-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px 8px 0 0;
            flex-shrink: 0;
        }
        .notifications-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .notifications-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            max-height: calc(90vh - 200px); /* Hauteur calculée pour le scroll */
        }
        .period-section {
            margin-bottom: 2rem;
        }
        .period-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
            font-size: 1.1rem;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            padding: 0.5rem 0;
        }
        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            background: white;
            transition: all 0.2s;
        }
        .notification-item:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }
        .notification-item.unread {
            background: #f0f8ff;
            border-left: 4px solid #007bff;
        }
        .notification-icon {
            font-size: 1.25rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }
        .icon-validated { color: #28a745; }
        .icon-modification { color: #ffc107; }
        .icon-pending { color: #17a2b8; }
        .icon-user { color: #6f42c1; }
        .icon-finance { color: #20c997; }
        .icon-rejected { color: #dc3545; }
        .notification-content {
            flex: 1;
            min-width: 0; /* Permet le truncate du texte */
        }
        .notification-text {
            color: #495057;
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }
        .notification-time {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .notification-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        .btn-mark-read {
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0.25rem;
            border-radius: 4px;
            transition: color 0.2s;
        }
        .btn-mark-read:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
        }
        .btn-mark-all {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }
        .btn-mark-all:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        .footer-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 1.5rem;
            border-top: 1px solid #e9ecef;
            flex-shrink: 0;
            background: white;
        }
        
        /* Custom scrollbar */
        .notifications-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .notifications-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        .notifications-scroll::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        .notifications-scroll::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Styles pour le dropdown existant */
        .notification-item .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .notification-item h4 {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }
        .notification-item p {
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }
        .notification-time {
            font-size: 0.75rem;
        }
    </style>



  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= header ======= -->
    @include('page.header')

  <!-- ======= Sidebar ======= -->
   @include('layouts.sidebar')
  
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container py-4">
        <div class="admin-container">

            @include('administration.minisidebar')
             
            <div class="p-4">
                <!-- Section Gestion des Utilisateurs -->
                <div class="mb-5">
                    <h6 class="section-title">GESTION DES UTILISATEURS (24 utilisateurs actifs)</h6>
                    
                    <div class="user-list mb-3">
                        <div class="user-item">
                            <div class="user-info">
                                <div class="user-name">John Doe</div>
                                <div class="user-role">Chef de Projet</div>
                            </div>
                            <div class="user-status">
                                <span class="status-badge status-active">
                                    <i class="bi bi-circle-fill me-1"></i>Actif
                                </span>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-key me-1"></i>Reset MDP
                                </button>
                            </div>
                        </div>

                        <div class="user-item">
                            <div class="user-info">
                                <div class="user-name">Martin Dupont</div>
                                <div class="user-role">Responsable Technique</div>
                            </div>
                            <div class="user-status">
                                <span class="status-badge status-active">
                                    <i class="bi bi-circle-fill me-1"></i>Actif
                                </span>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-key me-1"></i>Reset
                                </button>
                            </div>
                        </div>

                        <div class="user-item">
                            <div class="user-info">
                                <div class="user-name">Sophie Martin</div>
                                <div class="user-role">Responsable Financier</div>
                            </div>
                            <div class="user-status">
                                <span class="status-badge status-active">
                                    <i class="bi bi-circle-fill me-1"></i>Actif
                                </span>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-key me-1"></i>Reset
                                </button>
                            </div>
                        </div>

                        <div class="user-item">
                            <div class="user-info">
                                <div class="user-name">Pierre Lambert</div>
                                <div class="user-role">Direction</div>
                            </div>
                            <div class="user-status">
                                <span class="status-badge status-active">
                                    <i class="bi bi-circle-fill me-1"></i>Actif
                                </span>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Modifier
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-key me-1"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Ajouter un utilisateur
                    </button>
                </div>

                <div class="row">
                    <!-- Colonne de gauche : Configuration des Workflows -->
                    <div class="col-lg-6">
                        <h6 class="section-title">CONFIGURATION DES WORKFLOWS</h6>
                        
                        <div class="config-section">
                            <div class="config-item">
                                <div class="config-label">Workflow standard</div>
                                <div class="config-value">Tech → Finance → Direction</div>
                            </div>
                            <div class="config-item">
                                <div class="config-label">Seuil validation automatique</div>
                                <div class="config-value">&lt; 50K€</div>
                            </div>
                            <div class="config-item">
                                <div class="config-label">Délais maximum</div>
                                <div class="config-value">Tech(5j) • Finance(3j) • Direction(2j)</div>
                            </div>
                            <button class="btn btn-outline-primary w-100 mt-2">
                                <i class="bi bi-gear me-2"></i>Modifier les paramètres
                            </button>
                        </div>
                    </div>

                    <!-- Colonne de droite : Statistiques Système -->
                    <div class="col-lg-6">
                        <h6 class="section-title">STATISTIQUES SYSTÈME</h6>
                        
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-value">15</div>
                                <div class="stat-label">Projets ce mois</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">87%</div>
                                <div class="stat-label">Taux validation</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">42</div>
                                <div class="stat-label">Utilisation moyenne</div>
                                <div class="stat-label">users/jour</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">3.2 GB/10 GB</div>
                                <div class="stat-label">Stockage documents</div>
                                <div class="storage-bar">
                                    <div class="storage-fill" style="width: 32%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- ======= Footer ======= -->
   @include('page.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>