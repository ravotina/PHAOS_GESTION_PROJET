<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Emploi du Temps - {{ $lancement->nom }} - Cabinet PHAOS</title>
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

    .fc-event[style*="background-color"] {
        opacity: 1 !important;
    }

    .fc-daygrid-day-frame {
        min-height: 60px !important;
    }

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

    /* Style pour la modal de détails */
    #detailsModal .modal-dialog {
        max-width: 550px;
    }

    /* Légende des modules */
    .module-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 10px;
        background: white;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 3px;
    }
    .legend-text {
        font-size: 0.9em;
        font-weight: 500;
    }

    /* Modal emploi */
    .emploi-modal .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
    }
    .emploi-modal select {
        height: 42px;
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
            <!-- En-tête avec navigation -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-week text-primary me-2"></i>
                        Emploi du Temps - {{ $lancement->nom }}
                    </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('projets.index') }}">Projets</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('lancement.index', $lancement->projetDemare->id) }}">
                                    {{ $lancement->projetDemare->non_de_projet }}
                                </a>
                            </li>
                            <li class="breadcrumb-item active">{{ $lancement->nom }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="btn-group">
                    <a href="{{ route('emploi-du-temps.index', [$lancement->projetDemare->id, $lancement->id]) }}" 
                       class="btn btn-outline-secondary">
                        <i class="bi bi-list-ul"></i> Vue tableau
                    </a>
                    <button type="button" class="btn btn-primary" onclick="ouvrirModalNouveau()">
                        <i class="bi bi-plus-circle"></i> Nouveau module
                    </button>
                </div>
            </div>

            <!-- Légende des modules -->
            <div class="module-legend" id="moduleLegend"></div>

            <!-- Calendrier -->
            <div id="calendar"></div>
        </div>
    </div>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('page.footer')

  <!-- Modal pour ajouter/modifier un emploi du temps -->
  <div class="modal fade" id="emploiModal" tabindex="-1">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalTitle">Nouveau Module</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form id="emploiForm">
                  @csrf
                  <input type="hidden" name="id" id="emploi_id">

                  <div class="modal-body emploi-modal">
                      <div class="mb-3">
                          <label class="form-label">Module activé </label>
                          <select class="form-select" name="id_module_affecter" id="module_select" required>
                              <option value="">Sélectionner un module...</option>
                              @foreach($modules as $module)
                                  <option value="{{ $module->id }}">{{ $module->nom }}</option>
                              @endforeach
                          </select>
                      </div>
                      
                      <div class="row">
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Date début </label>
                                  <input type="date" class="form-control" name="date_debut" id="date_debut" required>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="mb-3">
                                  <label class="form-label">Date fin </label>
                                  <input type="date" class="form-control" name="date_fin" id="date_fin" required>
                              </div>
                          </div>
                      </div>
                      
                      <div class="mb-3">
                          <label class="form-label">Description</label>
                          <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description du module..."></textarea>
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

  <!-- Menu contextuel -->
  <div id="contextMenu" class="context-menu">
      <ul>
          <li onclick="modifierEmploi()">
              <i class="bi bi-pencil"></i> Modifier
          </li>
          <li onclick="supprimerEmploi()" class="delete">
              <i class="bi bi-trash"></i> Supprimer
          </li>
      </ul>
  </div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- FullCalendar JS -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>

<script>
    // AJOUTEZ CE TEST EN PREMIER
    console.log('=== DÉBUT DU SCRIPT ===');
    console.log('Lancement ID:', {{ $lancement->id }});
    console.log('Projet ID:', {{ $lancement->projetDemare->id }});
    console.log('Route events:', '{{ route("emploi-du-temps.events", [$lancement->projetDemare->id, $lancement->id]) }}');


    let calendar;
    let currentEventId = null;
    const lancementId = {{ $lancement->id }};
    const projetId = {{ $lancement->projetDemare->id }};
    const modules = @json($modules);
    
    // Couleurs pour les modules
    const moduleColors = [
        '#3788d8', '#28a745', '#dc3545', '#ffc107', 
        '#6f42c1', '#fd7e14', '#20c997', '#e83e8c',
        '#17a2b8', '#6610f2', '#6f42c1', '#d63384'
    ];
    
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        
        // Générer la légende
        genererLegende();
        
        // Initialiser le calendrier
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
            events: function(fetchInfo, successCallback, failureCallback) {
                console.log('Chargement des événements...');
                
                fetch('{{ route("emploi-du-temps.events", [$lancement->projetDemare->id, $lancement->id]) }}')
                    .then(response => {
                        console.log('Réponse status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Données API brutes:', data);
                        
                        // Utilisez les données TELS QUELLES
                        const events = data.map(item => ({
                            id: item.id,
                            title: item.title, 
                            start: item.start,
                            end: item.end,    
                            color: item.color || '#3788d8',
                            extendedProps: item.extendedProps || {}
                        }));
                        
                        console.log('Événements prêts:', events);
                        successCallback(events);
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        successCallback([]);
                    });
            },
            eventDisplay: 'block',
            displayEventTime: false,
            allDaySlot: true,
            nowIndicator: true,
            editable: true,
            selectable: true,
            
            // Gestion du clic droit
            eventDidMount: function(info) {
                const eventId = info.event.id;
                info.el.setAttribute('data-event-id', eventId);
                
                // Clic droit pour menu contextuel
                info.el.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    currentEventId = eventId;
                    const contextMenu = document.getElementById('contextMenu');
                    contextMenu.style.display = 'block';
                    contextMenu.style.left = e.pageX + 'px';
                    contextMenu.style.top = e.pageY + 'px';
                    
                    return false;
                });
                
                // Clic gauche pour détails
                info.el.addEventListener('click', function(e) {
                    if (e.button === 0) {
                        currentEventId = eventId;
                        const event = calendar.getEventById(eventId);
                        if (event) {
                            afficherDetails(event);
                        }
                    }
                });
            },
            
            // Sélection de dates pour création
            select: function(info) {
                ouvrirModalNouveau();
                
                // Pré-remplir les dates
                const startDate = new Date(info.startStr);
                const endDate = new Date(info.endStr);
                endDate.setDate(endDate.getDate() - 1); // FullCalendar inclut le dernier jour
                
                document.getElementById('date_debut').valueAsDate = startDate;
                document.getElementById('date_fin').valueAsDate = endDate;
                
                calendar.unselect();
            }
        });
        
        calendar.render();
        
        // Cacher menu contextuel au clic ailleurs
        document.addEventListener('click', function(e) {
            const contextMenu = document.getElementById('contextMenu');
            if (contextMenu.style.display === 'block' && !contextMenu.contains(e.target)) {
                contextMenu.style.display = 'none';
            }
        });
        
        // Empêcher menu contextuel par défaut
        calendarEl.addEventListener('contextmenu', function(e) {
            if (!e.target.closest('.fc-event')) {
                e.preventDefault();
                return false;
            }
        });
        
        // Gestion du formulaire
        const emploiForm = document.getElementById('emploiForm');
        if (emploiForm) {
            emploiForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const emploiId = document.getElementById('emploi_id').value;
                if (emploiId) {
                    modifierEmploiForm(this);
                } else {
                    creerEmploiForm(this);
                }
            });
        }
    });
    
    function genererLegende() {
        const legendContainer = document.getElementById('moduleLegend');
        legendContainer.innerHTML = '';
        
        // MÊME mapping que dans le PHP
        const colorMap = {
            1: '#3788d8', // Mission
            2: '#28a745', // Achat
            3: '#dc3545', // Projet
            4: '#ffc107', // Finance
            5: '#6f42c1', // Ressources Humaines
            6: '#fd7e14', // Inventaire
            7: '#20c997', // Vente
            8: '#e83e8c'  // Support Client
        };
        
        modules.forEach((module) => {
            const color = colorMap[module.id] || '#3788d8';
            
            const legendItem = document.createElement('div');
            legendItem.className = 'legend-item';
            legendItem.innerHTML = `
                <div class="legend-color" style="background-color: ${color}"></div>
                <span class="legend-text">${module.nom}</span>
            `;
            
            legendContainer.appendChild(legendItem);
        });
    }
    
    function ouvrirModalNouveau() {
        document.getElementById('modalTitle').textContent = 'Nouveau Module';
        document.getElementById('emploiForm').reset();
        document.getElementById('emploi_id').value = '';
        document.getElementById('submitBtn').textContent = 'Enregistrer';
        
        const modal = new bootstrap.Modal(document.getElementById('emploiModal'));
        modal.show();
    }
    
    function afficherDetails(event) {
        const moduleId = event.extendedProps.module_id;
        const module = modules.find(m => m.id == moduleId);
        
        const startDate = new Date(event.start);
        const endDate = new Date(event.end);
        
        const details = `
            <div class="p-3">
                <h5 class="text-primary mb-3">${event.title}</h5>
                
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong><i class="bi bi-calendar-event me-2"></i>Période :</strong><br>
                        ${startDate.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}<br>
                        au ${endDate.toLocaleDateString('fr-FR', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                        
                        <p><strong><i class="bi bi-clock me-2"></i>Durée :</strong> 
                        ${Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24))} jours</p>
                        
                        ${event.extendedProps.description ? `
                            <p><strong><i class="bi bi-card-text me-2"></i>Description :</strong><br>
                            ${event.extendedProps.description}</p>
                        ` : ''}
                        
                        <p><strong><i class="bi bi-diagram-3 me-2"></i>Lancement :</strong><br>
                        {{ $lancement->nom }}</p>
                    </div>
                </div>
            </div>
        `;
        
        // Créer une modal pour afficher les détails
        const modalHTML = `
            <div class="modal fade" id="detailsModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Détails du Module</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            ${details}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Créer et afficher la modal
        const modalContainer = document.createElement('div');
        modalContainer.innerHTML = modalHTML;
        document.body.appendChild(modalContainer);
        
        const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
        modal.show();
        
        // Supprimer la modal après fermeture
        modal._element.addEventListener('hidden.bs.modal', function() {
            document.body.removeChild(modalContainer);
        });
    }
    
    function modifierEmploi() {
        if (!currentEventId) return;
        
        const event = calendar.getEventById(currentEventId);
        if (!event) return;
        
        // Remplir le formulaire
        document.getElementById('modalTitle').textContent = 'Modifier Module';
        document.getElementById('emploi_id').value = currentEventId;
        document.getElementById('module_select').value = event.extendedProps.module_id;
        
        const startDate = new Date(event.start);
        const endDate = new Date(event.end);
        
        document.getElementById('date_debut').value = startDate.toISOString().split('T')[0];
        document.getElementById('date_fin').value = endDate.toISOString().split('T')[0];
        document.getElementById('description').value = event.extendedProps.description || '';
        document.getElementById('submitBtn').textContent = 'Modifier';
        
        const modal = new bootstrap.Modal(document.getElementById('emploiModal'));
        modal.show();
        
        document.getElementById('contextMenu').style.display = 'none';
    }
    
    function supprimerEmploi() {
        if (!currentEventId) return;
        
        if (confirm('Supprimer cet emploi du temps ?')) {
            fetch(`/projets/${projetId}/lancements/${lancementId}/emplois-du-temps/${currentEventId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    calendar.refetchEvents();
                    alert('Emploi du temps supprimé');
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la suppression');
            });
        }
        
        document.getElementById('contextMenu').style.display = 'none';
    }
    
    function creerEmploiForm(form) {
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBtn');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Création...';
        
        fetch(`/projets/${projetId}/lancements/${lancementId}/emplois-du-temps`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('emploiModal')).hide();
                form.reset();
                alert('Module ajouté avec succès!');
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la création');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Enregistrer';
        });
    }
    
    function modifierEmploiForm(form) {
        const formData = new FormData(form);
        const emploiId = formData.get('id');
        const submitBtn = document.getElementById('submitBtn');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Modification...';
        
        formData.append('_method', 'PUT');
        
        fetch(`/projets/${projetId}/lancements/${lancementId}/emplois-du-temps/${emploiId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendar.refetchEvents();
                bootstrap.Modal.getInstance(document.getElementById('emploiModal')).hide();
                form.reset();
                alert('Module modifié avec succès!');
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
            submitBtn.innerHTML = 'Modifier';
        });
    }
</script>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</body>
</html>