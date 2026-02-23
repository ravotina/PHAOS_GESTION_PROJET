<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Calendrier de Préparation - Cabinet PHAOS</title>
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

  <!-- FullCalendar CSS -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

  <style>
    .calendar-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 20px;
        margin: 20px 0;
    }
    .fc-toolbar {
        background: linear-gradient(135deg, #343a40 0%, #6c757d 100%);
        color: white;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0 !important;
    }
    .fc-toolbar-title {
        color: white !important;
    }
    .fc-button {
        background-color: #6c757d !important;
        border-color: #6c757d !important;
    }
    .fc-button:hover {
        background-color: #5a6268 !important;
        border-color: #545b62 !important;
    }
    .event-modal .form-label {
        font-weight: 600;
        color: #495057;
    }
    .hidden-input {
        display: none;
    }


    /* STYLES CRITIQUES PLEINE LARGEUR */
    .fc-event {
        border: none !important;
        padding: 4px 6px !important;
        margin: 1px 2px !important;
        font-size: 0.85em !important;
        font-weight: 600 !important;
        border-radius: 4px !important;
    }

    .fc-daygrid-event {
        min-height: 20px !important;
        white-space: normal !important;
    }

    /* Couleur de secours */
    .fc-event[style*="background-color"] {
        opacity: 1 !important;
    }

    /* S'assurer que la cellule peut afficher l'événement */
    .fc-daygrid-day-frame {
        min-height: 60px !important;
    }

    /* Forcer la visibilité */
    .fc-event-main {
        color: white !important;
        font-weight: bold !important;
    }










    /* Menu contextuel pour événements */
.context-menu {
    position: absolute;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    z-index: 9999;
    min-width: 200px;
    display: none;
}

.context-menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.context-menu li {
    padding: 8px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s;
}

.context-menu li:hover {
    background-color: #f8f9fa;
}

.context-menu li:last-child {
    border-bottom: none;
}

.context-menu li i {
    margin-right: 8px;
    width: 20px;
    text-align: center;
}

.context-menu li.delete {
    color: #dc3545;
}

.context-menu li.delete:hover {
    background-color: #f8d7da;
}

/* Modal pour ajouter/modifier utilisateur */
.utilisateur-modal .form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 5px;
}

.utilisateur-modal select {
    height: 42px;
}

.utilisateur-modal .selected-users {
    margin-top: 15px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.utilisateur-modal .user-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 12px;
    margin-bottom: 5px;
    background: white;
    border-radius: 4px;
    border: 1px solid #dee2e6;
}

.utilisateur-modal .user-item:last-child {
    margin-bottom: 0;
}

.utilisateur-modal .user-actions button {
    padding: 2px 8px;
    font-size: 0.8em;
}



/* Ajoutez à votre section <style> existante */
.modal-body .user-task {
    background-color: #f8f9fa;
    border-left: 3px solid #007bff;
    padding: 10px;
    margin: 8px 0;
    border-radius: 4px;
}

.modal-body .user-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.modal-body .task-description {
    font-size: 0.9em;
    color: #495057;
    padding-left: 10px;
}

/* Style pour la modal de détails */
#detailsModal .modal-dialog {
    max-width: 550px;
}





  </style>
</head>

<body>

  <!-- ======= header ======= -->
  @include('page.header')

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')

  <main id="main" class="main">
    <div class="p-3">
        <div class="calendar-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Calendrier de Préparation - {{ $projet->non_de_projet }}</h4>
                <button type="button" class="btn btn-primary" onclick="ouvrirModalNouvelleTache()" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="bi bi-plus-circle"></i> Nouvelle tache
                </button>
            </div>

            <!-- Calendrier -->
            <div id="calendar"></div>

        </div>
    </div>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('page.footer')

  <!-- Modal pour ajouter un événement -->
  <div class="modal fade" id="addEventModal" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Nouvel Événement</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="eventForm">
                  @csrf

                  <input type="hidden" name="event_id" id="event_id_hidden" value="">

                  <div class="modal-body event-modal">
                      <div class="mb-3">
                          <label class="form-label">Titre *</label>
                          <input type="text" class="form-control" name="title" required>
                      </div>

                      <!-- Champ caché pour l'ID du projet -->
                      <input type="hidden" name="id_projet" value="{{ $projet->id }}">
                      
                      <!-- Dans votre modal, remplacez les inputs date par datetime-local -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date et heure début *</label>
                                    <input type="datetime-local" class="form-control" name="date_debut" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date et heure fin</label>
                                    <input type="datetime-local" class="form-control" name="date_fin">
                                </div>
                            </div>
                        </div>
                      
                      <div class="mb-3">
                          <label class="form-label">Description</label>
                          <textarea class="form-control" name="decription" rows="3"></textarea>
                      </div>
                      
                      <div class="mb-3">
                          <label class="form-label">Couleur</label>
                          <input type="color" class="form-control" name="color" value="#3788d8">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-primary" id="submitBtn">Enregistrer</button>
                  </div>
              </form>
          </div>
      </div>
  </div>




  
    <!-- Modal pour ajouter/modifier utilisateur -->
    <div class="modal fade" id="utilisateurModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="utilisateurModalTitle">Affecter des utilisateurs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="utilisateurForm">
                    @csrf
                    <input type="hidden" id="event_id" name="event_id">
                    <div class="modal-body utilisateur-modal">
                        <div class="mb-3">
                            <label class="form-label">Sélectionner un utilisateur</label>
                            <select class="form-control" id="utilisateur_select">
                                <option value="">Choisir un utilisateur...</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description de la tâche</label>
                            <textarea class="form-control" id="description_tache" rows="3" placeholder="Décrivez la tâche de cet utilisateur..."></textarea>
                        </div>
                        
                        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="ajouterUtilisateur()">
                            <i class="bi bi-plus-circle"></i> Ajouter
                        </button>
                        
                        <div class="selected-users" id="selectedUsersContainer">
                            <h6 class="mb-3">Utilisateurs affectés :</h6>
                            <div id="selectedUsersList"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-primary" onclick="sauvegarderUtilisateurs()">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Menu contextuel -->
    <div id="contextMenu" class="context-menu">
        <ul>
            <li onclick="modifierEvenement()">
                <i class="bi bi-pencil"></i> Modifier
            </li>

            <li onclick="affecterUtilisateurs()">
                <i class="bi bi-person-plus"></i> Affecter des utilisateurs
            </li>

            <li onclick="envoyerNotification()">
                <i class="bi bi-bell"></i> Notifier les utilisateurs
            </li>

            <li onclick="supprimerEvenement()" class="delete">
                <i class="bi bi-trash"></i> Supprimer
            </li>

        </ul>
    </div>

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
    let calendar;
    let currentEventId = null;
    let utilisateursDisponibles = [];

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var projetId = {{$projet->id}};
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour',
                list: 'Liste'
            },
            events: {
                url: '{{ route("calendrier.events") }}',
                extraParams: function() {
                    return {
                        projet_id: projetId
                    };
                }
            },
            eventDisplay: 'block',
            displayEventTime: false,
            allDaySlot: true,
            nowIndicator: true,
            editable: true,
            selectable: true,
            
            // GESTION DU CLIC DROIT SUR LES ÉVÉNEMENTS
            eventDidMount: function(info) {
                // Ajouter écouteur pour clic droit
                info.el.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    currentEventId = info.event.id;
                    
                    const contextMenu = document.getElementById('contextMenu');
                    contextMenu.style.display = 'block';
                    contextMenu.style.left = e.pageX + 'px';
                    contextMenu.style.top = e.pageY + 'px';
                    
                    return false;
                });
                
                info.el.setAttribute('data-event-id', info.event.id);
            },
            
            eventClick: function(info) {
                currentEventId = info.event.id;
                // Option: afficher infos au clic gauche
                //alert(`${info.event.title}\n${info.event.extendedProps.description || ''}`);

                 // Récupérer les détails de l'événement
                const event = info.event;
                const title = event.title;
                const description = event.extendedProps.description || 'Aucune description';
                const startDate = event.start ? event.start.toLocaleDateString('fr-FR', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : 'Non défini';
                
                const endDate = event.end ? event.end.toLocaleDateString('fr-FR', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : 'Non défini';
                
                // Charger les utilisateurs affectés à cette tâche
                chargerEtAfficherUtilisateursAffectes(currentEventId, title, description, startDate, endDate);
            }
        });


        calendar.render();
        
        // Cacher menu au clic ailleurs
        document.addEventListener('click', function(e) {
            const contextMenu = document.getElementById('contextMenu');
            if (contextMenu.style.display === 'block' && !contextMenu.contains(e.target)) {
                contextMenu.style.display = 'none';
            }
        });
        
        // Empêcher menu contextuel par défaut sur calendrier
        calendarEl.addEventListener('contextmenu', function(e) {
            if (!e.target.closest('.fc-event')) {
                e.preventDefault();
                return false;
            }
        });


        const eventForm = document.getElementById('eventForm');
        if (eventForm) {
            eventForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const eventIdInput = this.querySelector('input[name="event_id"]');

                // ⭐⭐ AJOUTEZ CET ALERT POUR VOIR ⭐⭐
                alert("event_id trouvé: " + (eventIdInput ? "OUI - valeur: " + eventIdInput.value : "NON"));
                
                if (eventIdInput && eventIdInput.value) {
                    modifierTache(this);
                } else {
                    creationtache(this);
                }
            });
            
            // Gestion de l'ouverture/fermeture du modal
            document.getElementById('addEventModal').addEventListener('show.bs.modal', function(e) {
                if (!currentEventId) {
                    viderFormulaireNouveau();
                }
            });
            
            document.getElementById('addEventModal').addEventListener('hidden.bs.modal', function() {
                currentEventId = null;
            });
        }

        // Charger les utilisateurs disponibles
        chargerUtilisateursDisponibles();

    });

    function modifierEvenement() {
        if (!currentEventId) return;
        
        const event = calendar.getEventById(currentEventId);
        if (!event) return;
        
        // Remplir formulaire
        document.querySelector('input[name="title"]').value = event.title;
        document.querySelector('textarea[name="decription"]').value = event.extendedProps.description || '';
        document.querySelector('input[name="color"]').value = event.backgroundColor || '#3788d8';
        
        const start = event.start ? event.start.toISOString().slice(0, 16) : '';
        const end = event.end ? event.end.toISOString().slice(0, 16) : '';
        
        document.querySelector('input[name="date_debut"]').value = start;
        document.querySelector('input[name="date_fin"]').value = end;
        
        // ⭐⭐ Mettre à jour le champ caché qui existe DÉJÀ ⭐⭐
        const eventIdInput = document.getElementById('event_id_hidden');
        if (eventIdInput) {
            eventIdInput.value = currentEventId;
            console.log("event_id mis à:", eventIdInput.value);
        } else {
            console.error("Champ event_id_hidden non trouvé!");
        }
        
        document.getElementById('submitBtn').innerHTML = 'Modifier';
        
        new bootstrap.Modal(document.getElementById('addEventModal')).show();
        document.getElementById('contextMenu').style.display = 'none';
    }


    function affecterUtilisateurs() {
        if (!currentEventId) return;
        
        // Remplir le champ caché avec l'ID de l'événement
        document.getElementById('event_id').value = currentEventId;
        
        // Charger les utilisateurs déjà affectés
        chargerUtilisateursAffectes(currentEventId);
        
        // Ouvrir le modal
        const modal = new bootstrap.Modal(document.getElementById('utilisateurModal'));
        modal.show();
        
        // Mettre à jour le titre
        document.getElementById('utilisateurModalTitle').textContent = 'Affecter des utilisateurs';
        
        // Cacher le menu contextuel
        document.getElementById('contextMenu').style.display = 'none';
    }



    function supprimerEvenement() {
        if (!currentEventId) return;
        
        if (confirm('Supprimer cet événement ?')) {
            fetch('{{ route("calendrier.destroy", "") }}/' + currentEventId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    calendar.refetchEvents();
                    alert('Événement supprimé');
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur suppression');
            });
        }
        document.getElementById('contextMenu').style.display = 'none';
    }

    // ⭐ AJOUTEZ CETTE FONCTION ⭐
    function ouvrirModalNouvelleTache() {
        currentEventId = null;
        viderFormulaireNouveau();
    }

    // FONCTION POUR VIDER LE FORMULAIRE POUR NOUVELLE TÂCHE
    function viderFormulaireNouveau() {
        const form = document.getElementById('eventForm');
        form.reset();
        document.querySelector('input[name="color"]').value = '#3788d8';
        
        // ⭐⭐ VIDER AUSSI LE CHAMP EVENT_ID ⭐⭐
        const eventIdInput = document.getElementById('event_id_hidden');
        if (eventIdInput) {
            eventIdInput.value = '';
        }
        
        document.getElementById('submitBtn').innerHTML = 'Enregistrer';

    }

    function creationtache(form) {
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBtn');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Création...';

        fetch('{{ route("calendrier.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
                //form.reset();
                viderFormulaireNouveau();
                alert('Événement créé avec succès!');
                
                // Supprimer champ caché si présent (modification)
                const eventIdInput = form.querySelector('input[name="event_id"]');
                if (eventIdInput) eventIdInput.remove();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la création du Tache');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Enregistrer';
        });
    }



    function modifierTache(form) {
        const formData = new FormData(form);
        const eventId = formData.get('event_id');
        const submitBtn = document.getElementById('submitBtn');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Modification...';

        // ⭐⭐ DÉBOGAGE : Afficher ce qui est envoyé ⭐⭐
        console.log("=== DÉBOGAGE modifierTache ===");
        console.log("ID de l'événement:", eventId);
        
        // Afficher toutes les données du formulaire
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        formData.append('_method', 'PUT');

        fetch('{{ route("calendrier.update", "") }}/' + eventId, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            console.log("Réponse status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("Réponse data:", data);
            if (data.success) {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
                viderFormulaireNouveau();
                alert('Événement modifié avec succès!');
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la modification');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Enregistrer';
        });
    }


    function chargerUtilisateursDisponibles() {
        fetch('/utilisateurs-concerner/disponibles')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    utilisateursDisponibles = data.users;
                    
                    // Remplir la liste déroulante
                    const select = document.getElementById('utilisateur_select');
                    select.innerHTML = '<option value="">Choisir un utilisateur...</option>';
                    
                    data.users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = user.nom_complet + ' (' + user.login + ')';
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur chargement utilisateurs:', error);
            });
    }

    function chargerUtilisateursAffectes(eventId) {
        fetch('/utilisateurs-concerner/calendrier/' + eventId)
            .then(response => response.json())
            .then(utilisateurs => {
                const container = document.getElementById('selectedUsersList');
                container.innerHTML = '';
                
                if (utilisateurs.length === 0) {
                    container.innerHTML = '<p class="text-muted">Aucun utilisateur affecté</p>';
                    return;
                }
                
                utilisateurs.forEach(user => {
                    const div = document.createElement('div');
                    div.className = 'user-item';
                    div.innerHTML = `
                        <div>
                            <strong>${user.utilisateur_info.nom_complet}</strong><br>
                            <small class="text-muted">${user.description_tache || 'Pas de description'}</small>
                        </div>
                        <div class="user-actions">
                            <button class="btn btn-sm btn-danger" onclick="supprimerUtilisateur(${user.id}, this)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                    container.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Erreur chargement utilisateurs affectés:', error);
            });
    }

    function ajouterUtilisateur() {
        const select = document.getElementById('utilisateur_select');
        const userId = select.value;
        const description = document.getElementById('description_tache').value;
        
        if (!userId) {
            alert('Veuillez sélectionner un utilisateur');
            return;
        }
        
        const eventId = document.getElementById('event_id').value;
        
        fetch('/utilisateurs-concerner', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                id_utilsateur: userId,
                id_calandrier: eventId,
                description_tache: description
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Recharger la liste
                chargerUtilisateursAffectes(eventId);
                
                // Réinitialiser les champs
                select.value = '';
                document.getElementById('description_tache').value = '';
                
                alert('Utilisateur ajouté avec succès');
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'ajout');
        });
    }

    function supprimerUtilisateur(affectationId, button) {
        if (confirm('Retirer cet utilisateur de la tâche ?')) {
            fetch('/utilisateurs-concerner/' + affectationId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer l'élément de la liste
                    button.closest('.user-item').remove();
                    
                    // Vérifier si la liste est vide
                    const container = document.getElementById('selectedUsersList');
                    if (container.children.length === 0) {
                        container.innerHTML = '<p class="text-muted">Aucun utilisateur affecté</p>';
                    }
                    
                    alert('Utilisateur retiré avec succès');
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

    function sauvegarderUtilisateurs() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('utilisateurModal'));
        modal.hide();
        alert('Modifications enregistrées');
    }


    // NOUVELLE FONCTION POUR AFFICHER LES DÉTAILS DE LA TÂCHE AVEC LES UTILISATEURS
    function chargerEtAfficherUtilisateursAffectes(eventId, titre, description, startDate, endDate) {
        fetch('/utilisateurs-concerner/calendrier/' + eventId)
            .then(response => response.json())
            .then(utilisateurs => {
                // Construire le message avec les détails
                let message = `
                    <div style="max-width: 500px;">
                        <h5 style="color: #2c3e50; margin-bottom: 15px;">${titre}</h5>
                        
                        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                            <p><strong>📅 Date début :</strong> ${startDate}</p>
                            <p><strong>📅 Date fin :</strong> ${endDate}</p>
                            <p><strong>📝 Description :</strong> ${description}</p>
                        </div>
                `;
            
            if (utilisateurs.length > 0) {
                message += `
                    <h6 style="color: #495057; margin-bottom: 10px;">👥 Utilisateurs affectés :</h6>
                    <div style="max-height: 200px; overflow-y: auto;">
                `;
                
                utilisateurs.forEach((user, index) => {
                    message += `
                        <div style="background: white; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; margin-bottom: 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div>
                                    <strong style="color: #2c3e50;">${user.utilisateur_info.nom_complet}</strong><br>
                                    <small style="color: #6c757d;">${user.utilisateur_info.login}</small>
                                </div>
                            </div>
                            ${user.description_tache ? `
                                <div style="margin-top: 8px; padding: 8px; background-color: #f8f9fa; border-radius: 3px; font-size: 0.9em;">
                                    <strong>📋 Tâche attribuée :</strong><br>
                                    ${user.description_tache}
                                </div>
                            ` : ''}
                        </div>
                    `;
                });
                
                message += `
                    </div>
                    <p style="margin-top: 10px; font-size: 0.9em; color: #6c757d;">
                        ${utilisateurs.length} utilisateur(s) affecté(s) à cette tâche
                    </p>
                `;
            } else {
                message += `
                    <div style="text-align: center; padding: 20px; color: #6c757d;">
                        <i class="bi bi-person-x" style="font-size: 24px;"></i><br>
                        <p style="margin-top: 10px;">Aucun utilisateur n'est affecté à cette tâche</p>
                    </div>
                `;
            }
            
            message += '</div>';
            
            // Afficher dans une modal Bootstrap au lieu d'alert()
            afficherModalDetails(message);
        })
        .catch(error => {
            console.error('Erreur chargement utilisateurs:', error);
            
            // Afficher juste les détails de base si erreur
            const message = `
                <div style="max-width: 500px;">
                    <h5 style="color: #2c3e50; margin-bottom: 15px;">${titre}</h5>
                    
                    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
                        <p><strong>📅 Date début :</strong> ${startDate}</p>
                        <p><strong>📅 Date fin :</strong> ${endDate}</p>
                        <p><strong>📝 Description :</strong> ${description}</p>
                    </div>
                    
                    <div style="text-align: center; padding: 20px; color: #dc3545;">
                        <i class="bi bi-exclamation-triangle" style="font-size: 24px;"></i><br>
                        <p style="margin-top: 10px;">Erreur lors du chargement des utilisateurs affectés</p>
                    </div>
                </div>
            `;
            
            afficherModalDetails(message);
        });
    }


    // FONCTION POUR AFFICHER UNE MODAL AVEC LES DÉTAILS
    function afficherModalDetails(content) {
        // Créer la modal si elle n'existe pas
        let modal = document.getElementById('detailsModal');
        
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'detailsModal';
            modal.className = 'modal fade';
            modal.tabIndex = '-1';
            modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Détails de la tâche</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="detailsModalBody">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        // Mettre le contenu
        document.getElementById('detailsModalBody').innerHTML = content;
        
        // Afficher la modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    }


    function envoyerNotification() {
        if (!currentEventId) return;
        
        const event = calendar.getEventById(currentEventId);
        if (!event) return;
        
        // Demander le message de notification
        const messageDefault = `Nouvelle tâche : ${event.title}\nDate : ${event.start ? event.start.toLocaleDateString('fr-FR') : ''}\nDescription : ${event.extendedProps.description || 'Aucune description'}`;
        
        const message = prompt("Message de notification :", messageDefault);
        
        if (!message) {
            alert("Notification annulée");
            return;
        }
        
        // Envoyer la notification
        fetch('/calendrier/notifier/' + currentEventId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: message,
                event_id: currentEventId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Notification envoyée à ${data.notified_users || 0} utilisateur(s)`);
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de l\'envoi de la notification');
        });
        
        document.getElementById('contextMenu').style.display = 'none';
    }


</script>


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>