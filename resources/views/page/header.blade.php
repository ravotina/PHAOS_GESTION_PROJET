<!-- ======= Header ======= -->

 <style>
    :root {
        /* Variables CSS dynamiques basées sur le thème */
        --couleur_header: {{ $themeCss['--header-color'] ?? '#b15d15' }};
        --couleur_footer: {{ $themeCss['--footer-color'] ?? '#343a40' }};
        --couleur_sidebar: {{ $themeCss['--sidebar-color'] ?? '#fcfbfa' }};
        --couleur_main: {{ $themeCss['--main-color'] ?? '#eff6f2' }};
        --couleur_section: {{ $themeCss['--section-color'] ?? '#ffffff' }};
        --primary-color: {{ $themeCss['--primary-color'] ?? '#b15d15' }};
        --secondary-color: {{ $themeCss['--secondary-color'] ?? '#000000' }};
        --primary-dark: {{ $themeCss['--primary-dark'] ?? '#8a4710' }};
        --primary-light: {{ $themeCss['--primary-light'] ?? 'rgba(177, 93, 21, 0.1)' }};
        --primary-gradient: {{ $themeCss['--primary-gradient'] ?? 'linear-gradient(135deg, #000, #b15d15)' }};
    }

      .main {
        background-color:  var(--couleur_main);
       }

      .section_personaliser {
        background-color: var(--couleur_section);
      }

      .interne {
        background-color: #ffffff1c;
      }

      .btn-perso {
        background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; font-weight: 600;
      }

      .interne-input {
            background-color: #087b8a0b;
       }

        .interne-input:hover {
            border-color: #ffffff37;
            background: #ffffff28;
        }
        
        .interne-input:focus {
            border-color: var(--input-focus-color);
            box-shadow: 0 0 0 3px rgba(177, 93, 21, 0.15);
            background: #ffffff2e;
            outline: none;
        }


        .fc-toolbar {
             background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; font-weight: 600;
        }

        .fc-button-primary {
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }

        .fc-col-header-cell {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; font-weight: 600;
        }

        
        /* .fc-scrollgrid {
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        } */

        .fc-scroller {
            background: var(--couleur_section) 
        }



        
        /* .fc-scroller-liquid-absolute {
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        } */
        
        

        /* 
        .fc-scrollgrid-section {
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }
        .fc-scrollgrid-section-body {
             background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }
        .fc-scrollgrid-section-liquid {
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }
        .fc-daygrid-body {
             background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }
        .fc-daygrid-body-unbalanced{
             background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }
        .fc-scroller-harness {
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        }
        .fc-scroller-harness-liquid{
            background:  linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; border: none; padding: 8px 20px; border-color: #ffffff;
        } */


    
    /* Thème actuel : {{ $currentTheme->nom ?? 'Default' }} */
 </style>


  <header id="header" class="header fixed-top d-flex align-items-center" style="background-color: var(--couleur_header);">

     <div class="d-flex align-items-center justify-content-between"> <!-- -->
        <a href="index.html" class="d-flex align-items-center"><!--logo --> 
            <img src="{{ asset('assets/img/logo-phaos.webp') }}" alt="Logo Cabinet PHAOS" style="height: 60px; width: auto; margin-right: 60px; margin-left: 40px;">
        </a>
       
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

        <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" onclick="loadNotifications()">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number" id="navbar-notification-badge">0</span>
        </a>  -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
              <span id="notification-count-text">Chargement...</span>
              <a href="#" onclick="markAllAsRead(event)">
                  <span class="badge rounded-pill bg-primary p-2 ms-2">Tout marquer lu</span>
              </a>
          </li>
          <li>
              <hr class="dropdown-divider">
          </li>

          <div class="container py-4">
              <div class="notifications-container">
                  <!-- Corps avec zone de scroll -->
                  <div class="notifications-body">
                      <div class="notifications-scroll" id="notifications-content">
                          <!-- Contenu chargé dynamiquement -->
                          <div class="text-center p-4">
                              <div class="spinner-border text-primary" role="status">
                                  <span class="visually-hidden">Chargement...</span>
                              </div>
                              <p class="mt-2">Chargement des notifications...</p>
                          </div>
                      </div>
                  </div>

                  <!-- Actions du pied de page -->
                  <div class="footer-actions">
                      <button class="btn btn-outline-secondary" onclick="loadNotifications()">
                          <i class="bi bi-arrow-clockwise me-2"></i>Actualiser
                      </button>
                  </div>
              </div>
          </div>
      </ul>

      <!-- Template pour une période (Aujourd'hui, Hier, etc.) -->
      <template id="period-template">
          <div class="period-section">
              <h6 class="period-title">{title}</h6>
              {notifications}
          </div>
      </template>

      <!-- Template pour une notification -->
      <template id="notification-template">
          <div class="notification-item {unread_class}">
              <i class="bi {icon} notification-icon {icon_class}"></i>
              <div class="notification-content">
                  <div class="notification-text">
                      <strong>{title}</strong><br>
                      {message}
                  </div>
                  <div class="notification-time">{time}</div>
              </div>
              <div class="notification-actions">
                  <a href="/taches/{id}" class="btn btn-sm btn-outline-primary">Voir</a>
                  <button class="btn-mark-read" title="Marquer comme lu" onclick="markAsRead({id}, event)">
                      <i class="bi bi-check"></i>
                  </button>
              </div>
          </div>
      </template>

      <script>
      // Charger les notifications quand le dropdown s'ouvre
      function loadNotifications(event = null) {
          if (event) event.preventDefault();
          
          console.log('Chargement des notifications...');
          
          // Afficher le spinner
          const content = document.getElementById('notifications-content');
          if (content) {
              content.innerHTML = `
                  <div class="text-center p-4">
                      <div class="spinner-border text-primary" role="status">
                          <span class="visually-hidden">Chargement...</span>
                      </div>
                      <p class="mt-2">Chargement des notifications...</p>
                  </div>
              `;
          }
          
          // Charger les données
          fetch('/notifications')
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Erreur HTTP: ' + response.status);
                  }
                  return response.json();
              })
              .then(data => {
                  console.log('Données reçues:', data);
                  displayNotifications(data.notifications);
                  updateNotificationBadge(data.unread_count, data.total_count);
                  updateNotificationCountText(data.unread_count, data.total_count);
              })
              .catch(error => {
                  console.error('Erreur:', error);
                  showErrorMessage();
              });
      }

      // Afficher les notifications
      function displayNotifications(groups) {
          const content = document.getElementById('notifications-content');
          const periodTemplate = document.getElementById('period-template').innerHTML;
          const notificationTemplate = document.getElementById('notification-template').innerHTML;
          
          content.innerHTML = '';
          
          // Si pas de notifications
          if (!groups || Object.keys(groups).length === 0) {
              content.innerHTML = `
                  <div class="text-center p-5">
                      <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                      <p class="mt-2 text-muted">Aucune notification</p>
                  </div>
              `;
              return;
          }
          
          // Afficher chaque période
          for (const [periodKey, periodData] of Object.entries(groups)) {
              if (periodData.notifications.length === 0) continue;
              
              let notificationsHtml = '';
              
              // Générer le HTML pour chaque notification de cette période
              periodData.notifications.forEach(notification => {
                  const unreadClass = notification.is_unread ? 'unread' : '';
                  const iconClass = getIconClass(notification.icon);
                  const actionUrl = notification.action_url || '#';
                  
                  const notificationHtml = notificationTemplate
                      .replace(/{id}/g, notification.id)
                      .replace(/{icon}/g, notification.icon)
                      .replace(/{icon_class}/g, iconClass)
                      .replace(/{title}/g, escapeHtml(notification.title))
                      .replace(/{message}/g, escapeHtml(notification.message))
                      .replace(/{time}/g, notification.time)
                      .replace(/{action_url}/g, actionUrl)
                      .replace(/{unread_class}/g, unreadClass);
                  
                  notificationsHtml += notificationHtml;
              });
              
              // Générer le HTML pour la période
              const periodHtml = periodTemplate
                  .replace('{title}', periodData.title)
                  .replace('{notifications}', notificationsHtml);
              
              content.innerHTML += periodHtml;
          }
      }

      // Obtenir la classe CSS pour l'icône
      function getIconClass(iconName) {
          const iconMap = {
              'bi-calendar-event': 'icon-calendar',
              'bi-calendar-check': 'icon-validated',
              'bi-check-circle': 'icon-validated',
              'bi-exclamation-circle': 'icon-modification',
              'bi-arrow-clockwise': 'icon-pending',
              'bi-clock': 'icon-delayed',
              'bi-x-circle': 'icon-rejected',
              'bi-currency-euro': 'icon-finance',
              'bi-person-check': 'icon-user',
              'bi-graph-up': 'icon-validated'
          };
          
          return iconMap[iconName] || 'icon-default';
      }

      // Mettre à jour le badge
      function updateNotificationBadge(unreadCount, totalCount) {
          const badge = document.getElementById('navbar-notification-badge');
          if (badge) {
              badge.textContent = unreadCount > 0 ? unreadCount : totalCount;
          }
      }

      // Mettre à jour le texte du compteur
      function updateNotificationCountText(unreadCount, totalCount) {
          const countText = document.getElementById('notification-count-text');
          if (countText) {
              if (unreadCount > 0) {
                  countText.textContent = `Vous avez ${unreadCount} nouvelle(s) notification(s)`;
              } else {
                  countText.textContent = `Vous avez ${totalCount} notification(s)`;
              }
          }
      }

      // Marquer une notification comme lue
      function markAsRead(notificationId, event = null) {
          if (event) {
              event.preventDefault();
              event.stopPropagation();
          }
          
          fetch(`/notifications/${notificationId}/read`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': getCsrfToken()
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  // Retirer la classe "unread"
                  const notificationItem = document.querySelector(`[onclick*="${notificationId}"]`)?.closest('.notification-item');
                  if (notificationItem) {
                      notificationItem.classList.remove('unread');
                  }
                  
                  // Recharger les compteurs
                  loadNotificationCount();
              }
          })
          .catch(error => {
              console.error('Erreur:', error);
          });
      }

      // Marquer toutes comme lues
      function markAllAsRead(event = null) {
          if (event) {
              event.preventDefault();
              event.stopPropagation();
          }
          
          fetch('/notifications/read-all', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': getCsrfToken()
              }
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  // Recharger les notifications
                  loadNotifications();
              }
          })
          .catch(error => {
              console.error('Erreur:', error);
          });
      }

      // Charger seulement le compteur
      function loadNotificationCount() {
          fetch('/notifications/count')
              .then(response => response.json())
              .then(data => {
                  updateNotificationBadge(data.unread_count, data.total_count);
              })
              .catch(error => {
                  console.error('Erreur:', error);
              });
      }

      // Afficher message d'erreur
      function showErrorMessage() {
          const content = document.getElementById('notifications-content');
          if (content) {
              content.innerHTML = `
                  <div class="text-center p-4">
                      <i class="bi bi-exclamation-triangle text-danger"></i>
                      <p class="mt-2 text-danger">Erreur de chargement</p>
                      <button onclick="loadNotifications(event)" class="btn btn-sm btn-outline-primary">
                          Réessayer
                      </button>
                  </div>
              `;
          }
      }

      // Récupérer token CSRF
      function getCsrfToken() {
          return document.querySelector('meta[name="csrf-token"]')?.content || '';
      }

      // Échapper HTML
      function escapeHtml(text) {
          const div = document.createElement('div');
          div.textContent = text;
          return div.innerHTML;
      }

      // Charger le compteur au démarrage
      document.addEventListener('DOMContentLoaded', function() {
          loadNotificationCount();
      });
      </script>

      </li>

        <!-- Profile Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!-- Photo de profil -->
              @if(Session::get('user.photo'))
                  <img src="{{ Session::get('user.photo') }}" alt="Profile" class="rounded-circle">
              @else
                  <img src="" alt="Profile" class="rounded-circle">  <!-- assets/img/profile-img.jpg -->
              @endif
              <span class="d-none d-md-block dropdown-toggle ps-2">
                  {{ Session::get('user.firstname', Session::get('user.login', 'Utilisateur')) }}
              </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
             <!-- Nom complet -->
                <h6>{{ Session::get('user.full_name', Session::get('user.login', 'Utilisateur')) }}</h6>
                <!-- Rôle/Métier -->
                <span>{{ Session::get('user.role', 'Commercial') }}</span>
            </li>

            <!-- <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Mon Profile</span>
              </a>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('/logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
              </a>
            </li>

          </ul>
        </li>

      </ul>
    </nav>

  </header>