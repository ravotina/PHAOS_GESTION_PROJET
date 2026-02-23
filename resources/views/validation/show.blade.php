<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Validation - {{ $validation->etape }}</title>
    
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
        .project-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .validation-card {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .file-preview {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
        }
        
        .action-buttons .btn {
            min-width: 150px;
        }
        
        .section-title {
            border-left: 4px solid #0d6efd;
            padding-left: 15px;
            margin-bottom: 20px;
        }
        
        .projet-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
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
                            <!-- En-tête -->
                            <div class="project-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-1">
                                            <i class="bi bi-check-circle me-2"></i>
                                            Validation d'étape
                                        </h4>
                                        <p class="mb-0">Projet : {{ $validation->projet->titre }}</p>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-warning fs-6">
                                            <i class="bi bi-clock me-1"></i> En attente
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ==================== -->
                            <!-- SECTION 1 : DÉTAILS DU PROJET -->
                            <!-- ==================== -->
                            <div class="projet-details mb-4">
                                <h5 class="section-title">
                                    <i class="bi bi-folder me-2"></i>
                                    Détails du projet à valider
                                </h5>
                                
                                <div class="row">
                                    <!-- Informations de base -->
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <h6><i class="bi bi-info-circle me-2"></i> Informations générales</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th style="width: 40%;">Numéro projet :</th>
                                                    <td><strong>{{ $validation->projet->numero_projet }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Titre :</th>
                                                    <td>{{ $validation->projet->titre }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description :</th>
                                                    <td>{{ $validation->projet->description ?: 'Non renseignée' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Objectif :</th>
                                                    <td>{{ $validation->projet->objectif ?: 'Non renseigné' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <h6><i class="bi bi-calendar me-2"></i> Dates du projet</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th style="width: 40%;">Date début :</th>
                                                    <td>{{ $validation->projet->date_debu ? date('d/m/Y', strtotime($validation->projet->date_debu)) : 'Non définie' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Date fin :</th>
                                                    <td>{{ $validation->projet->date_fin ? date('d/m/Y', strtotime($validation->projet->date_fin)) : 'Non définie' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <!-- Informations workflow -->
                                    <div class="col-md-6">
                                        <div class="detail-item">
                                            <h6><i class="bi bi-diagram-3 me-2"></i> Étape de validation</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <th style="width: 40%;">Étape :</th>
                                                    <td><strong class="text-primary">{{ $validation->etape }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Date création :</th>
                                                    <td>{{ date('d/m/Y', strtotime($validation->date_creation)) }}</td>
                                                </tr>
                                                @if($validation->workflow && $validation->workflow->date_arriver)
                                                    <tr>
                                                        <th>Date début étape :</th>
                                                        <td>{{ date('d/m/Y', strtotime($validation->workflow->date_arriver)) }}</td>
                                                    </tr>
                                                @endif
                                                @if($validation->workflow && $validation->workflow->date_fin_de_validation)
                                                    <tr>
                                                        <th>Date fin étape :</th>
                                                        <td>{{ date('d/m/Y', strtotime($validation->workflow->date_fin_de_validation)) }}</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                        
                                        <!-- Participants -->
                                        <div class="detail-item">
                                            <h6><i class="bi bi-people me-2"></i> Participants à cette étape</h6>
                                            @if($validation->workflow && $validation->workflow->utilisateursConcernes)
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($validation->workflow->utilisateursConcernes as $user)
                                                        <span class="badge bg-light text-dark border">
                                                            <i class="bi bi-person me-1"></i>
                                                            Utilisateur #{{ $user->id_utilisateur }}
                                                            @if($user->id_utilisateur == $validation->id_utilisateur)
                                                                <span class="badge bg-primary ms-1">Vous</span>
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted mb-0"><small>Aucun participant défini</small></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Lancement projet -->
                                @if($validation->projet->lancementProjet)
                                    <div class="detail-item">
                                        <h6><i class="bi bi-rocket-takeoff me-2"></i> Lancement associé</h6>
                                        <p class="mb-0">
                                            {{ $validation->projet->lancementProjet->nom }}
                                            @if($validation->projet->lancementProjet->projetDemare)
                                                → Projet : {{ $validation->projet->lancementProjet->projetDemare->non_de_projet }}
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- ==================== -->
                            <!-- SECTION 2 : FICHIERS DU PROJET -->
                            <!-- ==================== -->
                            @if($validation->projet->details && $validation->projet->details->count() > 0)
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="section-title mb-3">
                                            <i class="bi bi-paperclip me-2"></i>
                                            Fichiers joints au projet
                                        </h5>
                                        <div class="row">
                                            @foreach($validation->projet->details as $detail)
                                                <div class="col-md-4 mb-3">
                                                    <div class="file-preview">
                                                        <div class="d-flex align-items-center">
                                                            @php
                                                                $icon = 'bi-file-earmark';
                                                                if($detail->file_extension) {
                                                                    $ext = strtolower($detail->file_extension);
                                                                    if(in_array($ext, ['pdf'])) $icon = 'bi-file-earmark-pdf';
                                                                    elseif(in_array($ext, ['doc', 'docx'])) $icon = 'bi-file-earmark-word';
                                                                    elseif(in_array($ext, ['xls', 'xlsx'])) $icon = 'bi-file-earmark-excel';
                                                                    elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) $icon = 'bi-file-earmark-image';
                                                                }
                                                            @endphp
                                                            <i class="bi {{ $icon }} fs-3 text-primary me-3"></i>
                                                            <div>
                                                                <strong class="d-block">{{ $detail->nom }}</strong>
                                                                @if($detail->description)
                                                                    <small class="text-muted">{{ $detail->description }}</small><br>
                                                                @endif
                                                                <div class="mt-2">
                                                                    <a href="{{ route('projet.travailler.details.download', [$validation->projet->id, $detail->id]) }}" 
                                                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                                                        <i class="bi bi-download me-1"></i> Télécharger
                                                                    </a>
                                                                    @if(in_array($detail->file_extension, ['pdf', 'jpg', 'jpeg', 'png']))
                                                                        <a href="{{ $detail->file_url }}" 
                                                                           class="btn btn-sm btn-outline-info ms-1" 
                                                                           target="_blank"
                                                                           title="Visualiser">
                                                                            <i class="bi bi-eye me-1"></i> Visualiser
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- ==================== -->
                            <!-- SECTION 3 : COMMENTAIRE DE L'ÉTAPE -->
                            <!-- ==================== -->
                            @if($validation->workflow && $validation->workflow->commentaires)
                                <div class="alert alert-info mb-4">
                                    <h6><i class="bi bi-chat-left-text me-2"></i>Commentaire de l'étape</h6>
                                    <p class="mb-0">{{ $validation->workflow->commentaires }}</p>
                                </div>
                            @endif
                            
                            <!-- ==================== -->
                            <!-- SECTION 4 : FICHIERS DÉJÀ ATTACHÉS À LA VALIDATION -->
                            <!-- ==================== -->
                            @if($validation->details && $validation->details->count() > 0)
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">
                                            <i class="bi bi-paperclip me-2"></i>
                                            Fichiers déjà attachés à cette validation
                                        </h6>
                                        <div class="row">
                                            @foreach($validation->details as $detail)
                                                <div class="col-md-4 mb-3">
                                                    <div class="file-preview">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-file-earmark fs-3 text-primary me-3"></i>
                                                            <div>
                                                                <strong class="d-block">{{ $detail->nom }}</strong>
                                                                <small class="text-muted">{{ $detail->description }}</small>
                                                                <br>
                                                                <a href="{{ route('validation.download', [$validation->id, $detail->id]) }}" 
                                                                   class="btn btn-sm btn-outline-primary mt-1">
                                                                    <i class="bi bi-download me-1"></i> Télécharger
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- ==================== -->
                            <!-- SECTION 5 : FORMULAIRE DE VALIDATION -->
                            <!-- ==================== -->
                            <div class="card validation-card">
                                <div class="card-body">
                                    <h5 class="section-title mb-4">
                                        <i class="bi bi-pencil-square me-2"></i>
                                        Votre décision
                                    </h5>
                                    
                                    <div class="alert alert-warning mb-4">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <strong>Important :</strong> Avant de prendre votre décision, vérifiez bien :
                                        <ul class="mb-0 mt-2">
                                            <li>Les informations du projet ci-dessus</li>
                                            <li>Les fichiers joints au projet</li>
                                            <li>Le commentaire de l'étape (si présent)</li>
                                        </ul>
                                    </div>
                                    
                                    <form id="validationForm" action="{{ route('validation.traiter', $validation->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <!-- Champ caché pour l'action -->
                                        <input type="hidden" id="actionField" name="action" value="">
                                        
                                        <!-- Commentaire -->
                                        <div class="mb-4">
                                            <label for="commentaire" class="form-label fw-bold">
                                                <i class="bi bi-chat-left-text me-1"></i>
                                                Votre commentaire
                                            </label>
                                            <textarea class="form-control" 
                                                      id="commentaire" 
                                                      name="commentaire" 
                                                      rows="4"
                                                      placeholder="Ajoutez un commentaire pour justifier votre décision (ex: 'Tous les documents sont conformes', 'Manque le fichier X', etc.)..."></textarea>
                                            <small class="text-muted">
                                                Optionnel mais fortement recommandé. Expliquez les raisons de votre décision.
                                            </small>
                                        </div>
                                        
                                        <!-- Fichiers joints (pour cette validation) -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">
                                                <i class="bi bi-paperclip me-1"></i>
                                                Ajouter des fichiers à votre validation
                                            </label>
                                            <div class="alert alert-light border">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Vous pouvez ajouter des fichiers supplémentaires pour justifier votre décision 
                                                (ex: preuve de vérification, corrections, etc.)
                                            </div>
                                            <div class="input-group mb-2">
                                                <input type="file" 
                                                       class="form-control" 
                                                       name="fichiers[]" 
                                                       multiple
                                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt">
                                                <button class="btn btn-outline-secondary" type="button" onclick="addMoreFiles()">
                                                    <i class="bi bi-plus"></i> Ajouter
                                                </button>
                                            </div>
                                            <div id="fileFields"></div>
                                            <small class="text-muted">Maximum 5 fichiers, 5MB par fichier. Formats: PDF, Word, Excel, Images, Texte</small>
                                        </div>
                                        
                                        <!-- Boutons d'action -->
                                        <div class="action-buttons d-flex justify-content-between mt-5 pt-4 border-top">
                                            <div>
                                                <a href="{{ route('validation.index') }}" class="btn btn-outline-secondary">
                                                    <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                                                </a>
                                                <a href="javascript:void(0)" onclick="window.location.reload()" class="btn btn-outline-info ms-2">
                                                    <i class="bi bi-arrow-clockwise me-1"></i> Actualiser
                                                </a>
                                            </div>
                                            
                                            <div class="d-flex gap-3">
                                                <button type="button" 
                                                        class="btn btn-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rejectModal">
                                                    <i class="bi bi-x-circle me-1"></i> Rejeter l'étape
                                                </button>
                                                
                                                <button type="button" 
                                                        class="btn btn-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#approveModal">
                                                    <i class="bi bi-check-circle me-1"></i> Valider l'étape
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- ==================== -->
                            <!-- SECTION 6 : ÉTAPE SUIVANTE (si existe) -->
                            <!-- ==================== -->
                            @if($etapeSuivante)
                                <div class="alert alert-info mt-4">
                                    <i class="bi bi-arrow-right-circle me-2"></i>
                                    <strong>Étape suivante :</strong> 
                                    Si cette étape est validée, la prochaine étape sera : 
                                    <strong>{{ $etapeSuivante->nom_etape }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de validation -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle me-2"></i>
                        Confirmer la validation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir <strong>valider</strong> cette étape ?</p>
                    <div class="alert alert-light border">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <small>
                            <strong>Conséquences :</strong><br>
                            1. Votre validation sera enregistrée<br>
                            2. Si tous les participants valident, l'étape sera marquée comme terminée<br>
                            3. L'étape suivante pourra commencer (si elle existe)
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-success" onclick="submitForm('valider')">
                        <i class="bi bi-check-circle me-1"></i> Oui, valider cette étape
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de rejet -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-x-circle me-2"></i>
                        Confirmer le rejet
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir <strong>rejeter</strong> cette étape ?</p>
                    
                    <div class="mb-3">
                        <label for="rejectComment" class="form-label fw-bold">
                            <i class="bi bi-chat-left-text me-1"></i>
                            Commentaire obligatoire pour le rejet
                        </label>
                        <textarea class="form-control" 
                                  id="rejectComment" 
                                  rows="3"
                                  placeholder="Veuillez expliquer les raisons du rejet... (ex: 'Documents incomplets', 'Information manquante', etc.)"
                                  required></textarea>
                        <small class="text-muted">Un commentaire est obligatoire pour justifier le rejet.</small>
                    </div>
                    
                    <div class="alert alert-light border">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                        <small>
                            <strong>Attention :</strong><br>
                            1. Le rejet stoppera le workflow pour cette étape<br>
                            2. Tous les participants seront notifiés<br>
                            3. Le projet devra être corrigé et relancé
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-danger" onclick="submitForm('rejeter')">
                        <i class="bi bi-x-circle me-1"></i> Oui, rejeter cette étape
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('page.footer')
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
    let fileCounter = 0;
    
    // Ajouter plus de champs de fichiers
    function addMoreFiles() {
        if (fileCounter >= 4) { // Maximum 5 fichiers au total
            alert('Maximum 5 fichiers autorisés');
            return;
        }
        
        fileCounter++;
        
        const fileFields = document.getElementById('fileFields');
        const newField = document.createElement('div');
        newField.className = 'input-group mb-2';
        newField.innerHTML = `
            <input type="file" 
                   class="form-control" 
                   name="fichiers[]"
                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt">
            <button class="btn btn-outline-danger" type="button" onclick="removeFileField(this)">
                <i class="bi bi-trash"></i>
            </button>
        `;
        
        fileFields.appendChild(newField);
    }
    
    // Supprimer un champ de fichier
    function removeFileField(button) {
        button.parentNode.remove();
        fileCounter--;
    }
    
    // Soumettre le formulaire
    function submitForm(action) {
        const form = document.getElementById('validationForm');
        const actionField = document.getElementById('actionField');
        
        // Définir l'action
        actionField.value = action;
        
        // Pour le rejet, copier le commentaire du modal dans le champ du formulaire
        if (action === 'rejeter') {
            const rejectComment = document.getElementById('rejectComment').value;
            if (!rejectComment.trim()) {
                alert('Veuillez saisir un commentaire pour justifier le rejet.');
                return;
            }
            
            // Copier dans le champ commentaire du formulaire principal
            document.getElementById('commentaire').value = rejectComment;
        }
        
        // Validation : si aucun commentaire ni fichier pour validation, demander confirmation
        const commentaire = document.getElementById('commentaire').value;
        const fichiers = document.querySelectorAll('input[name="fichiers[]"]');
        let hasFiles = false;
        
        fichiers.forEach(input => {
            if (input.files && input.files.length > 0) {
                hasFiles = true;
            }
        });
        
        if (!commentaire.trim() && !hasFiles && action === 'valider') {
            if (!confirm('Vous n\'avez ajouté ni commentaire ni fichier. Souhaitez-vous quand même valider cette étape ?')) {
                return;
            }
        }
        
        // Fermer le modal
        const modalId = action === 'valider' ? 'approveModal' : 'rejectModal';
        const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        if (modal) {
            modal.hide();
        }
        
        // Afficher un indicateur de chargement
        const submitBtns = document.querySelectorAll(`[onclick="submitForm('${action}')"]`);
        submitBtns.forEach(btn => {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Traitement en cours...';
            btn.disabled = true;
            
            // Restaurer après 3 secondes (au cas où)
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 3000);
        });
        
        // Soumettre le formulaire
        form.submit();
    }
    
    // Initialiser
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifier si le commentaire du rejet est requis
        const rejectModal = document.getElementById('rejectModal');
        if (rejectModal) {
            rejectModal.addEventListener('show.bs.modal', function() {
                document.getElementById('rejectComment').value = '';
            });
        }
    });
    </script>
    
</body>
</html>