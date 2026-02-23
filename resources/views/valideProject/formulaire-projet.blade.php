<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Créer un Nouveau Projet</title>
    
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
        /* Style pour les fichiers uploadés */
        .file-preview {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }
        
        .file-preview:hover {
            background-color: #e9ecef;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .file-icon {
            font-size: 1.5rem;
        }
        
        .file-name {
            flex-grow: 1;
            word-break: break-all;
        }
        
        .file-size {
            color: #6c757d;
            font-size: 0.875rem;
        }
        
        .remove-file {
            color: #dc3545;
            cursor: pointer;
        }
        
        .remove-file:hover {
            color: #c82333;
        }
        
        /* Animation pour l'ajout de fichiers */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Style pour le champ fichier personnalisé */
        .custom-file-upload {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .custom-file-upload:hover {
            border-color: #0d6efd;
            background-color: #e9ecef;
        }
        
        .custom-file-upload.drag-over {
            border-color: #198754;
            background-color: #d1e7dd;
        }
        
        /* Style pour les champs de fichier */
        .file-field {
            margin-top: 10px;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
        }
        
        /* Aperçu image */
        .image-preview {
            max-width: 150px;
            max-height: 100px;
            object-fit: cover;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 5px;
        }
        
        /* Numéro de fichier */
        .file-number {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 0.75rem;
            margin-right: 8px;
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="bi bi-folder-plus me-2"></i>
                                        Créer un Nouveau Projet
                                    </h5>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de Tache</a></li>
                                            <li class="breadcrumb-item"><a href="">Tache</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Créer</li>
                                        </ol>
                                    </nav>
                                </div>
                                <a href="" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Retour
                                </a>
                            </div>
                            
                            <!-- Messages d'alerte -->
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Succès !</strong> {{ session('success') }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                                    <div>
                                        <strong>Erreurs de validation !</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <!-- Formulaire -->
                            <form action="{{ route('workflow-validation.tache.store') }}" method="POST" enctype="multipart/form-data" id="projetForm">
                                @csrf

                                <div class="row">
                                    <!-- Numéro Projet -->
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_projet" class="form-label fw-bold">
                                            <span class="text-danger">*</span> Numéro du Projet
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('numero_projet') is-invalid @enderror" 
                                               id="numero_projet" 
                                               name="numero_projet"
                                               value="{{ old('numero_projet') }}" 
                                               required
                                               placeholder="Ex: PROJ-001"
                                               maxlength="50">
                                        @error('numero_projet')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Doit être unique (max: 50 caractères)</small>
                                    </div>

                                    <!-- Titre -->
                                    <div class="col-md-6 mb-3">
                                        <label for="titre" class="form-label fw-bold">
                                            <span class="text-danger">*</span> Titre du Projet
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('titre') is-invalid @enderror" 
                                               id="titre" 
                                               name="titre" 
                                               value="{{ old('titre') }}" 
                                               required
                                               maxlength="50"
                                               placeholder="Titre du projet">
                                        @error('titre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Maximum 50 caractères</small>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3"
                                              placeholder="Décrivez le projet...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Objectif -->
                                <div class="mb-3">
                                    <label for="objectif" class="form-label">Objectif</label>
                                    <textarea class="form-control @error('objectif') is-invalid @enderror" 
                                              id="objectif" 
                                              name="objectif" 
                                              rows="3"
                                              placeholder="Objectifs du projet...">{{ old('objectif') }}</textarea>
                                    @error('objectif')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <!-- Date Début -->
                                    <div class="col-md-6 mb-3">
                                        <label for="date_debu" class="form-label">Date de Début</label>
                                        <input type="date" 
                                               class="form-control @error('date_debu') is-invalid @enderror" 
                                               id="date_debu" 
                                               name="date_debu" 
                                               value="{{ old('date_debu', date('Y-m-d')) }}">
                                        @error('date_debu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date Fin -->
                                    <div class="col-md-6 mb-3">
                                        <label for="date_fin" class="form-label">Date de Fin</label>
                                        <input type="date" 
                                               class="form-control @error('date_fin') is-invalid @enderror" 
                                               id="date_fin" 
                                               name="date_fin" 
                                               value="{{ old('date_fin') }}">
                                        @error('date_fin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Projet Prérequis -->
                                    <div class="col-md-6 mb-6">
                                        <label for="id_projet_pre_a_faire" class="form-label fw-bold">
                                            <span class="text-danger">*</span> Projet Lancer
                                        </label>
                                        <select class="form-select @error('id_lancement_projet') is-invalid @enderror" 
                                                id="id_lancement_projet" 
                                                name="id_lancement_projet" 
                                                required>
                                            <option value="">Sélectionnez un lancement</option>
                                            @if($lancements->count() > 0)
                                                @foreach($lancements as $lancement)
                                                    <option value="{{ $lancement->id }}" 
                                                        {{ old('id_lancement_projet') == $lancement->id ? 'selected' : '' }}>
                                                        {{ $lancement->nom }}
                                                        @if($lancement->projetDemare)
                                                            (Projet: {{ $lancement->projetDemare->non_de_projet }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="" disabled>Aucun lancement disponible</option>
                                            @endif
                                        </select>
                                        @error('id_projet_pre_a_faire')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- SECTION FICHIERS - AVEC AJOUT DYNAMIQUE -->
                                <div class="mb-4">
                                    <h5 class="card-title mb-3">
                                        <i class="bi bi-paperclip me-2"></i>
                                        Fichiers associés
                                        <small class="text-muted">(Optionnel)</small>
                                    </h5>
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Conteneur pour les champs de fichiers -->
                                            <div id="fileFieldsContainer">
                                                <!-- Premier champ de fichier (toujours présent) -->
                                                <div class="file-field fade-in" id="fileField-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0">
                                                            <span class="file-number">1</span> Fichier
                                                        </h6>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-file-btn" onclick="removeFileField(1)" style="display: none;">
                                                            <i class="bi bi-trash me-1"></i> Supprimer
                                                        </button>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">
                                                                Fichier
                                                            </label>
                                                            <input type="file" 
                                                                   class="form-control file-input" 
                                                                   name="files[]"
                                                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">
                                                                Nom du fichier <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" 
                                                                   class="form-control file-name-input" 
                                                                   name="file_names[]" 
                                                                   placeholder="Ex: Spécifications techniques"
                                                                   maxlength="50"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="form-label">
                                                                Description
                                                            </label>
                                                            <textarea class="form-control file-description-input" 
                                                                      name="file_descriptions[]"
                                                                      rows="2"
                                                                      placeholder="Description du fichier..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Bouton pour ajouter un autre fichier -->
                                            <div class="text-center mt-3">
                                                <button type="button" class="btn btn-outline-primary" id="addFileBtn">
                                                    <i class="bi bi-plus-circle me-1"></i> Ajouter un autre fichier
                                                </button>
                                            </div>
                                            
                                            <!-- Instructions -->
                                            <div class="alert alert-info mt-3">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <div class="small">
                                                    <strong>Information :</strong><br>
                                                    1. Maximum 10 fichiers<br>
                                                    2. 5MB maximum par fichier<br>
                                                    3. Formats : PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, GIF, TXT<br>
                                                    4. Le nom du fichier est obligatoire si vous uploadez un fichier
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Boutons -->
                                <div class="d-flex justify-content-between mt-4 pt-4 border-top">
                                    <a href="" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                        <i class="bi bi-check-circle me-1"></i> Créer le Projet
                                    </button>
                                </div>
                            </form>
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

    let fileFieldCount = 1;
    const maxFiles = 10;
    // Variables globales pour gérer les fichiers
    let fileCounter = 0;
    const maxFileSize = 5 * 1024 * 1024; // 5MB en bytes
    const allowedTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'text/plain'
    ];
    
    // Extension en français
    const fileTypeNames = {
        'pdf': 'Document PDF',
        'doc': 'Document Word',
        'docx': 'Document Word',
        'xls': 'Feuille Excel',
        'xlsx': 'Feuille Excel',
        'jpg': 'Image',
        'jpeg': 'Image',
        'png': 'Image',
        'gif': 'Image',
        'txt': 'Document Texte'
    };
    
    // Validation des dates
    document.addEventListener('DOMContentLoaded', function() {
        const dateDebut = document.getElementById('date_debu');
        const dateFin = document.getElementById('date_fin');
        
        if (dateFin && dateDebut) {
            dateDebut.addEventListener('change', function() {
                if (this.value && dateFin.value && dateFin.value < this.value) {
                    alert('La date de fin ne peut pas être antérieure à la date de début.');
                    dateFin.value = '';
                }
            });
            
            dateFin.addEventListener('change', function() {
                if (dateDebut.value && this.value && this.value < dateDebut.value) {
                    alert('La date de fin ne peut pas être antérieure à la date de début.');
                    this.value = '';
                }
            });
        }
        
        // Formatage automatique du numéro de projet
        const numeroProjet = document.getElementById('numero_projet');
        if (numeroProjet) {
            numeroProjet.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // Initialiser le bouton "Ajouter un autre fichier"
        document.getElementById('addFileBtn').addEventListener('click', addFileField);
        
        // Validation avant soumission
        document.getElementById('projetForm').addEventListener('submit', validateForm);
        
        // Initialiser la gestion des fichiers
        initFileUpload();
    });

    // Fonction pour ajouter un nouveau champ de fichier
    function addFileField() {
        if (fileFieldCount >= maxFiles) {
            alert(`Maximum ${maxFiles} fichiers autorisés.`);
            return;
        }
        
        fileFieldCount++;
        
        // Créer le nouveau champ
        const newField = document.createElement('div');
        newField.className = 'file-field fade-in';
        newField.id = `fileField-${fileFieldCount}`;
        newField.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">
                    <span class="file-number">${fileFieldCount}</span> Fichier
                </h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-file-btn" onclick="removeFileField(${fileFieldCount})">
                    <i class="bi bi-trash me-1"></i> Supprimer
                </button>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label">
                        Fichier
                    </label>
                    <input type="file" 
                        class="form-control file-input" 
                        name="files[]"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.txt">
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        Nom du fichier
                    </label>
                    <input type="text" 
                        class="form-control file-name-input" 
                        name="file_names[]" 
                        placeholder="Ex: Spécifications techniques"
                        maxlength="50">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">
                        Description
                    </label>
                    <textarea class="form-control file-description-input" 
                            name="file_descriptions[]"
                            rows="2"
                            placeholder="Description du fichier..."></textarea>
                </div>
            </div>
        `;
        
        // Ajouter au conteneur
        document.getElementById('fileFieldsContainer').appendChild(newField);
        
        // Animer l'apparition
        setTimeout(() => {
            newField.style.opacity = 1;
        }, 10);
        
        // Mettre à jour le bouton de soumission
        updateSubmitButton();
        
        // Faire défiler jusqu'au nouveau champ
        newField.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Fonction pour supprimer un champ de fichier
    function removeFileField(fieldId) {
        const field = document.getElementById(`fileField-${fieldId}`);
        if (!field) return;
        
        // Animation de disparition
        field.style.opacity = 0;
        field.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            field.remove();
            
            // Renuméroter les champs restants
            renumberFileFields();
            
            // Mettre à jour le compteur
            fileFieldCount = document.querySelectorAll('.file-field').length;
            
            // Mettre à jour le bouton de soumission
            updateSubmitButton();
        }, 300);
    }

    // Fonction pour renuméroter les champs de fichiers
    function renumberFileFields() {
        const fields = document.querySelectorAll('.file-field');
        fields.forEach((field, index) => {
            const number = index + 1;
            const numberSpan = field.querySelector('.file-number');
            if (numberSpan) {
                numberSpan.textContent = number;
            }
            
            // Mettre à jour l'ID
            field.id = `fileField-${number}`;
            
            // Mettre à jour l'événement onclick du bouton supprimer
            const removeBtn = field.querySelector('.remove-file-btn');
            if (removeBtn) {
                removeBtn.setAttribute('onclick', `removeFileField(${number})`);
                
                // Afficher ou cacher le bouton supprimer (toujours présent sauf pour le premier)
                if (number === 1) {
                    removeBtn.style.display = 'none';
                } else {
                    removeBtn.style.display = 'block';
                }
            }
        });
    }

    // Fonction pour mettre à jour le bouton de soumission
    function updateSubmitButton() {
        const fileCount = document.querySelectorAll('.file-field').length;
        const submitBtn = document.getElementById('submitBtn');
        
        if (fileCount > 0) {
            submitBtn.innerHTML = `<i class="bi bi-check-circle me-1"></i> Créer le Projet (${fileCount} fichier${fileCount > 1 ? 's' : ''})`;
        } else {
            submitBtn.innerHTML = `<i class="bi bi-check-circle me-1"></i> Créer le Projet`;
        }
    }

    // Fonction de validation avant soumission
    function validateForm(e) {
        let isValid = true;
        const errorMessages = [];
        
        // Vérifier chaque champ de fichier
        const fileFields = document.querySelectorAll('.file-field');
        
        fileFields.forEach((field, index) => {
            const fileInput = field.querySelector('.file-input');
            const nameInput = field.querySelector('.file-name-input');
            
            // Si un fichier est sélectionné, le nom doit être rempli
            if (fileInput.files.length > 0) {
                if (!nameInput.value.trim()) {
                    isValid = false;
                    nameInput.classList.add('is-invalid');
                    
                    // Ajouter message d'erreur
                    if (!nameInput.nextElementSibling || !nameInput.nextElementSibling.classList.contains('invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Le nom du fichier est requis';
                        nameInput.parentNode.appendChild(errorDiv);
                    }
                    
                    errorMessages.push(`Le fichier ${index + 1} nécessite un nom`);
                } else {
                    nameInput.classList.remove('is-invalid');
                    const errorDiv = nameInput.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                }
            } else {
                // Pas de fichier, on supprime les erreurs
                nameInput.classList.remove('is-invalid');
                const errorDiv = nameInput.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
            
            // Validation de la taille du fichier (5MB max)
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (file.size > maxSize) {
                    isValid = false;
                    fileInput.classList.add('is-invalid');
                    
                    // Ajouter message d'erreur
                    if (!fileInput.nextElementSibling || !fileInput.nextElementSibling.classList.contains('invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Le fichier dépasse la taille maximale de 5MB';
                        fileInput.parentNode.appendChild(errorDiv);
                    }
                    
                    errorMessages.push(`Le fichier "${file.name}" dépasse 5MB`);
                } else {
                    fileInput.classList.remove('is-invalid');
                    const errorDiv = fileInput.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            
            // Afficher une alerte avec les erreurs
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Erreurs de validation :</strong>
                <ul class="mb-0 mt-2">
                    ${errorMessages.map(msg => `<li>${msg}</li>`).join('')}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Ajouter l'alerte en haut de la section fichiers
            const fileSection = document.querySelector('.card-body');
            fileSection.insertBefore(alertDiv, fileSection.firstChild);
            
            // Faire défiler jusqu'aux erreurs
            document.querySelector('.is-invalid').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }


    
    // Fonction pour initialiser l'upload de fichiers
    function initFileUpload() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        
        // Gestion du drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Changement de style pendant le drag
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropZone.classList.add('drag-over');
        }
        
        function unhighlight() {
            dropZone.classList.remove('drag-over');
        }
        
        // Gestion du drop
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        // Gestion du changement via input
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
            this.value = ''; // Réinitialiser
        });
    }
    
    // Gérer les fichiers sélectionnés
    function handleFiles(files) {
        [...files].forEach(file => {
            // Vérifier la taille
            if (file.size > maxFileSize) {
                showError(`Le fichier "${file.name}" dépasse la taille maximale de 5MB`);
                return;
            }
            
            // Vérifier le type
            if (!allowedTypes.includes(file.type) && !file.name.match(/\.(pdf|doc|docx|xls|xlsx|jpg|jpeg|png|gif|txt)$/i)) {
                showError(`Le type de fichier "${file.name}" n'est pas autorisé`);
                return;
            }
            
            // Ajouter le fichier à la liste
            addFileToList(file);
        });
    }
    
    // Ajouter un fichier à la liste d'affichage
    function addFileToList(file) {
        fileCounter++;
        const fileId = `file-${fileCounter}`;
        const fileList = document.getElementById('fileList');
        
        // Obtenir l'extension
        const extension = file.name.split('.').pop().toLowerCase();
        const typeName = fileTypeNames[extension] || 'Fichier';
        
        // Obtenir l'icône
        const icon = getFileIcon(extension);
        
        // Formater la taille
        const size = formatFileSize(file.size);
        
        // Extraire le nom sans extension
        const fileNameWithoutExt = file.name.replace(/\.[^/.]+$/, "");
        
        // Créer l'élément HTML
        const fileElement = document.createElement('div');
        fileElement.className = 'file-preview fade-in';
        fileElement.id = fileId;
        fileElement.innerHTML = `
            <div class="file-info mb-2">
                <div class="file-icon">
                    <i class="bi ${icon} text-primary"></i>
                </div>
                <div class="file-name">
                    <strong><span class="file-number">${fileCounter}</span> ${file.name}</strong>
                    <div class="file-size">${typeName} • ${size}</div>
                </div>
                <div class="remove-file" onclick="removeFile('${fileId}')" title="Supprimer ce fichier">
                    <i class="bi bi-x-circle fs-5"></i>
                </div>
            </div>
            
            <!-- Champs du formulaire pour ce fichier -->
            <div class="file-field">
                <!-- Input FICHIER réel (pour ce fichier spécifique) -->
                <input type="file" 
                       name="files[]" 
                       style="display: none;" 
                       id="real-file-${fileCounter}"
                       data-file-id="${fileId}">
                
                <!-- NOM DU FICHIER (obligatoire) -->
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="file_name_${fileCounter}" class="form-label fw-bold">
                            <i class="bi bi-fonts me-1"></i> Nom du fichier
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control file-name-input" 
                               id="file_name_${fileCounter}" 
                               name="file_names[]" 
                               value="${fileNameWithoutExt}"
                               placeholder="Ex: Spécifications techniques"
                               maxlength="50"
                               required>
                        <small class="text-muted">Nom qui sera affiché (max: 50 caractères)</small>
                    </div>
                </div>
                
                <!-- DESCRIPTION (optionnelle) -->
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="file_description_${fileCounter}" class="form-label">
                            <i class="bi bi-card-text me-1"></i> Description
                        </label>
                        <textarea class="form-control" 
                                  id="file_description_${fileCounter}" 
                                  name="file_descriptions[]" 
                                  rows="2"
                                  placeholder="Description détaillée du fichier..."></textarea>
                        <small class="text-muted">Optionnel - Décrivez le contenu du fichier</small>
                    </div>
                </div>
                
                <!-- Prévisualisation pour les images -->
                ${file.type.startsWith('image/') ? `
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <small class="text-muted">Aperçu de l'image :</small>
                            <div class="mt-1">
                                <img src="${URL.createObjectURL(file)}" 
                                     class="image-preview" 
                                     alt="Aperçu de ${file.name}">
                            </div>
                        </div>
                    </div>
                ` : ''}
            </div>
            
            <hr class="my-2">
        `;
        
        // Ajouter au début de la liste
        fileList.prepend(fileElement);
        
        // ATTENTION : On ne peut pas assigner un fichier à un input file après coup
        // Solution : on va stocker les fichiers et les ajouter au formulaire avant soumission
        
        // Stocker le fichier dans un attribut data
        fileElement.dataset.file = JSON.stringify({
            name: file.name,
            type: file.type,
            size: file.size,
            lastModified: file.lastModified
        });
        
        // Stocker l'objet File
        fileElement.fileObject = file;
        
        // Animer l'apparition
        setTimeout(() => {
            fileElement.style.opacity = 1;
        }, 10);
        
        // Mettre à jour le compteur de fichiers
        updateFileCounter();
    }
    
    // Obtenir l'icône selon l'extension
    function getFileIcon(extension) {
        const icons = {
            'pdf': 'bi-file-earmark-pdf',
            'doc': 'bi-file-earmark-word',
            'docx': 'bi-file-earmark-word',
            'xls': 'bi-file-earmark-excel',
            'xlsx': 'bi-file-earmark-excel',
            'jpg': 'bi-file-earmark-image',
            'jpeg': 'bi-file-earmark-image',
            'png': 'bi-file-earmark-image',
            'gif': 'bi-file-earmark-image',
            'txt': 'bi-file-earmark-text'
        };
        
        return icons[extension] || 'bi-file-earmark';
    }
    
    // Formater la taille du fichier
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Supprimer un fichier de la liste
    function removeFile(fileId) {
        const fileElement = document.getElementById(fileId);
        if (fileElement) {
            // Animation de disparition
            fileElement.style.opacity = 0;
            fileElement.style.transform = 'translateX(-20px)';
            
            setTimeout(() => {
                fileElement.remove();
                updateFileCounter();
                renumberFiles();
            }, 300);
        }
    }
    
    // Renuméroter les fichiers après suppression
    function renumberFiles() {
        const filePreviews = document.querySelectorAll('.file-preview');
        filePreviews.forEach((preview, index) => {
            const number = index + 1;
            const numberSpan = preview.querySelector('.file-number');
            if (numberSpan) {
                numberSpan.textContent = number;
                
                // Mettre à jour les IDs
                const nameInput = preview.querySelector('.file-name-input');
                if (nameInput) {
                    nameInput.id = `file_name_${number}`;
                }
            }
        });
    }
    
    // Mettre à jour le compteur de fichiers
    function updateFileCounter() {
        const count = document.querySelectorAll('.file-preview').length;
        const submitBtn = document.getElementById('submitBtn');
        
        if (count > 0) {
            submitBtn.innerHTML = `<i class="bi bi-check-circle me-1"></i> Créer le Projet (${count} fichier${count > 1 ? 's' : ''})`;
        } else {
            submitBtn.innerHTML = `<i class="bi bi-check-circle me-1"></i> Créer le Projet`;
        }
    }
    
    // Afficher une erreur
    function showError(message) {
        // Créer une alerte temporaire
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
        alertDiv.innerHTML = `
            <i class="bi bi-exclamation-triangle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Ajouter avant la liste de fichiers
        const fileList = document.getElementById('fileList');
        fileList.parentNode.insertBefore(alertDiv, fileList);
        
        // Supprimer automatiquement après 5 secondes
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
    
    // Intercepter la soumission du formulaire pour ajouter les fichiers
    document.getElementById('projetForm').addEventListener('submit', function(e) {
        // Vérifier que tous les noms de fichiers sont remplis
        const nameInputs = document.querySelectorAll('.file-name-input');
        let allValid = true;
        
        nameInputs.forEach(input => {
            if (!input.value.trim()) {
                allValid = false;
                input.classList.add('is-invalid');
                
                // Ajouter un message d'erreur
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Le nom du fichier est requis';
                    input.parentNode.appendChild(errorDiv);
                }
            } else {
                input.classList.remove('is-invalid');
                const errorDiv = input.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        });
        
        if (!allValid) {
            e.preventDefault();
            showError('Veuillez remplir le nom descriptif pour tous les fichiers.');
            return;
        }
        
        // NOTE: Dans cette solution, on ne peut pas envoyer les fichiers dynamiquement
        // avec un formulaire HTML standard. Il faudrait utiliser AJAX/FormData.
        // Pour l'instant, on va seulement valider les champs textuels.
        // Les fichiers seront envoyés via un formulaire séparé ou via AJAX.
        
        console.log('Formulaire validé, prêt pour l\'envoi AJAX');
        // Pour l'instant, on laisse le formulaire se soumettre normalement
        // Les fichiers ne seront PAS envoyés avec cette méthode
    });
    </script>
</body>
</html>