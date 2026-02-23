<!-- Vue complète pour voir le projet à valider -->
<!DOCTYPE html>
<html>
<head>
    
    <!-- Head standard -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Créer un Nouveau Projet</title>
    
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

</head>
<body>
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="p-3">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- En-tête -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="bi bi-folder me-2"></i>
                                        Projet à valider : {{ $projet->titre }}
                                    </h5>
                                    <div class="badge bg-info">
                                        Étape : {{ $validation->etape }}
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('validation.show', $validation->id) }}" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Procéder à la validation
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Informations du projet -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6><i class="bi bi-info-circle me-2"></i>Informations</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Numéro :</th>
                                                    <td>{{ $projet->numero_projet }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Titre :</th>
                                                    <td>{{ $projet->titre }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Description :</th>
                                                    <td>{{ $projet->description ?? 'Non renseignée' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Objectif :</th>
                                                    <td>{{ $projet->objectif ?? 'Non renseigné' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6><i class="bi bi-calendar me-2"></i>Dates</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Début projet :</th>
                                                    <td>{{ $projet->date_debu ? date('d/m/Y', strtotime($projet->date_debu)) : 'Non définie' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fin projet :</th>
                                                    <td>{{ $projet->date_fin ? date('d/m/Y', strtotime($projet->date_fin)) : 'Non définie' }}</td>
                                                </tr>
                                                @if($validation->workflow)
                                                    <tr>
                                                        <th>Début étape :</th>
                                                        <td>{{ date('d/m/Y', strtotime($validation->workflow->date_arriver)) }}</td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Fichiers du projet -->
                            @if($projet->details && $projet->details->count() > 0)
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3">
                                            <i class="bi bi-paperclip me-2"></i>
                                            Fichiers joints au projet
                                        </h6>
                                        <div class="row">
                                            @foreach($projet->details as $detail)
                                                <div class="col-md-4 mb-3">
                                                    <div class="file-preview">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-file-earmark fs-3 text-primary me-3"></i>
                                                            <div>
                                                                <strong class="d-block">{{ $detail->nom }}</strong>
                                                                <small class="text-muted">{{ $detail->description }}</small>
                                                                <br>
                                                                <div class="mt-2">
                                                                    <a href="{{ route('projet.travailler.details.download', [$projet->id, $detail->id]) }}" 
                                                                       class="btn btn-sm btn-outline-primary" target="_blank">
                                                                        <i class="bi bi-download me-1"></i> Télécharger
                                                                    </a>
                                                                    @if($detail->file_extension == 'pdf' || in_array($detail->file_extension, ['jpg', 'jpeg', 'png']))
                                                                        <a href="{{ $detail->file_url }}" 
                                                                           class="btn btn-sm btn-outline-info ms-1" 
                                                                           target="_blank">
                                                                            <i class="bi bi-eye me-1"></i> Visualiser
                                                                        </a>
                                                                    @endif
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
                                    Aucun fichier n'a été joint à ce projet.
                                </div>
                            @endif
                            
                            <!-- Bouton de validation -->
                            <div class="text-center mt-4">
                                <a href="{{ route('validation.show', $validation->id) }}" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i> Commencer la validation de ce projet
                                </a>
                                <p class="text-muted mt-2">
                                    <small>Vous pourrez ajouter votre commentaire et des fichiers lors de la validation</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>