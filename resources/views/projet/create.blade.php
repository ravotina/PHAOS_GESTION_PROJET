
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Cabinet PHAOS</title>
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
            <!-- @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
        @endif
        -->

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
            <div class="card shadow interne">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Créer un Nouveau Projet
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('projets.store') }}" method="POST" id="projetForm" class="interne">
                        @csrf

                        <!-- Informations de base -->
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="non_de_projet" class="form-label required">Nom du projet</label>

                                <input type="text" class="form-control @error('non_de_projet') is-invalid @enderror interne-input" 
                                       id="non_de_projet" name="non_de_projet" 
                                       value="{{ old('non_de_projet') }}" required
                                       placeholder="">
                                @error('non_de_projet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_type_projet" class="form-label required">Type de projet</label>
                                <select class="form-select @error('id_type_projet') is-invalid @enderror interne-input" 
                                        id="id_type_projet" name="id_type_projet" required>
                                    <option value="">Sélectionnez un type de projet...</option>
                                    @foreach($typesProjet as $type)
                                        <option value="{{ $type->id }}"
                                                {{ old('id_type_projet') == $type->id ? 'selected' : '' }}>
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
                                <label for="id_utilisateur_chef_de_projet" class="form-label required">Responsable</label>
                                <select class="form-select interne-input interne-input" id="id_utilisateur_chef_de_projet" name="id_utilisateur_chef_de_projet" required>
                                    <option value="">Sélectionnez un responsable...</option>
                                    @if(!empty($utilisateurs['formatted']['users']))
                                        @foreach($utilisateurs['formatted']['users'] as $utilisateur)
                                            <option value="{{ $utilisateur['id'] ?? $utilisateur['rowid'] ?? 'N/A' }}">
                                                {{ $utilisateur['firstname'] ?? '' }} {{ $utilisateur['lastname'] ?? '' }} 
                                                @if($utilisateur['login'] ?? false)
                                                    ({{ $utilisateur['login'] }})
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_type_intervention" class="form-label required">Type d'intervention</label>
                                <select class="form-select @error('id_type_intervention') is-invalid @enderror interne-input" 
                                        id="id_type_intervention" name="id_type_intervention" required>
                                    <option value="">Sélectionnez un type d' intervention...</option>
                                    @foreach($typesIntervention as $type)
                                        <option value="{{ $type->id }}"
                                                {{ old('id_type_intervention') == $type->id ? 'selected' : '' }}>
                                            {{ $type->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_type_intervention')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                   
                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="id_client" class="form-label required">Client</label>
                                <select class="form-select @error('id_client') is-invalid @enderror interne-input" 
                                        id="id_client" name="id_client" required>
                                    <option value="">Sélectionnez un client...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client['id'] }}" 
                                                {{ old('id_client') == $client['id'] ? 'selected' : '' }}>
                                            {{ $client['name'] }} ({{ $client['name_alias'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_client')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="id_categorie" class="form-label required">Catégorie</label>
                                <select class="form-select @error('id_categorie') is-invalid @enderror interne-input" 
                                        id="id_categorie" name="id_categorie" required>
                                    <option value="">Sélectionnez une catégorie...</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                                {{ old('id_categorie') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- Dates et délais -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_debu" class="form-label">Date de début</label>
                                <input type="date" class="form-control @error('date_debu') is-invalid @enderror interne-input" 
                                       id="date_debu" name="date_debu" 
                                       value="{{ old('date_debu') }}">
                                @error('date_debu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" class="form-control @error('date_fin') is-invalid @enderror interne-input" 
                                       id="date_fin" name="date_fin" 
                                       value="{{ old('date_fin') }}">
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror interne-input" 
                                      id="description" name="description" 
                                      rows="5" placeholder="Décrivez les objectifs, fonctionnalités, contraintes...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('projets.index') }}" class="btn btn-perso">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-perso" >
                                <i class="fas fa-save me-2"></i>Créer le projet
                            </button>
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

  <!-- Template Main JS File -->
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
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les erreurs et le message de succès depuis Blade en JSON
        const bladeErrors = @json($errors->all());
        const bladeSuccess = @json(session('success'));

        // Vérifier s'il y a des erreurs à afficher
        if (Array.isArray(bladeErrors) && bladeErrors.length) {
            showAlert('error', bladeErrors);
        }

        // Vérifier s'il y a un message de succès
        if (bladeSuccess) {
            showAlert('success', [bladeSuccess]);
        }

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
