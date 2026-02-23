<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Créer un Thème - Cabinet PHAOS</title>
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

    /* Styles spécifiques pour la création de thème */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card-header {
        background: var(--primary-gradient) !important;
        color: white !important;
        border-bottom: none !important;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .card-header h5 {
        color: white !important;
        margin-bottom: 0;
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

    .btn-secondary {
        background: #6c757d !important;
        border: none !important;
        color: white !important;
    }

    .btn-secondary:hover {
        background: #5a6268 !important;
    }

    .color-preview {
        width: 100%;
        height: 60px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .color-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .color-input-wrapper {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .color-picker-input {
        width: 50px;
        height: 50px;
        padding: 3px;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        cursor: pointer;
    }

    .color-picker-input:hover {
        border-color: var(--primary-color);
    }

    .color-picker-input::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    .color-picker-input::-webkit-color-swatch {
        border: none;
        border-radius: 6px;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
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

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Preview dynamique */
    .preview-container {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e9ecef;
        position: sticky;
        top: 20px;
    }

    .preview-button {
        background: linear-gradient(135deg, var(--preview-secondary, #000000), var(--preview-primary, #b15d15));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        margin: 10px 0;
        display: inline-block;
        width: 100%;
    }

    .preview-badge {
        background: linear-gradient(135deg, var(--preview-secondary, #000000), var(--preview-primary, #b15d15));
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9em;
        display: inline-block;
        margin: 5px;
    }

    .preview-header {
        background: linear-gradient(135deg, var(--preview-secondary, #000000), var(--preview-primary, #b15d15));
        color: white;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 10px;
    }

    .preview-sidebar {
        background-color: var(--preview-sidebar, #b15d15);
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .preview-main {
        background-color: var(--preview-main, #f8f9fa);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #dee2e6;
    }

    .preview-section {
        background-color: var(--preview-section, #ffffff);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border: 1px solid #dee2e6;
    }

    .preview-footer {
        background-color: var(--preview-footer, #343a40);
        color: white;
        padding: 15px;
        border-radius: 0 0 8px 8px;
    }

    /* Suggestions de couleurs */
    .color-suggestions {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 10px;
    }

    .color-suggestion {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s;
    }

    .color-suggestion:hover {
        transform: scale(1.2);
    }

    /* Grille des couleurs */
    .color-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header h5 {
            font-size: 1.1rem;
        }
        
        .preview-container {
            margin-top: 20px;
            position: static;
        }
        
        .color-input-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .color-picker-input {
            width: 50px;
            height: 50px;
        }

        .color-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Messages d'erreur */
    .invalid-feedback {
        display: block;
        font-size: 0.875em;
        color: #dc3545;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
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
        <i class="bi bi-palette me-2" style="color: var(--primary-color);"></i>
        Créer un Nouveau Thème
      </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Accueil</a></li>
          <li class="breadcrumb-item"><a href="{{ route('themes.index') }}">Thèmes</a></li>
          <li class="breadcrumb-item active">Créer</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section section_personaliser">
      <div class="row section_personaliser">
        <div class="col-lg-12 section_personaliser">
          <div class="card section_personaliser">
            <div class="card-header">
              <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>
                Formulaire de création de thème
              </h5>
            </div>
            <div class="card-body">
              <form action="{{ route('themes.store') }}" method="POST" id="themeForm">
                @csrf
                
                <div class="row">
                  <!-- Colonne gauche : Formulaire -->
                  <div class="col-lg-8">
                    <!-- Messages d'erreur -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <i class="bi bi-exclamation-triangle-fill me-2"></i>
                      <strong>Veuillez corriger les erreurs suivantes :</strong>
                      <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Nom du thème -->
                    <div class="mb-3">
                      <label for="nom" class="form-label">
                        <strong>Nom du thème *</strong>
                      </label>
                      <input type="text" 
                             class="form-control @error('nom') is-invalid @enderror" 
                             id="nom" 
                             name="nom" 
                             value="{{ old('nom') }}" 
                             required
                             placeholder="Ex: Thème été 2024">
                      @error('nom')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Choisissez un nom descriptif pour votre thème</small>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                      <label for="description" class="form-label">
                        <strong>Description</strong>
                      </label>
                      <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="3"
                                placeholder="Description du thème...">{{ old('description') }}</textarea>
                      @error('description')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>

                    <!-- Grille des couleurs -->
                    <div class="color-grid">
                      <!-- Couleur principale -->
                      <div class="mb-3">
                        <label for="couleur_principale" class="form-label">
                          <strong>Couleur principale *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_principale_picker" 
                                 value="{{ old('couleur_principale', '#b15d15') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_principale') is-invalid @enderror" 
                                 id="couleur_principale" 
                                 name="couleur_principale" 
                                 value="{{ old('couleur_principale', '#b15d15') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#b15d15">
                        </div>
                        @error('couleur_principale')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Couleur secondaire -->
                      <div class="mb-3">
                        <label for="couleur_secondaire" class="form-label">
                          <strong>Couleur secondaire *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_secondaire_picker" 
                                 value="{{ old('couleur_secondaire', '#000000') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_secondaire') is-invalid @enderror" 
                                 id="couleur_secondaire" 
                                 name="couleur_secondaire" 
                                 value="{{ old('couleur_secondaire', '#000000') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#000000">
                        </div>
                        @error('couleur_secondaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Couleur sidebar -->
                      <div class="mb-3">
                        <label for="couleur_sidebar" class="form-label">
                          <strong>Couleur sidebar *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_sidebar_picker" 
                                 value="{{ old('couleur_sidebar', '#b15d15') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_sidebar') is-invalid @enderror" 
                                 id="couleur_sidebar" 
                                 name="couleur_sidebar" 
                                 value="{{ old('couleur_sidebar', '#b15d15') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#b15d15">
                        </div>
                        @error('couleur_sidebar')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Couleur main -->
                      <div class="mb-3">
                        <label for="couleur_main" class="form-label">
                          <strong>Couleur main *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_main_picker" 
                                 value="{{ old('couleur_main', '#f8f9fa') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_main') is-invalid @enderror" 
                                 id="couleur_main" 
                                 name="couleur_main" 
                                 value="{{ old('couleur_main', '#f8f9fa') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#f8f9fa">
                        </div>
                        @error('couleur_main')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Couleur section -->
                      <div class="mb-3">
                        <label for="couleur_section" class="form-label">
                          <strong>Couleur section *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_section_picker" 
                                 value="{{ old('couleur_section', '#ffffff') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_section') is-invalid @enderror" 
                                 id="couleur_section" 
                                 name="couleur_section" 
                                 value="{{ old('couleur_section', '#ffffff') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#ffffff">
                        </div>
                        @error('couleur_section')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Couleur header -->
                      <div class="mb-3">
                        <label for="couleur_header" class="form-label">
                          <strong>Couleur header *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_header_picker" 
                                 value="{{ old('couleur_header', '#b15d15') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_header') is-invalid @enderror" 
                                 id="couleur_header" 
                                 name="couleur_header" 
                                 value="{{ old('couleur_header', '#b15d15') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#b15d15">
                        </div>
                        @error('couleur_header')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Couleur footer -->
                      <div class="mb-3">
                        <label for="couleur_footer" class="form-label">
                          <strong>Couleur footer *</strong>
                        </label>
                        <div class="color-input-wrapper">
                          <input type="color" 
                                 class="color-picker-input" 
                                 id="couleur_footer_picker" 
                                 value="{{ old('couleur_footer', '#343a40') }}">
                          <input type="text" 
                                 class="form-control @error('couleur_footer') is-invalid @enderror" 
                                 id="couleur_footer" 
                                 name="couleur_footer" 
                                 value="{{ old('couleur_footer', '#343a40') }}" 
                                 required
                                 pattern="^#[0-9A-Fa-f]{6}$"
                                 placeholder="#343a40">
                        </div>
                        @error('couleur_footer')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <!-- Suggestions de couleurs communes -->
                    <div class="mb-4">
                      <label class="form-label">
                        <strong>Suggestions de couleurs</strong>
                      </label>
                      <div class="color-suggestions">
                        <div class="color-suggestion" style="background-color: #B15D15;" title="#B15D15 - Marron" onclick="applyColorSuggestion('#B15D15')"></div>
                        <div class="color-suggestion" style="background-color: #2C3E50;" title="#2C3E50 - Bleu foncé" onclick="applyColorSuggestion('#2C3E50')"></div>
                        <div class="color-suggestion" style="background-color: #27AE60;" title="#27AE60 - Vert" onclick="applyColorSuggestion('#27AE60')"></div>
                        <div class="color-suggestion" style="background-color: #3498DB;" title="#3498DB - Bleu" onclick="applyColorSuggestion('#3498DB')"></div>
                        <div class="color-suggestion" style="background-color: #9B59B6;" title="#9B59B6 - Violet" onclick="applyColorSuggestion('#9B59B6')"></div>
                        <div class="color-suggestion" style="background-color: #E74C3C;" title="#E74C3C - Rouge" onclick="applyColorSuggestion('#E74C3C')"></div>
                        <div class="color-suggestion" style="background-color: #F39C12;" title="#F39C12 - Orange" onclick="applyColorSuggestion('#F39C12')"></div>
                        <div class="color-suggestion" style="background-color: #1ABC9C;" title="#1ABC9C - Turquoise" onclick="applyColorSuggestion('#1ABC9C')"></div>
                      </div>
                    </div>

                    <!-- Statut actif -->
                    <div class="mb-4">
                      <div class="form-check form-switch">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="actif" 
                               name="actif" 
                               value="1" 
                               {{ old('actif', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="actif">
                          <strong>Thème actif</strong>
                        </label>
                      </div>
                      <small class="text-muted">Désactivez pour créer un thème inactif (archivé)</small>
                    </div>
                  </div>

                  <!-- Colonne droite : Prévisualisation améliorée -->
                  <div class="col-lg-4">
                    <div class="preview-container">
                      <h6 class="mb-3">
                        <i class="bi bi-eye me-2"></i>
                        Prévisualisation du thème
                      </h6>
                      
                      <!-- Header preview -->
                      <div class="preview-header" id="previewHeader">
                        <i class="bi bi-grid"></i> En-tête
                      </div>

                      <!-- Sidebar + Main preview -->
                      <div class="row g-0">
                        <div class="col-4">
                          <div class="preview-sidebar" id="previewSidebar">
                            <i class="bi bi-layout-sidebar"></i><br>
                            <small>Sidebar</small>
                          </div>
                        </div>
                        <div class="col-8">
                          <div class="preview-main" id="previewMain">
                            <small>Contenu principal</small>
                            <div class="preview-section mt-2" id="previewSection">
                              <small>Section de contenu</small>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Footer preview -->
                      <div class="preview-footer" id="previewFooter">
                        <i class="bi bi-layout-text-window"></i> Pied de page
                      </div>

                      <!-- Aperçu des couleurs -->
                      <div class="mt-3">
                        <small class="text-muted d-block mb-2">Aperçu des couleurs :</small>
                        <div class="d-flex flex-wrap gap-2">
                          <div class="color-circle" id="previewPrimary" style="background-color: #b15d15;" title="Principale"></div>
                          <div class="color-circle" id="previewSecondary" style="background-color: #000000;" title="Secondaire"></div>
                          <div class="color-circle" id="previewSidebarCircle" style="background-color: #b15d15;" title="Sidebar"></div>
                          <div class="color-circle" id="previewMainCircle" style="background-color: #f8f9fa;" title="Main"></div>
                          <div class="color-circle" id="previewSectionCircle" style="background-color: #ffffff;" title="Section"></div>
                          <div class="color-circle" id="previewHeaderCircle" style="background-color: #0a0704;" title="Header"></div>
                          <div class="color-circle" id="previewFooterCircle" style="background-color: #343a40;" title="Footer"></div>
                        </div>
                      </div>

                      <!-- Bouton exemple -->
                      <div class="mt-3">
                        <small class="text-muted d-block mb-2">Bouton :</small>
                        <button type="button" class="preview-button" id="previewButton">
                          <i class="bi bi-check-circle me-2"></i>
                          Bouton exemple
                        </button>
                      </div>

                      <!-- Note -->
                      <div class="alert alert-light p-2 mt-3">
                        <small>
                          <i class="bi bi-info-circle me-1"></i>
                          La prévisualisation se met à jour automatiquement
                        </small>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row mt-4">
                  <div class="col-12">
                    <div class="d-flex justify-content-between">
                      <a href="{{ route('themes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Annuler
                      </a>
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Créer le thème
                      </button>
                    </div>
                  </div>
                </div>
              </form>
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
    // Fonction pour mettre à jour la prévisualisation
    function updatePreview() {
        // Récupérer toutes les couleurs
        const colors = {
            principale: document.getElementById('couleur_principale').value,
            secondaire: document.getElementById('couleur_secondaire').value,
            sidebar: document.getElementById('couleur_sidebar').value,
            main: document.getElementById('couleur_main').value,
            section: document.getElementById('couleur_section').value,
            header: document.getElementById('couleur_header').value,
            footer: document.getElementById('couleur_footer').value
        };

        // Mettre à jour les variables CSS
        Object.entries(colors).forEach(([key, value]) => {
            document.documentElement.style.setProperty(`--preview-${key}`, value);
        });

        // Mettre à jour les aperçus
        document.getElementById('previewHeader').style.background = colors.header;
        
        document.getElementById('previewSidebar').style.backgroundColor = colors.sidebar;
        document.getElementById('previewMain').style.backgroundColor = colors.main;
        document.getElementById('previewSection').style.backgroundColor = colors.section;
        document.getElementById('previewFooter').style.backgroundColor = colors.footer;
        
        document.getElementById('previewButton').style.background = 
            `linear-gradient(135deg, ${colors.secondaire}, ${colors.principale})`;

        // Mettre à jour les cercles de couleur
        document.getElementById('previewPrimary').style.backgroundColor = colors.principale;
        document.getElementById('previewSecondary').style.backgroundColor = colors.secondaire;
        document.getElementById('previewSidebarCircle').style.backgroundColor = colors.sidebar;
        document.getElementById('previewMainCircle').style.backgroundColor = colors.main;
        document.getElementById('previewSectionCircle').style.backgroundColor = colors.section;
        document.getElementById('previewHeaderCircle').style.backgroundColor = colors.header;
        document.getElementById('previewFooterCircle').style.backgroundColor = colors.footer;
    }

    // Fonction pour synchroniser les inputs color avec les inputs text
    function setupColorSync(id) {
        const picker = document.getElementById(`${id}_picker`);
        const input = document.getElementById(id);
        
        if (picker && input) {
            picker.addEventListener('input', function() {
                input.value = this.value.toUpperCase();
                updatePreview();
            });
            
            input.addEventListener('input', function() {
                const colorRegex = /^#[0-9A-Fa-f]{6}$/;
                if (colorRegex.test(this.value)) {
                    picker.value = this.value;
                }
                updatePreview();
            });
            
            input.addEventListener('blur', function() {
                this.value = this.value.toUpperCase();
                updatePreview();
            });
        }
    }

    // Fonction pour appliquer une suggestion de couleur
    function applyColorSuggestion(color) {
        document.getElementById('couleur_principale').value = color;
        document.getElementById('couleur_principale_picker').value = color;
        document.getElementById('couleur_secondaire').value = color;
        document.getElementById('couleur_secondaire_picker').value = color;
        document.getElementById('couleur_sidebar').value = color;
        document.getElementById('couleur_sidebar_picker').value = color;
        document.getElementById('couleur_header').value = color;
        document.getElementById('couleur_header_picker').value = color;
        updatePreview();
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Synchroniser tous les champs de couleur
        const colorFields = [
            'couleur_principale',
            'couleur_secondaire',
            'couleur_sidebar',
            'couleur_main',
            'couleur_section',
            'couleur_header',
            'couleur_footer'
        ];
        
        colorFields.forEach(field => setupColorSync(field));
        
        // Initialiser la prévisualisation
        updatePreview();

        // Validation du formulaire
        document.getElementById('themeForm').addEventListener('submit', function(e) {
            const colorRegex = /^#[0-9A-Fa-f]{6}$/;
            
            for (const field of colorFields) {
                const value = document.getElementById(field).value;
                if (!colorRegex.test(value)) {
                    e.preventDefault();
                    alert(`Le champ ${field.replace('couleur_', '')} doit être au format hexadécimal (#RRGGBB)`);
                    document.getElementById(field).focus();
                    return false;
                }
            }
            
            const nom = document.getElementById('nom').value.trim();
            if (!nom) {
                e.preventDefault();
                alert('Le nom du thème est requis');
                document.getElementById('nom').focus();
                return false;
            }
        });
    });
  </script>
</body>
</html>