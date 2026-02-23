

<!DOCTYPE html>     
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


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= header ======= -->
    @include('page.header')

  <!-- ======= Sidebar ======= -->
   @include('layouts.sidebar')

<main id="main" class="main">
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('projets.index') }}">Projets</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lancement.index', $projet->id) }}">{{ $projet->non_de_projet }}</a></li>
                    <li class="breadcrumb-item active">{{ $lancement->nom }}</li>
                </ol>
            </nav>
            
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-list-ul text-primary me-2"></i>
                    Détails - {{ $lancement->nom }}
                </h1>
                <a href="{{ route('lancement.details.create', [$projet->id, $lancement->id]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Ajouter un détail
                </a>
            </div>
        </div>
    </div>

    @if($details->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun détail</h5>
                <a href="{{ route('lancement.details.create', [$projet->id, $lancement->id]) }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Ajouter un détail
                </a>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Fichier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                            <tr>
                                <td>{{ $detail->nom }}</td>
                                <td>{{ Str::limit($detail->description, 50) }}</td>
                                <td>
                                    @if($detail->file)
                                        <a href="{{ route('lancement.details.download', [$projet->id, $lancement->id, $detail->id]) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>
                                            {{ $detail->file_name }}
                                        </a>
                                    @else
                                        <span class="text-muted">Aucun fichier</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('lancement.details.destroy', [$projet->id, $lancement->id, $detail->id]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Supprimer ce détail ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
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

</body>

</html>

