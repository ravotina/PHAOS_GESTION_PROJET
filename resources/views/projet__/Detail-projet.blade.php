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
        .project-detail-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .project-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px 8px 0 0;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }
        .validation-step {
            padding: 1rem;
            border-left: 4px solid #dee2e6;
            margin-bottom: 1rem;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
        }
        .validation-step.active {
            border-left-color: #ffc107;
            background: #fff3cd;
        }
        .validation-step.pending {
            border-left-color: #17a2b8;
        }
        .validation-step.waiting {
            border-left-color: #6c757d;
        }
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: #495057;
            color: white;
            border-radius: 50%;
            font-size: 0.8rem;
            margin-right: 0.5rem;
        }
        .validation-step.active .step-number {
            background: #ffc107;
        }
        .validator-info {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
        }
        .document-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            background: white;
            transition: background-color 0.2s;
        }
        .document-item:hover {
            background: #f8f9fa;
        }
        .document-icon {
            font-size: 1.2rem;
            margin-right: 0.75rem;
            color: #6c757d;
        }
        .document-info {
            flex: 1;
        }
        .document-meta {
            font-size: 0.875rem;
            color: #6c757d;
        }
        .activity-item {
            padding: 0.75rem;
            border-left: 3px solid #dee2e6;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
        }
        .activity-time {
            font-weight: 500;
            color: #495057;
        }
        .validation-status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        .status-cell {
            background: white;
            padding: 1rem;
            text-align: center;
        }
        .status-cell-header {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .status-indicator {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
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
          <li class="breadcrumb-item active">Detail</li>
          <li class="breadcrumb-item active">Projet</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container py-4">
        <div class="project-detail-container">
            <!-- En-tête du projet -->
            <div class="project-header">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="mb-1">Projet #AUD-23 • Audit bâtiment commercial</h4>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <span class="status-badge bg-primary">
                                <i class="bi bi-circle-fill me-1"></i>EN COURS DE VALIDATION
                            </span>
                            <span class="text-white-50">
                                <i class="bi bi-calendar me-1"></i>Dépôt: 15/03/2024 14:30
                            </span>
                        </div>
                    </div>
                    <button class="btn btn-back">
                        <i class="bi bi-arrow-left me-1"></i>Retour
                    </button>
                </div>
            </div>

            <!-- Grille des statuts de validation -->
            <div class="p-3 border-bottom">
                <div class="validation-status-grid">
                    <div class="status-cell">
                        <div class="status-cell-header">Technique</div>
                        <div class="status-indicator text-warning">
                            <i class="bi bi-circle-fill"></i>
                        </div>
                        <div class="status-text text-warning">En attente</div>
                    </div>
                    <div class="status-cell">
                        <div class="status-cell-header">Financier</div>
                        <div class="status-indicator text-secondary">
                            <i class="bi bi-circle"></i>
                        </div>
                        <div class="status-text text-muted">Non débuté</div>
                    </div>
                    <div class="status-cell">
                        <div class="status-cell-header">Direction</div>
                        <div class="status-indicator text-secondary">
                            <i class="bi bi-circle"></i>
                        </div>
                        <div class="status-text text-muted">Non débuté</div>
                    </div>
                    <div class="status-cell">
                        <div class="status-cell-header">Final</div>
                        <div class="status-indicator text-secondary">
                            <i class="bi bi-circle"></i>
                        </div>
                        <div class="status-text text-muted">-</div>
                    </div>
                </div>
            </div>

            <div class="row p-4">
                <!-- Colonne de gauche : Workflow et Activité -->
                <div class="col-lg-8">
                    <!-- Workflow de validation -->
                    <div class="mb-4">
                        <h6 class="section-title mb-3">WORKFLOW DE VALIDATION</h6>
                        
                        <div class="validation-step active">
                            <div class="d-flex align-items-center mb-2">
                                <span class="step-number">①</span>
                                <h6 class="mb-0">VALIDATION TECHNIQUE (Responsable Technique)</h6>
                            </div>
                            <div class="validator-info">
                                <div class="fw-medium">• Martin Dupont</div>
                                <div class="text-warning">• En attente depuis 2 jours</div>
                                <div class="text-danger">• Date limite: 20/03/2024</div>
                            </div>
                        </div>

                        <div class="validation-step waiting">
                            <div class="d-flex align-items-center mb-2">
                                <span class="step-number">②</span>
                                <h6 class="mb-0">VALIDATION FINANCIÈRE (Responsable Financier)</h6>
                            </div>
                            <div class="validator-info">
                                <div class="fw-medium">• Sophie Martin</div>
                                <div class="text-muted">• Non débuté</div>
                            </div>
                        </div>

                        <div class="validation-step waiting">
                            <div class="d-flex align-items-center mb-2">
                                <span class="step-number">③</span>
                                <h6 class="mb-0">VALIDATION DIRECTION (Direction Générale)</h6>
                            </div>
                            <div class="validator-info">
                                <div class="fw-medium">• Pierre Lambert</div>
                                <div class="text-muted">• Non débuté</div>
                            </div>
                        </div>
                    </div>

                    <!-- Activité récente -->
                    <div>
                        <h6 class="section-title mb-3">ACTIVITÉ RÉCENTE</h6>
                        
                        <div class="activity-item">
                            <div class="activity-time">15/03 14:30</div>
                            <div>• Projet déposé par John Doe</div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-time">15/03 14:31</div>
                            <div>• Notification envoyée à Martin Dupont</div>
                        </div>
                    </div>
                </div>

                <!-- Colonne de droite : Documents -->
                <div class="col-lg-4">
                    <h6 class="section-title mb-3">DOCUMENTS DU PROJET</h6>
                    
                    <div class="document-list">
                        <div class="document-item">
                            <i class="bi bi-file-text document-icon"></i>
                            <div class="document-info">
                                <div class="fw-medium">Cahier des charges (v2.1)</div>
                                <div class="document-meta">2.3 MB • 15/03/2024</div>
                            </div>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>

                        <div class="document-item">
                            <i class="bi bi-bar-chart document-icon"></i>
                            <div class="document-info">
                                <div class="fw-medium">Devis initial</div>
                                <div class="document-meta">1.1 MB • 15/03/2024</div>
                            </div>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>

                        <div class="document-item">
                            <i class="bi bi-calendar-event document-icon"></i>
                            <div class="document-info">
                                <div class="fw-medium">Planning projet</div>
                                <div class="document-meta">0.8 MB • 15/03/2024</div>
                            </div>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>

                        <button class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-plus-circle me-2"></i>Ajouter un document
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



  </main><!-- End #main -->

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
  <script src="{{ asset('assets/js/main.js"></script>

</body>

</html>