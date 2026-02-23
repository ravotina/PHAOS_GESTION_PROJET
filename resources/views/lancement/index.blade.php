<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Tous les Projets Lancés - Cabinet PHAOS</title>
    
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
    
</head>
<body>

    @include('page.header')
    @include('layouts.sidebar')
    
<main id="main" class="main">
<div class="container-fluid py-4">
    
    <!-- En-tête principal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-rocket text-primary me-2"></i>
                        Tout Projet Lancé
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projets.index') }}">Projets</a></li>
                            <li class="breadcrumb-item active">Projets Lancés</li>
                        </ol>
                    </nav>
                </div>
                <!-- BOUTON AJOUTÉ : Préparer calendrier -->
                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#selectCalendrierModal">
                    <i class="bi bi-calendar-plus me-2"></i>Préparer Calendrier
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Barre de filtres rapides -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="projetFilter" class="form-label fw-bold">
                        <i class="bi bi-funnel me-2"></i>
                        Filtrer par projet
                    </label>
                    <select class="form-select" id="projetFilter" name="projet_id">
                        <option value="">-- Tous les projets --</option>
                        @foreach($tousLesProjets as $projet)
                            <option value="{{ $projet->id }}"
                                    {{ request('projet_id') == $projet->id ? 'selected' : '' }}>
                                {{ $projet->non_de_projet }}
                                @if($projet->typeProjet)
                                    ({{ $projet->typeProjet->nom }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="searchInput" class="form-label fw-bold">
                        <i class="bi bi-search me-2"></i>
                        Rechercher
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" 
                               placeholder="Nom du lancement..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Boutons de filtres rapides -->

        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total lancements</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary bg-opacity-10">
                            <i class="bi bi-rocket fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Budget total</h6>
                            <h3 class="mb-0">
                                {{ number_format($stats['budget_total'], 0, ',', ' ') }} €
                            </h3>
                        </div>
                        <div class="avatar-sm rounded-circle bg-success bg-opacity-10">
                            <i class="bi bi-currency-euro fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Projets distincts</h6>
                            <h3 class="mb-0">{{ $stats['projets_distincts'] }}</h3>
                        </div>
                        <div class="avatar-sm rounded-circle bg-info bg-opacity-10">
                            <i class="bi bi-diagram-3 fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Taux accompli</h6>
                            <h3 class="mb-0">
                              
                            </h3>
                        </div>
                        <div class="avatar-sm rounded-circle bg-warning bg-opacity-10">
                            <i class="bi bi-graph-up fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des lancements -->
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-list-ul me-2"></i>
                    Liste des projets lancés
                </h6>
                <div class="text-muted small">
                    @if($lancements->total() > 0)
                        Affichage de {{ $lancements->firstItem() }} à {{ $lancements->lastItem() }} sur {{ $lancements->total() }}
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if($lancements->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-rocket fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun projet lancé</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['projet_id', 'status', 'search']))
                            Aucun résultat pour vos critères de recherche.
                        @else
                            Commencez par lancer votre premier projet
                        @endif
                    </p>
                   
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Nom du lancement</th>
                                <th>Projet parent</th>
                                <th>Dates</th>
                                <th>Budget</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lancements as $lancement)
                            @php
                                // Calcul du statut
                                $now = now();
                                $dateDebut = $lancement->date_debu;
                                $dateFin = $lancement->date_fin;
                                
                                $statut = 'non_planifie';
                                $statutClass = 'secondary';
                                $statutText = 'Non planifié';
                                
                                if ($dateDebut && $dateFin) {
                                    if ($now->between($dateDebut, $dateFin)) {
                                        $statut = 'en_cours';
                                        $statutClass = 'primary';
                                        $statutText = 'En cours';
                                    } elseif ($now->gt($dateFin)) {
                                        $statut = 'termine';
                                        $statutClass = 'success';
                                        $statutText = 'Terminé';
                                    } elseif ($now->lt($dateDebut)) {
                                        $statut = 'a_venir';
                                        $statutClass = 'warning';
                                        $statutText = 'À venir';
                                    }
                                } elseif ($dateDebut && !$dateFin) {
                                    if ($now->gte($dateDebut)) {
                                        $statut = 'en_cours';
                                        $statutClass = 'primary';
                                        $statutText = 'En cours';
                                    } else {
                                        $statut = 'a_venir';
                                        $statutClass = 'warning';
                                        $statutText = 'À venir';
                                    }
                                }
                            @endphp
                            
                            <tr>
                                <td>
                                    <strong>{{ $lancement->nom }}</strong>
                                    @if($lancement->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($lancement->description, 50) }}</small>
                                    @endif
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-person me-1"></i>
                                        Responsable: {{ $lancement->id_utilisateur }}
                                    </small>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <strong>{{ $lancement->projetDemare->non_de_projet ?? 'N/A' }}</strong>
                                            @if($lancement->projetDemare && $lancement->projetDemare->typeProjet)
                                                <br>
                                                <span class="badge bg-info">
                                                    {{ $lancement->projetDemare->typeProjet->nom }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="small">
                                        @if($dateDebut)
                                            <div>
                                                <i class="bi bi-calendar-plus me-1"></i>
                                                Début: {{ $dateDebut->format('d/m/Y') }}
                                            </div>
                                        @endif
                                        @if($dateFin)
                                            <div>
                                                <i class="bi bi-calendar-check me-1"></i>
                                                Fin: {{ $dateFin->format('d/m/Y') }}
                                            </div>
                                        @endif
                                        @if($dateDebut && $dateFin)
                                            <div class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $dateDebut->diffInDays($dateFin) }} jours
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <td>
                                    @if($lancement->budget > 0)
                                        <span class="fw-bold text-success">
                                            {{ number_format($lancement->budget, 2, ',', ' ') }} Ar
                                        </span>
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <span class="badge bg-{{ $statutClass }}">
                                        {{ $statutText }}
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- BOUTON AJOUTÉ : Calendrier emploi du temps -->
                                        @if(app('permission')->hasPermission('projet', 'lire'))
                                        <a href="{{ route('emploi-du-temps.calendrier', [$lancement->projetDemare->id ?? 0, $lancement->id]) }}" 
                                           class="btn btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="Calendrier emploi du temps">
                                            <i class="bi bi-calendar-week"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Voir détails -->
                                        @if(app('permission')->hasPermission('projet', 'lire'))
                                        <a href="{{ route('lancement.show', [$lancement->projetDemare->id ?? 0, $lancement->id]) }}" 
                                           class="btn btn-outline-primary" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Gérer les détails -->
                                        @if(app('permission')->hasPermission('projet', 'lire'))
                                        <a href="{{ route('lancement.details.index', [$lancement->projetDemare->id ?? 0, $lancement->id]) }}" 
                                           class="btn btn-outline-secondary"
                                           data-bs-toggle="tooltip" 
                                           title="Gérer les détails">
                                            <i class="bi bi-list-ul"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Modifier -->
                                        @if(app('permission')->hasPermission('projet', 'creer'))
                                        <a href="{{ route('lancement.edit', [$lancement->projetDemare->id ?? 0, $lancement->id]) }}" 
                                           class="btn btn-outline-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @endif
                                        
                                        <!-- Supprimer -->
                                        @if(app('permission')->hasPermission('projet', 'supprimer'))
                                        <form action="{{ route('lancement.destroy', [$lancement->projetDemare->id ?? 0, $lancement->id]) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Supprimer ce lancement ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Supprimer">
                                                <i class="bi bi-trash"></i>
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
                
                <!-- Pagination -->
                @if($lancements->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Page {{ $lancements->currentPage() }} sur {{ $lancements->lastPage() }}
                    </div>
                    <nav aria-label="Page navigation">
                        {{ $lancements->withQueryString()->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
</main>

    @include('page.footer')
    
    <!-- Modal de sélection pour calendrier -->
    <div class="modal fade" id="selectCalendrierModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Préparer un calendrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Choisissez le type de calendrier que vous souhaitez préparer :</p>
                    
                    <div class="list-group">
                        <!-- Option 1 : Pour un lancement spécifique -->
                        <div class="list-group-item">
                            <h6 class="mb-2">Pour un lancement spécifique</h6>
                            <select class="form-select mb-2" id="lancementSelect">
                                <option value="">Sélectionnez un lancement...</option>
                                @foreach($lancements as $lancement)
                                    <option value="{{ $lancement->id }}">
                                        {{ $lancement->nom }} - {{ $lancement->projetDemare->non_de_projet ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary w-100" onclick="allerAuCalendrierLancement()">
                                <i class="bi bi-calendar-week me-2"></i>Calendrier emploi du temps
                            </button>
                        </div>
                        
                        <!-- Option 2 : Pour un projet (préparation) -->
                        <div class="list-group-item">
                            <h6 class="mb-2">Pour un projet (phase de préparation)</h6>
                            <select class="form-select mb-2" id="projetSelectCalendrier">
                                <option value="">Sélectionnez un projet...</option>
                                @foreach($tousLesProjets as $projet)
                                    <option value="{{ $projet->id }}">
                                        {{ $projet->non_de_projet }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-info w-100" onclick="allerAuCalendrierPreparation()">
                                <i class="bi bi-calendar-event me-2"></i>Calendrier de préparation
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

    <script>
        // Fonction pour aller au calendrier d'un lancement
        function allerAuCalendrierLancement() {
            const lancementId = document.getElementById('lancementSelect').value;
            if (lancementId) {
                // Trouver le projet parent de ce lancement
                const lancement = @json($lancements->keyBy('id'));
                const projetId = lancement[lancementId]?.projetDemare?.id;
                
                if (projetId) {
                    window.location.href = `/projets/${projetId}/lancements/${lancementId}/emplois-du-temps/calendrier`;
                } else {
                    alert('Impossible de trouver le projet associé');
                }
            } else {
                alert('Veuillez sélectionner un lancement');
            }
        }
        
        // Fonction pour aller au calendrier de préparation d'un projet
        function allerAuCalendrierPreparation() {
            const projetId = document.getElementById('projetSelectCalendrier').value;
            if (projetId) {
                window.location.href = `/calendrier/${projetId}`;
            } else {
                alert('Veuillez sélectionner un projet');
            }
        }
        
        // Gestion des filtres (code existant)
        document.addEventListener('DOMContentLoaded', function() {
            // Application des filtres
            const applyFiltersBtn = document.getElementById('searchButton');
            const projetFilter = document.getElementById('projetFilter');
            const searchInput = document.getElementById('searchInput');
            
            function applyFilters() {
                const projetId = projetFilter.value;
                const search = searchInput.value;
                
                let url = '{{ route("lancement.all") }}?';
                const params = [];
                
                if (projetId) {
                    params.push(`projet_id=${projetId}`);
                }
                
                if (search) {
                    params.push(`search=${encodeURIComponent(search)}`);
                }
                
                if (params.length > 0) {
                    url += params.join('&');
                }
                
                window.location.href = url;
            }
            
            if (applyFiltersBtn) {
                applyFiltersBtn.addEventListener('click', applyFilters);
            }
            
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        applyFilters();
                    }
                });
            }
            
            if (projetFilter) {
                projetFilter.addEventListener('change', applyFilters);
            }
            
            // Initialiser les tooltips
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });
        });
    </script>
    
</body>
</html>