<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Détails Préparation - Cabinet PHAOS</title>
    
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
        .card-detail {
            border-left: 4px solid #4154f1;
        }
        .info-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-size: 1rem;
            color: #212529;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
        }
        .detail-card {
            transition: transform 0.2s;
        }
        .detail-card:hover {
            transform: translateY(-2px);
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
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
                            <!-- En-tête avec titre et boutons d'action -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="bi bi-clipboard-check me-2"></i>Détails de la Préparation
                                    </h5>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('preparations.index') }}">Préparations</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Détails #{{ $preparation->id }}</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div>
                                    <a href="{{ route('preparations.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i> Retour
                                    </a>
                                    @if($preparation->details->count() > 0)
                                    
                                    <!-- <button type="button" class="btn btn-outline-primary ms-2" onclick="printPreparation()">
                                        <i class="bi bi-printer me-1"></i> Imprimer
                                    </button> -->

                                    @endif
                                </div>
                            </div>
                            
                            <!-- Informations principales -->
                            <div class="row mb-4">
                                <div class="col-lg-8">
                                    <div class="card card-detail">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">
                                                <i class="bi bi-info-circle me-2"></i>Informations Générales
                                            </h6>
                                            
                                            <div class="row">
                                                <div class="col-md-6 info-item">
                                                    <div class="info-label">Description</div>
                                                    <div class="info-value">{{ $preparation->description }}</div>
                                                </div>
                                                
                                                <div class="col-md-6 info-item">
                                                    <div class="info-label">Date de préparation</div>
                                                    <div class="info-value">
                                                        <i class="bi bi-calendar-event me-1"></i>
                                                        {{ \Carbon\Carbon::parse($preparation->daty)->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 info-item">
                                                    <div class="info-label">Tâche à faire</div>
                                                    <div class="info-value">
                                                        @if($preparation->aFaire)
                                                            <span class="badge bg-primary">{{ $preparation->aFaire->nom }}</span>
                                                            <span class="d-block mt-1">{{ $preparation->description ?? 'Sans description' }}</span>
                                                        @else
                                                            <span class="text-muted">Non définie</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 info-item">
                                                    <div class="info-label">Tâche concernée</div>
                                                    <div class="info-value">
                                                        @if($preparation->utilisateurConcerner)
                                                            {{ $preparation->utilisateurConcerner->description_tache ?? 'Sans description' }}
                                                        @else
                                                            <span class="text-muted">Non liée</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- <div class="col-md-6 info-item">
                                                    <div class="info-label">Créée par</div>
                                                    <div class="info-value">
                                                        <i class="bi bi-person-circle me-1"></i>
                                                        Utilisateur #{{ $preparation->id_utilisateur }}
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 info-item">
                                                    <div class="info-label">ID Préparation</div>
                                                    <div class="info-value">
                                                        <span class="badge bg-secondary">#{{ $preparation->id }}</span>
                                                    </div>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Statut et actions -->
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">
                                                <i class="bi bi-gear me-2"></i>Statut & Actions
                                            </h6>
                                            
                                            <div class="d-grid gap-2">
                                                @if($preparation->details->count() > 0)
                                                    <span class="badge bg-success status-badge mb-3">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        {{ $preparation->details->count() }} détail(s) ajouté(s)
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning status-badge mb-3">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        Aucun détail ajouté
                                                    </span>
                                                @endif
                                                
                                                <a href="{{ route('preparations.edit', $preparation->id) }}" class="btn btn-primary">
                                                    <i class="bi bi-pencil me-1"></i> Modifier
                                                </a>
                                                
                                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                                    <i class="bi bi-trash me-1"></i> Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            



                            <!-- Section des détails -->
                            <!-- Section des détails -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="card-title mb-0">
                                                    <i class="bi bi-list-task me-2"></i>
                                                    Détails de la Préparation
                                                    @if($preparation->details->count() > 0)
                                                        <span class="badge bg-primary ms-2">{{ $preparation->details->count() }}</span>
                                                    @endif
                                                </h6>
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addDetailModal">
                                                    <i class="bi bi-plus-circle me-1"></i> Ajouter un détail
                                                </button>
                                            </div>
                                            
                                            @if($preparation->details->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="50">#</th>
                                                                <th>Nom</th>
                                                                <th>Description</th>
                                                                <th>Fichier</th>
                                                                <th>URL</th>
                                                                <th width="150">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($preparation->details as $index => $detail)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    @if($detail->nom)
                                                                        <strong>{{ $detail->nom }}</strong>
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($detail->description)
                                                                        {{ Str::limit($detail->description, 50) }}
                                                                        @if(strlen($detail->description) > 50)
                                                                            <button type="button" class="btn btn-sm btn-link p-0" 
                                                                                    onclick="showFullDescription('{{ addslashes($detail->description) }}')">
                                                                                Voir plus
                                                                            </button>
                                                                        @endif
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($detail->fichier)
                                                                        <?php
                                                                        // Vérifier si le fichier existe dans le dossier uploads
                                                                        $uploadPath = 'uploads/detaille_a_faire/';
                                                                        $filePath = public_path($uploadPath . $detail->fichier);
                                                                        $fileExists = file_exists($filePath);
                                                                        
                                                                        // Vérifier si c'est un fichier uploadé (conient timestamp) ou un nom manuel
                                                                        $isUploadedFile = preg_match('/^\d+_\w+\.\w+$/', $detail->fichier);
                                                                        ?>
                                                                        
                                                                        @if($isUploadedFile && $fileExists)
                                                                            <!-- Fichier uploadé et existant -->
                                                                            <a href="{{ asset($uploadPath . $detail->fichier) }}" 
                                                                            target="_blank"
                                                                            class="badge bg-success text-decoration-none"
                                                                            title="Télécharger {{ $detail->fichier }}">
                                                                                <i class="bi bi-download me-1"></i>
                                                                                {{ $detail->getFileExtension() ?: 'Fichier' }}
                                                                            </a>
                                                                            <br>
                                                                            <small class="text-muted">{{ Str::limit($detail->fichier, 20) }}</small>
                                                                        @elseif($isUploadedFile && !$fileExists)
                                                                            <!-- Fichier uploadé mais manquant -->
                                                                            <span class="badge bg-warning" title="Fichier manquant sur le serveur">
                                                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                                                {{ $detail->getFileExtension() ?: 'Fichier' }}
                                                                            </span>
                                                                        @else
                                                                            <!-- Nom de fichier manuel (pas uploadé) -->
                                                                            <span class="badge bg-info" title="{{ $detail->fichier }}">
                                                                                <i class="bi bi-file-earmark me-1"></i>
                                                                                {{ Str::limit($detail->fichier, 20) }}
                                                                            </span>
                                                                        @endif
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($detail->url)
                                                                        @if(filter_var($detail->url, FILTER_VALIDATE_URL))
                                                                            <a href="{{ $detail->url }}" target="_blank" 
                                                                            class="badge bg-primary text-decoration-none"
                                                                            title="{{ $detail->url }}">
                                                                                <i class="bi bi-link me-1"></i> URL
                                                                            </a>
                                                                        @else
                                                                            <span class="badge bg-secondary" title="{{ $detail->url }}">
                                                                                <i class="bi bi-folder me-1"></i>
                                                                                {{ Str::limit($detail->url, 20) }}
                                                                            </span>
                                                                        @endif
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group btn-group-sm">
                                                                        @if($detail->fichier && $isUploadedFile && $fileExists)
                                                                            <a href="{{ asset($uploadPath . $detail->fichier) }}" 
                                                                            class="btn btn-outline-success" 
                                                                            target="_blank"
                                                                            title="Télécharger">
                                                                                <i class="bi bi-download"></i>
                                                                            </a>
                                                                        @endif
                                                                        <button type="button" class="btn btn-outline-primary" 
                                                                                onclick="editDetail({{ $detail->id }})"
                                                                                title="Modifier">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-outline-danger" 
                                                                                onclick="deleteDetail({{ $detail->id }})"
                                                                                title="Supprimer">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="empty-state">
                                                    <i class="bi bi-inbox"></i>
                                                    <h5>Aucun détail ajouté</h5>
                                                    <p class="text-muted">Ajoutez des détails pour mieux organiser cette préparation.</p>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDetailModal">
                                                        <i class="bi bi-plus-circle me-1"></i> Ajouter le premier détail
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal d'ajout de détail -->
        <div class="modal fade" id="addDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un détail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addDetailForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id_preparation" value="{{ $preparation->id }}">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="detail_nom" class="form-label">Nom (optionnel)</label>
                                    <input type="text" class="form-control" id="detail_nom" name="nom" 
                                        placeholder="Nom du détail" maxlength="250">
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="detail_description" class="form-label">Description (optionnel)</label>
                                    <textarea class="form-control" id="detail_description" name="description" 
                                            rows="3" placeholder="Description du détail..."></textarea>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Fichier (optionnel)</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="detail_fichier_file" class="form-label">Uploader un fichier</label>
                                                    <input type="file" class="form-control" id="detail_fichier_file" name="fichier_file" 
                                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.txt">
                                                    <div class="form-text">Max: 10MB. Formats: PDF, Word, Excel, Images, TXT</div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="detail_fichier_text" class="form-label">Ou saisir un nom/chemin</label>
                                                    <input type="text" class="form-control" id="detail_fichier_text" name="fichier" 
                                                        placeholder="ex: document.pdf ou C:\dossier\fichier" maxlength="250">
                                                    <div class="form-text">Nom de fichier ou chemin local</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="detail_url" class="form-label">URL (optionnel)</label>
                                    <input type="text" class="form-control" id="detail_url" name="url" 
                                        placeholder="https://example.com" maxlength="500">
                                    <div class="form-text">URL web vers une ressource</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal pour modifier un détail -->
        <div class="modal fade" id="editDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier le détail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editDetailForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" id="editDetailModalBody">
                            <!-- Contenu chargé dynamiquement -->
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                                <p class="mt-2">Chargement des données...</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    </main>

    @include('page.footer')
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
    // Fonction pour imprimer la préparation
    function printPreparation() {
        window.print();
    }
    
    // Fonction pour confirmer la suppression
    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette préparation ? Cette action est irréversible.')) {
            window.location.href = "{{ route('preparations.destroy', $preparation->id) }}?_method=DELETE&_token={{ csrf_token() }}";
        }
    }
    
    // Fonction pour afficher la description complète
    function showFullDescription(description) {
        // Créer un modal temporaire pour afficher la description complète
        const modalHtml = `
            <div class="modal fade" id="descriptionModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Description complète</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p style="white-space: pre-wrap;">${description.replace(/\\'/g, "'")}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Ajouter le modal au DOM
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = modalHtml;
        document.body.appendChild(modalContainer);
        
        // Afficher le modal
        const modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
        modal.show();
        
        // Nettoyer après fermeture
        document.getElementById('descriptionModal').addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(modalContainer);
        });
    }
    
    // Fonction pour supprimer un détail
    function deleteDetail(detailId) {
        if (confirm('Supprimer ce détail ?')) {
            fetch('{{ route("preparations.details.destroy", "") }}/' + detailId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Détail supprimé avec succès');
                    location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la suppression');
            });
        }
    }
    
    // Fonction pour éditer un détail
    function editDetail(detailId) {
        console.log('Édition du détail ID:', detailId);
        
        // Vérifier si la modal existe
        const modalElement = document.getElementById('editDetailModal');
        const modalBodyElement = document.getElementById('editDetailModalBody');
        
        if (!modalElement || !modalBodyElement) {
            console.error('Éléments de modal non trouvés:', {
                modal: !!modalElement,
                modalBody: !!modalBodyElement
            });
            alert('Erreur: La fenêtre d\'édition n\'est pas disponible. Veuillez recharger la page.');
            return;
        }
        
        // Afficher un indicateur de chargement
        modalBodyElement.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-2">Chargement des données du détail...</p>
            </div>
        `;
        
        // Afficher la modal immédiatement
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        
        // Récupérer les données du détail
        fetch(`/preparations/details/${detailId}/edit`)
            .then(response => {
                console.log('Réponse serveur:', response.status);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Données reçues:', data);
                
                if (data.success && data.detail) {
                    const detail = data.detail;
                    
                    // Construire le formulaire d'édition avec échappement des caractères spéciaux
                    const formHtml = `
                        <input type="hidden" name="id" value="${escapeHtml(detail.id)}">
                        <input type="hidden" name="id_preparation" value="${escapeHtml(detail.id_preparation)}">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nom" class="form-label">Nom (optionnel)</label>
                                <input type="text" class="form-control" id="edit_nom" name="nom" 
                                    value="${escapeHtml(detail.nom || '')}" maxlength="250">
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="edit_description" class="form-label">Description (optionnel)</label>
                                <textarea class="form-control" id="edit_description" name="description" 
                                        rows="3">${escapeHtml(detail.description || '')}</textarea>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Fichier (optionnel)</h6>
                                    </div>
                                    <div class="card-body">
                                        ${detail.fichier ? `
                                        <div class="current-file mb-3">
                                            <div class="file-info">
                                                <i class="bi bi-file-earmark-text text-primary"></i>
                                                <span>Fichier actuel: ${escapeHtml(detail.fichier)}</span>
                                                ${detail.fichier.match(/^\d+_\w+\.\w+$/) ? 
                                                    `<a href="{{ asset('uploads/detaille_a_faire/') }}/${escapeHtml(detail.fichier)}" 
                                                    target="_blank" class="btn btn-sm btn-outline-success ms-auto">
                                                        <i class="bi bi-download"></i> Télécharger
                                                    </a>` : ''
                                                }
                                            </div>
                                            <div class="form-text mt-2">
                                                Laissez vide pour conserver le fichier actuel, ou uploader un nouveau fichier.
                                            </div>
                                        </div>
                                        ` : ''}
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="edit_fichier_file" class="form-label">Nouveau fichier</label>
                                                <input type="file" class="form-control" id="edit_fichier_file" name="fichier_file" 
                                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.txt">
                                                <div class="form-text">Max: 10MB. Formats: PDF, Word, Excel, Images, TXT</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="edit_fichier_text" class="form-label">Ou saisir un nom/chemin</label>
                                                <input type="text" class="form-control" id="edit_fichier_text" name="fichier" 
                                                    value="${detail.fichier && !detail.fichier.match(/^\d+_\w+\.\w+$/) ? escapeHtml(detail.fichier) : ''}"
                                                    placeholder="ex: document.pdf ou C:\\dossier\\fichier" maxlength="250">
                                                <div class="form-text">Nom de fichier ou chemin local</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="edit_url" class="form-label">URL (optionnel)</label>
                                <input type="text" class="form-control" id="edit_url" name="url" 
                                    value="${escapeHtml(detail.url || '')}" placeholder="https://example.com" maxlength="500">
                                <div class="form-text">URL web vers une ressource</div>
                            </div>
                        </div>
                    `;
                    
                    // Insérer le formulaire dans la modal
                    modalBodyElement.innerHTML = formHtml;
                    
                    // Gérer la soumission du formulaire d'édition
                    const editForm = document.getElementById('editDetailForm');
                    if (editForm) {
                        editForm.onsubmit = function(e) {
                            e.preventDefault();
                            updateDetail(detailId);
                        };
                    } else {
                        console.error('Formulaire editDetailForm non trouvé');
                    }
                    
                } else {
                    modalBodyElement.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            ${data.message || 'Erreur lors du chargement des données'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Erreur complète:', error);
                modalBodyElement.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Erreur lors du chargement des données: ${error.message}
                    </div>
                `;
            });
    }

    // Fonction d'échappement HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Fonction pour mettre à jour un détail
    function updateDetail(detailId) {
        const form = document.getElementById('editDetailForm');
        const modalBody = document.getElementById('editDetailModalBody');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        if (!form || !submitBtn) {
            alert('Erreur: Formulaire non trouvé');
            return;
        }
        
        // Désactiver le bouton
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';
        
        // Afficher un indicateur de chargement
        modalBody.insertAdjacentHTML('beforeend', `
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Mise à jour en cours...
            </div>
        `);
        
        const formData = new FormData(form);
        
        fetch(`/preparations/details/${detailId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => {
            console.log('Réponse mise à jour:', response.status);
            return response.json();
        })
        .then(data => {
            // Supprimer les messages précédents
            const alerts = modalBody.querySelectorAll('.alert');
            alerts.forEach(alert => alert.remove());
            
            if (data.success) {
                modalBody.innerHTML = `
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        ${data.message || 'Détail modifié avec succès'}
                    </div>
                `;
                
                // Fermer la modal après 2 secondes et recharger
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editDetailModal'));
                    modal.hide();
                    location.reload();
                }, 2000);
                
            } else {
                let errorMessage = data.message || 'Échec de la mise à jour';
                
                if (data.errors) {
                    errorMessage += '<ul class="mb-0 mt-2">';
                    for (const field in data.errors) {
                        errorMessage += `<li>${field}: ${data.errors[field].join(', ')}</li>`;
                    }
                    errorMessage += '</ul>';
                }
                
                modalBody.insertAdjacentHTML('beforeend', `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        ${errorMessage}
                    </div>
                `);
                
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Erreur mise à jour:', error);
            
            modalBody.insertAdjacentHTML('beforeend', `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Erreur lors de la mise à jour: ${error.message}
                </div>
            `);
            
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }


    
    // Fonction pour mettre à jour un détail
    function updateDetail(detailId) {
        const formData = new FormData(document.getElementById('editDetailForm'));
        const submitBtn = document.querySelector('#editDetailForm button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';
        
        fetch('{{ route("preparations.details.update", "") }}/' + detailId, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editDetailModal'));
                modal.hide();
                alert('Détail modifié avec succès');
                location.reload();
            } else {
                let errorMessage = 'Erreur: ' + (data.message || 'Échec de la mise à jour');
                if (data.errors) {
                    errorMessage += '\n\n';
                    for (const field in data.errors) {
                        errorMessage += `• ${field}: ${data.errors[field].join(', ')}\n`;
                    }
                }
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la mise à jour: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    }
    
    // Gestion de l'ajout de détail
    document.getElementById('addDetailForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';
        
        fetch('{{ route("preparations.details.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fermer le modal et recharger la page
                const modal = bootstrap.Modal.getInstance(document.getElementById('addDetailModal'));
                modal.hide();
                
                // Réinitialiser le formulaire
                this.reset();
                
                // Afficher message et recharger
                alert('Détail ajouté avec succès !');
                location.reload();
            } else {
                let errorMessage = 'Erreur: ' + (data.message || 'Veuillez vérifier les informations');
                if (data.errors) {
                    errorMessage += '\n\n';
                    for (const field in data.errors) {
                        errorMessage += `• ${field}: ${data.errors[field].join(', ')}\n`;
                    }
                }
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'enregistrement: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // Initialiser les tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>


</body>
</html>