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
    
</head>
<body>

@include('page.header')
@include('layouts.sidebar')

<main id="main" class="main">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-project-diagram me-2"></i>Organigramme du Workflow
                        </h4>
                        <button onclick="window.print()" class="btn btn-light btn-sm">
                            <i class="fas fa-print me-1"></i> Imprimer
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    
                    <!-- Formulaire de sélection du projet -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('workflow-validation.organigramme') }}" class="row g-3">
                                <div class="col-md-8">
                                    <label for="project_id" class="form-label fw-bold">Sélectionner un projet :</label>
                                    <select class="form-select" id="project_id" name="project_id" required>
                                        <option value="">-- Choisir un projet --</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" 
                                                {{ $projectId == $project->id ? 'selected' : '' }}>
                                                {{ $project->numero_projet }} - {{ $project->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-eye me-1"></i> Afficher l'organigramme
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            @if($projectId)
                                @php
                                    $projet = $projects->find($projectId);
                                @endphp
                                @if($projet)
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Projet sélectionné :</strong> {{ $projet->titre }}<br>
                                        <strong>Numéro :</strong> {{ $projet->numero_projet }}<br>
                                        @if($projet->description)
                                            <strong>Description :</strong> {{ Str::limit($projet->description, 100) }}
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    @if($projectId)
                        <!-- Affichage de l'organigramme -->
                        <div class="organigramme-container">
                            @if(empty($workflowHtml))
                                <div class="alert alert-warning text-center py-5">
                                    <i class="fas fa-search me-2"></i>
                                    Aucun workflow trouvé pour ce projet.
                                    <br>
                                    <a href="{{ route('workflow-validation.form') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Créer une première étape
                                    </a>
                                </div>
                            @else
                                <!-- Statistiques du workflow -->
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="card text-center border-primary">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary" id="totalEtapes">0</h5>
                                                <p class="card-text"><small>Étapes totales</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center border-warning">
                                            <div class="card-body">
                                                <h5 class="card-title text-warning" id="etapesAttente">0</h5>
                                                <p class="card-text"><small>En attente</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center border-success">
                                            <div class="card-body">
                                                <h5 class="card-title text-success" id="etapesValidees">0</h5>
                                                <p class="card-text"><small>Validées</small></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center border-danger">
                                            <div class="card-body">
                                                <h5 class="card-title text-danger" id="etapesRejetees">0</h5>
                                                <p class="card-text"><small>Rejetées</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Ligne du temps horizontale -->
                                <div class="timeline-line mb-5">
                                    <div class="timeline-start"></div>
                                    <div class="timeline-main"></div>
                                    <div class="timeline-end"></div>
                                </div>
                                
                                <!-- Conteneur pour les étapes -->
                                <div class="organigramme-steps">
                                    {!! $workflowHtml !!}
                                </div>
                                
                                <!-- Légende -->
                                <div class="legend mt-4">
                                    <div class="alert alert-light border">
                                        <h6 class="mb-2"><i class="fas fa-key me-2"></i>Légende :</h6>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="badge bg-warning me-2">⏳</span> En attente
                                            </div>
                                            <div class="col-md-3">
                                                <span class="badge bg-success me-2">✅</span> Validé
                                            </div>
                                            <div class="col-md-3">
                                                <span class="badge bg-danger me-2">❌</span> Rejeté
                                            </div>
                                            <div class="col-md-3">
                                                <span class="badge bg-primary me-2"><i class="fas fa-users"></i></span> Utilisateurs concernés
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-sitemap fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Sélectionnez un projet pour voir son organigramme</h4>
                            <p class="text-muted">Choisissez un projet dans la liste ci-dessus pour visualiser son flux de validation</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<style>
/* Styles pour l'organigramme */
.organigramme-container {
    position: relative;
    min-height: 400px;
    padding: 20px;
}

.organigramme-steps {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.etape-wrapper {
    position: relative;
    margin-bottom: 20px;
}

.etape-card {
    position: relative;
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
    min-width: 300px;
    max-width: 400px;
    margin: 0 auto;
}

.etape-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.etape-card.root {
    border-color: #198754;
    background-color: #f8f9fa;
}

.etape-card .etape-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
}

.etape-card .etape-title {
    font-weight: bold;
    font-size: 1.1rem;
    color: #212529;
    margin: 0;
}

.etape-card .etape-status {
    font-size: 0.85rem;
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 600;
}

.status-0 { background-color: #fff3cd; color: #856404; }
.status-1 { background-color: #d1e7dd; color: #0f5132; }
.status-2 { background-color: #f8d7da; color: #721c24; }

.etape-card .etape-dates {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 10px;
}

.etape-card .etape-users {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 10px;
}

.etape-card .user-badge {
    background-color: #e3f2fd;
    color: #0d6efd;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
}

/* Ligne de connexion entre les étapes */
.connection-line {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    background: #6c757d;
    z-index: 1;
}

/* Ligne du temps */
.timeline-line {
    position: relative;
    height: 4px;
    background: linear-gradient(90deg, #0d6efd, #6f42c1);
    border-radius: 2px;
    margin: 0 50px;
}

.timeline-start, .timeline-end {
    position: absolute;
    top: -8px;
    width: 20px;
    height: 20px;
    background: #0d6efd;
    border-radius: 50%;
}

.timeline-start {
    left: -10px;
}

.timeline-end {
    right: -10px;
    background: #6f42c1;
}

/* Style pour les étapes enfants */
.etape-enfants {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 40px;
    padding-top: 40px;
    position: relative;
}

.etape-enfants::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    width: 2px;
    height: 40px;
    background: #6c757d;
    transform: translateX(-50%);
}

/* Statistiques */
.card.border-primary .card-title { color: #0d6efd; }
.card.border-warning .card-title { color: #ffc107; }
.card.border-success .card-title { color: #198754; }
.card.border-danger .card-title { color: #dc3545; }

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

/* Responsive */
@media (max-width: 768px) {
    .organigramme-container {
        padding: 10px;
    }
    
    .etape-card {
        min-width: 250px;
        max-width: 100%;
    }
    
    .etape-enfants {
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }
    
    .timeline-line {
        margin: 0 20px;
    }
    
    .legend .row > div {
        margin-bottom: 10px;
    }
    
    .row.mb-4 > .col-md-3 {
        margin-bottom: 15px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.etape-card {
    animation: fadeIn 0.5s ease forwards;
}

/* Style d'impression */
@media print {
    .card-header button,
    .alert,
    .legend,
    .row.mb-4 {
        display: none !important;
    }
    
    .organigramme-container {
        padding: 0;
    }
    
    .etape-card {
        box-shadow: none;
        border: 1px solid #000;
        break-inside: avoid;
    }
}
</style>


    <!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

<script>
// Fonction pour calculer et afficher les statistiques
function calculerStatistiques() {
    const etapes = document.querySelectorAll('.etape-card');
    let total = etapes.length;
    let attente = 0;
    let valide = 0;
    let rejete = 0;
    
    etapes.forEach(etape => {
        const status = etape.querySelector('.etape-status');
        if (status) {
            if (status.classList.contains('status-0')) attente++;
            else if (status.classList.contains('status-1')) valide++;
            else if (status.classList.contains('status-2')) rejete++;
        }
    });
    
    // Mettre à jour les compteurs
    document.getElementById('totalEtapes').textContent = total;
    document.getElementById('etapesAttente').textContent = attente;
    document.getElementById('etapesValidees').textContent = valide;
    document.getElementById('etapesRejetees').textContent = rejete;
}

// Fonction pour formater les dates (si besoin dans le futur)
function formatDate(dateString) {
    if (!dateString) return 'Non définie';
    
    try {
        const date = new Date(dateString);
        return date.toLocaleString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (e) {
        return 'Date invalide';
    }
}

// Initialisation quand le DOM est chargé
document.addEventListener('DOMContentLoaded', function() {
    // Gérer le changement de projet
    const projectSelect = document.getElementById('project_id');
    if (projectSelect) {
        projectSelect.addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    }
    
    // Calculer les statistiques si des étapes existent
    if (document.querySelector('.etape-card')) {
        calculerStatistiques();
    }
    
    console.log('Organigramme chargé avec succès');
});

// Amélioration pour l'impression
window.addEventListener('beforeprint', function() {
    // Ajouter un en-tête d'impression
    const printHeader = document.createElement('div');
    printHeader.className = 'print-header';
    printHeader.innerHTML = `
        <h3>Organigramme du Workflow</h3>
        <p>Généré le ${new Date().toLocaleDateString('fr-FR')} à ${new Date().toLocaleTimeString('fr-FR')}</p>
        <hr>
    `;
    document.querySelector('.organigramme-container').prepend(printHeader);
});

window.addEventListener('afterprint', function() {
    // Supprimer l'en-tête d'impression
    const printHeader = document.querySelector('.print-header');
    if (printHeader) {
        printHeader.remove();
    }
});
</script>




</body>
</html>