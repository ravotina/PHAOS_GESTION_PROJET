<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Validations</title>
    
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
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        .validation-card {
            border-left: 4px solid #0d6efd;
            transition: all 0.3s ease;
        }
        
        .validation-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .validation-card.validated {
            border-left-color: #198754;
        }
        
        .validation-card.rejected {
            border-left-color: #dc3545;
        }
        
        .badge-validation {
            font-size: 0.75rem;
            padding: 4px 8px;
        }
        
        .project-info {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .first-step-badge {
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
            color: white;
        }

        .btn-create-step {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-create-step:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        .step-created-badge {
            background: linear-gradient(45deg, #17a2b8, #20c997);
            color: white;
        }

        /* Styles pour les modals */
        .list-group-item.active {
            background-color: #e7f1ff;
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .modal-type-icon {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .step-type-option {
            cursor: pointer;
            transition: all 0.2s;
        }

        .step-type-option:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .step-type-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .step-type-icon.validation {
            background-color: #e7f1ff;
            color: #0d6efd;
        }

        .step-type-icon.revision {
            background-color: #fff3cd;
            color: #ffc107;
        }

        .step-type-icon.approbation {
            background-color: #d1e7dd;
            color: #198754;
        }

        .step-type-icon.consultation {
            background-color: #cff4fc;
            color: #0dcaf0;
        }
    </style>
</head>
<body>
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="p-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Mes Validations
                                    </h5>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Validations</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="badge bg-primary">
                                    {{ $validationsEnAttente->total() }} en attente
                                </div>
                            </div>
                            
                            <!-- Alertes -->
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            <!-- Section Projets en première étape -->
                            @if($projetsPremiereEtape->count() > 0)
                            <div class="card mb-4 border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="bi bi-star-fill me-2"></i>
                                        Projets en première étape
                                        <span class="badge bg-light text-primary ms-2">{{ $projetsPremiereEtape->count() }}</span>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                        @foreach($projetsPremiereEtape as $projet)
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100 border-start border-3 border-primary">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <span class="badge first-step-badge mb-2">
                                                                <i class="bi bi-1-circle me-1"></i> Première étape
                                                            </span>
                                                            <h6 class="card-title mb-2">
                                                                <i class="bi bi-folder me-1"></i>
                                                                {{ $projet->titre }}
                                                                <small class="text-muted">({{ $projet->numero_projet }})</small>
                                                            </h6>
                                                            <p class="card-text mb-1">
                                                                <small class="text-muted">
                                                                    <i class="bi bi-calendar me-1"></i>
                                                                    Créé le {{ date('d/m/Y', strtotime($projet->created_at)) }}
                                                                </small>
                                                            </p>
                                                            @if($projet->workflows->first())
                                                            <p class="card-text mb-0">
                                                                <small>
                                                                    <strong>Étape :</strong> {{ $projet->workflows->first()->nom_etape }}
                                                                </small>
                                                            </p>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <a href="{{ route('validation.show-projet', ['id' => $projet->id]) }}" 
                                                               class="btn btn-sm btn-primary mb-2">
                                                                <i class="bi bi-eye me-1"></i> Voir
                                                            </a>
                                                            
                                                            <!-- Bouton pour créer/voir l'étape -->
                                                            @php
                                                                $userEtape = $projet->etapesValidation->where('id_utilisateur', $userId)->first();
                                                            @endphp
                                                            
                                                            @if(!$userEtape)
                                                            <br>
                                                            <button type="button" class="btn btn-sm btn-success mt-1" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#modalChoixEtape{{ $projet->id }}">
                                                                <i class="bi bi-plus-circle me-1"></i> Créer étape
                                                            </button>

                                                            @else

                                                            <br>
                                                            <div class="mt-1">
                                                                <span class="badge {{ $userEtape->status == 'en attente' ? 'bg-warning' : ($userEtape->status == 'validé' ? 'bg-success' : 'bg-danger') }}">
                                                                    <i class="bi {{ $userEtape->status == 'en attente' ? 'bi-clock' : ($userEtape->status == 'validé' ? 'bi-check-circle' : 'bi-x-circle') }} me-1"></i>
                                                                    {{ ucfirst($userEtape->status) }}
                                                                </span>
                                                                <br>
                                                                <a href="{{ route('validation.show', $userEtape->id) }}" class="btn btn-sm btn-outline-primary mt-1">
                                                                    <i class="bi bi-check-square me-1"></i> -----
                                                                </a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal pour choisir le type d'étape pour CE PROJET -->
                                        <div class="modal fade" id="modalChoixEtape{{ $projet->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-list-check me-2"></i>
                                                            Choisir le type d'étape
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="mb-3">Sélectionnez le type d'étape pour le projet :</p>
                                                        <p class="fw-bold text-primary">{{ $projet->titre }} <small class="text-muted">({{ $projet->numero_projet }})</small></p>
                                                        
                                                        <form id="formCreerEtape{{ $projet->id }}" action="{{ route('validation.creer-premiere-etape', $projet->id) }}" method="POST">
                                                            @csrf
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Type d'étape *</label>
                                                                <div class="list-group">
                                                                    <label class="list-group-item list-group-item-action step-type-option">
                                                                        <div class="form-check d-flex align-items-center">
                                                                            <input class="form-check-input me-3" type="radio" name="type_etape" value="validation" checked>
                                                                            <div class="step-type-icon validation me-3">
                                                                                <i class="bi bi-check-circle-fill"></i>
                                                                            </div>
                                                                            <div>
                                                                                <strong class="d-block">Validation</strong>
                                                                                <small class="text-muted">Valider ou rejeter le projet avec commentaires</small>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    
                                                                    <label class="list-group-item list-group-item-action step-type-option">
                                                                        <div class="form-check d-flex align-items-center">
                                                                            <input class="form-check-input me-3" type="radio" name="type_etape" value="revision">
                                                                            <div class="step-type-icon revision me-3">
                                                                                <i class="bi bi-pencil-fill"></i>
                                                                            </div>
                                                                            <div>
                                                                                <strong class="d-block">Révision</strong>
                                                                                <small class="text-muted">Demander des modifications avant validation</small>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    
                                                                    <label class="list-group-item list-group-item-action step-type-option">
                                                                        <div class="form-check d-flex align-items-center">
                                                                            <input class="form-check-input me-3" type="radio" name="type_etape" value="approbation">
                                                                            <div class="step-type-icon approbation me-3">
                                                                                <i class="bi bi-award-fill"></i>
                                                                            </div>
                                                                            <div>
                                                                                <strong class="d-block">Approbation</strong>
                                                                                <small class="text-muted">Donner votre approbation définitive</small>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    
                                                                    <label class="list-group-item list-group-item-action step-type-option">
                                                                        <div class="form-check d-flex align-items-center">
                                                                            <input class="form-check-input me-3" type="radio" name="type_etape" value="consultation">
                                                                            <div class="step-type-icon consultation me-3">
                                                                                <i class="bi bi-chat-left-text-fill"></i>
                                                                            </div>
                                                                            <div>
                                                                                <strong class="d-block">Consultation</strong>
                                                                                <small class="text-muted">Donner votre avis consultatif</small>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="commentaire_initial{{ $projet->id }}" class="form-label">
                                                                    <i class="bi bi-chat-left-text me-1"></i> Commentaire initial (optionnel)
                                                                </label>
                                                                <textarea class="form-control" id="commentaire_initial{{ $projet->id }}" 
                                                                          name="commentaire_initial" rows="3" 
                                                                          placeholder="Ajoutez un commentaire initial..."></textarea>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-1"></i> Annuler
                                                        </button>
                                                        <button type="submit" form="formCreerEtape{{ $projet->id }}" class="btn btn-primary">
                                                            <i class="bi bi-check-circle me-1"></i> Créer l'étape
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin du modal -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            
                            @if($projetsRejetes->count() > 0)
                            <div class="card mb-4">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-exclamation-triangle"></i> Projets Rejetés aux Étapes Suivantes
                                        <span class="badge bg-light text-dark">{{ $projetsRejetes->count() }}</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <!-- <i class="fas fa-info-circle"></i> Ces projets ont été rejetés aux étapes suivantes. Vous étiez concerné à l'étape précédente. -->
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Projet</th>
                                                    <th>Étape Rejetée</th>
                                                    <th>Commentaire du Rejet</th>
                                                    <th>Date du Rejet</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($projetsRejetes as $projet)
                                                    @php
                                                        // Récupérez les informations de rejet
                                                        $rejetInfo = $projet->rejet_info ?? [
                                                            'commentaire' => $projet->commentaire_rejet ?? null,
                                                            'date_rejet' => $projet->date_rejet ?? null,
                                                            'etape_rejetee' => $projet->etape_rejetee ?? null,
                                                            'utilisateur_rejet' => $projet->utilisateur_rejet ?? null
                                                        ];
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $projet->titre ?? $projet->nom }}</strong><br>
                                                            <small class="text-muted">ID: {{ $projet->id }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-danger">
                                                                {{ $rejetInfo['etape_rejetee'] ?? 'Inconnue' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="commentaire-rejet">
                                                                @if($rejetInfo['commentaire'] ?? null)
                                                                    <em>"{{ Str::limit($rejetInfo['commentaire'], 150) }}"</em><br>
                                                                    <small class="text-muted">
                                                                        Par: Utilisateur #{{ $rejetInfo['utilisateur_rejet'] ?? 'Inconnu' }}
                                                                    </small>
                                                                @else
                                                                    <span class="text-muted">Aucun commentaire</span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($rejetInfo['date_rejet'] ?? null)
                                                                {{ \Carbon\Carbon::parse($rejetInfo['date_rejet'])->format('d/m/Y H:i') }}
                                                            @endif
                                                        </td>


                                                        <td>
                                                            <div class="btn-group">
                                                                @if(isset($projet->id))
                                                                    <a href="{{ route('validation.historique', $projet->id) }}" 
                                                                    class="btn btn-sm btn-info" 
                                                                    title="Voir l'historique">
                                                                        <i class="fas fa-history"></i>
                                                                    </a>
                                                                    <a href="{{ route('validation.show-projet', $projet->id) }}" 
                                                                    class="btn btn-sm btn-warning" 
                                                                    title="Voir les détails du projet">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </td>


                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- En-tête avec statistiques -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card text-center border-primary">
                                        <div class="card-body">
                                            <h3 class="card-title text-primary">{{ $validationsEnAttente->total() }}</h3>
                                            <p class="card-text">En attente</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center border-success">
                                        <div class="card-body">
                                            <h3 class="card-title text-success">{{ $validationsTraitees->total() }}</h3>
                                            <p class="card-text">Traitées</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center border-info">
                                        <div class="card-body">
                                            <h3 class="card-title text-info">{{ $validationsEnAttente->total() + $validationsTraitees->total() }}</h3>
                                            <p class="card-text">Total</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Onglets -->
                            <ul class="nav nav-tabs mb-4" id="validationTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                                        <i class="bi bi-clock me-1"></i> En attente
                                        <span class="badge bg-warning ms-1">{{ $validationsEnAttente->count() }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                                        <i class="bi bi-history me-1"></i> Historique
                                    </button>
                                </li>
                            </ul>
                            
                            <!-- Contenu des onglets -->
                            <div class="tab-content" id="validationTabContent">
                                <!-- Onglet En attente -->
                                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                                    @if($validationsEnAttente->count() > 0)
                                        @foreach($validationsEnAttente as $validation)
                                            <div class="card validation-card mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="card-title mb-1">
                                                                <i class="bi bi-folder me-1"></i>
                                                                {{ $validation->projet->titre }}
                                                                <small class="text-muted">({{ $validation->projet->numero_projet }})</small>
                                                            </h6>
                                                            <p class="card-text mb-2">
                                                                <strong>Étape :</strong> {{ $validation->etape }}
                                                                <br>
                                                                <small class="text-muted">
                                                                    <i class="bi bi-calendar me-1"></i>
                                                                    Créée le {{ date('d/m/Y', strtotime($validation->date_creation)) }}
                                                                </small>
                                                            </p>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="badge bg-warning badge-validation mb-2">
                                                                <i class="bi bi-clock me-1"></i> En attente
                                                            </span>
                                                            <br>
                                                            <a href="{{ route('validation.show', $validation->id) }}" class="btn btn-sm btn-primary">
                                                                <i class="bi bi-eye me-1"></i> Voir les tache
                                                            </a>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($validation->workflow && $validation->workflow->commentaires)
                                                        <div class="alert alert-light border mt-2 mb-0">
                                                            <small><i class="bi bi-chat-left-text me-1"></i> <strong>Commentaire :</strong> {{ Str::limit($validation->workflow->commentaires, 150) }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $validationsEnAttente->links() }}
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-check2-circle fs-1 text-muted mb-3"></i>
                                            <h5 class="text-muted">Aucune validation en attente</h5>
                                            <p class="text-muted">Vous n'avez pas de validation à traiter pour le moment.</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Onglet Historique -->
                                <div class="tab-pane fade" id="history" role="tabpanel">
                                    @if($validationsTraitees->count() > 0)
                                        @foreach($validationsTraitees as $validation)
                                            <div class="card validation-card mb-3 {{ $validation->status == 'validé' ? 'validated' : 'rejected' }}">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <h6 class="card-title mb-1">
                                                                <i class="bi bi-folder me-1"></i>
                                                                {{ $validation->projet->titre }}
                                                                <small class="text-muted">({{ $validation->projet->numero_projet }})</small>
                                                            </h6>
                                                            <p class="card-text mb-2">
                                                                <strong>Étape :</strong> {{ $validation->etape }}
                                                                <br>
                                                                <small class="text-muted">
                                                                    <i class="bi bi-calendar me-1"></i>
                                                                    Traitée le {{ date('d/m/Y', strtotime($validation->date_decision)) }}
                                                                </small>
                                                            </p>
                                                            @if($validation->commentaire)
                                                                <div class="alert alert-light border mt-2 mb-0">
                                                                    <small><i class="bi bi-chat-left-text me-1"></i> <strong>Votre commentaire :</strong> {{ Str::limit($validation->commentaire, 150) }}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="badge {{ $validation->status == 'validé' ? 'bg-success' : 'bg-danger' }} badge-validation mb-2">
                                                                <i class="bi {{ $validation->status == 'validé' ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                                                {{ ucfirst($validation->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $validationsTraitees->links() }}
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-clock-history fs-1 text-muted mb-3"></i>
                                            <h5 class="text-muted">Aucun historique de validation</h5>
                                            <p class="text-muted">Vous n'avez pas encore traité de validation.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('page.footer')
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
    // Initialiser les onglets
    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#validationTab button'));
        triggerTabList.forEach(function (triggerEl) {
            const tabTrigger = new bootstrap.Tab(triggerEl);
            
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
        
        // Gérer la sélection des types d'étape
        const radioInputs = document.querySelectorAll('input[name="type_etape"]');
        radioInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Retirer la classe active de tous les éléments
                document.querySelectorAll('.step-type-option').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Ajouter la classe active à l'élément parent
                if (this.checked) {
                    this.closest('.step-type-option').classList.add('active');
                }
            });
            
            // Initialiser l'état actif
            if (input.checked) {
                input.closest('.step-type-option').classList.add('active');
            }
        });
        
        // Confirmation avant soumission
        const forms = document.querySelectorAll('form[id^="formCreerEtape"]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const typeEtape = this.querySelector('input[name="type_etape"]:checked').value;
                const typeLabels = {
                    'validation': 'Validation',
                    'revision': 'Révision',
                    'approbation': 'Approbation',
                    'consultation': 'Consultation'
                };
                
                if (!confirm(`Créer une étape de type "${typeLabels[typeEtape] || typeEtape}" pour ce projet ?`)) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
</body>
</html>