<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Préparer une Tâche - Cabinet PHAOS</title>
    
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

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    

</head>
<body>
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">
                                <i class="bi bi-list-check me-2"></i>Préparer la Tâche
                            </h4>
                        </div>
                        
                        <div class="card-body">
                            <form id="preparationForm">
                                @csrf
                                
                                <input type="hidden" name="notification_id" value="{{ $notificationId ?? '' }}">
                                
                                @if(isset($preSelectedData) && !empty($preSelectedData))
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Cette préparation est liée à la tâche : <strong>{{ $preSelectedData['titre'] ?? '' }}</strong>
                                </div>
                                @endif
                                
                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label required">Description de la préparation</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="5" required placeholder="Décrivez comment vous allez préparer cette tâche..."></textarea>
                                </div>
                                
                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="daty" class="form-label required">Date de préparation</label>
                                    <input type="date" class="form-control" id="daty" name="daty" 
                                           value="{{ date('Y-m-d') }}" required>
                                </div>
                                
                                <!-- Tâche à faire -->
                                <div class="mb-3">
                                    <label for="id_a_faire" class="form-label required">Type de tâche à faire</label>
                                    <select class="form-select" id="id_a_faire" name="id_a_faire" required>
                                        <option value="">Sélectionnez une tâche...</option>
                                        @foreach($aFaireList as $aFaire)
                                            <option value="{{ $aFaire->id }}">{{ $aFaire->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Utilisateur concerné (pré-rempli si disponible) -->
                           
                                
                                <input type="hidden" name="id_utilisateur_concerner" value="{{ $tacheConcernerId }}">
                                
                                <!-- Boutons -->
                                <div class="mt-4 text-center">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i> Annuler
                                    </a>
                                    <button type="submit" class="btn btn-primary ms-2">
                                        <i class="bi bi-save me-1"></i> Enregistrer la préparation
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

        <!-- FullCalendar JS -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>
    
    <script>
    // Soumission du formulaire
    document.getElementById('preparationForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // ⭐⭐ DEBUG : Afficher les données du formulaire ⭐⭐
        console.log('Données du formulaire:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';
        
        fetch('{{ route("preparations.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Status:', response.status);
            console.log('Headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Réponse:', data);
            
            if (data.success) {
                alert('Préparation créée avec succès !');
                window.location.href = `/preparations/${data.preparation_id}`;
            } else {
                let errorMessage = 'Erreur: ' + (data.message || 'Veuillez vérifier les informations');
                
                if (data.errors) {
                    console.error('Erreurs de validation:', data.errors);
                    errorMessage += '\n\n';
                    for (const field in data.errors) {
                        errorMessage += `• ${field}: ${data.errors[field].join(', ')}\n`;
                    }
                }
                
                alert(errorMessage);
            }
        })
        .catch(error => {
            console.error('Erreur complète:', error);
            alert('Erreur lors de l\'enregistrement: ' + error.message);
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    </script>


</body>
</html>