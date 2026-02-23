

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Détails du Projet - Cabinet PHAOS</title>
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
        /* Thème couleur principal */
        /* :root {
        --primary-gradient: linear-gradient(135deg, #000, #b15d15);
        --primary-dark: #000;
        --primary-orange: #b15d15;
        --primary-light: #d87c2a;
        } */

        /* Header principal */
        .project-main-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(177, 93, 21, 0.2);
        position: relative;
        overflow: hidden;
        }

        .project-main-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        }

        .project-main-header h1 {
        font-weight: 600;
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .project-main-header .badge {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        font-weight: 500;
        }

        /* Conteneur calendrier */
        .calendar-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
        border: 1px solid #eee;
        }

        .fc-toolbar {
        background: var(--primary-gradient);
        color: white;
        padding: 15px 20px;
        border-radius: 12px 12px 0 0;
        margin-bottom: 0 !important;
        }

        .fc-toolbar-title {
        color: white !important;
        font-weight: 600;
        }

        .fc-button {
        background-color: var(--primary-orange) !important;
        border-color: var(--primary-orange) !important;
        font-weight: 500;
        }

        .fc-button:hover {
        background-color: var(--primary-dark) !important;
        border-color: var(--primary-dark) !important;
        }

        /* Cartes */
        .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
        transition: transform 0.3s ease;
        }

        .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 15px 20px;
        border: none;
        }

        .card-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        }

        /* Boutons */
        .btn-primary {
        background: var(--primary-gradient);
        border: none;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
        }

        .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(177, 93, 21, 0.3);
        }

        .btn-outline-primary {
        color: var(--primary-orange);
        border-color: var(--primary-orange);
        }

        .btn-outline-primary:hover {
        background: var(--primary-orange);
        border-color: var(--primary-orange);
        color: white;
        }

        .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
        }

        .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
        }

        /* Liste des détails (remplace le tableau) */
        .details-list {
        max-height: 500px;
        overflow-y: auto;
        }

        .detail-item {
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #eee;
        transition: all 0.3s ease;
        }

        .detail-item:hover {
        border-color: var(--primary-orange);
        box-shadow: 0 3px 10px rgba(177, 93, 21, 0.1);
        transform: translateX(5px);
        }

        .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        }

        .detail-title {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
        margin: 0;
        }

        .detail-id {
        background: #f8f9fa;
        color: #666;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        }

        .detail-description {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.5;
        }

        .detail-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
        }

        .file-badge {
        background: var(--primary-gradient);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        }

        .file-badge .bi {
        font-size: 0.9rem;
        }

        .actions-buttons {
        display: flex;
        gap: 8px;
        }

        .actions-buttons .btn {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.9rem;
        }

        /* Alertes */
        .alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .alert-info {
        background: #e3f2fd;
        color: #1565c0;
        }

        /* Scrollbar personnalisée */
        .details-list::-webkit-scrollbar {
        width: 6px;
        }

        .details-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
        }

        .details-list::-webkit-scrollbar-thumb {
        background: var(--primary-orange);
        border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
        .calendar-container {
            padding: 15px;
        }
        
        .detail-header {
            flex-direction: column;
            gap: 10px;
        }
        
        .detail-footer {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        
        .actions-buttons {
            width: 100%;
            justify-content: flex-end;
        }
        }

        /* Event styles pour FullCalendar */
        .fc-event {
        border: none !important;
        padding: 6px 8px !important;
        margin: 2px !important;
        font-size: 0.85em !important;
        font-weight: 600 !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .fc-daygrid-event {
        min-height: 24px !important;
        white-space: normal !important;
        }

        .fc-event-main {
        color: white !important;
        font-weight: bold !important;
        }

        .fc-daygrid-day-frame {
        min-height: 60px !important;
        }


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

    .project-main-header {
        /* background: linear-gradient(135deg, #000, #b15d15); */
        color: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 20px rgba(177, 93, 21, 0.2);
    }
    
    .info-badge {
        padding: 10px 15px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        min-width: 180px;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }
    
    .btn-light {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        color: #333;
        font-weight: 500;
    }
    
    .btn-light:hover {
        background: white;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .d-flex.justify-content-between.align-items-start {
            flex-direction: column;
            gap: 20px;
        }
        
        .text-end {
            text-align: left !important;
            width: 100%;
        }
        
        .d-flex.flex-wrap.align-items-center.gap-4 {
            gap: 15px !important;
        }
        
        .info-badge {
            min-width: auto;
            flex: 1;
        }
    }
    
    @media (max-width: 576px) {
        .project-main-header {
            padding: 20px;
        }
        
        .d-flex.flex-wrap.align-items-center.gap-4 {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .info-badge {
            width: 100%;
        }
    }


    /* CALENDRIER - THÈME PERSONNALISÉ */
    .calendar-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 20px;
        border: 1px solid #eee;
        margin-bottom: 25px;
    }

    /* En-tête du calendrier */
    .fc-toolbar {
        background: linear-gradient(135deg, #000, #b15d15);
        color: white;
        padding: 15px 20px;
        border-radius: 12px 12px 0 0;
        margin-bottom: 0 !important;
    }

    .fc-toolbar-title {
        color: white !important;
        font-weight: 600;
        font-size: 1.2rem !important;
    }

    .fc-button {
        font-weight: 500;
        border-radius: 6px !important;
        padding: 6px 12px !important;
        font-size: 0.9rem !important;
    }

    .fc-button:hover {
        background-color: #000 !important;
        border-color: #000 !important;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .fc-button-primary:not(:disabled):active,
    .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #000 !important;
        border-color: #000 !important;
    }

    /* En-tête des jours */
    .fc-col-header-cell {
        background: #f8f9fa;
        border-color: #dee2e6 !important;
        padding: 10px 0 !important;
        font-weight: 600;
        color: #333;
    }

    .fc-col-header-cell-cushion {
        color: #333;
        font-weight: 600;
    }

    /* Cellules du calendrier */
    .fc-daygrid-day {
        border-color: #e9ecef !important;
    }

    .fc-daygrid-day.fc-day-today {
        background-color: rgba(177, 93, 21, 0.1) !important;
    }

    .fc-daygrid-day-number {
        color: #555;
        font-weight: 500;
        padding: 5px !important;
    }

    .fc-day-today .fc-daygrid-day-number {
        font-weight: 600;
    }

    /* Événements */
    .fc-event {
        border: none !important;
        padding: 6px 8px !important;
        margin: 2px 3px !important;
        font-size: 0.85em !important;
        font-weight: 600 !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .fc-event:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .fc-event-main {
        color: white !important;
        font-weight: bold !important;
        padding: 2px 0 !important;
    }

    .fc-daygrid-event {
        min-height: 24px !important;
        white-space: normal !important;
    }

    .fc-daygrid-day-frame {
        min-height: 60px !important;
    }

    /* Couleurs des événements par défaut */
    .fc-event[style*="background-color"] {
        opacity: 1 !important;
    }

    /* Indicateur "Aujourd'hui" */
    .fc-daygrid-day.fc-day-today {
        background-color: rgba(177, 93, 21, 0.05) !important;
    }

    /* Vue semaine/jour */
    .fc-timegrid-slot {
        border-color: #f0f0f0 !important;
    }

    .fc-timegrid-axis {
        background: #f8f9fa;
        border-color: #dee2e6 !important;
    }

    .fc-timegrid-col.fc-day-today {
        background-color: rgba(177, 93, 21, 0.05) !important;
    }

    /* Vue liste */
    .fc-list-event {
        background: #f8f9fa;
        border-left: 4px solid #b15d15;
        margin-bottom: 5px;
        border-radius: 4px;
    }

    .fc-list-event:hover {
        background: #e9ecef;
    }

    .fc-list-event-title {
        color: #333;
        font-weight: 500;
    }

    /* Scrollbar */
    .fc-scroller::-webkit-scrollbar {
        width: 8px;
    }

    .fc-scroller::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .fc-scroller::-webkit-scrollbar-thumb {
        background: var(--couleur_main);
        border-radius: 10px;
    }

    .fc-scroller::-webkit-scrollbar-thumb:hover {
        background: var(--couleur_main);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .calendar-container {
            padding: 15px;
        }
        
        .fc-toolbar {
            padding: 12px 15px;
            flex-direction: column;
            gap: 10px;
        }
        
        .fc-toolbar-title {
            font-size: 1rem !important;
            margin-bottom: 10px;
        }
        
        .fc-button {
            padding: 5px 10px !important;
            font-size: 0.8rem !important;
        }
        
        .fc-header-toolbar .fc-toolbar-chunk {
            display: flex;
            justify-content: center;
            width: 100%;
        }
    }


    /* Bouton avec icône uniquement */
    .icon-only-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        padding: 0;
        margin: 0 auto;
        position: relative;
        transition: all 0.3s ease;
    }

    .icon-only-btn .btn-text {
        display: none;
    }

    .icon-only-btn:hover {
        width: 200px;
        border-radius: 25px;
        padding: 0 20px;
        justify-content: flex-start;
    }

    .icon-only-btn:hover .btn-text {
        display: inline-block;
        margin-left: 10px;
        font-weight: 500;
        white-space: nowrap;
        opacity: 0;
        animation: fadeIn 0.3s ease forwards 0.1s;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Tooltip personnalisé pour mobile */
    .icon-only-btn::after {
        content: "Ajouter un Fichier";
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 1000;
    }

    .icon-only-btn:hover::after {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .icon-only-btn {
            width: 45px;
            height: 45px;
        }
        
        .icon-only-btn:hover {
            width: 180px;
        }
        
        .icon-only-btn .bi {
            font-size: 1.2rem;
        }
    }



    /* Bouton flottant */
    .btn-floating {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        position: relative;
        z-index: 10;
    }

    .btn-floating:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(177, 93, 21, 0.3);
    }

    .float-end {
        margin-top: -10px;
    }










    /* Alertes */
    .alert {
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    /* Icônes */
    .fas, .bi {
        transition: transform 0.2s ease;
    }

    .btn:hover .fas,
    .btn:hover .bi {
        transform: scale(1.1);
    }

    /* Pagination (si vous en ajoutez plus tard) */
    .page-item.active .page-link {
        background: var(--primary-gradient) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
    }

    .page-link {
        color: var(--primary-color) !important;
        border: 1px solid #dee2e6 !important;
    }

    .page-link:hover {
        background: var(--primary-light) !important;
        color: var(--primary-dark) !important;
    }

    /* Bouton group */
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 6px !important;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    /* Message "Aucun projet" */
    .fa-folder-open {
        color: var(--primary-color) !important;
        opacity: 0.7;
    }

    /* Tooltips */
    [data-bs-toggle="tooltip"] {
        cursor: pointer;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header h6 {
            font-size: 1rem;
        }
        
        .table-responsive {
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }
        
        .btn-group {
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .btn-group .btn {
            margin-bottom: 5px;
        }
    }

    /* Animation pour les cartes */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Amélioration du contraste */
    .text-muted {
        color: #6c757d !important;
    }

    .table-light {
        background: rgba(177, 93, 21, 0.08) !important;
    }

    /* Bouton retour en haut */
    .back-to-top {
        background: var(--primary-gradient) !important;
        border: none;
        color: white;
    }

    .back-to-top:hover {
        background: linear-gradient(135deg, #b15d15, #8a4710) !important;
    }











    /* Styles pour la modal de notification */
    .event-preview {
        transition: all 0.3s ease;
    }

    .event-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(177, 93, 21, 0.1);
    }

    #notificationMessage {
        resize: vertical;
        min-height: 150px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 12px;
        font-size: 14px;
        line-height: 1.5;
    }

    #notificationMessage:focus {
        border-color: #b15d15;
        box-shadow: 0 0 0 0.2rem rgba(177, 93, 21, 0.25);
    }

    .modal-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 15px 20px;
    }

    /* Animation pour les boutons */
    #sendNotificationBtn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    #sendNotificationBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(177, 93, 21, 0.3);
    }

    #sendNotificationBtn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Spinner pour le bouton d'envoi */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }




    /* Ajoutez ceci dans votre balise <style> ou fichier CSS */
    .fc .fc-button-primary {
        background-color: #b15d15;
        border-color: #b15d15;
    }

    .fc .fc-button-primary:hover {
        background-color: #8a4710;
        border-color: #8a4710;
    }

    /* Style pour les boutons d'année dans la modal */
    #yearButtonsContainer .btn-outline-primary {
        color: #b15d15;
        border-color: #b15d15;
    }

    #yearButtonsContainer .btn-outline-primary:hover {
        background-color: #b15d15;
        border-color: #b15d15;
        color: white;
    }

    #customYearInput:focus {
        border-color: #b15d15;
        box-shadow: 0 0 0 0.2rem rgba(177, 93, 21, 0.25);
    }






    /* Pour tous les boutons du calendrier */
    .fc .fc-button {
        padding: 0.25em 0.6em !important;
        font-size: 0.85em !important;
        line-height: 1.4 !important;
        min-height: 28px !important;
    }

    /* Pour l'espacement entre les boutons */
    .fc .fc-button-group {
        margin: 0 3px !important;
    }

    .fc .fc-button-group .fc-button {
        margin: 0 1px !important;
    }

       
  </style>

</head>

<body>

   <!-- ======= header ======= -->
    @include('page.header')

   <!-- ======= Sidebar ======= -->
   @include('page.sidebar')
  
   <main id="main" class="main">
        <!-- Header principal -->
        <div class="project-main-header btn-perso">
            <div class="d-flex justify-content-between align-items-start">
                <!-- Partie gauche - Informations principales -->
                <div class="flex-grow-1 me-4">
                    <!-- Titre du projet -->
                    <h1 class="h2 mb-3 text-white">
                        <i class="bi bi-clipboard-data me-2"></i>
                        {{ $projet->non_de_projet }}
                    </h1>
                    
                    <!-- Description -->
                    @if($projet->description)
                    <div class="mb-3">
                        <p class="text-white mb-0" style="opacity: 0.9;">
                            {{ $projet->description }}
                        </p>
                    </div>
                    @endif
                    
                    <!-- Informations en ligne -->
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <!-- Client -->
                        <div class="info-badge">
                            <small class="text-white-50 d-block mb-1">
                                <i class="bi bi-person-circle me-1"></i> Client
                            </small>
                            <span class="text-white">
                                {{ $clientsMap[$projet->id_client] ?? 'Client #' . $projet->id_client }}
                            </span>
                        </div>
                        
                        <!-- Dates -->
                        <div class="info-badge">
                            <small class="text-white-50 d-block mb-1">
                                <i class="bi bi-calendar-range me-1"></i> Dates
                            </small>
                            <div class="text-white">
                                <div class="d-flex gap-3">
                                    <span>
                                        <i class="bi bi-calendar-plus me-1"></i>
                                        {{ $projet->date_debu ? \Carbon\Carbon::parse($projet->date_debu)->format('d/m/Y') : 'Non définie' }}
                                    </span>
                                    ->
                                    <span>
                                        <i class="bi bi-calendar-check me-1"></i>
                                        {{ $projet->date_fin ? \Carbon\Carbon::parse($projet->date_fin)->format('d/m/Y') : 'Non définie' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Responsable/Chef de projet -->

                        @if(app('permission')->hasModule('api'))
                            <div class="info-badge">
                                <small class="text-white-50 d-block mb-1">
                                    <i class="bi bi-person-badge me-1"></i> Responsable
                                </small>
                                <div class="text-white">
                                    @php
                                        $chefInfo = null;
                                        $chefPhoto = null;
                                        
                                        // Vérifier d'abord la relation chefProjet
                                        if($projet->chefProjet) {
                                            $chefInfo = $projet->chefProjet;
                                            $chefPhoto = $chefInfo->photo ?? null;
                                        }
                                        // Sinon chercher dans les utilisateurs
                                        elseif(!empty($utilisateurs['formatted']['users'])) {
                                            foreach($utilisateurs['formatted']['users'] as $user) {
                                                if(($user['id'] ?? $user['rowid'] ?? '') == $projet->id_utilisateur_chef_de_projet) {
                                                    $chefInfo = $user;
                                                    $chefPhoto = $chefInfo['photo'] ?? null;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    
                                    @if($chefInfo)
                                        <div class="d-flex align-items-center">
                                            @if($chefPhoto)
                                                <img src="{{ $chefPhoto }}" 
                                                    alt="{{ $chefInfo['firstname'] ?? $chefInfo->firstname ?? '' }} {{ $chefInfo['lastname'] ?? $chefInfo->lastname ?? '' }}"
                                                    class="rounded-circle me-2" 
                                                    style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 bg-white" 
                                                    style="width: 32px; height: 32px; color: #b15d15;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div style="font-weight: 500;">
                                                    {{ $chefInfo['firstname'] ?? $chefInfo->firstname ?? '' }} {{ $chefInfo['lastname'] ?? $chefInfo->lastname ?? '' }}
                                                </div>
                                                @if($chefInfo['login'] ?? $chefInfo->login ?? false)
                                                    <!-- <small class="text-white-50">{{ $chefInfo['login'] ?? $chefInfo->login }}</small> -->
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-white-50">Non assigné</span>
                                    @endif
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
                
                <!-- Partie droite - Actions et statut -->
                <div class="text-end">
                    <!-- Bouton retour -->
                    <div class="mb-3">
                        <a href="{{ route('projets.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left me-2"></i> Retour
                        </a>
                    </div>
                    
                    <!-- Badges de statut -->
                    <div class="d-flex flex-column gap-2">
                        @if($projet->date_fin && now()->gt($projet->date_fin) && ($projet->avancement ?? 0) < 100)
                        <span class="badge bg-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i> En retard
                        </span>
                        @endif
                        
                        @if(($projet->avancement ?? 0) == 100)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i> Terminé
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
        <!-- Colonne gauche - Calendrier -->
        <div class="col-lg-8 mb-4">

            <div class="calendar-container section_personaliser">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 fw-bold">Calendrier</h4>
                    <button type="button" class="btn btn-primary" onclick="ouvrirModalNouvelleTache()" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <i class="bi bi-plus-circle me-2"></i> Nouvelle tâche
                    </button>
                </div>
                
                <div id="calendar"></div>
            </div>
        </div>


        <!-- Colonne droite - Détails du projet -->
        <div class="col-lg-4 mb-4">
            <div class="card">
            <div class="card-header">
                <h5>
                <i class="bi bi-list-ul"></i>
                    Documents du Projet
                </h5>
            </div>
            
            <div class="card-body section_personaliser">
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


                <div class="mb-4">
                    <div class="float-end">
                        <a href="{{ route('projet.details.create', $projet->id) }}" 
                        class="btn btn-primary btn-floating"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="left"
                        title="Ajouter un Fichier">
                            <i class="bi bi-plus-circle"></i>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                @if($details->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i>
                    Aucun détail n'a été ajouté à ce projet pour le moment.
                </div>
                @else
                <div class="details-list">
                    @foreach($details as $detail)
                    <div class="detail-item section_personaliser">
                    <div class="detail-header">
                        <h6 class="detail-title">{{ $detail->nom }}</h6>
                        <!-- <span class="detail-id">#{{ $detail->id }}</span> -->
                    </div>
                    
                    <div class="detail-description">
                        {{ Str::limit($detail->description, 100) }}
                    </div>
                    
                    <div class="detail-footer">
                        <div>
                            @if($detail->file)
                                <span class="file-badge">
                                <i class="bi bi-file-earmark"></i>
                                {{ basename($detail->file) }}
                                    <a href="{{ route('projet.details.download', [$projet->id, $detail->id]) }}" 
                                        class="btn btn-sm ms-2" 
                                        title="Télécharger"
                                        style="color: white; border: 1px solid white; background: transparent; transition: all 0.3s ease;">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </span>
                            @else
                                <span class="badge bg-secondary">Aucun fichier</span>
                            @endif
                        </div>
                        
                        <div class="actions-buttons">
                        @if(app('permission')->hasPermission('projet', 'creer'))
                        <a href="{{ route('projet.details.edit', [$projet->id, $detail->id]) }}" 
                            class="btn btn-outline-secondary btn-sm" 
                            title="Modifier">
                            <i class="bi bi-pen"></i>
                        </a>
                        @endif

                        @if(app('permission')->hasPermission('projet', 'supprimer'))
                        <form action="{{ route('projet.details.destroy', [$projet->id, $detail->id]) }}" 
                                method="POST" 
                                class="d-inline"
                                onsubmit="return confirm('Supprimer ce détail ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-outline-danger btn-sm" 
                                    title="Supprimer">
                            <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                        @endif
                        </div>
                    </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                    {{ $details->count() }} détail(s) trouvé(s)
                    </small>
                </div>
                @endif
            </div>
            </div>
        </div>
        </div>

    </main>

    <!-- Modal pour ajouter un événement -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content section_personaliser">
                <div class="modal-header btn-perso">
                    <h5 class="modal-title">Nouvelle Tâche</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="eventForm">
                    @csrf

                    <!-- <input type="hidden" name="event_id" id="event_id" value=""> -->
                    <input type="hidden" name="event_id" id="eventIdForm" value="">
                        
                    <div class="modal-body event-modal">
                        <div class="mb-3">
                            <label class="form-label">Nom du Tache</label>
                            <input type="text" class="form-control interne-input" name="title" required>
                        </div>

                        <!-- Champ caché pour l'ID du projet -->
                        <input type="hidden" name="id_projet" value="{{ $projet->id }}">
                        
                        <!-- Dans votre modal, remplacez les inputs date par datetime-local -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Date et heure début </label>
                                        <input type="datetime-local" class="form-control interne-input" name="date_debut" id="date_debut" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> Date et heure fin </label>
                                        <input type="datetime-local" class="form-control interne-input" name="date_fin" id="date_fin">
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const dateDebut = document.getElementById('date_debut');
                                    const dateFin = document.getElementById('date_fin');
                                    
                                    if (!dateDebut || !dateFin) return;
                                    
                                    dateFin.addEventListener('change', function() {
                                        if (!dateDebut.value || !dateFin.value) return;
                                        
                                        const debut = new Date(dateDebut.value);
                                        const fin = new Date(dateFin.value);
                                        
                                        if (fin <= debut) {
                                            // Formatage des dates pour l'affichage
                                            const formatDate = (dateStr) => {
                                                return dateStr.replace('T', ' à ');
                                            };
                                            
                                            alert(`⛔ DATES INVALIDE ⛔\n\n` +
                                                `La date de fin (${formatDate(dateFin.value)}) \n` +
                                                `doit être après la date de début (${formatDate(dateDebut.value)})\n\n` +
                                                `Veuillez choisir une date de fin plus récente.`);
                                            
                                            // Réinitialiser le champ
                                            dateFin.value = '';
                                            dateFin.focus();
                                        }
                                    });
                                    
                                    // Optionnel : Validation au blur (quand on quitte le champ)
                                    dateFin.addEventListener('blur', function() {
                                        if (!dateDebut.value || !dateFin.value) return;
                                        
                                        if (new Date(dateFin.value) <= new Date(dateDebut.value)) {
                                            alert('⚠️ Attention : La date de fin doit être après la date de début');
                                            dateFin.focus();
                                        }
                                    });
                                });
                            </script>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control interne-input" name="decription" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Couleur</label>
                            <input type="color" class="form-control interne-input" name="color" value="#3788d8">
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
            <div class="modal-content section_personaliser">

                <div class="modal-header btn-perso">
                    <h5 class="modal-title" id="utilisateurModalTitle">Affecter des utilisateurs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="utilisateurForm">
                    @csrf
                    <input type="hidden" id="eventIdForm" name="event_id">
                    <div class="modal-body utilisateur-modal">

                        <div class="mb-3">
                            <label class="form-label">Sélectionner un utilisateur</label>
                            <select class="form-control interne-input" id="utilisateur_select">
                                <option value="">Choisir un utilisateur...</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description de la tâche</label>
                            <textarea class="form-control interne-input" id="description_tache" rows="3" placeholder="Décrivez la tâche de cet utilisateur..."></textarea>
                        </div>
                        
                        <button type="button" class="btn btn-primary btn-sm mb-3" onclick="ajouterUtilisateur()">
                            <i class="bi bi-plus-circle"></i> Ajouter
                        </button>
                        
                        <div class="interne-input" id="selectedUsersContainer">
                            <!-- interne-input -->
                            <h6 class="mb-3">Utilisateurs affectés :</h6>
                            <div class="interne" id="selectedUsersList"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-perso" data-bs-dismiss="modal">Fermer</button>
                        <!-- <button type="button" class="btn btn-primary" onclick="sauvegarderUtilisateurs()">Enregistrer</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Menu contextuel -->
    <div id="contextMenu" class="context-menu">
        <ul>

            @if(app('permission')->hasPermission('projet', 'lire') && app('permission')->hasPermission('projet', 'creer'))
                <li onclick="modifierEvenement()">
                    <i class="bi bi-pencil"></i> Modifier
                </li>
            @endif

            @if(app('permission')->hasPermission('projet', 'lire') && app('permission')->hasPermission('projet', 'creer'))
            <li onclick="affecterUtilisateurs()">
                <i class="bi bi-person-plus"></i> Affecter des utilisateurs
            </li>
            @endif

            @if(app('permission')->hasPermission('projet', 'lire') && app('permission')->hasPermission('projet', 'creer'))
            <li onclick="envoyerNotification()">
                <i class="bi bi-bell"></i> Notifier les utilisateurs
            </li>
            @endif

            @if(app('permission')->hasPermission('projet', 'supprimer'))
            <li onclick="supprimerEvenement()" class="delete">
                <i class="bi bi-trash"></i> Supprimer
            </li>
            @endif
            

        </ul>
    </div>

    

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


  <!-- FullCalendar JS -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>


    <script>
        let calendar;
        let currentEventId = null;
        let utilisateursDisponibles = [];

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var projetId = {{ $projet->id }};
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'yearButton dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },

                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour',
                    list: 'Liste'
                },


                customButtons: {
                    yearButton: {
                        text: 'Année',
                        click: function() {
                            afficherSelecteurAnnee();
                        }
                    }
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
                    
                    //const eventIdInput = this.querySelector('input[name="event_id"]');
                    const eventIdInput = document.getElementById('eventIdForm');

                    // ⭐⭐ AJOUTEZ CET ALERT POUR VOIR ⭐⭐
                    // alert("event_id trouvé: " + (eventIdInput ? "OUI - valeur: " + eventIdInput.value : "NON"));
                    
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

            console.log(" description chargée dans le formulaire:", event.extendedProps.description || '');
            
            document.querySelector('input[name="color"]').value = event.backgroundColor || '#3788d8';
            
            const start = event.start ? event.start.toISOString().slice(0, 16) : '';
            const end = event.end ? event.end.toISOString().slice(0, 16) : '';
            
            document.querySelector('input[name="date_debut"]').value = start;
            document.querySelector('input[name="date_fin"]').value = end;

                const eventIdInput = document.getElementById('eventIdForm');
                if (eventIdInput) {
                    eventIdInput.value = currentEventId;
                    console.log("ID événement défini dans eventIdForm:", currentEventId);
                } else {
                    console.error("Champ eventIdForm non trouvé!");
                }
            
            const modalTitle = document.querySelector('#addEventModal .modal-title');
            if (modalTitle) {
                modalTitle.textContent = 'Modifier la Tâche';
            }

            
            // Vérification visuelle
            console.log("Tous les champs event_id:", document.querySelectorAll('input[name="event_id"]'));
            
            document.getElementById('submitBtn').innerHTML = 'Modifier';
            
            new bootstrap.Modal(document.getElementById('addEventModal')).show();
            document.getElementById('contextMenu').style.display = 'none';
        }



        function affecterUtilisateurs() {
            if (!currentEventId) return;
            
            // Remplir le champ caché avec l'ID de l'événement
            // document.getElementById('event_id').value = currentEventId;

            // ⭐⭐ METTRE À JOUR LES DEUX CHAMPS POUR ÊTRE SÛR ⭐⭐
            const eventIdFormInput = document.getElementById('eventIdForm');
            const eventIdInput = document.getElementById('event_id');
            
            if (eventIdFormInput) {
                eventIdFormInput.value = currentEventId;
            }
            
            if (eventIdInput) {
                eventIdInput.value = currentEventId;
            }



            //  const eventIdInput = document.getElementById('eventIdForm');
            //     if (eventIdInput) {
            //         eventIdInput.value = currentEventId;
            //     }
            
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
            
            if (confirm(' Voulez vous bien supprimer cet tâches ?')) {
                fetch('{{ route("calendrier.destroy", ":id") }}'.replace(':id', currentEventId), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        // alert('Événement supprimé');
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
        // function viderFormulaireNouveau() {
        //     const form = document.getElementById('eventForm');
        //     form.reset();
        //     document.querySelector('input[name="color"]').value = '#3788d8';
            
        //     const eventIdInput = document.getElementById('eventIdForm');
        //     const eventIdInput2 = document.getElementById('event_id');
        //     //const eventIdInput = document.getElementById('event_id');
        //     if (eventIdInput) {
        //         eventIdInput.value = '';
        //         eventIdInput2.value = '';
        //     }
            
        //     document.getElementById('submitBtn').innerHTML = 'Enregistrer';

        // }


        function viderFormulaireNouveau() {
            console.log("=== VIDER FORMULAIRE ===");
            
            const form = document.getElementById('eventForm');
            if (!form) {
                console.error("Formulaire non trouvé!");
                return;
            }
            
            // Réinitialiser le formulaire
            form.reset();
            
            // Réinitialiser la couleur
            const colorInput = document.querySelector('input[name="color"]');
            if (colorInput) {
                colorInput.value = '#3788d8';
            }
            
            // ⭐⭐ UN SEUL CHAMP À VIDER ⭐⭐
            const eventIdInput = document.getElementById('eventIdForm');
            if (eventIdInput) {
                eventIdInput.value = '';
                console.log("Champ eventIdForm vidé");
            }
            
            // Réinitialiser le texte du bouton
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.innerHTML = 'Enregistrer';
            }
            
            console.log("Formulaire vidé avec succès");
        }



        function creationtache(form) {

            console.log("=== DÉBOGAGE creationtache ===");
            console.log("Formulaire reçu:", form);
            console.log("Form elements:", form.elements);

            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');


            // Afficher toutes les données du formulaire
            // console.log("=== DONNÉES DU FORMULAIRE ===");
            // for (let [key, value] of formData.entries()) {
            //     console.log(`${key}:`, value);
            // }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Création...';


            // Vérifier la route
            const route = '{{ route("calendrier.store") }}';
            console.log("Route:", route);
            console.log("CSRF Token:", '{{ csrf_token() }}');

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
                    alert('Tâche créée avec succès!');
                    
                    // Supprimer champ caché si présent (modification)
                    // const eventIdInput = form.querySelector('input[name="event_id"]');
                    // if (eventIdInput) eventIdInput.remove();

                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la création: ' + error.message);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Enregistrer';
            });
        }


        function modifierTache(form) {
            const submitBtn = document.getElementById('submitBtn');
            const title_forme = document
            
            console.log("=== DÉBOGAGE modifierTache ===");
            
            // ⭐⭐ CORRECTION : Utilisez getElementById au lieu de formData.get() ⭐⭐
            const eventIdInput = document.getElementById('eventIdForm'); // ou 'event_id'
            const eventId = eventIdInput ? eventIdInput.value : null;
            
            console.log("ID de l'événement à modifier:", eventId);
            console.log("Input trouvé:", eventIdInput);
            console.log("Valeur de l'input:", eventIdInput ? eventIdInput.value : "non trouvé");
            
            if (!eventId || eventId === '') {
                console.error("ERREUR: event_id est vide ou non trouvé!");
                alert("Erreur: Impossible de modifier - ID de l'événement manquant");
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Enregistrer';
                return;
            }
            
            const formData = new FormData(form);
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Modification...';
            
            // Afficher toutes les données du formulaire
            console.log("=== DONNÉES DU FORMULAIRE ===");
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            formData.append('_method', 'PUT');
            
            fetch(`/calendrier/events/${eventId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
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
            
            const eventId = currentEventId || document.getElementById('eventIdForm').value;
            
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
                        button.closest('.user-item').remove();
                        
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
            
            // ✅ AJOUTER CETTE LIGNE
            return false;
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
            
            // Formater la date
            const eventDate = event.start ? 
                event.start.toLocaleDateString('fr-FR', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : 'Date non définie';

            const eventendDate = event.end ? 
                event.end.toLocaleDateString('fr-FR', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : 'Date non définie';
            
            // Message professionnel
            const messageDefault = `📋 **Nouvelle Tâche Assignée**\n\n` +
                                `**Tâche :** ${event.title}\n` +
                                `**Date prévue :** ${eventDate}\n` +
                                `**Description :** ${event.extendedProps.description || 'Aucune description fournie'}\n\n` +
                                `📍 **Projet :** {{ $projet->non_de_projet ?? 'Phaos' }}\n\n` +
                                `Bonjour,\n\n` +
                                `Une nouvelle tâche vous a été assignée dans le cadre du projet.\n` +
                                `Veuillez vous connecter à l'application pour plus de détails.\n\n` +
                                `Cordialement,\n` +
                                `Équipe Phaos`;
            
            // Créer une modal professionnelle au lieu de prompt()
            const modalHtml = `
                <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content section_personaliser">
                            <div class="modal-header btn-perso">
                                <h5 class="modal-title">
                                    <i class="fas fa-bell me-2"></i>Notification de Tâche
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                            
                                <div class="alert alert-info mb-3 interne">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Cette notification sera envoyée par email à tous les utilisateurs concernés.
                                </div>
                                
                                <div class="event-preview mb-4 p-3 interne">
                                    <h6><i class="fas fa-tasks me-2"></i>${event.title}</h6>
                                    <p class="mb-1"><i class="far fa-calendar me-2"></i><strong>Date Debut:</strong> ${eventDate}</p>
                                    <p class="mb-1"><i class="far fa-calendar-check me-2"></i><strong>Date Fin :</strong> ${eventendDate}</p>
                                    <p class="mb-0"><i class="far fa-file-alt me-2"></i><strong>Description :</strong> ${event.extendedProps.description || 'Non spécifiée'}</p>
                                </div>
                                <!-- SECTION SUPPRIMÉE ICI -->
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-perso" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </button>
                                <button type="button" class="btn btn-primary btn-perso" id="sendNotificationBtn">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer la Notification
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Ajouter la modal au body si elle n'existe pas déjà
            if (!document.getElementById('notificationModal')) {
                document.body.insertAdjacentHTML('beforeend', modalHtml);
            }
            
            // Afficher la modal
            const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));
            notificationModal.show();
            
            // Gérer l'envoi de la notification
            document.getElementById('sendNotificationBtn').onclick = function() {
                // Désactiver le bouton pendant l'envoi
                const sendBtn = document.getElementById('sendNotificationBtn');
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
                
                // Envoyer la notification avec le message fixe
                fetch('/calendrier/notifier/' + currentEventId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: messageDefault,
                        event_id: currentEventId,
                        projetId: '{{ $projet->id }}'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    notificationModal.hide();
                    
                    if (data.success) {
                        showAlert('success', 
                            `<i class="fas fa-check-circle me-2"></i>
                            <strong>Notification envoyée avec succès !</strong><br>
                            <small>
                                ${data.emails_envoyes || 0} email(s) envoyé(s)<br>
                                ${data.logs_emails_enregistres || 0} log(s) enregistré(s)<br>
                                ${data.notifications_crees || 0} notification(s) créée(s)
                            </small>`,
                            5000
                        );
                    } else {
                        showAlert('error', 
                            `<i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Erreur lors de l'envoi</strong><br>
                            <small>${data.message || 'Une erreur est survenue'}</small>`
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notificationModal.hide();
                    showAlert('error', 
                        `<i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Erreur de connexion</strong><br>
                        <small>Veuillez vérifier votre connexion internet</small>`
                    );
                })
                .finally(() => {
                    // Réactiver le bouton
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Envoyer la Notification';
                });
                
                document.getElementById('contextMenu').style.display = 'none';
            };
        }

        // Fonction pour afficher des alertes professionnelles
        function showAlert(type, message, duration = 3000) {
            // Supprimer les alertes existantes
            const existingAlerts = document.querySelectorAll('.custom-alert');
            existingAlerts.forEach(alert => alert.remove());
            
            // Déterminer les styles selon le type
            let bgColor, icon, title;
            switch(type) {
                case 'success':
                    bgColor = 'linear-gradient(135deg, #d4edda, #c3e6cb)';
                    borderColor = '#28a745';
                    icon = 'fas fa-check-circle';
                    title = 'Succès';
                    break;
                case 'error':
                    bgColor = 'linear-gradient(135deg, #f8d7da, #f5c6cb)';
                    borderColor = '#dc3545';
                    icon = 'fas fa-exclamation-triangle';
                    title = 'Erreur';
                    break;
                case 'warning':
                    bgColor = 'linear-gradient(135deg, #fff3cd, #ffeaa7)';
                    borderColor = '#ffc107';
                    icon = 'fas fa-exclamation-circle';
                    title = 'Attention';
                    break;
                case 'info':
                    bgColor = 'linear-gradient(135deg, #d1ecf1, #bee5eb)';
                    borderColor = '#17a2b8';
                    icon = 'fas fa-info-circle';
                    title = 'Information';
                    break;
                default:
                    bgColor = 'linear-gradient(135deg, #d1ecf1, #bee5eb)';
                    borderColor = '#17a2b8';
                    icon = 'fas fa-info-circle';
                    title = 'Information';
            }
            
            // Créer l'alerte
            const alertHtml = `
                <div class="custom-alert" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    min-width: 350px;
                    max-width: 500px;
                    background: ${bgColor};
                    border-left: 4px solid ${borderColor};
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    animation: slideInRight 0.3s ease-out;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
                ">
                    <div class="d-flex align-items-start">
                        <div style="margin-right: 15px; font-size: 24px; color: ${borderColor};">
                            <i class="${icon}"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                                <h6 style="margin: 0; font-weight: 600; color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : type === 'warning' ? '#856404' : '#0c5460'};">
                                    ${title}
                                </h6>
                                <button type="button" class="close-alert" style="
                                    background: none;
                                    border: none;
                                    font-size: 18px;
                                    cursor: pointer;
                                    color: #666;
                                    padding: 0;
                                    line-height: 1;
                                ">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div style="color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : type === 'warning' ? '#856404' : '#0c5460'}; font-size: 14px; line-height: 1.5;">
                                ${message}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Ajouter l'alerte au body
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            // Ajouter l'animation CSS
            if (!document.querySelector('#alert-animation')) {
                const style = document.createElement('style');
                style.id = 'alert-animation';
                style.textContent = `
                    @keyframes slideInRight {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    
                    @keyframes fadeOut {
                        from {
                            opacity: 1;
                        }
                        to {
                            opacity: 0;
                        }
                    }
                    
                    .custom-alert.fade-out {
                        animation: fadeOut 0.3s ease-out forwards;
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Fermer l'alerte au clic sur la croix
            const alertElement = document.querySelector('.custom-alert');
            const closeBtn = alertElement.querySelector('.close-alert');
            
            closeBtn.onclick = function() {
                alertElement.classList.add('fade-out');
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.parentNode.removeChild(alertElement);
                    }
                }, 300);
            };
            
            // Fermer automatiquement après la durée
            if (duration > 0) {
                setTimeout(() => {
                    if (alertElement.parentNode) {
                        alertElement.classList.add('fade-out');
                        setTimeout(() => {
                            if (alertElement.parentNode) {
                                alertElement.parentNode.removeChild(alertElement);
                            }
                        }, 300);
                    }
                }, duration);
            }
        }





        // ============ FONCTIONS POUR LE SELECTEUR D'ANNÉE ============
        // Fonction pour afficher le sélecteur d'année
        function afficherSelecteurAnnee() {
            const currentDate = calendar.getDate();
            const currentYear = currentDate.getFullYear();
            
            // Créer une modal pour sélectionner l'année
            const modalHtml = `
                <div class="modal fade" id="yearSelectorModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <div class="modal-header" style="background: linear-gradient(135deg, #000, #b15d15); color: white;">
                                <h5 class="modal-title">
                                    <i class="fas fa-calendar-alt me-2"></i>Sélectionner une année
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2" id="yearButtonsContainer">
                                    <!-- Les boutons d'année seront générés ici -->
                                </div>
                                <div class="mt-3">
                                    <div class="input-group">
                                        <input type="number" 
                                            class="form-control" 
                                            id="customYearInput" 
                                            min="2000" 
                                            max="2100" 
                                            value="${currentYear}"
                                            placeholder="Année">
                                        <button class="btn btn-primary" id="goToCustomYear">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Fermer
                                </button>
                                <button type="button" class="btn btn-primary" onclick="goToCurrentYear()" style="background: linear-gradient(135deg, #000, #b15d15); border: none;">
                                    <i class="fas fa-home me-2"></i>Année actuelle
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Ajouter la modal au body si elle n'existe pas
            if (!document.getElementById('yearSelectorModal')) {
                document.body.insertAdjacentHTML('beforeend', modalHtml);
            }
            
            const modalElement = document.getElementById('yearSelectorModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            
            // Générer les boutons d'année
            const container = document.getElementById('yearButtonsContainer');
            container.innerHTML = '';
            
            // Générer les années (5 avant, 5 après l'année actuelle)
            const startYear = currentYear - 5;
            const endYear = currentYear + 5;
            
            for (let year = startYear; year <= endYear; year++) {
                const isCurrent = year === currentYear;
                const col = document.createElement('div');
                col.className = 'col-4';
                col.innerHTML = `
                    <button type="button" 
                            class="btn ${isCurrent ? 'btn-primary' : 'btn-outline-primary'} w-100 mb-2" 
                            onclick="goToYear(${year})"
                            style="${isCurrent ? 'background: linear-gradient(135deg, #000, #b15d15); border: none;' : ''}">
                        ${year}${isCurrent ? ' <small>(actuelle)</small>' : ''}
                    </button>
                `;
                container.appendChild(col);
            }
            
            // Gérer l'entrée personnalisée
            document.getElementById('goToCustomYear').onclick = function() {
                const customYear = parseInt(document.getElementById('customYearInput').value);
                if (customYear >= 2000 && customYear <= 2100) {
                    goToYear(customYear);
                    modal.hide();
                } else {
                    alert('Veuillez entrer une année entre 2000 et 2100');
                }
            };
            
            // Permettre Entrée pour valider
            document.getElementById('customYearInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('goToCustomYear').click();
                }
            });
            
            // Nettoyer la modal lorsqu'elle est fermée
            modalElement.addEventListener('hidden.bs.modal', function () {
                modalElement.remove();
            });
        }

        // Fonction pour aller à une année spécifique
        function goToYear(year) {
            const currentDate = calendar.getDate();
            const newDate = new Date(year, currentDate.getMonth(), 1);
            calendar.gotoDate(newDate);
            
            // Fermer la modal si elle est ouverte
            const modalElement = document.getElementById('yearSelectorModal');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) modal.hide();
            }
        }

        // Fonction pour revenir à l'année actuelle
        function goToCurrentYear() {
            calendar.today();
            goToYear(new Date().getFullYear());
        }

    </script>

</body>
</html>