<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Modifier Projet - Cabinet PHAOS</title>
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
    /* ============ STYLES POUR LA SUPPRESSION ============ */

    /* Style du bouton de suppression */
    .btn-outline-danger.delete-btn {
        border-color: #dc3545;
        color: #dc3545;
        transition: all 0.3s ease;
        padding: 5px 10px;
        font-size: 0.875rem;
    }

    .btn-outline-danger.delete-btn:hover {
        background-color: #dc3545;
        color: white;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-danger.delete-btn:active {
        transform: scale(0.98);
    }

    /* Style de l'icône dans le bouton */
    .btn-outline-danger.delete-btn i {
        font-size: 1rem;
    }

    /* Tooltip personnalisé pour les boutons d'action */
    .btn-outline-danger.delete-btn[data-bs-toggle="tooltip"] {
        position: relative;
    }

    /* Override du style Bootstrap pour les tooltips */
    .tooltip-inner {
        background-color: #333;
        color: white;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 0.8rem;
    }

    .tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #333;
    }

    /* Animation pour le bouton de suppression */
    @keyframes pulse-danger {
        0% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
        }
        70% {
            box-shadow: 0 0 0 6px rgba(220, 53, 69, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }

    .btn-outline-danger.delete-btn:hover {
        animation: pulse-danger 1.5s infinite;
    }

    /* Style pour la boîte de dialogue de confirmation */
    /* Note: Vous ne pouvez pas styliser directement window.confirm() */
    /* Mais vous pouvez la remplacer par une modale personnalisée */

    /* ============ MODALE DE CONFIRMATION PERSONNALISÉE ============ */
    .custom-confirm-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .custom-confirm-modal.active {
        opacity: 1;
        visibility: visible;
    }

    .custom-confirm-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        transform: translateY(-20px);
        transition: transform 0.3s ease;
    }

    .custom-confirm-modal.active .custom-confirm-content {
        transform: translateY(0);
    }

    .custom-confirm-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        color: #dc3545;
    }

    .custom-confirm-header i {
        font-size: 24px;
        margin-right: 10px;
    }

    .custom-confirm-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }

    .custom-confirm-body {
        margin-bottom: 25px;
        color: #555;
        line-height: 1.5;
        font-size: 0.95rem;
    }

    .custom-confirm-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .custom-confirm-btn {
        padding: 8px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .custom-confirm-btn.cancel {
        background-color: #6c757d;
        color: white;
    }

    .custom-confirm-btn.cancel:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    .custom-confirm-btn.delete {
        background-color: #dc3545;
        color: white;
    }

    .custom-confirm-btn.delete:hover {
        background-color: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    /* ============ RESPONSIVE ============ */
    @media (max-width: 576px) {
        .custom-confirm-content {
            width: 95%;
            padding: 20px;
        }
        
        .custom-confirm-footer {
            flex-direction: column;
        }
        
        .custom-confirm-btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }

    /* ============ INTÉGRATION AVEC VOTRE THÈME EXISTANT ============ */
    /* Vous pouvez ajouter ces classes à votre bouton existant */
    .btn-outline-danger {
        position: relative;
        overflow: hidden;
    }

    .btn-outline-danger::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }

    .btn-outline-danger:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
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
    <div class="row justify-content-center">

    <!-- Alertes -->
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
    
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #000, #b15d15);">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Modifier le Projet
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('projets.update', $projet->id) }}" method="POST" id="projetForm">
                        @csrf
                        @method('PUT')

                        <!-- Informations de base -->
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="non_de_projet" class="form-label required">Nom du projet</label>
                                <input type="text" class="form-control @error('non_de_projet') is-invalid @enderror" 
                                       id="non_de_projet" name="non_de_projet" 
                                       value="{{ old('non_de_projet', $projet->non_de_projet) }}" required
                                       placeholder="Ex: Audit metrogride Ambatofinandrahana">
                                @error('non_de_projet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_type_projet" class="form-label required">Type de projet</label>
                                <select class="form-select @error('id_type_projet') is-invalid @enderror" 
                                        id="id_type_projet" name="id_type_projet" required>
                                    <option value="">Sélectionnez un type de projet...</option>
                                    @foreach($typesProjet as $type)
                                        <option value="{{ $type->id }}"
                                                {{ (old('id_type_projet', $projet->id_type_projet) == $type->id) ? 'selected' : '' }}>
                                            {{ $type->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_type_projet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_type_intervention" class="form-label required">Type d'intervention</label>
                                <select class="form-select @error('id_type_intervention') is-invalid @enderror" 
                                        id="id_type_intervention" name="id_type_intervention" required>
                                    <option value="">Sélectionnez un type...</option>
                                    @foreach($typesIntervention as $type)
                                        <option value="{{ $type->id }}"
                                                {{ (old('id_type_intervention', $projet->id_type_intervention) == $type->id) ? 'selected' : '' }}>
                                            {{ $type->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_type_intervention')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_categorie" class="form-label required">Catégorie</label>
                                <select class="form-select @error('id_categorie') is-invalid @enderror" 
                                        id="id_categorie" name="id_categorie" required>
                                    <option value="">Sélectionnez une catégorie...</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                                {{ (old('id_categorie', $projet->id_categorie) == $categorie->id) ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_client" class="form-label required">Client</label>
                                <select class="form-select @error('id_client') is-invalid @enderror" 
                                        id="id_client" name="id_client" required>
                                    <option value="">Sélectionnez un client...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client['id'] }}" 
                                                {{ (old('id_client', $projet->id_client) == $client['id']) ? 'selected' : '' }}>
                                            {{ $client['name'] }} ({{ $client['code_client'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_client')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_utilisateur" class="form-label required">Responsable</label>
                                <select class="form-select @error('id_utilisateur') is-invalid @enderror" 
                                        id="id_utilisateur" name="id_utilisateur" required>
                                    <option value="">Sélectionnez un responsable...</option>
                                    @if(!empty($utilisateurs['formatted']['users']))
                                        @foreach($utilisateurs['formatted']['users'] as $utilisateur)
                                            @php
                                                $userId = $utilisateur['id'] ?? $utilisateur['rowid'] ?? 'N/A';
                                                $selected = (old('id_utilisateur', $projet->id_utilisateur) == $userId) ? 'selected' : '';
                                            @endphp
                                            <option value="{{ $userId }}" {{ $selected }}>
                                                {{ $utilisateur['firstname'] ?? '' }} {{ $utilisateur['lastname'] ?? '' }} 
                                                @if($utilisateur['login'] ?? false)
                                                    ({{ $utilisateur['login'] }})
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('id_utilisateur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Dates et délais -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date_debu" class="form-label">Date de début</label>
                                <input type="date" class="form-control @error('date_debu') is-invalid @enderror" 
                                       id="date_debu" name="date_debu" 
                                       value="{{ old('date_debu', $projet->date_debu ? \Carbon\Carbon::parse($projet->date_debu)->format('Y-m-d') : '') }}">
                                @error('date_debu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" name="date_fin" 
                                       value="{{ old('date_fin', $projet->date_fin ? \Carbon\Carbon::parse($projet->date_fin)->format('Y-m-d') : '') }}">
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="dedlinne" class="form-label">Délai (jours)</label>
                                <input type="number" class="form-control @error('dedlinne') is-invalid @enderror" 
                                       id="dedlinne" name="dedlinne" 
                                       value="{{ old('dedlinne', $projet->dedlinne) }}" min="0"
                                       placeholder="Ex: 30">
                                @error('dedlinne')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" 
                                      rows="5" placeholder="Décrivez les objectifs, fonctionnalités, contraintes...">{{ old('description', $projet->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statut (optionnel, si vous voulez le garder) -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status">
                                <option value="">Sélectionnez un statut (optionnel)...</option>
                                <option value="brouillon" {{ (old('status', $projet->status) == 'brouillon') ? 'selected' : '' }}>Brouillon</option>
                                <option value="en_attente" {{ (old('status', $projet->status) == 'en_attente') ? 'selected' : '' }}>En attente</option>
                                <option value="en_cours" {{ (old('status', $projet->status) == 'en_cours') ? 'selected' : '' }}>En cours</option>
                                <option value="termine" {{ (old('status', $projet->status) == 'termine') ? 'selected' : '' }}>Terminé</option>
                                <option value="annule" {{ (old('status', $projet->status) == 'annule') ? 'selected' : '' }}>Annulé</option>
                                <option value="suspendu" {{ (old('status', $projet->status) == 'suspendu') ? 'selected' : '' }}>Suspendu</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('projets.index') }}" class="btn" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #dee2e6; padding: 8px 16px; font-weight: 500;">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <div>
                                <button type="submit" class="btn me-2" style="background: linear-gradient(135deg, #000, #b15d15); color: white; border: none; padding: 8px 20px; font-weight: 600;">
                                    <i class="fas fa-save me-2"></i>Mettre à jour
                                </button>
                                <a href="{{ route('projets.show', $projet->id) }}" class="btn" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #dee2e6; padding: 8px 16px; font-weight: 500;">
                                    <i class="fas fa-eye me-2"></i>Voir
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
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

  <!-- Template Main CSS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

<script>
    // Validation des dates
    document.addEventListener('DOMContentLoaded', function() {
        const dateDebut = document.getElementById('date_debu');
        const dateFin = document.getElementById('date_fin');
        
        if (dateDebut && dateFin) {
            dateDebut.addEventListener('change', function() {
                if (this.value && dateFin.value && new Date(this.value) > new Date(dateFin.value)) {
                    alert('La date de fin doit être postérieure à la date de début');
                    this.value = '';
                }
            });
            
            dateFin.addEventListener('change', function() {
                if (this.value && dateDebut.value && new Date(this.value) < new Date(dateDebut.value)) {
                    alert('La date de fin doit être postérieure à la date de début');
                    this.value = '';
                }
            });
        }
        
        // Définir les dates minimales
        const today = new Date().toISOString().split('T')[0];
        if (dateDebut) dateDebut.min = today;
        if (dateFin) dateFin.min = today;
    });
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
    });
</script>

</body>

</html>