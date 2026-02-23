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
        .form-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px 8px 0 0;
        }
        .form-section {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .section-title {
            color: #495057;
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        .file-upload-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
        }
        .file-status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .file-status.uploaded {
            color: #28a745;
        }
        .file-status.pending {
            color: #ffc107;
        }
        .validator-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }
        .validator-role {
            font-weight: 500;
            min-width: 180px;
        }
        .auto-assigned {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .btn-cancel {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        .btn-cancel:hover {
            background: #5a6268;
            border-color: #545b62;
            color: white;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .date-input-group {
            position: relative;
        }
        .date-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
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
      <h1>Formulaire de dépôt de projet</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Formulaire</li>
          <li class="breadcrumb-item active">Projet</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container py-4">
        <div class="form-container">
            <!-- En-tête du formulaire -->
            <div class="form-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Nouveau Projet • Chef de Projet</h5>
                <button class="btn btn-cancel btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Annuler
                </button>
            </div>

            <form>
                <!-- Section Informations Générales -->
                <div class="form-section">
                    <h6 class="section-title">INFORMATIONS GÉNÉRALES</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Nom du projet</label>
                            <input type="text" class="form-control" placeholder="Audit énergétique bâtiment X" value="Audit énergétique bâtiment X">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Décrivez votre projet..."></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type de projet</label>
                            <select class="form-select">
                                <option selected>Audit énergétique</option>
                                <option>Optimisation système</option>
                                <option>Installation équipement</option>
                                <option>Maintenance préventive</option>
                                <option>Étude de faisabilité</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priorité</label>
                            <select class="form-select">
                                <option selected>Normale</option>
                                <option>Élevée</option>
                                <option>Urgente</option>
                                <option>Faible</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de début</label>
                            <div class="date-input-group">
                                <input type="text" class="form-control" value="15/04/2024">
                                <i class="bi bi-calendar date-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de fin</label>
                            <div class="date-input-group">
                                <input type="text" class="form-control" value="30/06/2024">
                                <i class="bi bi-calendar date-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Budget estimé</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="125 000">
                                <span class="input-group-text">€</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Documents -->
                <div class="form-section">
                    <h6 class="section-title">DOCUMENTS À TÉLÉCHARGER</h6>
                    
                    <div class="file-upload-list">
                        <div class="file-upload-item">
                            <span>Cahier des charges</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status uploaded">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Fichier_CDC.pdf
                                </span>
                            </div>
                        </div>

                        <div class="file-upload-item">
                            <span>Devis et budget</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status pending">
                                    <i class="bi bi-clock"></i>
                                    En attente
                                </span>
                            </div>
                        </div>

                        <div class="file-upload-item">
                            <span>Planning projet</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status pending">
                                    <i class="bi bi-clock"></i>
                                    En attente
                                </span>
                            </div>
                        </div>

                        <div class="file-upload-item">
                            <span>Étude de faisabilité</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status pending">
                                    <i class="bi bi-clock"></i>
                                    En attente
                                </span>
                            </div>
                        </div>

                        <div class="file-upload-item">
                            <span>Rapport technique</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status pending">
                                    <i class="bi bi-clock"></i>
                                    En attente
                                </span>
                            </div>
                        </div>

                        <div class="file-upload-item">
                            <span>Analyse financière</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status pending">
                                    <i class="bi bi-clock"></i>
                                    En attente
                                </span>
                            </div>
                        </div>

                        <div class="file-upload-item">
                            <span>Contrats fournisseurs</span>
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-folder2-open me-1"></i>Parcourir...
                                </button>
                                <span class="file-status pending">
                                    <i class="bi bi-clock"></i>
                                    En attente
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Validateurs -->
                <div class="form-section">
                    <h6 class="section-title">VALIDATEURS ATTRIBUÉS</h6>
                    
                    <div class="validators-list">
                        <div class="validator-item">
                            <span class="validator-role">Responsable Technique:</span>
                            <span>Martin Dupont</span>
                            <span class="auto-assigned">(auto-attribué)</span>
                        </div>
                        <div class="validator-item">
                            <span class="validator-role">Responsable Financier:</span>
                            <span>Sophie Martin</span>
                            <span class="auto-assigned">(auto-attribué)</span>
                        </div>
                        <div class="validator-item">
                            <span class="validator-role">Direction:</span>
                            <span>Pierre Lambert</span>
                            <span class="auto-assigned">(auto-attribué)</span>
                        </div>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="form-section text-center">
                    <button type="submit" class="btn btn-submit btn-lg">
                        <i class="bi bi-send me-2"></i>SOUMETTRE LE PROJET
                    </button>
                </div>
            </form>
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
  <script src="{{ asset('assets/vendor/quill/quill.js"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>