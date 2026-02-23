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
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <!-- <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bi bi-list-task me-2"></i>Détail de la Tâche
                            </h4>
                        </div> -->
                        
                        <div class="card-body">
                            <!-- Titre -->
                            <h3 class="mb-3">{{ $tache->titre }}</h3>
                            
                            <!-- Description de la notification -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-card-text me-2"></i>Description
                                    </h5>
                                    <p class="card-text">{{ $tache->description ?? 'Aucune description' }}</p>
                                </div>
                            </div>
                            
                            <!-- Description spécifique de la tâche (si elle existe dans utilisateur_concerner) -->
                            @if(isset($tacheConcerner) && $tacheConcerner && $tacheConcerner->description_tache)
                            <div class="card mb-4 border-success">
                                <div class="card-body">
                                    <h5 class="card-title text-success">
                                        <i class="bi bi-list-check me-2"></i>Description de votre tâche assignée
                                    </h5>
                                    <p class="card-text">{{ $tacheConcerner->description_tache }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Informations -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="bi bi-info-circle me-2"></i>Informations
                                            </h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <i class="bi bi-calendar-event me-2"></i>
                                                    <strong>Date début :</strong> 
                                                    {{ $tache->date_debu ? date('d/m/Y', strtotime($tache->date_debu)) : 'Non définie' }}
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-calendar-check me-2"></i>
                                                    <strong>Date fin :</strong> 
                                                    {{ $tache->date_fin ? date('d/m/Y', strtotime($tache->date_fin)) : 'Non définie' }}
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-clock me-2"></i>
                                                    <strong>Notification :</strong> 
                                                    {{ $tache->date_heur_notification ? date('d/m/Y H:i', strtotime($tache->date_heur_notification)) : '' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="bi bi-activity me-2"></i>Statut
                                            </h6>
                                            <div class="mb-3">
                                                <strong>État de la notification :</strong>
                                                @if($tache->etat == 0)
                                                    <span class="badge bg-warning">Non lu</span>
                                                @else
                                                    <span class="badge bg-success">Lu</span>
                                                @endif
                                            </div>
                                            
                                            @if(isset($tacheConcerner) && $tacheConcerner)
                                            <div class="mb-3">
                                                <strong>Votre affectation :</strong>
                                                <span class="badge bg-primary">
                                                    <i class="bi bi-person-check me-1"></i> Assigné à cette tâche
                                                </span>
                                            </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="mt-4 text-center">
                                <a href="javascript:history.back()" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-1"></i> Retour
                                </a>
                                
                                @if(isset($tacheConcerner) && $tacheConcerner)
                                    @if($tache->etat == 0)
                                    <form method="POST" action="{{ route('notifications.mark-read', $tache->id) }}" class="d-inline ms-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-1"></i> Marquer comme lu
                                        </button>
                                    </form>
                                    @else
                                    <!-- ⭐⭐ BOUTONS POUR LA PRÉPARATION DE LA TÂCHE (visible seulement quand la notification est lue) ⭐⭐ -->
                                    <div class="mt-3 d-flex justify-content-center gap-2">
                                        <!-- Bouton pour créer une préparation -->
                                        <a href="{{ route('preparations.create', ['notification_id' => $tache->id, 'tache_concerner_id' => $tacheConcerner->id] ) }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-1"></i> Préparer la tâche
                                        </a>
                                        
                                        <!-- Ou si vous avez déjà une préparation, bouton pour ajouter des détails -->
                                        @if(isset($preparation) && $preparation)
                                        <a href="{{ route('preparations.show', $preparation->id) }}" class="btn btn-info">
                                            <i class="bi bi-eye me-1"></i> Voir la préparation
                                        </a>
                                        
                                        <a href="{{ route('preparations.details.create', $preparation->id) }}" class="btn btn-success">
                                            <i class="bi bi-plus-lg me-1"></i> Ajouter un détail
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                @endif
                            </div>

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
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script>
    // Script pour marquer comme lu avec AJAX (optionnel)
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Rafraîchir la page pour mettre à jour le statut
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }
</script>

</body>

</html>