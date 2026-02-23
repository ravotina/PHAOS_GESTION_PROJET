<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Créer un projet - Cabinet PHAOS</title>
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
        :root {
            --primary-color: #6c380b;
            --primary-light: rgba(108, 56, 11, 0.1);
            --primary-dark: #5a2f09;
            --gradient-primary: linear-gradient(135deg, #000, #6c380b);
        }
        
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            border: 1px solid #e9ecef;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(108, 56, 11, 0.15);
        }
        .quick-actions .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .project-card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
            border: 1px solid #e9ecef;
        }
        .project-card:hover {
            box-shadow: 0 4px 8px rgba(108, 56, 11, 0.1);
            border-color: #6c380b;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 12px;
        }
        .notification-item {
            border-left: 3px solid #dee2e6;
            padding-left: 10px;
            margin-bottom: 10px;
        }
        .notification-item.validated {
            border-left-color: #28a745;
        }
        .notification-item.modification {
            border-left-color: #ffc107;
        }
        .notification-item.pending {
            border-left-color: #17a2b8;
        }

        /* Cartes statistiques */
        .info-card .card-icon {
            background: linear-gradient(135deg, rgba(108, 56, 11, 0.1), rgba(108, 56, 11, 0.2));
            color: #6c380b !important;
        }
        
        .info-card .card-title {
            color: #6c380b;
            font-weight: 600;
        }
        
        .info-card h6 {
            color: #6c380b;
            font-size: 1.8rem;
        }

        /* Titres */
        .pagetitle h1 {
            color: #6c380b;
        }
        
        .card-title {
            color: #6c380b;
            font-weight: 600;
        }

        /* Badges */
        .badge.bg-primary {
            background-color: #6c380b !important;
            border-color: #6c380b !important;
        }

        /* Pagination */
        .pagination .page-item.active .page-link {
            background-color: #6c380b;
            border-color: #6c380b;
            color: white;
        }
        
        .pagination .page-link {
            color: #2c3e50;
            border: 1px solid #dee2e6;
            cursor: pointer;
        }
        
        .pagination .page-link:hover {
            color: #6c380b;
            background-color: rgba(108, 56, 11, 0.1);
        }

        /* Boutons */
        .btn-outline-primary {
            color: #6c380b;
            border-color: #6c380b;
        }
        
        .btn-outline-primary:hover {
            background-color: #6c380b;
            border-color: #6c380b;
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #000, #6c380b);
            border: none;
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #6c380b, #5a2f09);
        }

        /* Liens "Voir plus" */
        .see-more-btn {
            color: #6c380b !important;
        }
        
        .see-more-btn:hover {
            color: #5a2f09 !important;
        }

        /* Alertes */
        .alert-info {
            border-left: 4px solid #6c380b;
            background-color: rgba(108, 56, 11, 0.05);
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
            background: linear-gradient(135deg, #6c380b 0%, #5a2f09 100%);
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
            color: #6c380b;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(108, 56, 11, 0.2);
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
            background: rgba(108, 56, 11, 0.05);
            border-color: #6c380b;
        }
        .notification-item.unread {
            background: rgba(108, 56, 11, 0.08);
            border-left: 4px solid #6c380b;
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
            color: #6c380b;
            background: rgba(108, 56, 11, 0.1);
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
      <h1 style="color: #6c380b;">Tableau de bord</h1>
      <!-- <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav> -->
    </div><!-- End Page Title -->

    

    <section class="section dashboard section_personaliser">
      <div class="row section_personaliser">
        <!-- Left side columns -->
        <div class="col-lg-12 section_personaliser">

          <div class="row">

            <!-- Projets Déposés Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card projects-card interne">
                    <div class="card-body"> 
                        <h5 class="card-title" style="color: #6c380b;">Nombre Total Projets <span>  </span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(108, 56, 11, 0.1); color: #6c380b;">
                                <i class="bi bi-folder-plus"></i>
                            </div>
                            <div class="ps-3">
                                <h6 style="color: #6c380b;">{{ $statsProjets['total'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Projets Déposés Card -->

            <!-- Projets en Cours Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card validation-card interne">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #6c380b;">Projets en Cours <span> </span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(108, 56, 11, 0.1); color: #6c380b;">
                                <i class="bi bi-play-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6 style="color: #6c380b;">{{ $statsProjets['en_cours'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Projets en Cours Card -->

            <!-- Projets en Attente Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card approved-card interne">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #6c380b;"> Projets en attente <span> </span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(108, 56, 11, 0.1); color: #6c380b;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="ps-3">
                                <h6 style="color: #6c380b;">{{ $statsProjets['en_attente'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Projets en Attente Card -->

            <!-- Projets Terminés Card -->
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card rejected-card interne">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #6c380b;">Projets Terminés <span></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(108, 56, 11, 0.1); color: #6c380b;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6 style="color: #6c380b;">{{ $statsProjets['termine'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Projets Terminés Card -->

          <div class="col-lg-8 mb-4">
              <div class="card dashboard-card h-100 interne">
                  <div class="card-body interne">
                      <h5 class="card-title" style="color: #6c380b;">LISTE DES PROJETS</h5>
                      
                      <!-- Container pour les projets avec ID -->
                      <div class="row" id="projects-container">
                          <!-- Les projets seront chargés ici par JavaScript -->
                      </div>
                      
                      <!-- Pagination -->
                      <div class="mt-4" id="pagination-container" style="display: none;">
                          <nav aria-label="Pagination des projets">
                              <ul class="pagination justify-content-center">
                                  <li class="page-item">
                                      <a class="page-link" href="#" id="prev-page" aria-label="Précédent">
                                          <span aria-hidden="true">&laquo;</span>
                                      </a>
                                  </li>
                                  <li class="page-item">
                                      <span class="page-link" id="page-info">Page 1 sur 1</span>
                                  </li>
                                  <li class="page-item">
                                      <a class="page-link" href="#" id="next-page" aria-label="Suivant">
                                          <span aria-hidden="true">&raquo;</span>
                                      </a>
                                  </li>
                              </ul>
                          </nav>
                      </div>
                      
                      <!-- Message si aucun projet -->
                      <div id="no-projects-message" style="display: none;">
                          <div class="alert alert-info text-center" style="border-left: 4px solid #6c380b; background-color: rgba(108, 56, 11, 0.05);">
                              Aucun projet disponible.
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <style>
              .description-container {
                  position: relative;
                  min-height: 40px;
              }
              
              .description-text {
                  margin-bottom: 0;
                  line-height: 1.4;
                  font-size: 0.9rem;
              }
              
              .see-more-btn {
                  font-size: 0.85rem;
                  text-decoration: none;
                  cursor: pointer;
                  transition: color 0.3s;
                  display: inline-block;
                  margin-top: 5px;
                  color: #6c380b !important;
              }
              
              .see-more-btn:hover {
                  color: #5a2f09 !important;
                  text-decoration: underline;
              }
              
              .project-card {
                  height: 100%;
                  transition: transform 0.3s;
                  border: 1px solid #e9ecef;
                  margin-bottom: 1rem;
              }
              
              .project-card:hover {
                  transform: translateY(-5px);
                  box-shadow: 0 5px 15px rgba(108, 56, 11, 0.1);
              }
              
              .pagination .page-item.active .page-link {
                  background-color: #6c380b;
                  border-color: #6c380b;
                  color: white;
              }
              
              .pagination .page-link {
                  color: #2c3e50;
                  border: 1px solid #dee2e6;
                  cursor: pointer;
              }
              
              .pagination .page-link:hover {
                  color: #6c380b;
                  background-color: rgba(108, 56, 11, 0.1);
              }
              
              .page-link.disabled {
                  opacity: 0.5;
                  pointer-events: none;
              }
          </style>

          <script>
          // Données des projets depuis PHP
          const allProjects = @json($projets);
          const projectsPerPage = 6;
          let currentPage = 1;
          let totalPages = 0;

          // Fonction pour formater la date
          function formatDate(dateString) {
              if (!dateString) return '';
              const date = new Date(dateString);
              return date.toLocaleDateString('fr-FR');
          }

          // Fonction pour obtenir la couleur du statut
          function getStatusColor(status) {
              switch(status) {
                  case 'brouillon': return 'secondary';
                  case 'en_attente': return 'warning';
                  case 'en_cours': return 'primary';
                  case 'termine': return 'success';
                  case 'annule': return 'danger';
                  default: return 'secondary';
              }
          }

          // Fonction pour limiter le texte
          function limitText(text, limit) {
              if (!text) return '';
              return text.length > limit ? text.substring(0, limit) + '...' : text;
          }

          // Fonction pour basculer la description
          function toggleDescription(projectId) {
              const shortDesc = document.getElementById(`description-short-${projectId}`);
              const fullDesc = document.getElementById(`description-full-${projectId}`);
              const button = document.querySelector(`button[data-id="${projectId}"]`);
              
              if (!shortDesc || !fullDesc || !button) return;
              
              if (shortDesc.style.display === 'none') {
                  shortDesc.style.display = 'block';
                  fullDesc.style.display = 'none';
                  button.textContent = 'Voir plus';
              } else {
                  shortDesc.style.display = 'none';
                  fullDesc.style.display = 'block';
                  button.textContent = 'Voir moins';
              }
          }

          // Fonction pour générer le HTML d'un projet
          function generateProjectHTML(projet) {
              const hasDescription = projet.description && projet.description.length > 0;
              const hasLongDescription = hasDescription && projet.description.length > 80;
              const shortDescription = hasDescription ? limitText(projet.description, 80) : '';
              
              return `
                  <div class="col-md-4 mb-3">
                      <div class="card project-card interne">
                          <div class="card-body">
                              <h6 class="card-subtitle mb-2 project-title">${projet.non_de_projet || 'Sans nom'}</h6>

                              <style>
                                  .project-title {
                                      color: #6c380b !important;
                                      font-weight: 600;
                                      font-size: 1.1rem;
                                  }
                              </style>
                              
                              ${hasDescription ? `
                                  <div class="description-container mb-2">
                                      <p class="card-text description-text" id="description-short-${projet.id}">
                                          ${shortDescription}
                                      </p>
                                      ${hasLongDescription ? `
                                          <p class="card-text description-text" id="description-full-${projet.id}" style="display: none;">
                                              ${projet.description}
                                          </p>
                                          <button class="btn btn-sm btn-link p-0 see-more-btn" 
                                                  data-id="${projet.id}" 
                                                  onclick="toggleDescription(${projet.id})">
                                              Voir plus
                                          </button>
                                      ` : ''}
                                  </div>
                              ` : ''}
                              
                              <span class="badge bg-${getStatusColor(projet.status)}">
                                  ${projet.status || 'Non défini'}
                              </span>
                              
                              <p class="card-text mt-2">
                                  ${projet.date_debu ? 
                                      `<small>${formatDate(projet.date_debu)}${projet.date_fin ? ' - ' + formatDate(projet.date_fin) : ''}</small>` : 
                                      '<span class="text-muted">Dates non définies</span>'
                                  }
                              </p>
                              
                          </div>
                      </div>
                  </div>
              `;
          }

          // <a href="${projet.id ? '/demarage/details/' + projet.id : '#'}" class="btn btn-sm btn-outline-primary" style="color: #6c380b; border-color: #6c380b;"  Voir détails  </a>
          
          // Fonction pour afficher les projets d'une page
          function displayProjects(page) {
              const container = document.getElementById('projects-container');
              const paginationContainer = document.getElementById('pagination-container');
              const noProjectsMessage = document.getElementById('no-projects-message');
              
              // Vérifier si nous avons des projets
              if (!allProjects || allProjects.length === 0) {
                  container.innerHTML = '';
                  paginationContainer.style.display = 'none';
                  noProjectsMessage.style.display = 'block';
                  return;
              }
              
              // Calculer les pages
              totalPages = Math.ceil(allProjects.length / projectsPerPage);
              currentPage = Math.max(1, Math.min(page, totalPages));
              
              // Calculer les indices de début et fin
              const startIndex = (currentPage - 1) * projectsPerPage;
              const endIndex = Math.min(startIndex + projectsPerPage, allProjects.length);
              
              // Vider le conteneur
              container.innerHTML = '';
              
              // Ajouter les projets de la page courante
              for (let i = startIndex; i < endIndex; i++) {
                  if (allProjects[i]) {
                      container.innerHTML += generateProjectHTML(allProjects[i]);
                  }
              }
              
              // Mettre à jour la pagination
              updatePagination();
              
              // Afficher/masquer les éléments
              paginationContainer.style.display = totalPages > 1 ? 'block' : 'none';
              noProjectsMessage.style.display = 'none';
          }

          // Fonction pour mettre à jour la pagination
          function updatePagination() {
              const pageInfo = document.getElementById('page-info');
              const prevPageBtn = document.getElementById('prev-page');
              const nextPageBtn = document.getElementById('next-page');
              
              // Mettre à jour l'info de page
              pageInfo.textContent = `Page ${currentPage} sur ${totalPages}`;
              
              // Gérer les boutons précédent/suivant
              if (currentPage === 1) {
                  prevPageBtn.classList.add('disabled');
              } else {
                  prevPageBtn.classList.remove('disabled');
              }
              
              if (currentPage === totalPages) {
                  nextPageBtn.classList.add('disabled');
              } else {
                  nextPageBtn.classList.remove('disabled');
              }
          }

          // Initialiser quand le DOM est chargé
          document.addEventListener('DOMContentLoaded', function() {
              // Initialiser l'affichage
              displayProjects(1);
              
              // Gérer le clic sur "Précédent"
              document.getElementById('prev-page').addEventListener('click', function(e) {
                  e.preventDefault();
                  if (currentPage > 1) {
                      displayProjects(currentPage - 1);
                      // Faire défiler vers le haut
                      document.getElementById('projects-container').scrollIntoView({ behavior: 'smooth' });
                  }
              });
              
              // Gérer le clic sur "Suivant"
              document.getElementById('next-page').addEventListener('click', function(e) {
                  e.preventDefault();
                  if (currentPage < totalPages) {
                      displayProjects(currentPage + 1);
                      // Faire défiler vers le haut
                      document.getElementById('projects-container').scrollIntoView({ behavior: 'smooth' });
                  }
              });
          });
          </script>

          <!-- Notifications -->
          <div class="col-lg-4 mb-4">
            <div class="card dashboard-card h-100 interne">
                <div class="card-body">
                    <h5 class="card-title" style="color: #6c380b;">NOTIFICATIONS <span class="badge bg-primary" style="background-color: #6c380b !important;">0</span></h5>

                    <div class="text-center py-4">
                        <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2 mb-0">Aucune notification</p>
                    </div>
                </div>
            </div>
          </div>
          </div>
        </div><!-- End Left side columns -->
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

</body>

</html>