<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Themes - Cabinet PHAOS</title>
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
    /* Variables CSS pour le thème */


    /* Styles spécifiques pour la page des thèmes */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: var(--primary-gradient) !important;
        color: white !important;
        border-bottom: none !important;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .card-header h5, .card-header h6 {
        color: white !important;
        margin-bottom: 0;
    }

    .current-theme-card {
        border-left: 5px solid var(--primary-color);
        animation: fadeIn 0.5s ease-out;
    }

    .color-circle {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background: var(--primary-gradient) !important;
        border: none !important;
        color: white !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(177, 93, 21, 0.2);
    }

    .stat-card {
        padding: 15px;
        border-radius: 8px;
        background: #f8f9fa;
        transition: transform 0.2s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .table thead th {
        background: var(--primary-light);
        color: var(--primary-color);
        font-weight: 600;
        border-bottom: 2px solid var(--primary-light);
        padding: 1rem;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(177, 93, 21, 0.05);
    }

    .badge.bg-primary {
        background: var(--primary-gradient) !important;
        border: none;
    }

    /* Style pour le thème actuel */
    .theme-preview {
        background: var(--primary-gradient);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header h5 {
            font-size: 1rem;
        }
        
        .stat-card {
            margin-bottom: 15px;
        }
        
        .btn-group {
            flex-wrap: wrap;
            gap: 5px;
        }
    }

    /* Amélioration du contraste pour les badges */
    .badge.bg-success {
        background: linear-gradient(135deg, #28a745, #1e7e34) !important;
    }

    .badge.bg-secondary {
        background: linear-gradient(135deg, #6c757d, #545b62) !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800) !important;
        color: #212529;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545, #c82333) !important;
    }

    .badge.bg-info {
        background: linear-gradient(135deg, #17a2b8, #138496) !important;
    }

    /* Boutons outline */
    .btn-outline-primary {
        color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color) !important;
        color: white !important;
        border-color: var(--primary-color) !important;
    }

    .btn-outline-success {
        color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .btn-outline-success:hover {
        background: #28a745 !important;
        color: white !important;
    }

    .btn-outline-warning {
        color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    .btn-outline-warning:hover {
        background: #ffc107 !important;
        color: #212529 !important;
    }

    .btn-outline-danger {
        color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .btn-outline-danger:hover {
        background: #dc3545 !important;
        color: white !important;
    }






    /* Styles pour les tooltips personnalisés */
    [title] {
        position: relative;
        cursor: help;
    }

    /* Amélioration de l'affichage des couleurs dans le tableau */
    .color-circle {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }

    .color-circle:hover {
        transform: scale(1.2);
        z-index: 10;
    }

    /* Style pour le groupe de boutons */
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    /* Animation pour les lignes du tableau */
    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(177, 93, 21, 0.05) !important;
        transform: translateX(5px);
    }

    /* Style pour les badges */
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #28a745, #1e7e34) !important;
    }

    .badge.bg-primary {
        background: linear-gradient(135deg, var(--primary-color, #b15d15), var(--primary-dark, #8a4710)) !important;
    }

    /* Style pour les tooltips Bootstrap améliorés */
    .tooltip-inner {
        background: linear-gradient(135deg, #2c3e50, #34495e);
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
        border-radius: 6px;
    }

    /* Responsive pour mobile */
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
        
        .table thead {
            display: none;
        }
        
        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem;
        }
        
        .table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
            padding: 0.5rem;
        }
        
        .table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            min-width: 100px;
        }
  }

  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  @include('page.header')

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <div class="pagetitle">

      <h1>
        <i class="bi bi-palette me-2"></i>
        Gestion des Thèmes
      </h1>

      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item active">Thèmes</li>
        </ol>
      </nav>

    </div><!-- End Page Title -->

    <section class="section section_personaliser">
      <div class="row section_personaliser">
        <div class="col-lg-12 section_personaliser">
          <div class="card section_personaliser">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">
                  <!-- <i class="bi bi-palette-fill me-2"></i>
                      Thèmes du Cabinet PHAOS -->
                </h5>
                <a href="{{ route('themes.create') }}" class="btn btn-primary">
                  <i class="bi bi-plus-lg me-2"></i>Nouveau Thème
                </a>
              </div>

              <!-- Messages de session -->
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              @endif
              
              @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              @endif

              <!-- Thème actuel -->
              <!-- Dans la vue index, section "Thème actuel" avec 7 couleurs -->
            @if($currentTheme)
            <div class="card current-theme-card mb-4">

                <!-- <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-star-fill me-2"></i>
                        Thème actuellement actif
                    </h6>
                </div> -->

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="theme-preview">
                                <h4 class="mb-1">{{ $currentTheme->nom }}</h4>
                                <small>ACTIF</small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!-- Première ligne : Couleurs principales -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Principale</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_principale }};"></div>
                                        <code>{{ $currentTheme->couleur_principale }}</code>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Secondaire</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_secondaire }};"></div>
                                        <code>{{ $currentTheme->couleur_secondaire }}</code>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Deuxième ligne : Sidebar, Main, Section -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Sidebar</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_sidebar }};"></div>
                                        <code>{{ $currentTheme->couleur_sidebar }}</code>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Main</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_main }};"></div>
                                        <code>{{ $currentTheme->couleur_main }}</code>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Section</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_section }};"></div>
                                        <code>{{ $currentTheme->couleur_section }}</code>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Troisième ligne : Header, Footer -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Header</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_header }};"></div>
                                        <code>{{ $currentTheme->couleur_header }}</code>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <small class="text-muted d-block">Footer</small>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="color-circle me-2" style="background-color: {{ $currentTheme->couleur_footer }};"></div>
                                        <code>{{ $currentTheme->couleur_footer }}</code>
                                    </div>
                                </div>
                            </div>
                            
                            @if($currentTheme->description)
                            <div class="row mt-2">
                                <div class="col-12">
                                    <small class="text-muted d-block">Description</small>
                                    <p class="mb-0 mt-1">{{ $currentTheme->description }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif




            <!-- Liste des thèmes -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        Liste des thèmes ({{ $themes->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($themes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Couleurs</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($themes as $theme)
                                <tr class="{{ $theme->isActive() ? 'table-success' : '' }}">
                                    <td>
                                        <strong>{{ $theme->nom }}</strong>
                                        @if($theme->description)
                                        <br><small class="text-muted">{{ Str::limit($theme->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Affichage compact des 7 couleurs -->
                                        <div class="d-flex flex-column">
                                            <!-- Ligne 1 : Principale et Secondaire -->
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="color-circle me-1" style="background-color: {{ $theme->couleur_principale }};" title="Principale: {{ $theme->couleur_principale }}"></div>
                                                <div class="color-circle me-2" style="background-color: {{ $theme->couleur_secondaire }};" title="Secondaire: {{ $theme->couleur_secondaire }}"></div>
                                                <small class="text-muted">P/S</small>
                                            </div>
                                            
                                            <!-- Ligne 2 : Sidebar, Main, Section -->
                                            <div class="d-flex align-items-center mb-1">
                                                <div class="color-circle me-1" style="background-color: {{ $theme->couleur_sidebar }};" title="Sidebar: {{ $theme->couleur_sidebar }}"></div>
                                                <div class="color-circle me-1" style="background-color: {{ $theme->couleur_main }};" title="Main: {{ $theme->couleur_main }}"></div>
                                                <div class="color-circle me-2" style="background-color: {{ $theme->couleur_section }};" title="Section: {{ $theme->couleur_section }}"></div>
                                                <small class="text-muted">S/M/S</small>
                                            </div>
                                            
                                            <!-- Ligne 3 : Header, Footer -->
                                            <div class="d-flex align-items-center">
                                                <div class="color-circle me-1" style="background-color: {{ $theme->couleur_header }};" title="Header: {{ $theme->couleur_header }}"></div>
                                                <div class="color-circle me-2" style="background-color: {{ $theme->couleur_footer }};" title="Footer: {{ $theme->couleur_footer }}"></div>
                                                <small class="text-muted">H/F</small>
                                            </div>
                                        </div>
                                        
                                        <!-- Alternative : Affichage en grille (optionnel) -->
                                        <!--
                                        <div class="d-flex flex-wrap gap-1" style="max-width: 150px;">
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_principale }};" title="Principale: {{ $theme->couleur_principale }}"></div>
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_secondaire }};" title="Secondaire: {{ $theme->couleur_secondaire }}"></div>
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_sidebar }};" title="Sidebar: {{ $theme->couleur_sidebar }}"></div>
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_main }};" title="Main: {{ $theme->couleur_main }}"></div>
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_section }};" title="Section: {{ $theme->couleur_section }}"></div>
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_header }};" title="Header: {{ $theme->couleur_header }}"></div>
                                            <div class="color-circle" style="background-color: {{ $theme->couleur_footer }};" title="Footer: {{ $theme->couleur_footer }}"></div>
                                        </div>
                                        -->
                                    </td>
                                    <td>
                                        @if($theme->actif)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                        @if($theme->isActive())
                                            <br><span class="badge bg-primary mt-1">● Actuel</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            

                                            <!-- <a href="{{ route('themes.show', $theme->id) }}" 
                                              class="btn btn-outline-info" 
                                              title="Voir détails">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                           
                                            <a href="{{ route('themes.edit', $theme->id) }}" 
                                              class="btn btn-outline-primary" 
                                              title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a> -->


                                            
                                            <!-- Bouton Activer/Désactiver -->
                                            <form action="{{ route('themes.toggle', $theme->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-outline-warning" 
                                                        title="{{ $theme->actif ? 'Désactiver' : 'Activer' }}">
                                                    <i class="bi bi-power"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Bouton Supprimer (optionnel) -->
                                            <form action="{{ route('themes.destroy', $theme->id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce thème ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger" 
                                                        title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>


                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination si nécessaire -->
                    @if(method_exists($themes, 'links'))
                    <div class="d-flex justify-content-center mt-3">
                        {{ $themes->links() }}
                    </div>
                    @endif
                    
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-palette display-1 mb-3" style="color: var(--primary-color); opacity: 0.7;"></i>
                        <h5 class="text-muted">Aucun thème trouvé</h5>
                        <p class="text-muted">Commencez par créer votre premier thème</p>
                        <a href="{{ route('themes.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-lg me-2"></i>Créer un thème
                        </a>
                    </div>
                    @endif
                </div>

            </div>




              <!-- Retour -->
              <div class="mt-4">
                <a href="/" class="btn btn-secondary">
                  <i class="bi bi-arrow-left me-2"></i>Retour à l'accueil
                </a>
              </div>

            </div>
          </div>

        </div>
      </div>
    </section>

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
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
          var bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        });
      }, 5000);
    });

    // Activer les tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>
</body>
</html>