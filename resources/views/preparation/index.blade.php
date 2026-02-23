<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Vue des Préparations par Projet</title>
    
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
        .stat-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .preparation-card {
            border-left: 4px solid;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }
        .preparation-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .file-badge {
            cursor: pointer;
            transition: all 0.2s;
        }
        .file-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .badge-fichier {
            font-size: 0.75rem;
        }
        .accordion-button {
            font-weight: 500;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,123,255,0.05);
        }
        .search-form .card {
            border: 1px solid #dee2e6;
        }
        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>

    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="p-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- En-tête -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="bi bi-eye me-2"></i>
                                        Vue des Préparations par Projet
                                    </h5>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                                            <li class="breadcrumb-item active">Vue Préparations</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div>
                                    <button class="btn btn-success" onclick="exportToCsv()">
                                        <i class="bi bi-download me-1"></i> Exporter CSV
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Statistiques -->
                            <div class="row mb-4">
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card border-primary">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-primary">
                                                <i class="bi bi-clipboard-check me-1"></i> Préparations
                                            </h6>
                                            <h3 class="text-primary">{{ $stats['total_preparations'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card border-success">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-success">
                                                <i class="bi bi-list-check me-1"></i> Détails
                                            </h6>
                                            <h3 class="text-success">{{ $stats['total_details'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card border-warning">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-warning">
                                                <i class="bi bi-file-earmark me-1"></i> Avec fichiers
                                            </h6>
                                            <h3 class="text-warning">{{ $stats['avec_fichiers'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card stat-card border-info">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-info">
                                                <i class="bi bi-calendar-event me-1"></i> Calendriers
                                            </h6>
                                            <h3 class="text-info">{{ $stats['total_calendriers'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Formulaire de recherche -->
                            <div class="card search-form mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-search me-2"></i> Recherche multi-critères
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('vue-preparations.index') }}" id="searchForm">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="projet_id" class="form-label">Projet</label>
                                                <select name="projet_id" id="projet_id" class="form-select">
                                                    <option value="">Tous les projets</option>
                                                     <option value="">Tous les projets</option>
                                                    @foreach($projets as $projet)
                                                    <option value="{{ $projet->id }}" 
                                                        {{ ($searchParams['projet_id'] ?? '') == $projet->id ? 'selected' : '' }}>
                                                        {{ $projet->non_de_projet }} (ID: {{ $projet->id }})
                                                        @if($projet->id_client)
                                                        - Client #{{ $projet->id_client }}
                                                        @endif
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label for="calendrier" class="form-label">Calendrier</label>
                                                <input type="text" name="calendrier" id="calendrier" 
                                                       class="form-control" placeholder="Nom du calendrier"
                                                       value="{{ $searchParams['calendrier'] ?? '' }}">
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <label for="type_tache" class="form-label">Type de tâche</label>
                                                <input type="text" name="type_tache" id="type_tache" 
                                                       class="form-control" placeholder="Type de tâche"
                                                       value="{{ $searchParams['type_tache'] ?? '' }}">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="date_debut" class="form-label">Date début</label>
                                                <input type="date" name="date_debut" id="date_debut"
                                                       class="form-control" 
                                                       value="{{ $searchParams['date_debut'] ?? '' }}">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="date_fin" class="form-label">Date fin</label>
                                                <input type="date" name="date_fin" id="date_fin" 
                                                       class="form-control" 
                                                       value="{{ $searchParams['date_fin'] ?? '' }}">
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="avec_fichiers" id="avec_fichiers" value="1"
                                                           {{ ($searchParams['avec_fichiers'] ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="avec_fichiers">
                                                        Afficher seulement les préparations avec fichiers
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('vue-preparations.index') }}" class="btn btn-secondary">
                                                        <i class="bi bi-arrow-clockwise me-1"></i> Réinitialiser
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-search me-1"></i> Rechercher
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Résultats -->
                            @if($preparations->isEmpty())
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Aucune préparation trouvée avec les critères de recherche.
                            </div>
                            @else
                            
                            <!-- Informations sur les résultats -->
                            <div class="alert alert-light mb-3">
                                <i class="bi bi-info-circle me-2"></i>
                                Affichage de {{ $preparations->firstItem() }} à {{ $preparations->lastItem() }} 
                                sur {{ $preparations->total() }} préparation(s)
                            </div>
                            
                            <!-- Tableau des résultats -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Projet</th>
                                            <th>Calendrier</th>
                                            <th>Tâche assignée</th>
                                            <th>Assigné à</th>
                                            <th>Type</th>
                                            <th>Préparation</th>
                                            <th>Date</th>
                                            <th>Détails</th>
                                            <th>Fichiers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($preparations as $prep)
                                        <tr class="{{ $prep->hasFiles() ? 'table-info' : '' }}">
                                            <td>
                                                <strong>{{ $prep->non_de_projet }}</strong><br>
                                                <small class="text-muted">ID: {{ $prep->projet_id }}</small>
                                            </td>
                                            <td>
                                                @if($prep->titre_calendrier)
                                                <span class="badge" style="background-color: {{ $prep->couleur_calendrier ?? '#3788d8' }}; color: white;">
                                                    {{ $prep->titre_calendrier }}
                                                </span>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $prep->description_tache ?? '-' }}</td>
                                            <td>
                                                @if($prep->id_utilisateur_assignee)
                                                    @php
                                                        $assigneeId = $prep->id_utilisateur_assignee;
                                                        $assigneeName = isset($tousUtilisateurs[$assigneeId]) ? 
                                                            $tousUtilisateurs[$assigneeId]['nom_complet'] : 
                                                            'Utilisateur ' . $assigneeId;
                                                    @endphp
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-person me-1"></i>
                                                        {{ $assigneeName }}
                                                    </span>
                                                    @if(isset($tousUtilisateurs[$assigneeId]['email']))
                                                    <br>
                                                    <small class="text-muted">{{ $tousUtilisateurs[$assigneeId]['email'] }}</small>
                                                    @endif
                                                @else
                                                <span class="text-muted">Non assigné</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($prep->type_tache)
                                                <span class="badge bg-primary">{{ $prep->type_tache }}</span>
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($prep->description_preparation, 50) }}</td>
                                            <td>
                                                @if($prep->date_preparation)
                                                {{ \Carbon\Carbon::parse($prep->date_preparation)->format('d/m/Y') }}
                                                @else
                                                <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $prep->nombre_details }}
                                                </span>
                                            </td>
                                           
                                            <td>
                                                @php
                                                    $files = $prep->files;
                                                @endphp
                                                @if(count($files) > 0)
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($files as $file)
                                                            @if(!empty($file['detail_id']) && !empty($file['fichier']))
                                                                <a href="{{ route('vue-preparations.download-file', $file['detail_id']) }}" 
                                                                class="badge file-badge bg-success text-decoration-none"
                                                                title="Télécharger {{ $file['nom'] }}"
                                                                onclick="return confirmDownload()">
                                                                    <i class="bi bi-download me-1"></i>
                                                                    {{ $file['file_type'] }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">Aucun</span>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <!-- Ligne détaillée (optionnelle) -->
                                        @if($prep->hasFiles() && $prep->nombre_details > 0)
                                        <tr>
                                            <td colspan="9" class="p-0">
                                                <div class="accordion" id="accordion{{ $prep->preparation_id }}">
                                                    <div class="accordion-item border-0">
                                                        <div class="accordion-header">
                                                            <button class="accordion-button collapsed bg-light py-2" 
                                                                    type="button" data-bs-toggle="collapse" 
                                                                    data-bs-target="#collapse{{ $prep->preparation_id }}">
                                                                <small>
                                                                    <i class="bi bi-chevron-down me-2"></i>
                                                                    Détails des fichiers ({{ $prep->nombre_fichiers }})
                                                                </small>
                                                            </button>
                                                        </div>
                                                        <div id="collapse{{ $prep->preparation_id }}" 
                                                             class="accordion-collapse collapse" 
                                                             data-bs-parent="#accordion{{ $prep->preparation_id }}">
                                                            <div class="accordion-body p-2">
                                                                <div class="row">
                                                                    @foreach($prep->details as $detail)
                                                                    @if(!empty($detail['has_file']) && $detail['has_file'])
                                                                    <div class="col-md-6 mb-2">
                                                                        <div class="card card-sm">
                                                                            <div class="card-body p-2">
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <strong>{{ $detail['nom'] ?? 'Sans nom' }}</strong><br>
                                                                                        <small class="text-muted">
                                                                                            {{ Str::limit($detail['description'] ?? '', 40) }}
                                                                                        </small>
                                                                                    </div>
                                                                                    <div>
                                                                                        <a href="{{ route('vue-preparations.download-file', $detail['detail_id']) }}" 
                                                                                           class="btn btn-sm btn-success"
                                                                                           onclick="return confirmDownload()">
                                                                                            <i class="bi bi-download me-1"></i>
                                                                                            {{ $detail['file_type'] ?? 'Fichier' }}
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted">
                                        {{ $preparations->firstItem() }}-{{ $preparations->lastItem() }} 
                                        sur {{ $preparations->total() }}
                                    </small>
                                </div>
                                <div>
                                    {{ $preparations->links() }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('page.footer')
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    
    <script>
    // Confirmation de téléchargement
    function confirmDownload() {
        return confirm('Voulez-vous télécharger ce fichier ?');
    }
    
    // Exporter en CSV
    function exportToCsv() {
        // Récupérer les paramètres de recherche
        const form = document.getElementById('searchForm');
        const formData = new FormData(form);
        
        // Construire l'URL avec les paramètres
        let params = new URLSearchParams();
        for (let pair of formData.entries()) {
            params.append(pair[0], pair[1]);
        }
        
        window.location.href = '{{ route("vue-preparations.export-csv") }}?' + params.toString();
    }
    
    // Afficher les fichiers d'une préparation
    function showFiles(preparationId) {
        // Implémentation pour afficher les fichiers dans une modal
        alert('Fonctionnalité à implémenter pour la préparation ID: ' + preparationId);
    }
    
    // Initialiser les tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    // Gestion des dates
    document.getElementById('date_debut').addEventListener('change', function() {
        const dateFin = document.getElementById('date_fin');
        if (this.value && (!dateFin.value || dateFin.value < this.value)) {
            dateFin.min = this.value;
        }
    });
    </script>

</body>
</html>
