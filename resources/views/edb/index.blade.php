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
        
    <div class="container-fluid py-4">
        <!-- En-tête -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('projets.index') }}">Projets</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('lancement.index', $lancement->projetDemare->id) }}">
                                {{ $lancement->projetDemare->non_de_projet }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $lancement->nom }} - Emplois du temps</li>
                    </ol>
                </nav>
                
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-calendar-week text-primary me-2"></i>
                        Emplois du Temps - {{ $lancement->nom }}
                    </h1>
                    <div class="btn-group">
                        <a href="{{ route('emploi-du-temps.calendrier', [$lancement->projetDemare->id, $lancement->id]) }}" 
                        class="btn btn-outline-primary">
                            <i class="bi bi-calendar"></i> Vue calendrier
                        </a>
                        <button type="button" class="btn btn-primary" onclick="ouvrirModalNouveau()">
                            <i class="bi bi-plus-circle"></i> Nouveau module
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertes -->
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

        <!-- Tableau des emplois du temps -->
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-list-ul me-2"></i>
                    Liste des modules planifiés
                </h6>
            </div>
            
            <div class="card-body">
                @if($emplois->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun emploi du temps</h5>
                        <p class="text-muted">Commencez par planifier les modules à faire</p>
                        <button type="button" class="btn btn-primary" onclick="ouvrirModalNouveau()">
                            <i class="bi bi-plus-circle"></i> Ajouter un module
                        </button>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Module</th>
                                    <th>Période</th>
                                    <th>Durée</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emplois as $emploi)
                                @php
                                    $colorIndex = $emploi->id_module_affecter % 8;
                                    $colors = ['#3788d8', '#28a745', '#dc3545', '#ffc107', 
                                            '#6f42c1', '#fd7e14', '#20c997', '#e83e8c'];
                                    $color = $colors[$colorIndex];
                                @endphp
                                
                                <tr>
                                    <td>
                                        <span class="badge" style="background-color: {{ $color }}; color: white;">
                                            {{ $emploi->module->nom }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-calendar-plus me-1"></i>
                                            {{ $emploi->date_debut->format('d/m/Y') }}
                                            <br>
                                            <i class="bi bi-calendar-check me-1"></i>
                                            {{ $emploi->date_fin->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $emploi->duree }} jours
                                        </span>
                                    </td>
                                    <td>
                                        @if($emploi->description)
                                            {{ Str::limit($emploi->description, 50) }}
                                        @else
                                            <span class="text-muted">Aucune description</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Modifier -->
                                            @if(app('permission')->hasPermission('projet', 'creer'))
                                            <button type="button" class="btn btn-outline-warning" 
                                                    onclick="modifierEmploi({{ $emploi->id }})"
                                                    data-bs-toggle="tooltip" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            @endif
                                            
                                            <!-- Supprimer -->
                                            @if(app('permission')->hasPermission('projet', 'supprimer'))
                                            <form action="{{ route('emploi-du-temps.destroy', [$lancement->projetDemare->id, $lancement->id, $emploi->id]) }}" 
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Supprimer cet emploi du temps ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"
                                                        data-bs-toggle="tooltip" title="Supprimer">
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
                @endif
            </div>
        </div>
    </div>

    <!-- Modal pour ajouter/modifier un emploi du temps -->
    <div class="modal fade" id="emploiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nouveau Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="emploiForm" action="{{ route('emploi-du-temps.store', [$lancement->projetDemare->id, $lancement->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="emploi_id">
                    <input type="hidden" name="_method" id="form_method" value="POST">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Module à faire *</label>
                            <select class="form-select" name="id_module_affecter" id="module_select" required>
                                <option value="">Sélectionner un module...</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date début *</label>
                                    <input type="date" class="form-control" name="date_debut" id="date_debut" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date fin *</label>
                                    <input type="date" class="form-control" name="date_fin" id="date_fin" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description du module..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </main>
    @include('page.footer')

        <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

    <script>
        function ouvrirModalNouveau() {
            document.getElementById('modalTitle').textContent = 'Nouveau Module';
            document.getElementById('emploiForm').reset();
            document.getElementById('emploi_id').value = '';
            document.getElementById('form_method').value = 'POST';
            document.getElementById('submitBtn').textContent = 'Enregistrer';
            
            // Mettre à jour l'action du formulaire
            document.getElementById('emploiForm').action = '{{ route("emploi-du-temps.store", [$lancement->projetDemare->id, $lancement->id]) }}';
            
            const modal = new bootstrap.Modal(document.getElementById('emploiModal'));
            modal.show();
        }
        
        function modifierEmploi(emploiId) {
            // Récupérer les données de l'emploi via AJAX
            fetch(`/projets/{{ $lancement->projetDemare->id }}/lancements/{{ $lancement->id }}/emplois-du-temps/${emploiId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const emploi = data.data;
                        
                        // Remplir le formulaire
                        document.getElementById('modalTitle').textContent = 'Modifier Module';
                        document.getElementById('emploi_id').value = emploi.id;
                        document.getElementById('module_select').value = emploi.id_module_affecter;
                        document.getElementById('date_debut').value = emploi.date_debut.split('T')[0];
                        document.getElementById('date_fin').value = emploi.date_fin.split('T')[0];
                        document.getElementById('description').value = emploi.description || '';
                        document.getElementById('form_method').value = 'PUT';
                        document.getElementById('submitBtn').textContent = 'Modifier';
                        
                        // Mettre à jour l'action du formulaire
                        document.getElementById('emploiForm').action = `{{ route("emploi-du-temps.update", [$lancement->projetDemare->id, $lancement->id, '']) }}/${emploiId}`;
                        
                        const modal = new bootstrap.Modal(document.getElementById('emploiModal'));
                        modal.show();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors du chargement des données');
                });
        }
        
        // Initialiser les tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });
        });
    </script>

</body>
</html>
