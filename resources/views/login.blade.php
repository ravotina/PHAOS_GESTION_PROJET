<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login Phaos</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- ======= Header ======= -->

  <!-- Favicons -->
  <link href="assets/img/logo-phaos.webp" rel="icon">
  <link href="assets/img/logo-phaos.webp" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

   <style>
    :root {
        /* Variables CSS dynamiques basées sur le thème */
        --primary-color: {{ $themeCss['--primary-color'] ?? '#b15d15' }};
        --primary-dark: {{ $themeCss['--primary-dark'] ?? '#8a4710' }};
        --primary-light: {{ $themeCss['--primary-light'] ?? 'rgba(177, 93, 21, 0.1)' }};
        --secondary-color: {{ $themeCss['--secondary-color'] ?? '#000000' }};
        --primary-gradient: {{ $themeCss['--primary-gradient'] ?? 'linear-gradient(135deg, #000, #b15d15)' }};
    }
    
    /* Thème actuel : {{ $currentTheme->nom ?? 'Default' }} */
 </style>
</head>

<body>
  <main>
            
  <div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="text-center mb-4">
              <img src="assets/img/logo-phaos.webp" alt="Cabinet PHAOS" style="height: 100px;">
            </div>

            <div class="card mb-3" style="border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">

              <div class="card-body">

                @if (session('success'))
                    <div id="successAlert" class="alert alert-success" style="display: none;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="pt-4 pb-2">
                  <p class="text-center small" style="color: #7f8c8d; font-style: italic; font-size: 1.1rem;">
                    Thème Phaos
                  </p>
                </div>

                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ url('/login') }}" id="loginForm">
                @csrf
                  <div class="col-12">
                    <label for="yourUsername" class="form-label" style="font-weight: 500;">Nom d’utilisateur</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend" style="background: #f8f9fa;">
                        <i class="bi bi-person"></i>
                      </span>
                      <input type="text" name="login" value="{{ old('login') }}"  class="form-control" id="yourUsername" placeholder="" required>
                      <div class="invalid-feedback">Veuillez saisir votre identifiant.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label" style="font-weight: 500;">Mot de passe</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" style="background: #f8f9fa;">
                        <i class="bi bi-lock"></i>
                      </span>
                      <input type="password" name="password" class="form-control" id="yourPassword" placeholder="" required>
                      <div class="invalid-feedback">Veuillez saisir votre mot de passe.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <button class="btn w-100" type="submit" style="background: linear-gradient(135deg, #000, #b15d15); color: white; border: none; padding: 12px; font-weight: 600;">
                      Se connecter
                    </button>
                  </div>

                </form>

              </div>
            </div>

              <div class="credits">
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifier s'il y a des erreurs à afficher
        @if ($errors->any())
            // Créer un élément d'alerte stylisé
            const errorContainer = document.createElement('div');
            errorContainer.className = 'error-toast';
            errorContainer.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: #f8d7da;
                color: #721c24;
                padding: 15px 20px;
                border-radius: 8px;
                border: 1px solid #f5c6cb;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                z-index: 9999;
                max-width: 400px;
                width: 90%;
                animation: fadeInDown 0.3s ease;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            `;
            
            // Créer le contenu de l'erreur
            let errorContent = '<div style="font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; justify-content: center;">';
            errorContent += '<i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px; color: #dc3545;"></i>';
            errorContent += 'Erreur de connexion';
            errorContent += '</div>';
            errorContent += '<div style="font-size: 0.9em; line-height: 1.4;">';
            
            @foreach ($errors->all() as $error)
                errorContent += '<div style="margin: 5px 0; padding-left: 5px; border-left: 3px solid #dc3545; text-align: center;">';
                errorContent += '• {{ $error }}';
                errorContent += '</div>';
            @endforeach
            
            errorContent += '</div>';
            
            // Ajouter le bouton de fermeture
            errorContent += '<button id="closeError" style="position: absolute; top: 10px; right: 10px; background: none; border: none; color: #721c24; cursor: pointer; font-size: 18px;">&times;</button>';
            
            errorContainer.innerHTML = errorContent;
            
            // Ajouter au body
            document.body.appendChild(errorContainer);
            
            // Ajouter l'animation CSS
            const style = document.createElement('style');
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
            
            // Gérer la fermeture
            document.getElementById('closeError').addEventListener('click', function() {
                errorContainer.style.animation = 'fadeOutUp 0.3s ease';
                setTimeout(() => {
                    if (errorContainer.parentNode) {
                        errorContainer.parentNode.removeChild(errorContainer);
                    }
                }, 300);
            });
            
            // Fermeture automatique après 8 secondes
            setTimeout(() => {
                if (errorContainer.parentNode) {
                    errorContainer.style.animation = 'fadeOutUp 0.3s ease';
                    setTimeout(() => {
                        if (errorContainer.parentNode) {
                            errorContainer.parentNode.removeChild(errorContainer);
                        }
                    }, 300);
                }
            }, 8000);
        @endif
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
                    title: 'Erreur de connexion',
                    icon: 'bi-exclamation-triangle-fill',
                    bgColor: '#f8d7da',
                    textColor: '#721c24',
                    borderColor: '#f5c6cb',
                    iconColor: '#dc3545'
                },
                success: {
                    title: 'Déconnexion réussie',
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
                alertContent += type === 'success' ? message : '• ' + message;
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
            
            // Fermeture automatique après 8 secondes pour les succès, 8 secondes pour les erreurs
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