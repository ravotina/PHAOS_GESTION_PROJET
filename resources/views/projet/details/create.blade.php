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
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                <i class="fas fa-plus-circle me-2"></i>
                Ajouter un détail - {{ $projet->non_de_projet }}
              </h4>
            </div>
            <div class="card-body p-4">
              <form action="{{ route('projet.details.store', $projet->id) }}" method="POST" enctype="multipart/form-data" id="detailForm">
                @csrf

                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="nom" class="form-label required">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                           id="nom" name="nom" value="{{ old('nom') }}" required maxlength="50"
                           placeholder="Ex: Cahier des charges">
                    @error('nom')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4"
                              placeholder="Décrivez ce détail...">{{ old('description') }}</textarea>
                    @error('description')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="file" class="form-label">Fichier</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" 
                           id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
                    <div class="form-text text-muted">
                      <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Formats acceptés: PDF, Word, Excel, Images (max: 2MB)
                      </small>
                    </div>
                    @error('file')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-between mt-4">
                  <a href="{{ route('projet.details.index', $projet->id) }}" class="btn" style="background: #f8f9fa; color: #2c3e50; border: 1px solid #dee2e6; padding: 8px 16px; font-weight: 500;">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                  </a>
                  <button type="submit" class="btn" style="background: linear-gradient(135deg, #000, #b15d15); color: white; border: none; padding: 8px 20px; font-weight: 600;">
                    <i class="fas fa-save me-2"></i>Ajouter le détail
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