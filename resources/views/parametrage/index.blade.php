<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Paramètres - Cabinet PHAOS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo-phaos.webp') }}" rel="icon">
    <link href="{{ asset('assets/img/logo-phaos.webp') }}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #000, #b15d15);
            --primary-orange: #b15d15;
        }

        .param-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 25px;
        }

        .tab-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 15px 20px;
            margin-bottom: 0;
        }

        .tab-content {
            padding: 20px;
            border: 1px solid #e9ecef;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }

        .nav-tabs {
            border-bottom: 3px solid #dee2e6;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 25px;
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: var(--primary-orange);
            background: rgba(177, 93, 21, 0.05);
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-orange);
            background: white;
            border-bottom: 3px solid var(--primary-orange);
        }

        .entity-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .entity-card:hover {
            border-color: var(--primary-orange);
            box-shadow: 0 3px 10px rgba(177, 93, 21, 0.1);
            transform: translateY(-2px);
        }

        .entity-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .entity-title {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            margin: 0;
        }

        .entity-id {
            background: #f8f9fa;
            color: #666;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .entity-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .btn-custom {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(177, 93, 21, 0.3);
            color: white;
        }

        .btn-outline-custom {
            color: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        .btn-outline-custom:hover {
            background: var(--primary-orange);
            color: white;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 25px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .stats-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background: #f8f9fa;
            margin-bottom: 15px;
        }

        .stats-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin-bottom: 5px;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .modal-header-custom {
            background: var(--primary-gradient);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }
    </style>
</head>

<body>
    
    @include('page.header')
    @include('layouts.sidebar')
    
    <main id="main" class="main">
        <div class="p-3">
            <div class="param-container">

                <h2 class="tab-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-gear me-2"></i>Panel d'Administration
                    </span>
                    <a href="http://127.0.0.1:8000/themes" class="btn btn-outline-primary btn-perso">
                        <i class="bi bi-palette me-2"></i>Modifier le thème
                    </a>
                </h2>
                
                <!-- Onglets -->
                <ul class="nav nav-tabs mt-4" id="paramTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="type-projet-tab" data-bs-toggle="tab" 
                                data-bs-target="#type-projet" type="button" role="tab">
                            <i class="bi bi-folder me-2"></i>Types de Projet
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="type-intervention-tab" data-bs-toggle="tab"
                                data-bs-target="#type-intervention" type="button" role="tab">
                            <i class="bi bi-tools me-2"></i>Types d'Intervention
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="categorie-tab" data-bs-toggle="tab" 
                                data-bs-target="#categorie" type="button" role="tab">
                            <i class="bi bi-tags me-2"></i>Catégories
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="categorie-tab" data-bs-toggle="tab" 
                                data-bs-target="#client" type="button" role="tab">
                            <i class="bi bi-tags me-2"></i>Clients
                        </button>
                    </li>

                </ul>

                <!-- Contenu des onglets -->
                <div class="tab-content" id="paramTabsContent">
                    <!-- Onglet Types de Projet -->
                    <div class="tab-pane fade show active" id="type-projet" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" class="form-control" id="searchTypeProjet" 
                                           placeholder="Rechercher un type de projet...">
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                        data-bs-target="#modalTypeProjet" onclick="resetTypeProjetForm()">
                                    <i class="bi bi-plus-circle me-2"></i>Nouveau Type
                                </button>
                            </div>
                        </div>

                        <!-- Statistiques -->

                        <!-- <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="typeProjetTotal">0</div>
                                    <div class="stats-label">Total</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="typeProjetWithDesc">0</div>
                                    <div class="stats-label">Avec description</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="typeProjetWithoutDesc">0</div>
                                    <div class="stats-label">Sans description</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Liste -->
                        <div id="typeProjetList">
                            <!-- Contenu chargé via AJAX -->
                            <div class="empty-state">
                                <i class="bi bi-folder"></i>
                                <p>Chargement des types de projet...</p>
                            </div>
                        </div>
                    </div>




                    <!-- Onglet Types d'Intervention -->
                    <div class="tab-pane fade" id="type-intervention" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" class="form-control" id="searchTypeIntervention" 
                                           placeholder="Rechercher un type d'intervention...">
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                        data-bs-target="#modalTypeIntervention" onclick="resetTypeInterventionForm()">
                                    <i class="bi bi-plus-circle me-2"></i>Nouveau Type
                                </button>
                            </div>
                        </div>

                        <!-- Statistiques -->
                        <!-- <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="stats-card">
                                    <div class="stats-number" id="typeInterventionTotal">0</div>
                                    <div class="stats-label">Total</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="stats-card">
                                    <div class="stats-number" id="typeInterventionWithDesc">0</div>
                                    <div class="stats-label">Avec description</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Liste -->
                        <div id="typeInterventionList">
                            <!-- Contenu chargé via AJAX -->
                            <div class="empty-state">
                                <i class="bi bi-tools"></i>
                                <p>Chargement des types d'intervention...</p>
                            </div>
                        </div>
                    </div>



                    <!-- Onglet Catégories -->
                    <div class="tab-pane fade" id="categorie" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" class="form-control" id="searchCategorie" 
                                           placeholder="Rechercher une catégorie...">
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                        data-bs-target="#modalCategorie" onclick="resetCategorieForm()">
                                    <i class="bi bi-plus-circle me-2"></i>Nouvelle Catégorie
                                </button>
                            </div>
                        </div>

                        <!-- Statistiques -->


                        <!-- <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="categorieTotal">0</div>
                                    <div class="stats-label">Total</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="categorieWithDesc">0</div>
                                    <div class="stats-label">Avec description</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="categorieWithoutDesc">0</div>
                                    <div class="stats-label">Sans description</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Liste -->
                        <div id="categorieList">
                            <!-- Contenu chargé via AJAX -->
                            <div class="empty-state">
                                <i class="bi bi-tags"></i>
                                <p>Chargement des catégories...</p>
                            </div>
                        </div>
                    </div>


                    <!-- Onglet Client -->
                    <div class="tab-pane fade" id="client" role="tabpanel">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" class="form-control" id="searchClient" 
                                        placeholder="Rechercher un interlocuteur client...">
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-custom" data-bs-toggle="modal" 
                                        data-bs-target="#modalClient" onclick="resetClientForm()">
                                    <i class="bi bi-plus-circle me-2"></i>Nouvel Interlocuteur
                                </button>
                            </div>
                        </div>

                        <!-- Statistiques -->

                        <!-- <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="clientTotal">0</div>
                                    <div class="stats-label">Total Interlocuteurs</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="clientWithNumero">0</div>
                                    <div class="stats-label">Avec numéro</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <div class="stats-number" id="clientWithoutNumero">0</div>
                                    <div class="stats-label">Sans numéro</div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Liste -->
                        <div id="clientList">
                            <!-- Contenu chargé via AJAX -->
                            <div class="empty-state">
                                <i class="bi bi-people"></i>
                                <p>Chargement des interlocuteurs clients...</p>
                            </div>
                        </div>
                    </div>
                </div>


        


            </div>
        </div>
    </main>

    @include('page.footer')

    <!-- Modal Type de Projet -->
    <div class="modal fade" id="modalTypeProjet" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalTypeProjetTitle">
                        <i class="bi bi-folder me-2"></i>Nouveau Type de Projet
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formTypeProjet">
                    @csrf
                    <input type="hidden" id="typeProjetId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="typeProjetNom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="typeProjetNom" name="nom" required 
                                   maxlength="250" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="typeProjetDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="typeProjetDescription" name="description" 
                                      rows="3" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-custom" id="submitTypeProjet">
                            <span id="typeProjetBtnText">Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Type d'Intervention -->
    <div class="modal fade" id="modalTypeIntervention" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalTypeInterventionTitle">
                        <i class="bi bi-tools me-2"></i>Nouveau Type d'Intervention
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formTypeIntervention">
                    @csrf
                    <input type="hidden" id="typeInterventionId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="typeInterventionNom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="typeInterventionNom" name="nom" required 
                                   maxlength="250" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="typeInterventionDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="typeInterventionDescription" name="description" 
                                      rows="3" placeholder="Description optionnelle..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-custom" id="submitTypeIntervention">
                            <span id="typeInterventionBtnText">Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Catégorie -->
    <div class="modal fade" id="modalCategorie" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalCategorieTitle">
                        <i class="bi bi-tags me-2"></i>Nouvelle Catégorie
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCategorie">
                    @csrf
                    <input type="hidden" id="categorieId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categorieNom" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="categorieNom" name="nom" required 
                                   maxlength="250" placeholder="Ex: Projet Interne">
                        </div>
                        <div class="mb-3">
                            <label for="categorieDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categorieDescription" name="description" 
                                      rows="3" placeholder="Description optionnelle..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-custom" id="submitCategorie">
                            <span id="categorieBtnText">Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Client Interlocuteur -->
    <div class="modal fade" id="modalClient" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="modalClientTitle">
                        <i class="bi bi-person-plus me-2"></i>Nouvel Interlocuteur Client
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formClient">
                    @csrf
                    <input type="hidden" id="clientId" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_client_select" class="form-label required">Client</label>
                                <select class="form-select" id="id_client_select" name="id_client" required>
                                    <option value="">Sélectionnez un client...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client['id'] }}">
                                            {{ $client['name'] }} ({{ $client['name_alias'] ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="clientNom" class="form-label required">Nom de l'interlocuteur</label>
                                <input type="text" class="form-control" id="clientNom" name="nom_interlocuteur" required 
                                    maxlength="150" placeholder="Ex: Jean Dupont">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="clientFonction" class="form-label required">Fonction</label>
                                <input type="text" class="form-control" id="clientFonction" name="fonction" required 
                                    maxlength="150" placeholder="Ex: Chef de projet">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="clientEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="clientEmail" name="email" 
                                    maxlength="250" placeholder="exemple@entreprise.com">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="clientLieuOperation" class="form-label">Lieu d'opération</label>
                                <input type="text" class="form-control" id="clientLieuOperation" name="lieu_operation" 
                                    maxlength="250" placeholder="Ex: Site principal, Bâtiment A">
                            </div>
                        </div>

                        <!-- Section Numéros de téléphone -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Numéros de téléphone</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="numeroInput" 
                                        maxlength="10" placeholder="0123456789 (10 chiffres)" 
                                        onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
                                    <button type="button" class="btn btn-outline-custom" onclick="addNumeroToList()">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                                <small class="text-muted">Format: 10 chiffres sans espace (ex: 0123456789)</small>
                            </div>
                        </div>

                        <!-- Liste des numéros -->
                        <div class="mb-3">
                            <label class="form-label">Liste des numéros</label>
                            <div id="numerosList" class="border rounded p-2" style="min-height: 60px; max-height: 120px; overflow-y: auto;">
                                <div class="empty-state small p-2">
                                    Aucun numéro ajouté
                                </div>
                            </div>
                            <input type="hidden" id="selected_numeros" name="numeros[]">
                        </div>

                        <!-- Section Utilisateurs associés (garder le code existant) -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Utilisateurs associés</label>
                                <div class="input-group">
                                    <select class="form-select" id="utilisateur_select">
                                        <option value="">Sélectionnez un utilisateur...</option>
                                        @if(!empty($utilisateurs['formatted']['users']))
                                            @foreach($utilisateurs['formatted']['users'] as $utilisateur)
                                                <option value="{{ $utilisateur['id'] ?? $utilisateur['rowid'] ?? '' }}">
                                                    {{ $utilisateur['firstname'] ?? '' }} {{ $utilisateur['lastname'] ?? '' }}
                                                    @if($utilisateur['login'] ?? false)
                                                        ({{ $utilisateur['login'] }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <button type="button" class="btn btn-outline-custom" onclick="addUtilisateurToList()">
                                        <i class="bi bi-plus"></i> Ajouter
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Liste des utilisateurs -->
                        <div class="mb-3">
                            <label class="form-label">Liste des utilisateurs associés</label>
                            <div id="utilisateursList" class="border rounded p-2" style="min-height: 80px; max-height: 150px; overflow-y: auto;">
                                <div class="empty-state small p-2">
                                    Aucun utilisateur sélectionné
                                </div>
                            </div>
                            <input type="hidden" id="selected_utilisateurs" name="selected_utilisateurs">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-custom" id="submitClient">
                            <span id="clientBtnText">Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page paramètres chargée');
            
            // Charger les données initiales
            loadTypeProjets();
            loadTypeInterventions();
            loadCategories();
            loadClients();

            // Recherche en temps réel
            document.getElementById('searchTypeProjet').addEventListener('keyup', function() {
                searchTypeProjets(this.value);
            });

            document.getElementById('searchTypeIntervention').addEventListener('keyup', function() {
                searchTypeInterventions(this.value);
            });

            document.getElementById('searchCategorie').addEventListener('keyup', function() {
                searchCategories(this.value);
            });

            document.getElementById('searchClient').addEventListener('keyup', function() {
                searchClients(this.value);
            });

            // Gestion des formulaires
            setupForm('formTypeProjet', '/type-projet', 'typeProjet', loadTypeProjets);
            setupForm('formTypeIntervention', '/type-intervention', 'typeIntervention', loadTypeInterventions);
            setupForm('formCategorie', '/categorie', 'categorie', loadCategories);

            // Initialiser les tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });



            const formClient = document.getElementById('formClient');
            formClient.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Récupérer les valeurs du formulaire
                const formData = new FormData(this);
                
                // Récupérer les numéros comme tableau
                const numerosString = document.getElementById('selected_numeros').value;
                const numerosArray = numerosString ? numerosString.split(',').filter(n => n.trim() !== '') : [];
                
                // Supprimer l'ancienne valeur (si elle existe)
                formData.delete('numeros[]');
                formData.delete('numeros_string');
                
                // Ajouter chaque numéro comme entrée séparée
                numerosArray.forEach((numero, index) => {
                    formData.append(`numeros[${index}]`, numero);
                });
                
                // Ajouter aussi en tant que JSON (alternative)
                formData.append('numeros_json', JSON.stringify(numerosArray));
                
                fetch('{{ route("parametre.interlocuteur.save") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json' // Optionnel pour JSON
                    },
                    // Utilisez JSON si vous préférez
                    body: JSON.stringify({
                        id: document.getElementById('clientId').value,
                        id_client: document.getElementById('id_client_select').value,
                        nom_interlocuteur: document.getElementById('clientNom').value,
                        fonction: document.getElementById('clientFonction').value,
                        email: document.getElementById('clientEmail').value,
                        lieu_operation: document.getElementById('clientLieuOperation').value,
                        numeros: numerosArray,
                        selected_utilisateurs: document.getElementById('selected_utilisateurs').value
                    })
                })
                .then(response => response.json())
                .then(data => {

                     if (data.success) {
                        // Fermer la modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalClient'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Réinitialiser le formulaire
                        resetClientForm();
                        
                        // IMPORTANT: Recharger la liste des clients
                        loadClients();
                        
                        // Afficher message de succès
                        showAlert('success', data.message || 'Enregistré avec succès');
                        
                        console.log('Interlocuteur sauvegardé:', data);
                    } else {
                        showAlert('error', data.message || 'Erreur');
                    }
                    // ... traitement de la réponse ...
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('error', 'Erreur réseau');
                });
            });
        });

        // ============ FONCTION GÉNÉRALE POUR CHARGER LES DONNÉES ============
        function loadEntities(type, containerId, search = '') {
            const endpoints = {
                'typeProjet': {
                    all: '{{ route("parametre.api.types-projet") }}',
                    search: '{{ route("parametre.search.types-projet") }}'
                },
                'typeIntervention': {
                    all: '{{ route("parametre.api.types-intervention") }}',
                    search: '{{ route("parametre.search.types-intervention") }}'
                },
                'categorie': {
                    all: '{{ route("parametre.api.categories") }}',
                    search: '{{ route("parametre.search.categories") }}'
                },
                'interlocuteur': {
                    all: '{{ route("parametre.api.interlocuteurs") }}',
                    search: '{{ route("parametre.search.interlocuteurs") }}'
                }
            };

            let url = endpoints[type].all;
            if (search) {
                url = `${endpoints[type].search}?q=${encodeURIComponent(search)}`;
            }

            console.log(`Chargement ${type} depuis:`, url);

            fetch(url)
            .then(response => {
                console.log(`Réponse ${type}:`, response);
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(`Données ${type} reçues:`, data);
                renderEntities(data, type, containerId);
            })
            .catch(error => {
                console.error(`Erreur chargement ${type}:`, error);
                showError(containerId, error.message);
            });
        }


        // Mettre à jour renderEntities pour les interlocuteurs
            function renderEntities(data, type, containerId) {
                const container = document.getElementById(containerId);
                const stats = {
                    total: 0,
                    withNumero: 0,
                    withoutNumero: 0
                };

                // Extraire les données
                let items = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data.data && Array.isArray(data.data)) {
                    items = data.data;
                } else if (data.success && Array.isArray(data.data)) {
                    items = data.data;
                }

                if (items.length === 0) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <i class="bi ${getIcon(type)}"></i>
                            <p>Aucun élément trouvé</p>
                        </div>
                    `;
                    updateStats(type, stats);
                    return;
                }

                let html = '';
                
                if (type === 'interlocuteur') {

                items.forEach(item => {
                    stats.total++;
                    if (item.numero && item.numero.trim() !== '') stats.withNumero++;
                    else stats.withoutNumero++;

                    // Formater la liste des numéros avec meilleur affichage
                    let numerosHtml = '';
                    if (item.numeros && item.numeros.length > 0) {
                        numerosHtml = `
                            <div class="info-section">
                                <div class="section-title">
                                    <i class="bi bi-telephone-fill"></i> Numéros
                                </div>
                                <div class="badge-container">
                                    ${item.numeros.map(numero => 
                                        `<span class="badge-numero"><i class="bi bi-telephone"></i> ${numero}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        `;
                    }

                    // Formater la liste des utilisateurs avec style
                    let utilisateursHtml = '';
                    if (item.utilisateurs && item.utilisateurs.length > 0) {
                        utilisateursHtml = `
                            <div class="info-section">
                                <div class="section-title">
                                    <i class="bi bi-people-fill"></i> Utilisateurs associés
                                </div>
                                <div class="badge-container">
                                    ${item.utilisateurs.map(user => 
                                        `<span class="badge-user"><i class="bi bi-person"></i> ${escapeHtml(user.nom)}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        `;
                    }

                    // Formater la liste des projets avec style
                    let projetsHtml = '';
                    if (item.projets && item.projets.length > 0) {
                        projetsHtml = `
                            <div class="info-section">
                                <div class="section-title">
                                    <i class="bi bi-folder-fill"></i> Projets associés
                                </div>
                                <div class="badge-container">
                                    ${item.projets.map(projet => 
                                        `<span class="badge-projet"><i class="bi bi-folder"></i> ${escapeHtml(projet.nom || projet.titre || `Projet #${projet.id}`)}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        `;
                    }

                    // Déterminer la couleur de la carte en fonction du type
                    const cardColor = type === 'client' ? 'border-primary' : 'border-success';
                    
                    html += `

                    <style>
                        .hover-card {
                            transition: transform 0.2s, box-shadow 0.2s;
                            border-left: 4px solid transparent;
                        }

                        .hover-card:hover {
                            transform: translateY(-4px);
                            box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
                        }

                        .border-primary {
                            border-left-color: #0d6efd !important;
                        }

                        .border-success {
                            border-left-color: #198754 !important;
                        }

                        .badge-id {
                            background: #f8f9fa;
                            padding: 4px 8px;
                            border-radius: 20px;
                            font-size: 0.75rem;
                            font-weight: 600;
                            color: #6c757d;
                        }

                        .info-row {
                            display: flex;
                            margin-bottom: 12px;
                            padding: 6px 0;
                            border-bottom: 1px dashed #f0f0f0;
                        }

                        .info-label {
                            width: 100px;
                            flex-shrink: 0;
                            color: #6c757d;
                            font-size: 0.85rem;
                        }

                        .info-label i {
                            width: 20px;
                            color: #0d6efd;
                        }

                        .info-value {
                            flex: 1;
                            color: #212529;
                            font-weight: 500;
                            word-break: break-word;
                        }

                        .info-value a {
                            color: #0d6efd;
                        }

                        .info-value a:hover {
                            text-decoration: underline !important;
                        }

                        .info-section {
                            margin-top: 16px;
                            padding-top: 8px;
                            border-top: 1px solid #e9ecef;
                        }

                        .section-title {
                            font-size: 0.85rem;
                            font-weight: 600;
                            color: #495057;
                            margin-bottom: 8px;
                        }

                        .section-title i {
                            margin-right: 4px;
                            color: #0d6efd;
                        }

                        .badge-container {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 6px;
                        }

                        .badge-numero {
                            background: #e7f5ff;
                            color: #0d6efd;
                            padding: 4px 10px;
                            border-radius: 16px;
                            font-size: 0.8rem;
                            display: inline-flex;
                            align-items: center;
                            gap: 4px;
                        }

                        .badge-user {
                            background: #e9ecef;
                            color: #495057;
                            padding: 4px 10px;
                            border-radius: 16px;
                            font-size: 0.8rem;
                            display: inline-flex;
                            align-items: center;
                            gap: 4px;
                        }

                        .badge-projet {
                            background: #d1e7dd;
                            color: #0f5132;
                            padding: 4px 10px;
                            border-radius: 16px;
                            font-size: 0.8rem;
                            display: inline-flex;
                            align-items: center;
                            gap: 4px;
                        }

                        .action-btn {
                            transition: all 0.2s;
                            border-width: 1px;
                        }

                        .action-btn:hover {
                            transform: scale(1.02);
                        }

                        .card-footer {
                            border-top: 1px solid #e9ecef;
                            padding: 12px;
                        }
                    </style>

                        <div class="col-md-12 col-lg-12 mb-12">
                            <div class="card h-100 shadow-sm hover-card ${cardColor}" id="${type}-${item.id}">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0 fw-bold">
                                            <i class="bi bi-person-badge me-2"></i>
                                            ${escapeHtml(item.nom_interlocuteur)}
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bi bi-building me-1"></i>${escapeHtml(item.client_nom)}
                                        </small>
                                    </div>
                                    <span class="badge-id">#${item.id}</span>
                                </div>
                                
                                <div class="card-body">
                                    <!-- Fonction avec icône -->
                                    <div class="info-row">
                                        <div class="info-label">
                                            <i class="bi bi-briefcase-fill"></i>
                                            <span>Fonction :</span>
                                        </div>
                                        <div class="info-value">${escapeHtml(item.fonction)}</div>
                                    
                                    
                                    <!-- Email avec lien -->
                                    ${item.email ? `
                                       
                                            <div class="info-label">
                                                <i class="bi bi-envelope-fill"></i>
                                                <span>Email :</span>
                                            </div>
                                            <div class="info-value">
                                                <a href="mailto:${escapeHtml(item.email)}" class="text-decoration-none">
                                                    ${escapeHtml(item.email)}
                                                    <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                                                </a>
                                            </div>
                                        
                                    ` : ''}
                                    
                                    <!-- Lieu d'opération -->
                                    ${item.lieu_operation ? `
                                       
                                            <div class="info-label">
                                                <i class="bi bi-geo-alt-fill"></i>
                                                <span>Lieu :</span>
                                            </div>
                                            <div class="info-value">${escapeHtml(item.lieu_operation)}</div>
                                    ` : ''}
                                    </div>
                                    
                                    <!-- Numéros -->
                                    ${numerosHtml}
                                    
                                    <!-- Utilisateurs associés -->
                                    ${utilisateursHtml}
                                    
                                    <!-- Projets associés -->
                                    ${projetsHtml}
                                </div>
                                
                                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-outline-success action-btn" 
                                            onclick="addProjetToInterlocuteur(${item.id})"
                                            data-bs-toggle="tooltip" title="Ajouter un projet">
                                        <i class="bi bi-plus-circle"></i>
                                        <span class="d-none d-md-inline ms-1">Projet</span>
                                    </button>
                                    
                                    <button class="btn btn-sm btn-outline-primary action-btn" 
                                            onclick="editClient(${item.id})"
                                            data-bs-toggle="tooltip" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                        <span class="d-none d-md-inline ms-1">Modifier</span>
                                    </button>
                                    
                                    <button class="btn btn-sm btn-outline-danger action-btn" 
                                            onclick="deleteClient(${item.id})"
                                            data-bs-toggle="tooltip" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                        <span class="d-none d-md-inline ms-1">Supprimer</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });









                } else {
                    // ... code pour les autres types ...
                    items.forEach(item => {
                        stats.total++;
                        if (item.description && item.description.trim() !== '') stats.withDesc++;
                        else stats.withoutDesc++;

                        html += `
                            <div class="entity-card" id="${type}-${item.id}">
                                <div class="entity-header">
                                    <h6 class="entity-title">${escapeHtml(item.nom)}</h6>
                                    <span class="entity-id">#${item.id}</span>
                                </div>
                                ${item.description && item.description.trim() !== '' ? `
                                    <div class="entity-description">${escapeHtml(item.description)}</div>
                                ` : ''}
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-sm btn-outline-custom" 
                                            onclick="editEntity('${type}', ${item.id})"
                                            data-bs-toggle="tooltip" title="Modifier">
                                        <i class="bi bi-pen"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteEntity('${type}', ${item.id})"
                                            data-bs-toggle="tooltip" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                    });
                }

                container.innerHTML = html;
                updateStats(type, stats);
            }


        function getIcon(type) {
            switch(type) {
                case 'typeProjet': return 'bi-folder';
                case 'typeIntervention': return 'bi-tools';
                case 'categorie': return 'bi-tags';
                case 'interlocuteur': return 'bi-people';
                default: return 'bi-list';
            }
        }


        function updateStats(type, stats) {
            const statsElements = {
                'typeProjet': {
                    total: 'typeProjetTotal',
                    withDesc: 'typeProjetWithDesc',
                    withoutDesc: 'typeProjetWithoutDesc'
                },
                'typeIntervention': {
                    total: 'typeInterventionTotal',
                    withDesc: 'typeInterventionWithDesc'
                },
                'categorie': {
                    total: 'categorieTotal',
                    withDesc: 'categorieWithDesc',
                    withoutDesc: 'categorieWithoutDesc'
                },
                'interlocuteur': {
                    total: 'clientTotal',
                    withNumero: 'clientWithNumero',
                    withoutNumero: 'clientWithoutNumero'
                }
            };

            const elements = statsElements[type];
            // if (elements.total) document.getElementById(elements.total).textContent = stats.total;
            // if (elements.withDesc) document.getElementById(elements.withDesc).textContent = stats.withDesc;
            // if (elements.withoutDesc) document.getElementById(elements.withoutDesc).textContent = stats.withoutDesc;
        }

        function showError(containerId, message) {
            const container = document.getElementById(containerId);
            container.innerHTML = `
                <div class="empty-state text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <p>Erreur de chargement</p>
                    <small class="d-block mt-2">${escapeHtml(message)}</small>
                </div>
            `;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ============ FONCTIONS SPÉCIFIQUES ============
        function loadTypeProjets(search = '') {
            loadEntities('typeProjet', 'typeProjetList', search);
        }

        function searchTypeProjets(term) {
            loadTypeProjets(term);
        }

        function loadTypeInterventions(search = '') {
            loadEntities('typeIntervention', 'typeInterventionList', search);
        }

        function searchTypeInterventions(term) {
            loadTypeInterventions(term);
        }

        function loadCategories(search = '') {
            loadEntities('categorie', 'categorieList', search);
        }

        function searchCategories(term) {
            loadCategories(term);
        }


        function loadClients(search = '') {
            loadEntities('interlocuteur', 'clientList', search);
        }

        function searchClients(term) {
            loadClients(term);
        }

        // ============ GESTION DES FORMULAIRES ============
        function resetTypeProjetForm() {
            resetForm('typeProjet', 'Type de Projet');
        }

        function resetTypeInterventionForm() {
            resetForm('typeIntervention', "Type d'Intervention");
        }

        function resetCategorieForm() {
            resetForm('categorie', 'Catégorie');
        }

        function resetForm(type, label) {
            document.getElementById(`form${type.charAt(0).toUpperCase() + type.slice(1)}`).reset();
            document.getElementById(`${type}Id`).value = '';
            document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}Title`).innerHTML = 
                `<i class="bi ${getIcon(type)} me-2"></i>Nouveau ${label}`;
            document.getElementById(`${type}BtnText`).textContent = 'Enregistrer';
        }

        function editEntity(type, id) {
            // Récupérer TOUTE la liste depuis votre API qui fonctionne
            const apiEndpoints = {
                'typeProjet': '{{ route("parametre.api.types-projet") }}',
                'typeIntervention': '{{ route("parametre.api.types-intervention") }}',
                'categorie': '{{ route("parametre.api.categories") }}'
            };

            console.log(`Chargement ${type} ID: ${id} depuis API...`);
            
            // Cache pour éviter de recharger à chaque fois
            if (!window.cachedEntities) {
                window.cachedEntities = {};
            }
            
            // Si déjà en cache, utiliser le cache
            if (window.cachedEntities[type] && window.cachedEntities[type][id]) {
                const entityData = window.cachedEntities[type][id];
                fillForm(type, entityData);
                return;
            }
            
            // Sinon, charger depuis l'API
            fetch(apiEndpoints[type], {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`API error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Données API reçues:', data);
                
                // Extraire la liste
                let items = [];
                if (Array.isArray(data)) {
                    items = data;
                } else if (data.data && Array.isArray(data.data)) {
                    items = data.data;
                } else if (data.success && Array.isArray(data.data)) {
                    items = data.data;
                }
                
                // Trouver l'élément
                const entityData = items.find(item => item.id == id);
                
                if (!entityData) {
                    throw new Error('Élément non trouvé');
                }
                
                // Mettre en cache
                if (!window.cachedEntities[type]) {
                    window.cachedEntities[type] = {};
                }
                window.cachedEntities[type][id] = entityData;
                
                // Remplir le formulaire
                fillForm(type, entityData);
            })
            .catch(error => {
                console.error('Erreur:', error);
                showAlert('error', 'Erreur de chargement. Essayez à nouveau.');
            });
        }

        function fillForm(type, entityData) {
            document.getElementById(`${type}Id`).value = entityData.id;
            document.getElementById(`${type}Nom`).value = entityData.nom || '';
            document.getElementById(`${type}Description`).value = entityData.description || '';
            
            // Mettre à jour le titre
            const modalTitle = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}Title`);
            const modalBtnText = document.getElementById(`${type}BtnText`);
            
            modalTitle.innerHTML = `<i class="bi ${getIcon(type)} me-2"></i>Modifier`;
            modalBtnText.textContent = 'Mettre à jour';
            
            // Ouvrir la modal
            const modalEl = document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`);
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }


        function deleteEntity(type, id) {
            const labels = {
                'typeProjet': 'ce type de projet',
                'typeIntervention': 'ce type d\'intervention',
                'categorie': 'cette catégorie'
            };

            if (confirm(`Supprimer ${labels[type]} ?`)) {
                const endpoints = {
                    'typeProjet': '/type-projet',
                    'typeIntervention': '/type-intervention',
                    'categorie': '/categorie'
                };

                fetch(`${endpoints[type]}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success || response.ok) {
                        // Recharger les données
                        if (type === 'typeProjet') loadTypeProjets();
                        else if (type === 'typeIntervention') loadTypeInterventions();
                        else if (type === 'categorie') loadCategories();
                        
                        showAlert('success', 'Supprimé avec succès');
                    } else {
                        alert('Erreur: ' + (data.message || 'Suppression impossible'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }


        function setupForm(formId, baseUrl, type, reloadFunction) {
            const form = document.getElementById(formId);
            const submitBtn = form.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const id = formData.get('id');
                const method = id ? 'PUT' : 'POST';
                const url = id ? `${baseUrl}/${id}` : baseUrl;
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Traitement...';
                
                // NE PAS convertir en JSON - utiliser FormData directement
                // AJOUTER _method pour les requêtes PUT
                if (method === 'PUT') {
                    formData.append('_method', 'PUT');
                }
                
                fetch(url, {
                    method: 'POST', // Toujours POST avec FormData
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                        // NE PAS mettre 'Content-Type' - FormData le fait automatiquement
                    },
                    body: formData // Utiliser FormData directement
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = id ? 'Mettre à jour' : 'Enregistrer';
                    
                    if (data.success) { // Vérifier data.success au lieu de response.ok
                        // Fermer la modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById(`modal${type.charAt(0).toUpperCase() + type.slice(1)}`));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Réinitialiser le formulaire
                        form.reset();
                        document.getElementById(`${type}Id`).value = '';
                        
                        // Recharger la page
                        //location.reload();
                        reloadFunction();
                        
                        // Afficher message de succès
                        showAlert('success', data.message || (id ? 'Modifié avec succès' : 'Créé avec succès'));
                    } else {
                        showAlert('error', data.message || 'Erreur');
                    }
                })
                .catch(error => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = id ? 'Mettre à jour' : 'Enregistrer';
                    showAlert('error', 'Erreur réseau');
                    console.error('Error:', error);
                });
            });
        }




        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Fonction de débogage
        function testApi() {
            console.log('Test API en cours...');
            const endpoints = [
                {name: 'Type Projet', url: '{{ route("parametre.api.types-projet") }}'},
                {name: 'Type Intervention', url: '{{ route("parametre.api.types-intervention") }}'},
                {name: 'Catégorie', url: '{{ route("parametre.api.categories") }}'}
            ];
            
            endpoints.forEach(endpoint => {
                fetch(endpoint.url)
                    .then(r => r.json())
                    .then(data => {
                        console.log(`${endpoint.name}:`, data);
                        alert(`${endpoint.name}: ${data.total || data.length || 0} éléments`);
                    })
                    .catch(err => console.error(`${endpoint.name} error:`, err));
            });
        }




        function resetClientForm() {
            document.getElementById('formClient').reset();
            document.getElementById('clientId').value = '';
            document.getElementById('modalClientTitle').innerHTML = 
                '<i class="bi bi-person-plus me-2"></i>Nouvel Interlocuteur Client';
            document.getElementById('clientBtnText').textContent = 'Enregistrer';
            
            // Réinitialiser la liste des numéros
            document.getElementById('numerosList').innerHTML = 
                '<div class="empty-state small p-2">Aucun numéro ajouté</div>';
            document.getElementById('selected_numeros').value = '';
            
            // Réinitialiser la liste des utilisateurs
            document.getElementById('utilisateursList').innerHTML = 
                '<div class="empty-state small p-2">Aucun utilisateur sélectionné</div>';
            document.getElementById('selected_utilisateurs').value = '';
        }





        function addUtilisateurToList() {
            const select = document.getElementById('utilisateur_select');
            const selectedOption = select.options[select.selectedIndex];
            
            if (!selectedOption.value) {
                alert('Veuillez sélectionner un utilisateur');
                return;
            }
            
            const utilisateurId = selectedOption.value;
            const utilisateurNom = selectedOption.text;
            
            // Vérifier si déjà dans la liste
            const currentIds = document.getElementById('selected_utilisateurs').value.split(',');
            if (currentIds.includes(utilisateurId)) {
                alert('Cet utilisateur est déjà dans la liste');
                return;
            }
            
            // Ajouter à la liste
            const utilisateursList = document.getElementById('utilisateursList');
            const badge = document.createElement('div');
            badge.className = 'badge bg-primary me-2 mb-2 p-2 d-inline-flex align-items-center';
            badge.innerHTML = `
                ${utilisateurNom}
                <button type="button" class="btn-close btn-close-white ms-2" 
                        onclick="removeUtilisateurFromList('${utilisateurId}')"></button>
            `;
            
            // Supprimer le message vide si présent
            if (utilisateursList.querySelector('.empty-state')) {
                utilisateursList.innerHTML = '';
            }
            
            utilisateursList.appendChild(badge);
            
            // Mettre à jour le champ caché
            const currentValue = document.getElementById('selected_utilisateurs').value;
            document.getElementById('selected_utilisateurs').value = 
                currentValue ? currentValue + ',' + utilisateurId : utilisateurId;
            
            // Réinitialiser le select
            select.selectedIndex = 0;
        }




        function removeUtilisateurFromList(id) {
            // Mettre à jour le champ caché
            const currentIds = document.getElementById('selected_utilisateurs').value.split(',');
            const newIds = currentIds.filter(itemId => itemId !== id);
            document.getElementById('selected_utilisateurs').value = newIds.join(',');
            
            // Supprimer le badge
            const badges = document.querySelectorAll('#utilisateursList .badge button');
            badges.forEach(button => {
                const badge = button.closest('.badge');
                if (badge && badge.querySelector(`button[onclick*="${id}"]`)) {
                    badge.remove();
                }
            });
            
            // Afficher message vide si liste vide
            if (newIds.length === 0) {
                document.getElementById('utilisateursList').innerHTML = 
                    '<div class="empty-state small p-2">Aucun utilisateur sélectionné</div>';
            }
        }


        function editClient(id) {
            // Charger les données depuis l'API des interlocuteurs
            fetch('{{ route("parametre.api.interlocuteurs") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const interlocuteur = data.data.find(item => item.id == id);
                        if (interlocuteur) {
                            fillClientForm(interlocuteur);
                        } else {
                            showAlert('error', 'Interlocuteur non trouvé');
                        }
                    } else {
                        showAlert('error', 'Erreur de chargement');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showAlert('error', 'Erreur de chargement');
                });
        }



        // Modifier la fonction fillClientForm
        function fillClientForm(data) {
            document.getElementById('clientId').value = data.id;
            document.getElementById('id_client_select').value = data.id_client;
            document.getElementById('clientNom').value = data.nom_interlocuteur;
            document.getElementById('clientFonction').value = data.fonction;
            document.getElementById('clientEmail').value = data.email || '';
            document.getElementById('clientLieuOperation').value = data.lieu_operation || '';
            
            // Remplir la liste des numéros
            const numerosList = document.getElementById('numerosList');
            numerosList.innerHTML = '';
            
            if (data.numeros && data.numeros.length > 0) {
                const numeros = data.numeros;
                document.getElementById('selected_numeros').value = numeros.join(',');
                
                numeros.forEach(numero => {
                    const badge = document.createElement('div');
                    badge.className = 'badge bg-info me-2 mb-2 p-2 d-inline-flex align-items-center';
                    badge.innerHTML = `
                        <i class="bi bi-telephone me-1"></i>${numero}
                        <button type="button" class="btn-close btn-close-white ms-2" 
                                onclick="removeNumeroFromList('${numero}')"></button>
                    `;
                    numerosList.appendChild(badge);
                });
            } else {
                numerosList.innerHTML = '<div class="empty-state small p-2">Aucun numéro ajouté</div>';
                document.getElementById('selected_numeros').value = '';
            }
            
            // Remplir la liste des utilisateurs (garder le code existant)
            const utilisateursList = document.getElementById('utilisateursList');
            utilisateursList.innerHTML = '';
            
            if (data.utilisateurs && data.utilisateurs.length > 0) {
                const ids = [];
                data.utilisateurs.forEach(utilisateur => {
                    const badge = document.createElement('div');
                    badge.className = 'badge bg-primary me-2 mb-2 p-2 d-inline-flex align-items-center';
                    badge.innerHTML = `
                        ${escapeHtml(utilisateur.nom)}
                        <button type="button" class="btn-close btn-close-white ms-2" 
                                onclick="removeUtilisateurFromList('${utilisateur.id}')"></button>
                    `;
                    utilisateursList.appendChild(badge);
                    ids.push(utilisateur.id.toString());
                });
                document.getElementById('selected_utilisateurs').value = ids.join(',');
            } else {
                utilisateursList.innerHTML = '<div class="empty-state small p-2">Aucun utilisateur sélectionné</div>';
                document.getElementById('selected_utilisateurs').value = '';
            }
            
            // Mettre à jour le titre
            document.getElementById('modalClientTitle').innerHTML = 
                '<i class="bi bi-person-plus me-2"></i>Modifier Interlocuteur';
            document.getElementById('clientBtnText').textContent = 'Mettre à jour';
            
            // Ouvrir la modal
            const modal = new bootstrap.Modal(document.getElementById('modalClient'));
            modal.show();
        }



        function deleteClient(id) {
            if (confirm('Supprimer cet interlocuteur ?')) {
                fetch(`{{ route("parametre.interlocuteur.delete", "") }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadClients();
                        showAlert('success', 'Interlocuteur supprimé avec succès');
                    } else {
                        alert('Erreur: ' + (data.message || 'Suppression impossible'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de la suppression');
                });
            }
        }



        function addNumeroToList() {
            const input = document.getElementById('numeroInput');
            let numero = input.value.trim();
            
            // Supprimer tous les caractères non numériques
            numero = numero.replace(/\D/g, '');
            
            // Validation du format
            if (numero.length !== 10) {
                alert('Le numéro doit contenir exactement 10 chiffres');
                input.focus();
                return;
            }
            
            // Vérifier si déjà dans la liste
            const currentNumeros = document.getElementById('selected_numeros').value.split(',');
            if (currentNumeros.includes(numero)) {
                alert('Ce numéro est déjà dans la liste');
                return;
            }
            
            // Ajouter à la liste
            const numerosList = document.getElementById('numerosList');
            const badge = document.createElement('div');
            badge.className = 'badge bg-info me-2 mb-2 p-2 d-inline-flex align-items-center';
            badge.innerHTML = `
                <i class="bi bi-telephone me-1"></i>${formatNumero(numero)}
                <button type="button" class="btn-close btn-close-white ms-2" 
                        onclick="removeNumeroFromList('${numero}')"></button>
            `;
            
            // Supprimer le message vide si présent
            if (numerosList.querySelector('.empty-state')) {
                numerosList.innerHTML = '';
            }
            
            numerosList.appendChild(badge);
            
            // Mettre à jour le champ caché
            const currentValue = document.getElementById('selected_numeros').value;
            document.getElementById('selected_numeros').value = 
                currentValue ? currentValue + ',' + numero : numero;
            
            // Réinitialiser l'input
            input.value = '';
            input.focus();
        }

        // Fonction pour formater le numéro (ex: 01 23 45 67 89)
        function formatNumero(numero) {
            if (numero.length === 10) {
                return numero.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
            }
            return numero;
        }

        // Fonction pour enlever les espaces avant l'envoi
        function cleanNumeroForSubmit(numero) {
            return numero.replace(/\s/g, '');
        }






        function removeNumeroFromList(numero) {
            // Mettre à jour le champ caché
            const currentNumeros = document.getElementById('selected_numeros').value.split(',');
            const newNumeros = currentNumeros.filter(n => n !== numero);
            document.getElementById('selected_numeros').value = newNumeros.join(',');
            
            // Supprimer le badge
            const badges = document.querySelectorAll('#numerosList .badge');
            badges.forEach(badge => {
                if (badge.textContent.includes(numero)) {
                    badge.remove();
                }
            });
            
            // Afficher message vide si liste vide
            if (newNumeros.length === 0) {
                document.getElementById('numerosList').innerHTML = 
                    '<div class="empty-state small p-2">Aucun numéro ajouté</div>';
            }
        }




        // // Fonction pour ajouter un projet à un interlocuteur
        // function addProjetToInterlocuteur(interlocuteurId) {
        //     // Créer une modal dédiée pour l'ajout de projet
        //     const modalHtml = `
        //         <div class="modal fade" id="modalAddProjet" tabindex="-1">
        //             <div class="modal-dialog">
        //                 <div class="modal-content">
        //                     <div class="modal-header modal-header-custom">
        //                         <h5 class="modal-title">
        //                             <i class="bi bi-folder-plus me-2"></i>Ajouter un projet
        //                         </h5>
        //                         <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        //                     </div>
        //                     <div class="modal-body">
        //                         <div class="mb-3">
        //                             <label for="selectProjetForInterlocuteur" class="form-label">Sélectionner un projet</label>
        //                             <select class="form-select" id="selectProjetForInterlocuteur">
        //                                 <option value="">Chargement des projets...</option>
        //                             </select>
        //                         </div>
        //                         <div class="alert alert-info">
        //                             <i class="bi bi-info-circle me-2"></i>
        //                             Ce projet sera lié à l'interlocuteur #${interlocuteurId}
        //                         </div>
        //                     </div>
        //                     <div class="modal-footer">
        //                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        //                         <button type="button" class="btn btn-custom" onclick="saveProjetToInterlocuteur(${interlocuteurId})">
        //                             <i class="bi bi-plus-circle me-2"></i>Ajouter
        //                         </button>
        //                     </div>
        //                 </div>
        //             </div>
        //         </div>
        //     `;
            
        //     // Ajouter la modal au DOM si elle n'existe pas
        //     if (!document.getElementById('modalAddProjet')) {
        //         const modalContainer = document.createElement('div');
        //         modalContainer.innerHTML = modalHtml;
        //         document.body.appendChild(modalContainer);
        //     }
            
        //     // Charger la liste des projets dans le select
        //     loadProjetsForInterlocuteur();
            
        //     // Afficher la modal
        //     const modal = new bootstrap.Modal(document.getElementById('modalAddProjet'));
        //     modal.show();
        // }


        // Fonction pour ajouter un projet à un interlocuteur
        function addProjetToInterlocuteur(interlocuteurId) {
            // Stocker l'ID de l'interlocuteur dans un data attribute
            const modalElement = document.getElementById('modalAddProjet');
            if (!modalElement) {
                createAddProjetModal(interlocuteurId);
            } else {
                modalElement.setAttribute('data-interlocuteur-id', interlocuteurId);
                
                // Charger la liste des projets dans le select
                loadProjetsForInterlocuteur();
                
                // Afficher la modal
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        }

        // Fonction pour créer la modal (si elle n'existe pas)
        function createAddProjetModal(interlocuteurId) {
            const modalHtml = `
                <div class="modal fade" id="modalAddProjet" tabindex="-1" data-interlocuteur-id="${interlocuteurId}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-header-custom">
                                <h5 class="modal-title">
                                    <i class="bi bi-folder-plus me-2"></i>Ajouter un projet
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">


                                <div class="mb-3">
                                    <label for="selectProjetForInterlocuteur" class="form-label">Sélectionner un projet</label>
                                    <select class="form-select" id="selectProjetForInterlocuteur">
                                        <option value="">Chargement des projets...</option>
                                    </select>
                                </div>


                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Ce projet sera lié à l'interlocuteur #${interlocuteurId}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-custom" onclick="saveProjetToInterlocuteur(${interlocuteurId})">
                                    <i class="bi bi-plus-circle me-2"></i>Ajouter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = modalHtml;
            document.body.appendChild(modalContainer);
            
            // Charger la liste des projets
            loadProjetsForInterlocuteur();
            
            // Afficher la modal
            const modal = new bootstrap.Modal(document.getElementById('modalAddProjet'));
            modal.show();
        }




        // // Fonction pour charger les projets disponibles
        // function loadProjetsForInterlocuteur() {
        //     const select = document.getElementById('selectProjetForInterlocuteur');
        //     select.innerHTML = '<option value="">Chargement des projets...</option>';
            
        //     // Remplacer par votre route API pour les projets
        //     fetch('{{ route("parametre.api.projets.list") }}') // Vous devez créer cette route
        //         .then(response => response.json())
        //         .then(data => {
        //             select.innerHTML = '<option value="">Sélectionnez un projet...</option>';
                    
        //             if (data.success && data.data) {
        //                 data.data.forEach(projet => {
        //                     const option = document.createElement('option');
        //                     option.value = projet.id;
        //                     option.textContent = projet.nom || projet.titre || `Projet #${projet.id}`;
        //                     if (projet.reference) {
        //                         option.textContent += ` (${projet.reference})`;
        //                     }
        //                     select.appendChild(option);
        //                 });
        //             } else {
        //                 select.innerHTML = '<option value="">Aucun projet disponible</option>';
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Erreur chargement projets:', error);
        //             select.innerHTML = '<option value="">Erreur de chargement</option>';
        //         });
        // }


        // Fonction pour charger les projets disponibles
        function loadProjetsForInterlocuteur() {
            const select = document.getElementById('selectProjetForInterlocuteur');
            if (!select) {
                console.error('Element selectProjetForInterlocuteur non trouvé');
                return;
            }
            
            select.innerHTML = '<option value="">Chargement des projets...</option>';
            select.disabled = true;
            
            // Remplacer par votre route API pour les projets
            fetch('{{ route("parametre.api.projets.list") }}', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                select.disabled = false;
                
                if (data.success && data.data && Array.isArray(data.data)) {
                    select.innerHTML = '<option value="">Sélectionnez un projet...</option>';
                    
                    data.data.forEach(projet => {
                        const option = document.createElement('option');
                        option.value = projet.id;
                        
                        // Formater le texte de l'option
                        let optionText = projet.nom || `Projet #${projet.id}`;
                        if (projet.client_id) {
                            optionText += ` (Client: ${projet.client_id})`;
                        }
                        if (projet.date_debut) {
                            const date = new Date(projet.date_debut).toLocaleDateString('fr-FR');
                            optionText += ` - Début: ${date}`;
                        }
                        
                        option.textContent = optionText;
                        option.title = `Projet ID: ${projet.id}`;
                        select.appendChild(option);
                    });
                    
                    if (data.data.length === 0) {
                        select.innerHTML = '<option value="">Aucun projet disponible</option>';
                    }
                } else {
                    console.error('Format de données invalide:', data);
                    select.innerHTML = '<option value="">Erreur: format invalide</option>';
                }
            })
            .catch(error => {
                console.error('Erreur chargement projets:', error);
                select.innerHTML = '<option value="">Erreur de chargement</option>';
                select.disabled = false;
            });
        }




        // Fonction pour sauvegarder l'association projet-interlocuteur
        function saveProjetToInterlocuteur(interlocuteurId) {
            const select = document.getElementById('selectProjetForInterlocuteur');
            const projetId = select.value;
            
            if (!projetId) {
                alert('Veuillez sélectionner un projet');
                return;
            }
            
            // Afficher un indicateur de chargement
            const saveBtn = document.querySelector('#modalAddProjet .btn-custom');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> En cours...';
            saveBtn.disabled = true;
            
            // Envoyer la requête à votre API
            fetch('{{ route("parametre.interlocuteur.projets.add", ["id" => ":interlocuteurId"]) }}'.replace(':interlocuteurId', interlocuteurId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id_projet: projetId,
                    _method: 'POST'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fermer la modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAddProjet'));
                    if (modal) {
                        modal.hide();
                    }
                    
                    // Recharger la liste des interlocuteurs
                    loadClients();
                    
                    // Afficher message de succès
                    showAlert('success', data.message || 'Projet ajouté avec succès');
                } else {
                    showAlert('error', data.message || 'Erreur lors de l\'ajout du projet');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showAlert('error', 'Erreur réseau');
            })
            .finally(() => {
                // Réinitialiser le bouton
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
        }



    </script>
</body>
</html>