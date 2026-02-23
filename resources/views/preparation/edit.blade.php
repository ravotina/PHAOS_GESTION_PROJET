<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Modifier Préparation - Cabinet PHAOS</title>
    
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
        .required:after {
            content: " *";
            color: red;
        }
        .current-file {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }
        .file-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="p-3">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <!-- En-tête avec titre -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="bi bi-pencil-square me-2"></i>Modifier la Préparation
                                    </h5>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('preparations.index') }}">Préparations</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('preparations.show', $preparation->id) }}">#{{ $preparation->id }}</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Modifier</li>
                                        </ol>
                                    </nav>
                                </div>
                                <a href="{{ route('preparations.show', $preparation->id) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Retour
                                </a>
                            </div>
                            
                            <!-- Formulaire de modification -->
                            <form id="editPreparationForm">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <!-- Description -->
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label required">Description</label>
                                        <textarea class="form-control" id="description" name="description" 
                                                  rows="4" required placeholder="Description de la préparation...">{{ old('description', $preparation->description) }}</textarea>
                                        <div class="invalid-feedback" id="description-error"></div>
                                    </div>
                                    
                                    <!-- Date -->
                                    <div class="col-md-6 mb-3">
                                        <label for="daty" class="form-label required">Date de préparation</label>
                                        <input type="date" class="form-control" id="daty" name="daty" 
                                               value="{{ old('daty', $preparation->daty) }}" required>
                                        <div class="invalid-feedback" id="daty-error"></div>
                                    </div>
                                    
                                    <!-- Tâche à faire -->
                                    <div class="col-md-6 mb-3">
                                        <label for="id_a_faire" class="form-label required">Type de tâche à faire</label>
                                        <select class="form-select" id="id_a_faire" name="id_a_faire" required>
                                            <option value="">Sélectionnez une tâche...</option>
                                            @foreach($aFaireList as $aFaire)
                                                <option value="{{ $aFaire->id }}" 
                                                    {{ old('id_a_faire', $preparation->id_a_faire) == $aFaire->id ? 'selected' : '' }}>
                                                    {{ $aFaire->nom }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="id_a_faire-error"></div>
                                    </div>
                                    
                                    <!-- Utilisateur concerné (lecture seule) -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Tâche concernée</label>
                                        <div class="form-control bg-light">
                                            @if($preparation->utilisateurConcerner)
                                                {{ $preparation->utilisateurConcerner->description_tache ?? 'Sans description' }}
                                            @else
                                                <span class="text-muted">Non liée</span>
                                            @endif
                                        </div>
                                        <input type="hidden" name="id_utilisateur_concerner" value="{{ $preparation->id_utilisateur_concerner }}">
                                    </div>
                                    
                                    <!-- Boutons d'action -->
                                    <div class="col-md-12 mt-4">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                                <i class="bi bi-trash me-1"></i> Supprimer
                                            </button>
                                            <div>
                                                <a href="{{ route('preparations.show', $preparation->id) }}" class="btn btn-secondary">
                                                    Annuler
                                                </a>
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    <i class="bi bi-save me-1"></i> Enregistrer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <!-- Section des détails existants -->
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="bi bi-list-check me-2"></i>
                                                Détails associés
                                                @if($preparation->details->count() > 0)
                                                    <span class="badge bg-primary ms-2">{{ $preparation->details->count() }}</span>
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            @if($preparation->details->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Nom</th>
                                                                <th>Description</th>
                                                                <th>Fichier</th>
                                                                <th>URL</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($preparation->details as $index => $detail)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $detail->nom ?: '-' }}</td>
                                                                <td>{{ Str::limit($detail->description, 30) ?: '-' }}</td>
                                                                <td>
                                                                    @if($detail->fichier)
                                                                        <?php
                                                                        $uploadPath = 'uploads/detaille_a_faire/';
                                                                        $filePath = public_path($uploadPath . $detail->fichier);
                                                                        $fileExists = file_exists($filePath);
                                                                        $isUploadedFile = preg_match('/^\d+_\w+\.\w+$/', $detail->fichier);
                                                                        ?>
                                                                        
                                                                        @if($isUploadedFile && $fileExists)
                                                                            <a href="{{ asset($uploadPath . $detail->fichier) }}" 
                                                                               target="_blank"
                                                                               class="badge bg-success text-decoration-none">
                                                                                <i class="bi bi-download me-1"></i>
                                                                                {{ $detail->getFileExtension() ?: 'Fichier' }}
                                                                            </a>
                                                                        @else
                                                                            <span class="badge bg-secondary">
                                                                                {{ Str::limit($detail->fichier, 15) }}
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
                                                                               class="badge bg-info text-decoration-none">
                                                                                <i class="bi bi-link me-1"></i> URL
                                                                            </a>
                                                                        @else
                                                                            <span class="badge bg-warning">
                                                                                {{ Str::limit($detail->url, 15) }}
                                                                            </span>
                                                                        @endif
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group btn-group-sm">
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
                                                <div class="text-center py-4">
                                                    <i class="bi bi-inbox display-6 text-muted"></i>
                                                    <p class="text-muted mt-2">Aucun détail associé à cette préparation.</p>
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
    // Gestion de la soumission du formulaire de modification
    document.getElementById('editPreparationForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Réinitialiser les erreurs
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';
        
        fetch('{{ route("preparations.update", $preparation->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Préparation modifiée avec succès !');
                window.location.href = '{{ route("preparations.show", $preparation->id) }}';
            } else {
                // Afficher les erreurs de validation
                if (data.errors) {
                    for (const field in data.errors) {
                        const input = document.querySelector(`[name="${field}"]`);
                        const errorEl = document.getElementById(`${field}-error`);
                        
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                        if (errorEl) {
                            errorEl.textContent = data.errors[field][0];
                        }
                    }
                }
                alert(data.message || 'Erreur lors de la modification');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la modification: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // Fonction pour confirmer la suppression de la préparation
    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette préparation ? Tous les détails associés seront également supprimés.')) {
            window.location.href = '{{ route("preparations.destroy", $preparation->id) }}';
        }
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
    
    // Fonction pour modifier un détail
    function editDetail(detailId) {
        // Récupérer les données du détail
        fetch('{{ route("preparations.details.edit", "") }}/' + detailId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement des données');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const detail = data.detail;
                    
                    // Construire le formulaire d'édition
                    const formHtml = `
                        <input type="hidden" name="id" value="${detail.id}">
                        <input type="hidden" name="id_preparation" value="${detail.id_preparation}">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nom" class="form-label">Nom (optionnel)</label>
                                <input type="text" class="form-control" id="edit_nom" name="nom" 
                                       value="${detail.nom || ''}" maxlength="250">
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="edit_description" class="form-label">Description (optionnel)</label>
                                <textarea class="form-control" id="edit_description" name="description" 
                                          rows="3">${detail.description || ''}</textarea>
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
                                                <span>Fichier actuel: ${detail.fichier}</span>
                                                ${detail.fichier.match(/^\d+_\w+\.\w+$/) ? 
                                                    `<a href="{{ asset('uploads/detaille_a_faire/') }}/${detail.fichier}" 
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
                                                       value="${detail.fichier && !detail.fichier.match(/^\d+_\w+\.\w+$/) ? detail.fichier : ''}"
                                                       placeholder="ex: document.pdf ou C:\dossier\fichier" maxlength="250">
                                                <div class="form-text">Nom de fichier ou chemin local</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="edit_url" class="form-label">URL (optionnel)</label>
                                <input type="text" class="form-control" id="edit_url" name="url" 
                                       value="${detail.url || ''}" placeholder="https://example.com" maxlength="500">
                                <div class="form-text">URL web vers une ressource</div>
                            </div>
                        </div>
                    `;
                    
                    // Insérer le formulaire dans la modal
                    document.getElementById('editDetailModalBody').innerHTML = formHtml;
                    
                    // Afficher la modal
                    const modal = new bootstrap.Modal(document.getElementById('editDetailModal'));
                    modal.show();
                    
                    // Gérer la soumission du formulaire d'édition
                    document.getElementById('editDetailForm').onsubmit = function(e) {
                        e.preventDefault();
                        updateDetail(detailId);
                    };
                    
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors du chargement des données du détail');
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
                alert('Erreur: ' + (data.message || 'Échec de la mise à jour'));
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