<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Validations</title>
    
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
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    
    <style>
        .project-header {
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .file-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        
        .file-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .file-icon {
            font-size: 2rem;
            color: #4e54c8;
        }
        
        .action-buttons {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 15px;
            border-top: 1px solid #dee2e6;
            z-index: 1000;
        }
    </style>
</head>
<body>
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="p-3">
            <div class="container-fluid">
                <!-- En-tête du projet -->
                <div class="project-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h2 class="mb-2">
                                <i class="bi bi-folder me-2"></i>
                                {{ $projet->titre }}
                            </h2>
                            <p class="mb-0">
                                <strong>Numéro :</strong> {{ $projet->numero_projet }}
                                | <strong>Créé le :</strong> {{ date('d/m/Y', strtotime($projet->created_at)) }}
                            </p>
                        </div>
                        <div>
                            <span class="badge first-step-badge">
                                <i class="bi bi-1-circle me-1"></i> Première étape
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons d'action -->
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('validation.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    @if($validationEnAttente)
                    <a href="{{ route('validation.show', $validationEnAttente->id) }}" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Valider ce projet
                    </a>
                    @endif
                </div>
                
                <!-- Détails du projet -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Description du projet
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h6>Description :</h6>
                                    <p>{{ $projet->description ?? 'Aucune description' }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Objectif :</h6>
                                    <p>{{ $projet->objectif ?? 'Aucun objectif spécifié' }}</p>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6>Date de début :</h6>
                                            <p>{{ $projet->date_debu ? date('d/m/Y', strtotime($projet->date_debu)) : 'Non définie' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6>Date de fin :</h6>
                                            <p>{{ $projet->date_fin ? date('d/m/Y', strtotime($projet->date_fin)) : 'Non définie' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-people me-2"></i>
                                    Information étape
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($projet->workflows->first())
                                <div class="mb-3">
                                    <h6>Étape actuelle :</h6>
                                    <p class="text-primary fw-bold">{{ $projet->workflows->first()->nom_etape }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6>Date d'arrivée :</h6>
                                    <p>{{ date('d/m/Y H:i', strtotime($projet->workflows->first()->date_arriver)) }}</p>
                                </div>
                                
                                @if($projet->workflows->first()->commentaires)
                                <div class="alert alert-info">
                                    <small>
                                        <i class="bi bi-chat-left-text me-1"></i>
                                        <strong>Commentaire :</strong> {{ $projet->workflows->first()->commentaires }}
                                    </small>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Fichiers joints -->
                @if($projet->details->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-paperclip me-2"></i>
                            Fichiers joints ({{ $projet->details->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($projet->details as $detail)
                            <div class="col-md-6 mb-3">
                                <div class="file-card">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            <i class="bi {{ $detail->file_icon }} file-icon"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $detail->nom }}</h6>
                                            @if($detail->description)
                                            <p class="text-muted mb-2 small">{{ Str::limit($detail->description, 100) }}</p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-light text-dark">
                                                    {{ strtoupper($detail->file_extension) }}
                                                </span>
                                                <a href="{{ $detail->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download me-1"></i> Télécharger
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Aucun fichier joint à ce projet.
                </div>
                @endif
                
                <!-- Zone d'action fixe en bas -->
                @if($validationEnAttente)
                <div class="action-buttons">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('validation.show', $validationEnAttente->id) }}" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle me-1"></i> Valider ce projet
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </main>

    @include('page.footer')
    
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>