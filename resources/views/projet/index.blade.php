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

    /* ============ STYLES POUR LE SWITCH ACTIF ============ */
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 15px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 11px;
        width: 22px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background: linear-gradient(135deg, #28a745, #1e7e34);
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #28a745;
    }

    input:checked + .slider:before {
        transform: translateX(15px);
    }

    .switch-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .switch-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #6c757d;
    }

    .switch-label.active {
        color: #28a745;
        font-weight: 600;
    }

    .switch-label.inactive {
        color: #dc3545;
        font-weight: 600;
    }

    /* Animation pour le changement d'état */
    @keyframes switchToggle {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    input:checked + .slider {
        animation: switchToggle 0.3s ease;
    }

    /* Style pour les projets inactifs */
    .project-inactive {
        opacity: 0.7;
        background-color: rgba(220, 220, 220, 0.1);
    }

    .project-inactive:hover {
        background-color: rgba(220, 220, 220, 0.2);
    }


    /* ============ STYLES POUR LA LISTE DES INTERLOCUTEURS ============ */
    .client-link {
        color: #b15d15;
        cursor: pointer;
        text-decoration: none;
    }

    .client-link:hover {
        text-decoration: underline;
    }

    .interlocuteur-item {
        background: #f8f9fa;
        border-left: 3px solid #b15d15;
    }
  </style>
</head>

<body>

  <!-- ======= header ======= -->
    @include('page.header')

  <!-- ======= Sidebar ======= -->
   @include('page.sidebar')
  
  <main id="main" class="main">

        <div class="container-fluid py-4">
        <!-- En-tête -->
        @if(app('permission')->hasPermission('projet', 'creer'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-rocket me-2" style="color: #b15d15;"></i>
                        Liste des projets
                    </h1>
                    <a href="{{ route('projets.create') }}" class="btn btn-primary btn-perso">
                        <i class="fas fa-plus me-2"></i>Nouveau Projet
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if (session('success'))
            <div id="successAlert" class="alert alert-success" style="display: none;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filtres -->
        @if($hasApiPermission ?? false) {{-- Afficher les filtres SEULEMENT pour ceux qui ont la permission --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card interne">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filterActive" checked>
                                    <label class="form-check-label" for="filterActive">
                                        Afficher les projets actifs
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filterInactive" checked>
                                    <label class="form-check-label" for="filterInactive">
                                        Afficher les projets inactifs
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="filterAll" checked>
                                    <label class="form-check-label" for="filterAll">
                                        Tout afficher
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif {{-- FIN DU IF hasApiPermission --}}

        <!-- Tableau des projets -->
        <div class="card shadow interne">

            <div class="interne"><!--  card-body  -->
                @if($projets->count() > 0)
                    <div class="interne"> <!--  table-responsive  -->

                        <table class="interne" id="projectsTable"> <!--  table table-hover  -->
                            <thead class="interne"> <!--  table-light  -->
                                <tr>
                                    <th>Nom du Projet</th>
                                    <th>Type</th>
                                    <th>Client</th>

                                    @if(app('permission')->hasModule('api'))
                                    <th>Chef de Projet</th> 
                                    @endif

                                    <th>Dates</th>

                                    @if(app('permission')->hasModule('api'))
                                        <th>Actif</th>
                                    @endif
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody class="interne">
                                @foreach($projets as $projet)
                                    
                                    <tr class="{{ !$projet->actif ? 'project-inactive' : '' }} interne" data-active="{{ $projet->actif ? 'true' : 'false' }}" style="border-top: solid;">
                                        <td>
                                            <strong style="color: #2c3e50;">{{ $projet->non_de_projet }}</strong>
                                            @if($projet->description)
                                                <br><small class="text-muted">{{ Str::limit($projet->description, 50) }}</small>
                                            @endif
                                            @if(!$projet->actif)
                                                <br><small class="badge bg-secondary mt-1">Archivé</small>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge bg-info">
                                                {{ $projet->typeProjet->nom ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td style="color: #5a6a7a;">
                                            <a href="javascript:void(0);" 
                                            class="client-link" 
                                            onclick="showInterlocuteurs({{ $projet->id_client }}, '{{ $clientsMap[$projet->id_client] ?? 'Client #' . $projet->id_client }}')">
                                                {{ $clientsMap[$projet->id_client] ?? 'Client #' . $projet->id_client }}
                                            </a>
                                        </td>

                                        @if(app('permission')->hasModule('api'))
                                            <td>
                                                @if($projet->chefProjet)
                                                    <div class="d-flex align-items-center">
                                                        @if($projet->chefProjet->photo ?? false)
                                                            <img src="{{ $projet->chefProjet->photo }}" 
                                                                alt="{{ $projet->chefProjet->firstname ?? '' }} {{ $projet->chefProjet->lastname ?? '' }}"
                                                                class="rounded-circle me-2" 
                                                                style="width: 30px; height: 30px; object-fit: cover;">
                                                        @else
                                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                                style="width: 30px; height: 30px; background: #e9ecef; color: #6c757d;">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <small class="d-block" style="font-weight: 500;">
                                                                {{ $projet->chefProjet->firstname ?? '' }} {{ $projet->chefProjet->lastname ?? '' }}
                                                            </small>
                                                            @if($projet->chefProjet->login ?? false)
                                                                <small class="text-muted d-block">{{ $projet->chefProjet->login }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else


                                                    @php
                                                        $chefInfo = null;
                                                        if(!empty($utilisateurs['formatted']['users'])) {
                                                            foreach($utilisateurs['formatted']['users'] as $user) {
                                                                $userId = $user['id'] ?? $user['rowid'] ?? '';
                                                                $chefProjetId = $projet->id_utilisateur_chef_de_projet ?? '';
                                                                if($userId == $chefProjetId) {
                                                                    $chefInfo = $user;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    
                                                    @if($chefInfo)
                                                        <div class="d-flex align-items-center">
                                                            @if($chefInfo['photo'] ?? false)
                                                                <img src="{{ $chefInfo['photo'] }}" 
                                                                    alt="{{ $chefInfo['firstname'] ?? '' }} {{ $chefInfo['lastname'] ?? '' }}"
                                                                    class="rounded-circle me-2" 
                                                                    style="width: 30px; height: 30px; object-fit: cover;">
                                                            @else
                                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                                    style="width: 30px; height: 30px; background: #e9ecef; color: #6c757d;">
                                                                    <i class="bi bi-person"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <small class="d-block" style="font-weight: 500;">
                                                                    {{ $chefInfo['firstname'] ?? '' }} {{ $chefInfo['lastname'] ?? '' }}
                                                                </small>
                                                                @if($chefInfo['login'] ?? false)
                                                                    <small class="text-muted d-block">{{ $chefInfo['login'] }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Non assigné</span>
                                                    @endif
                                                @endif
                                            </td>
                                        @endif

                                        <td>
                                            @if($projet->date_debu)
                                                <small style="color: #5a6a7a;">
                                                    {{ \Carbon\Carbon::parse($projet->date_debu)->format('d/m/Y') }}
                                                    @if($projet->date_fin)
                                                        - {{ \Carbon\Carbon::parse($projet->date_fin)->format('d/m/Y') }}
                                                    @endif
                                                </small>
                                            @else
                                                <span class="text-muted">Non définies</span>
                                            @endif
                                        </td>

                                        @if(app('permission')->hasModule('api'))
                                            <td>
                                                <div class="switch-container">
                                                    <label class="switch">
                                                        <input type="checkbox" 
                                                            class="toggle-active" 
                                                            data-id="{{ $projet->id }}" 
                                                            data-url="{{ route('projets.toggle-active', $projet->id) }}"
                                                            {{ $projet->actif ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <span class="switch-label {{ $projet->actif ? 'active' : 'inactive' }}">
                                                        {{ $projet->actif ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                </div>
                                            </td>
                                        @endif
                                        
                                        <td>
                                            <span class="badge bg-{{ match($projet->status) {
                                                'brouillon' => 'secondary',
                                                'en_attente' => 'warning', 
                                                'en_cours' => 'primary',
                                                'termine' => 'success',
                                                'annule' => 'danger',
                                                default => 'secondary'
                                            } }}">
                                                {{ $projet->status }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if(app('permission')->hasPermission('projet', 'lire'))
                                                <a href="{{ route('projet.details.index', $projet->id) }}" 
                                                class="btn btn-outline-primary" 
                                                data-bs-toggle="tooltip" 
                                                title="Voir détails">
                                                    <i class="bi bi-file-text"></i>
                                                </a>
                                                @endif
                                                
                                                @if(app('permission')->hasPermission('projet', 'creer'))
                                                <a href="{{ route('projets.edit', $projet->id) }}"
                                                class="btn btn-outline-secondary" 
                                                data-bs-toggle="tooltip" 
                                                title="Modifier">
                                                    <i class="bi bi-pen"></i>
                                                </a>
                                                @endif
                                               
                                               @if(app('permission')->hasPermission('projet', 'supprimer'))
                                                    <form action="{{ route('projets.destroy', $projet->id) }}" 
                                                        method="POST" 
                                                        class="d-inline delete-form"
                                                        onsubmit="return confirmDelete(event, this, '{{addslashes($projet->nom ?? ',ce_projet,')}}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger delete-btn" 
                                                                data-bs-toggle="tooltip" 
                                                                title="Supprimer">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x mb-3" style="color: #b15d15; opacity: 0.7;"></i>
                        <h5 class="text-muted">Aucun projet trouvé</h5>

                        @if(app('permission')->hasPermission('projet', 'creer'))
                            <p class="text-muted">Commencez par créer votre premier projet</p>
                            <a href="{{ route('projets.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-2"></i>Créer un projet
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal pour les interlocuteurs -->
    <div class="modal fade" id="interlocuteursModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #000, #b15d15); color: white;">
                    <h5 class="modal-title" id="modalTitle" style="color: white;">
                        Interlocuteurs
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 id="clientName"></h6>
                    
                    <!-- Liste des interlocuteurs -->
                    <div id="interlocuteursList">
                        <p>Chargement...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
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
    // Activer les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
  </script>

  <script>
    // Fonction pour afficher une alerte de confirmation personnalisée
    function showConfirmAlert(message, onConfirm, onCancel = null) {
        // Créer l'overlay
        const overlay = document.createElement('div');
        overlay.className = 'confirm-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            animation: fadeIn 0.3s ease;
        `;
        
        // Créer l'alerte de confirmation
        const confirmAlert = document.createElement('div');
        confirmAlert.className = 'custom-confirm-alert';
        confirmAlert.style.cssText = `
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff3cd;
            color: #856404;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ffeaa7;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 9999;
            max-width: 450px;
            width: 90%;
            animation: slideInDown 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        `;
        
        // Contenu de l'alerte
        confirmAlert.innerHTML = `
            <div class="confirm-header">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>Confirmer la suppression</span>
            </div>
            <div class="confirm-body">
                ${message}
            </div>
            <div class="confirm-footer">
                <button type="button" class="confirm-btn cancel">Annuler</button>
                <button type="button" class="confirm-btn delete">Supprimer</button>
            </div>
        `;
        
        // Ajouter au body
        document.body.appendChild(overlay);
        document.body.appendChild(confirmAlert);
        
        // Gérer les boutons
        const cancelBtn = confirmAlert.querySelector('.cancel');
        const deleteBtn = confirmAlert.querySelector('.delete');
        
        // Fonction pour fermer l'alerte
        const closeAlert = () => {
            confirmAlert.style.animation = 'slideOutUp 0.3s ease';
            overlay.style.animation = 'fadeOut 0.3s ease';
            
            setTimeout(() => {
                if (confirmAlert.parentNode) {
                    confirmAlert.parentNode.removeChild(confirmAlert);
                }
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }, 300);
        };
        
        // Événements
        cancelBtn.addEventListener('click', () => {
            if (onCancel) onCancel();
            closeAlert();
        });
        
        deleteBtn.addEventListener('click', () => {
            closeAlert();
            setTimeout(() => {
                if (onConfirm) onConfirm();
            }, 300);
        });
        
        // Fermer en cliquant sur l'overlay
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                if (onCancel) onCancel();
                closeAlert();
            }
        });
        
        // Focus sur le bouton Annuler par défaut
        cancelBtn.focus();
    }

    // Fonction de confirmation pour la suppression
    function confirmDelete(event, form, projetName) {
        event.preventDefault();
        
        showConfirmAlert(
            `Êtes-vous sûr de vouloir supprimer <strong>"${projetName}"</strong> ?<br><small>Cette action est irréversible.</small>`,
            () => {
                // Soumettre le formulaire après confirmation
                form.submit();
            },
            () => {
                // Annulation - ne rien faire
                console.log('Suppression annulée');
            }
        );
        
        return false;
    }

    // Ajouter les animations CSS si nécessaire
    if (!document.querySelector('#confirmAnimations')) {
        const style = document.createElement('style');
        style.id = 'confirmAnimations';
        style.textContent = `
            @keyframes slideInDown {
                from {
                    transform: translateX(-50%) translateY(-20px);
                    opacity: 0;
                }
                to {
                    transform: translateX(-50%) translateY(0);
                    opacity: 1;
                }
            }
            @keyframes slideOutUp {
                from {
                    opacity: 1;
                    transform: translateX(-50%) translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(-50%) translateY(-20px);
                }
            }
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifier s'il y a des erreurs à afficher
        @if ($errors->any())
            showAlert('error', [
                @foreach ($errors->all() as $error)
                    '{{ $error }}',
                @endforeach
            ]);
        @endif

        // Vérifier s'il y a un message de succès
        @if (session('success'))
            showAlert('success', ['{{ session('success') }}']);
        @endif

        // Fonction pour afficher les alertes
        function showAlert(type, messages) {
            const config = {
                error: {
                    title: 'Erreur',
                    icon: 'bi-exclamation-triangle-fill',
                    bgColor: '#f8d7da',
                    textColor: '#721c24',
                    borderColor: '#f5c6cb',
                    iconColor: '#dc3545'
                },
                success: {
                    title: 'Succès',
                    icon: 'bi-check-circle-fill',
                    bgColor: '#d1e7dd',
                    textColor: '#0f5132',
                    borderColor: '#badbcc',
                    iconColor: '#198754'
                }
            };

            const alertConfig = config[type];
            
            // Créer un élément d'alerte stylisé
            const alertContainer = document.createElement('div');
            alertContainer.className = 'custom-alert';
            alertContainer.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: ${alertConfig.bgColor};
                color: ${alertConfig.textColor};
                padding: 15px 20px;
                border-radius: 8px;
                border: 1px solid ${alertConfig.borderColor};
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                z-index: 9999;
                max-width: 400px;
                width: 90%;
                animation: fadeInDown 0.3s ease;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            `;
            
            // Créer le contenu de l'alerte
            let alertContent = '<div style="font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; justify-content: center;">';
            alertContent += `<i class="bi ${alertConfig.icon}" style="margin-right: 8px; color: ${alertConfig.iconColor};"></i>`;
            alertContent += alertConfig.title;
            alertContent += '</div>';
            alertContent += '<div style="font-size: 0.9em; line-height: 1.4;">';
            
            messages.forEach(message => {
                alertContent += '<div style="margin: 5px 0; padding-left: 5px; border-left: 3px solid ' + alertConfig.iconColor + '; text-align: center;">';
                alertContent += message;
                alertContent += '</div>';
            });
            
            alertContent += '</div>';
            
            // Ajouter le bouton de fermeture
            alertContent += '<button class="closeAlertBtn" style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: ' + alertConfig.textColor + '; cursor: pointer; font-size: 18px;">&times;</button>';
            
            alertContainer.innerHTML = alertContent;
            
            // Ajouter au body
            document.body.appendChild(alertContainer);
            
            // Ajouter l'animation CSS si pas déjà présente
            if (!document.querySelector('#alertAnimations')) {
                const style = document.createElement('style');
                style.id = 'alertAnimations';
                style.textContent = `
                    @keyframes fadeInDown {
                        from { 
                            transform: translateX(-50%) translateY(-20px); 
                            opacity: 0; 
                        }
                        to { 
                            transform: translateX(-50%) translateY(0); 
                            opacity: 1; 
                        }
                    }
                    @keyframes fadeOutUp {
                        from { 
                            opacity: 1; 
                            transform: translateX(-50%) translateY(0); 
                        }
                        to { 
                            opacity: 0; 
                            transform: translateX(-50%) translateY(-20px); 
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Gérer la fermeture
            const closeBtn = alertContainer.querySelector('.closeAlertBtn');
            closeBtn.addEventListener('click', function() {
                closeAlert(alertContainer);
            });
            
            // Fermeture automatique après 8 secondes
            setTimeout(() => {
                closeAlert(alertContainer);
            }, 8000);
            
            // Fonction pour fermer l'alerte
            function closeAlert(container) {
                container.style.animation = 'fadeOutUp 0.3s ease';
                setTimeout(() => {
                    if (container.parentNode) {
                        container.parentNode.removeChild(container);
                    }
                }, 300);
            }
        }

        // Gestion des filtres
        const filterActive = document.getElementById('filterActive');
        const filterInactive = document.getElementById('filterInactive');
        const filterAll = document.getElementById('filterAll');
        const projectsTable = document.getElementById('projectsTable');
        
        function filterProjects() {
            const showActive = filterActive.checked;
            const showInactive = filterInactive.checked;
            const rows = projectsTable.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const isActive = row.getAttribute('data-active') === 'true';
                
                if ((isActive && showActive) || (!isActive && showInactive)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        
        // Événements pour les filtres
        filterActive.addEventListener('change', function() {
            if (!this.checked && !filterInactive.checked) {
                this.checked = true;
                return;
            }
            filterAll.checked = this.checked && filterInactive.checked;
            filterProjects();
        });
        
        filterInactive.addEventListener('change', function() {
            if (!this.checked && !filterActive.checked) {
                this.checked = true;
                return;
            }
            filterAll.checked = this.checked && filterActive.checked;
            filterProjects();
        });
        
        filterAll.addEventListener('change', function() {
            filterActive.checked = this.checked;
            filterInactive.checked = this.checked;
            filterProjects();
        });
        
        // Gestion du toggle actif/inactif
        const toggleSwitches = document.querySelectorAll('.toggle-active');
        
        toggleSwitches.forEach(switchElement => {
            switchElement.addEventListener('change', function() {
                const projectId = this.getAttribute('data-id');
                const url = this.getAttribute('data-url');
                const isActive = this.checked;
                const switchLabel = this.closest('.switch-container').querySelector('.switch-label');
                const projectRow = this.closest('tr');
                
                // Mettre à jour l'interface utilisateur immédiatement
                switchLabel.textContent = isActive ? 'Actif' : 'Inactif';
                switchLabel.className = `switch-label ${isActive ? 'active' : 'inactive'}`;
                projectRow.setAttribute('data-active', isActive ? 'true' : 'false');
                
                if (isActive) {
                    projectRow.classList.remove('project-inactive');
                } else {
                    projectRow.classList.add('project-inactive');
                }
                
                // Envoyer la requête AJAX
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ actif: isActive })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // Revenir à l'état précédent en cas d'erreur
                        this.checked = !isActive;
                        switchLabel.textContent = !isActive ? 'Actif' : 'Inactif';
                        switchLabel.className = `switch-label ${!isActive ? 'active' : 'inactive'}`;
                        projectRow.setAttribute('data-active', !isActive ? 'true' : 'false');
                        
                        if (!isActive) {
                            projectRow.classList.remove('project-inactive');
                        } else {
                            projectRow.classList.add('project-inactive');
                        }
                        
                        showAlert('error', [data.message || 'Une erreur est survenue']);
                    } else {
                        showAlert('success', [`Projet ${isActive ? 'activé' : 'désactivé'} avec succès`]);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    // Revenir à l'état précédent en cas d'erreur
                    this.checked = !isActive;
                    switchLabel.textContent = !isActive ? 'Actif' : 'Inactif';
                    switchLabel.className = `switch-label ${!isActive ? 'active' : 'inactive'}`;
                    projectRow.setAttribute('data-active', !isActive ? 'true' : 'false');
                    
                    if (!isActive) {
                        projectRow.classList.remove('project-inactive');
                    } else {
                        projectRow.classList.add('project-inactive');
                    }
                    
                    showAlert('error', ['Erreur réseau. Veuillez réessayer.']);
                });
            });
        });
    });

    // Fonction pour afficher les interlocuteurs
    async function showInterlocuteurs(clientId, clientName) {
        console.log('showInterlocuteurs appelée avec:', clientId, clientName);
        
        // Mettre à jour le titre du modal
        document.getElementById('modalTitle').textContent = 'Interlocuteurs - ' + clientName;
        document.getElementById('clientName').textContent = 'Client: ' + clientName;
        
        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('interlocuteursModal'));
        modal.show();
        
        // Charger les interlocuteurs
        await loadInterlocuteurs(clientId, clientName);
    }

    async function loadInterlocuteurs(clientId, clientName) {
        console.log('=== FORCED LOAD ===');
        console.log('Client:', clientId, '-', clientName);
        
        const interlocuteursList = document.getElementById('interlocuteursList');
        if (!interlocuteursList) {
            console.error('Élément interlocuteursList non trouvé');
            return;
        }
        
        // VIDER COMPLÈTEMENT et montrer un loader
        interlocuteursList.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-2">Chargement des interlocuteurs...</p>
                <p class="small text-muted">Client: ${escapeHtml(clientName)} (ID: ${clientId})</p>
            </div>
        `;
        
        try {
            const userId = {{ Session::get('user.id') ?? 0 }};
            const apiUrl = `/interlocuteurs/client/${clientId}?user_id=${userId}&_=${Date.now()}`;
            
            console.log('API Call:', apiUrl);
            
            const response = await fetch(apiUrl);
            
            if (!response.ok) {
                throw new Error(`API error: ${response.status} ${response.statusText}`);
            }
            
            const result = await response.json();
            
            console.log('API Response:', result);
            
            // VIDER À NOUVEAU pour être sûr
            interlocuteursList.innerHTML = '';
            
            // Si succès et il y a des données
            if (result.success) {
                if (result.count > 0 && result.interlocuteurs.length > 0) {
                    console.log(`Affichage de ${result.count} interlocuteur(s)`);

                    // Créer un conteneur pour les résultats
                    const resultsContainer = document.createElement('div');
                    resultsContainer.id = 'apiResultsContainer';
                    
                    // Ajouter chaque interlocuteur
                    result.interlocuteurs.forEach((interlocuteur, index) => {
                        console.log(`Interlocuteur ${index + 1}:`, interlocuteur);
                        
                        // Formater les numéros (tableau)
                        let numerosHtml = '';
                        if (interlocuteur.numeros && Array.isArray(interlocuteur.numeros) && interlocuteur.numeros.length > 0) {
                            numerosHtml = `
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Numéros:</small>
                                    ${interlocuteur.numeros.map(numero => 
                                        `<span class="badge bg-info me-1 mb-1">
                                            <i class="bi bi-telephone"></i> ${escapeHtml(numero)}
                                        </span>`
                                    ).join('')}
                                </div>
                            `;
                        } else if (interlocuteur.numero) {
                            // Ancien format (un seul numéro)
                            numerosHtml = `
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Numéro:</small>
                                    <span class="badge bg-info">
                                        <i class="bi bi-telephone"></i> ${escapeHtml(interlocuteur.numero)}
                                    </span>
                                </div>
                            `;
                        }
                        
                        // Formater les emails
                        let emailHtml = '';
                        if (interlocuteur.email) {
                            emailHtml = `
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Email:</small>
                                    <a href="mailto:${escapeHtml(interlocuteur.email)}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-1"></i>${escapeHtml(interlocuteur.email)}
                                    </a>
                                </div>
                            `;
                        }
                        
                        // Formater le lieu d'opération
                        let lieuOperationHtml = '';
                        if (interlocuteur.lieu_operation) {
                            lieuOperationHtml = `
                                <div class="mt-2">
                                    <small class="text-muted d-block mb-1">Lieu d'opération:</small>
                                    <span>
                                        <i class="bi bi-geo-alt me-1"></i>${escapeHtml(interlocuteur.lieu_operation)}
                                    </span>
                                </div>
                            `;
                        }
                        
                        const item = document.createElement('div');
                        item.className = 'interlocuteur-item mb-3 p-3 border rounded';
                        item.style.borderLeft = '4px solid #28a745';
                        item.innerHTML = `
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">${escapeHtml(interlocuteur.nom_interlocuteur)}</h6>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-primary">${escapeHtml(interlocuteur.fonction || '')}</span>
                                </div>
                            </div>
                            
                            ${emailHtml}
                            ${lieuOperationHtml}
                            ${numerosHtml}
                        `;
                        resultsContainer.appendChild(item);
                    });
                    
                    interlocuteursList.appendChild(resultsContainer);
                    
                } else {
                    // Aucun interlocuteur
                    interlocuteursList.innerHTML = `
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-info-circle fs-4 me-3"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Aucun interlocuteur trouvé</h6>
                                    <p class="mb-0">${escapeHtml(result.message || `Aucun interlocuteur n'est associé à ce client (${clientName})`)}</p>
                                    <div class="mt-3">
                                        <p class="small text-muted mb-2">Détails techniques:</p>
                                        <ul class="small text-muted mb-0">
                                            <li>Client ID: ${clientId}</li>
                                            <li>User ID: ${userId}</li>
                                            <li>Note: ${escapeHtml(result.note || '')}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            } else {
                // Erreur API
                interlocuteursList.innerHTML = `
                    <div class="alert alert-danger">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-x-circle fs-4 me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Erreur API</h6>
                                <p class="mb-0">${escapeHtml(result.message || 'Erreur inconnue')}</p>
                                ${result.error ? `<div class="small mt-2 text-muted">${escapeHtml(result.error)}</div>` : ''}
                                <div class="mt-3">
                                    <button onclick="retryLoadInterlocuteurs(${clientId}, '${escapeHtml(clientName)}')" 
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-arrow-clockwise"></i> Réessayer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
        } catch (error) {
            console.error('Erreur:', error);
            
            interlocuteursList.innerHTML = `
                <div class="alert alert-danger">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bug fs-4 me-3"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Erreur technique</h6>
                            <p class="mb-0">Une erreur est survenue lors du chargement</p>
                            <div class="small text-muted mt-2">${escapeHtml(error.message)}</div>
                            <div class="mt-3">
                                <button onclick="retryLoadInterlocuteurs(${clientId}, '${escapeHtml(clientName)}')" 
                                        class="btn btn-sm btn-outline-danger me-2">
                                    <i class="bi bi-arrow-clockwise"></i> Réessayer
                                </button>
                                <button onclick="forceReload(${clientId}, '${escapeHtml(clientName)}')" 
                                        class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-lightning-charge"></i> Forcer le rechargement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // Fonction utilitaire pour échapper le HTML
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function forceReload(clientId, clientName) {
        console.log('Force reload pour client:', clientId);
        loadInterlocuteurs(clientId, clientName);
    }

    // Fonction de réessai spécifique pour les interlocuteurs
    function retryLoadInterlocuteurs(clientId, clientName) {
        console.log('Réessai pour client:', clientId, clientName);
        loadInterlocuteurs(clientId, clientName);
    }
  </script>
</body>
</html>