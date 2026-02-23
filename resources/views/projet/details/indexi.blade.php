<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Détails du Projet - {{ $projet->non_de_projet }} - Cabinet PHAOS</title>
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
        /* Styles pour la page unifiée */
        .project-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .project-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: translate(50px, -50px);
        }
        
        .info-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 2px solid #3498db;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            color: #3498db;
        }
        
        .progress-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .calendar-event-mini {
            border-left: 4px solid #3498db;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .calendar-event-mini:hover {
            background: #e3f2fd;
            transform: translateX(5px);
        }
        
        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease;
        }
        
        .file-item:hover {
            background: #f8f9fa;
        }
        
        .file-icon {
            font-size: 24px;
            margin-right: 15px;
            color: #3498db;
        }
        
        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-action i {
            font-size: 1rem;
        }
        
        .btn-calendar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        
        .btn-calendar:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-add-file {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
        }
        
        .btn-add-file:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        
        .badge-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #3498db;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -23px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #3498db;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #3498db;
        }
    </style>
</head>

<body>
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <!-- En-tête du projet -->
        <div class="project-header">
            <div class="d-flex justify-content-between align-items-start">
                <div style="position: relative; z-index: 2;">
                    <h1 class="h3 mb-2 text-white-50">
                        <i class="bi bi-clipboard-data"></i>
                        Détails du Projet
                    </h1>
                    <h2 class="h1 mb-3 text-white">{{ $projet->non_de_projet }}</h2>
                    
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        @if($projet->date_fin && now()->gt($projet->date_fin) && ($projet->avancement ?? 0) < 100)
                        <span class="badge bg-warning">
                            <i class="bi bi-exclamation-triangle"></i> En retard
                        </span>
                        @endif
                        
                        @if(($projet->avancement ?? 0) == 100)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle"></i> Terminé
                        </span>
                        @endif
                        
                        <span class="badge bg-info">
                            <i class="bi bi-calendar"></i>
                            {{ $projet->date_debut ? $projet->date_debut->format('d/m/Y') : 'Sans date' }}
                        </span>
                    </div>
                </div>
                
                <div style="position: relative; z-index: 2;">
                    <div class="btn-group">
                        <a href="{{ route('projets.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                        
                        @if(app('permission')->hasPermission('projet', 'modifier'))
                        <a href="{{ route('projets.edit', $projet->id) }}" class="btn btn-outline-light">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        @endif
                        
                        @if(app('permission')->hasPermission('projet', 'supprimer'))
                        <button onclick="confirmDeleteProjet()" class="btn btn-outline-light">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Colonne gauche - Informations principales -->
            <div class="col-lg-8">
                <!-- Informations du projet -->
                <div class="card info-card">
                    <div class="card-header card-header-custom">
                        <h5 class="section-title">
                            <i class="bi bi-info-circle"></i> Informations du projet
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small mb-1">Nom du projet</label>
                                <div class="p-3 bg-light rounded">{{ $projet->non_de_projet }}</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small mb-1">Client</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $projet->client->nom ?? 'Non spécifié' }}
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label text-muted small mb-1">Description</label>
                                <div class="p-3 bg-light rounded" style="min-height: 120px;">
                                    {{ $projet->description ?? 'Aucune description fournie' }}
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small mb-1">Responsable</label>
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        @if($projet->responsable && $projet->responsable->photo)
                                        <img src="{{ asset('storage/' . $projet->responsable->photo) }}" 
                                             class="user-avatar me-2">
                                        @else
                                        <div class="user-avatar bg-primary text-white d-flex align-items-center justify-content-center me-2">
                                            @if($projet->responsable)
                                            {{ substr($projet->responsable->name, 0, 1) }}
                                            @else
                                            ?
                                            @endif
                                        </div>
                                        @endif
                                        <span>{{ $projet->responsable->name ?? 'Non assigné' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small mb-1">Dates du projet</label>
                                <div class="p-3 bg-light rounded">
                                    <div class="timeline">
                                        <div class="timeline-item">
                                            <strong><i class="bi bi-calendar-plus"></i> Début :</strong>
                                            {{ $projet->date_debut ? $projet->date_debut->format('d/m/Y') : 'Non définie' }}
                                        </div>
                                        <div class="timeline-item">
                                            <strong><i class="bi bi-calendar-check"></i> Fin prévue :</strong>
                                            {{ $projet->date_fin ? $projet->date_fin->format('d/m/Y') : 'Non définie' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Utilisateurs assignés et Avancement -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card info-card h-100">
                            <div class="card-header card-header-custom">
                                <h5 class="section-title">
                                    <i class="bi bi-people"></i> Équipe assignée
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-3">
                                    @forelse($projet->users as $user)
                                    <div class="d-flex flex-column align-items-center text-center">
                                        @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" 
                                             class="user-avatar mb-2">
                                        @else
                                        <div class="user-avatar bg-secondary text-white d-flex align-items-center justify-content-center mb-2">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        @endif
                                        <small class="text-muted">{{ $user->name }}</small>
                                    </div>
                                    @empty
                                    <div class="text-center w-100 py-3">
                                        <i class="bi bi-person-x text-muted" style="font-size: 2rem;"></i>
                                        <p class="text-muted mt-2">Aucun utilisateur assigné</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card info-card h-100">
                            <div class="card-header card-header-custom">
                                <h5 class="section-title">
                                    <i class="bi bi-speedometer2"></i> Avancement
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="progress-container">
                                    @php
                                        $progress = $projet->avancement ?? 0;
                                        $color = $progress < 30 ? 'danger' : ($progress < 70 ? 'warning' : 'success');
                                    @endphp
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="h5 mb-0">{{ $progress }}%</span>
                                        <span class="badge bg-{{ $color }} badge-status">
                                            @if($progress < 30)
                                                Début
                                            @elseif($progress < 70)
                                                En cours
                                            @elseif($progress < 100)
                                                Finalisation
                                            @else
                                                Terminé
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-{{ $color }} progress-bar-striped progress-bar-animated" 
                                             role="progressbar" 
                                             style="width: {{ $progress }}%"
                                             aria-valuenow="{{ $progress }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    
                                    @if($projet->date_fin)
                                    <div class="mt-3 text-center">
                                        @php
                                            $today = now();
                                            $end = $projet->date_fin;
                                            $totalDays = $projet->date_debut ? $projet->date_debut->diffInDays($end) : 0;
                                            $daysPassed = $projet->date_debut ? $projet->date_debut->diffInDays($today) : 0;
                                            $daysLeft = $today->diffInDays($end, false);
                                        @endphp
                                        
                                        @if($daysLeft < 0 && $progress < 100)
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-triangle"></i> 
                                            Retard de {{ abs($daysLeft) }} jour(s)
                                        </span>
                                        @elseif($daysLeft >= 0)
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i>
                                            {{ $daysLeft }} jour(s) restant(s)
                                        </small>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendrier - Aperçu -->
                <div class="card info-card">
                    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">
                            <i class="bi bi-calendar-week"></i> Calendrier du projet
                        </h5>
                        <a href="{{ route('calendrier.projet.show', $projet->id) }}" 
                           class="btn btn-calendar btn-action">
                            <i class="bi bi-calendar2-week"></i> Calendrier complet
                        </a>
                    </div>
                    <div class="card-body">
                        @if($calendriers->isEmpty())
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2">Aucun événement au calendrier</p>
                                <a href="{{ route('calendrier.projet.show', $projet->id) }}" 
                                   class="btn btn-sm btn-primary mt-2">
                                    <i class="bi bi-plus-circle"></i> Ajouter le premier événement
                                </a>
                            </div>
                        @else
                            <div class="row mb-4">
                                @foreach(['total_calendrier', 'prochains', 'termines'] as $statKey)
                                <div class="col-md-4 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-number">{{ $stats[$statKey] }}</div>
                                        <div class="stat-label">
                                            @if($statKey == 'total_calendrier')
                                                Total événements
                                            @elseif($statKey == 'prochains')
                                                À venir
                                            @else
                                                Terminés
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <h6 class="mb-3">Prochains événements :</h6>
                            @foreach($calendriers->where('date_debut', '>=', now())->take(3) as $event)
                            <div class="calendar-event-mini" 
                                 onclick="window.location.href='{{ route('calendrier.projet.show', $projet->id) }}'"
                                 style="border-left-color: {{ $event->color ?? '#3788d8' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong>{{ $event->title }}</strong>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($event->date_debut)->format('d/m H:i') }}
                                    </small>
                                </div>
                                @if($event->decription)
                                <p class="mb-1 small text-muted">{{ Str::limit($event->decription, 60) }}</p>
                                @endif
                            </div>
                            @endforeach
                            
                            @if($calendriers->count() > 3)
                            <div class="text-center mt-3">
                                <a href="{{ route('calendrier.projet.show', $projet->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                    Voir les {{ $calendriers->count() }} événements
                                </a>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Colonne droite - Documents et Fichiers -->
            <div class="col-lg-4">
                <!-- Statistiques fichiers -->
                <div class="row mb-4">
                    <div class="col-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-number">{{ $stats['total_fichiers'] }}</div>
                            <div class="stat-label">Fichiers</div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-number">{{ $stats['fichiers_recents'] }}</div>
                            <div class="stat-label">7 derniers jours</div>
                        </div>
                    </div>
                </div>
                
                <!-- Documents du projet -->
                <div class="card info-card">
                    <div class="card-header card-header-custom d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">
                            <i class="bi bi-files"></i> Documents
                        </h5>
                        @if(app('permission')->hasPermission('projet', 'creer'))
                        <button type="button" 
                                class="btn btn-add-file btn-action" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addDocumentModal">
                            <i class="bi bi-plus"></i> Ajouter
                        </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        @if($details->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-folder-x text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mt-2">Aucun document</p>
                                @if(app('permission')->hasPermission('projet', 'creer'))
                                <button type="button" 
                                        class="btn btn-sm btn-primary mt-2"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#addDocumentModal">
                                    <i class="bi bi-plus-circle"></i> Ajouter un fichier
                                </button>
                                @endif
                            </div>
                        @else
                            <div style="max-height: 400px; overflow-y: auto;">
                                @foreach($details as $detail)
                                <div class="file-item">
                                    <i class="bi bi-file-earmark-text file-icon"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $detail->nom }}</h6>
                                        <p class="mb-1 small text-muted">
                                            {{ Str::limit($detail->description, 40) }}
                                        </p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar"></i>
                                            {{ $detail->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        @if($detail->file)
                                        <a href="{{ route('projet.details.download', [$projet->id, $detail->id]) }}" 
                                           class="btn btn-outline-primary" 
                                           title="Télécharger">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        @endif
                                        @if(app('permission')->hasPermission('projet', 'supprimer'))
                                        <button type="button" 
                                                class="btn btn-outline-danger"
                                                onclick="deleteDocument({{ $detail->id }}, '{{ addslashes($detail->nom) }}')"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="p-3 border-top">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    {{ $details->count() }} document(s) au total
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Actions rapides -->
                <div class="card info-card">
                    <div class="card-header card-header-custom">
                        <h5 class="section-title">
                            <i class="bi bi-lightning"></i> Actions rapides
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('calendrier.projet.show', $projet->id) }}" 
                               class="btn btn-outline-primary">
                               <i class="bi bi-calendar-plus"></i> Nouvel événement
                            </a>
                            
                            @if(app('permission')->hasPermission('projet', 'creer'))
                            <button type="button" 
                                    class="btn btn-outline-success"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#addDocumentModal">
                                <i class="bi bi-file-earmark-plus"></i> Nouveau document
                            </button>
                            @endif
                            
                            <a href="{{ route('projet.details.index', $projet->id) }}" 
                               class="btn btn-outline-info">
                               <i class="bi bi-list-ul"></i> Tous les détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('page.footer')

    <!-- Modal pour ajouter un document -->
    @if(app('permission')->hasPermission('projet', 'creer'))
    <div class="modal fade" id="addDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-plus"></i> Ajouter un document
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('projet.details.store', $projet->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_projet_demare" value="{{ $projet->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du document *</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Fichier *</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png" required>
                            <small class="text-muted">Formats acceptés : PDF, Word, Excel, PowerPoint, images, texte</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        // Fonction pour supprimer un document
        function deleteDocument(detailId, documentName) {
            if (confirm(`Supprimer le document "${documentName}" ? Cette action est irréversible.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/projet/details/{{ $projet->id }}/${detailId}`;
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Fonction pour confirmer la suppression du projet
        function confirmDeleteProjet() {
            if (confirm(`Supprimer le projet "{{ $projet->non_de_projet }}" ?\n\n⚠️ Cette action supprimera également :\n- Tous les documents associés\n- Tous les événements du calendrier\n- L'historique du projet\n\nCette action est irréversible.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("projets.destroy", $projet->id) }}';
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        // Fonction pour supprimer un événement du calendrier
        function deleteCalendarEvent(eventId, eventTitle) {
            if (confirm(`Supprimer l'événement "${eventTitle}" ?`)) {
                fetch(`/calendrier/${eventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Événement supprimé avec succès');
                        location.reload();
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
        
        // Initialisation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Animation pour les cartes au chargement
            const cards = document.querySelectorAll('.info-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>