<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Vue des Préparations par Projet</title>
    
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

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-sitemap me-2"></i>Nouvelle étape de workflow
                    </h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif 

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form id="workflowForm" action="{{ route('workflow-validation.create') }}" method="POST">
                        @csrf
                        
                        <!-- 1. Sélection du projet -->
                        <div class="mb-4">
                            <label for="id_projects_travailler" class="form-label fw-bold">
                                Projet <span class="text-danger"></span>
                            </label>
                            <select class="form-select @error('id_projects_travailler') is-invalid @enderror" 
                                    id="id_projects_travailler" 
                                    name="id_projects_travailler"
                                    required>
                                <option value="">-- Sélectionnez un projet --</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" 
                                            {{ old('id_projects_travailler') == $project->id ? 'selected' : '' }}>
                                        {{ $project->numero_projet }} - {{ $project->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_projects_travailler')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- 2. Informations sur le projet sélectionné (AJAX) -->
                        <div id="projectInfo" class="alert alert-info mb-4" style="display: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong id="projectTitle"></strong><br>
                                    <small id="projectDetails"></small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 3. Section étape parente (dynamique) -->
                        <div class="mb-4" id="parentStepSection" style="display: none;">
                            <label class="form-label fw-bold">Étape parente</label>
                            
                            <!-- Message première étape -->
                            <div id="firstStepAlert" class="alert alert-success" style="display: none;">
                                <i class="fas fa-star me-2"></i>
                                Ce sera la <strong>première étape</strong> pour ce projet.
                                <input type="hidden" name="id_parent" value="">
                            </div>
                            
                            <!-- Liste des étapes existantes -->
                            <div id="existingSteps" style="display: none;">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Ce projet a déjà <span id="stepCount" class="fw-bold">0</span> étape(s).
                                    Sélectionnez l'étape parente :
                                </div>
                                <select class="form-select @error('id_parent') is-invalid @enderror" 
                                        id="id_parent" 
                                        name="id_parent">
                                    <option value="">-- Sélectionnez l'étape parente --</option>
                                    <!-- Options chargées dynamiquement -->
                                </select>
                                @error('id_parent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Cette nouvelle étape sera ajoutée après l'étape parente sélectionnée.
                                </div>
                            </div>
                        </div>
                        
                        <!-- 4. Détails de la nouvelle étape -->
                        <div class="mb-4 border-top pt-4">
                            <h5 class="mb-3">
                                <i class="fas fa-plus-circle me-2"></i>Détails de la nouvelle étape
                            </h5>
                            
                            <!-- Nom de l'étape -->
                            <div class="mb-3">
                                <label for="nom_etape" class="form-label">
                                    Nom de l'étape <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom_etape') is-invalid @enderror" 
                                       id="nom_etape" 
                                       name="nom_etape" 
                                       value="{{ old('nom_etape') }}"
                                       required
                                       maxlength="50"
                                       placeholder="Ex: Validation initiale, Révision technique, Approbation finale...">
                                @error('nom_etape')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Dates -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_arriver" class="form-label">
                                        Date de début <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" 
                                           class="form-control @error('date_arriver') is-invalid @enderror" 
                                           id="date_arriver" 
                                           name="date_arriver" 
                                           value="{{ old('date_arriver') ?: date('Y-m-d\TH:i') }}"
                                           required>
                                    @error('date_arriver')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_fin_de_validation" class="form-label">
                                        Date de fin de validation
                                    </label>
                                    <input type="datetime-local" 
                                           class="form-control @error('date_fin_de_validation') is-invalid @enderror" 
                                           id="date_fin_de_validation" 
                                           name="date_fin_de_validation" 
                                           value="{{ old('date_fin_de_validation') }}">
                                    @error('date_fin_de_validation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Statut -->
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    Statut initial <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status"
                                        required>
                                    <option value="0" {{ old('status', '0') == '0' ? 'selected' : '' }}>⏳ En attente</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>✅ Validé</option>
                                    <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>❌ Rejeté</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Commentaires -->
                            <div class="mb-2">
                                <label for="commentaires" class="form-label">Commentaires</label>
                                <textarea class="form-control @error('commentaires') is-invalid @enderror" 
                                          id="commentaires" 
                                          name="commentaires" 
                                          rows="3"
                                          placeholder="Notes, remarques, instructions...">{{ old('commentaires') }}</textarea>
                                @error('commentaires')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 5. Section pour les utilisateurs concernés (avec bouton Ajouter) -->
                            <div class="mb-4 border-top pt-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-users me-2"></i>Utilisateurs concernés (optionnel)
                                </h5>
                                
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    1. Sélectionnez un utilisateur dans la liste<br>
                                    2. Cliquez sur "Ajouter"<br>
                                    3. L'utilisateur apparaîtra ci-dessous<br>
                                    4. Ajoutez un commentaire spécifique pour chaque utilisateur
                                </div>
                                
                                <!-- Liste déroulante simple avec bouton Ajouter -->
                                <div class="row mb-3">
                                    <div class="col-md-9">
                                        <label for="utilisateur_select" class="form-label">
                                            Sélectionner un utilisateur
                                        </label>
                                        <select class="form-select" id="utilisateur_select">

                                            <option value="">Sélectionnez un enqueter...</option>
                                            @if(!empty($utilisateurs['formatted']['users']))
                                                @foreach($utilisateurs['formatted']['users'] as $utilisateur)
                                                    <option value="{{ $utilisateur['id'] ?? $utilisateur['rowid'] ?? 'N/A' }}">
                                                        {{ $utilisateur['firstname'] ?? '' }} {{ $utilisateur['lastname'] ?? '' }} 
                                                        @if($utilisateur['login'] ?? false)
                                                            ({{ $utilisateur['login'] }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary w-100" id="btnAjouterUtilisateur">
                                            <i class="fas fa-plus me-1"></i> Ajouter
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Champ pour ajouter un commentaire à l'utilisateur sélectionné -->
                                <div class="mb-3" id="commentaireUtilisateurSection" style="display: none;">
                                    <label for="commentaire_utilisateur" class="form-label">
                                        Commentaire pour cet utilisateur
                                    </label>
                                    <div class="input-group">
                                        <textarea class="form-control" 
                                                  id="commentaire_utilisateur" 
                                                  rows="2"
                                                  placeholder="Ajoutez un commentaire spécifique pour cet utilisateur..."></textarea>
                                        <button type="button" class="btn btn-outline-secondary" id="btnAjouterCommentaire">
                                            <i class="fas fa-comment me-1"></i> Ajouter
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        Ce commentaire sera spécifique à cet utilisateur pour cette étape.
                                    </div>
                                </div>
                                
                                <!-- Liste des utilisateurs sélectionnés avec leurs commentaires -->
                                <div class="mb-3">
                                    <label class="form-label">Utilisateurs à associer à cette étape (avec commentaires)</label>
                                    <div id="selectedUtilisateurs" class="border rounded p-3 min-height-100 bg-light">
                                        <p class="text-muted mb-0" id="noUsersMessage">
                                            Aucun utilisateur sélectionné. Ajoutez des utilisateurs ci-dessus.
                                        </p>
                                    </div>
                                    <!-- Champ caché pour stocker les IDs et commentaires -->
                                    <input type="hidden" name="utilisateurs" id="utilisateurs_hidden" value="">
                                </div>
                                
                                <!-- Bouton pour tout effacer -->
                                <div class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="btnEffacerTout">
                                        <i class="fas fa-trash me-1"></i> Tout effacer
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('workflow-validation.form') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-1"></i> Créer l'étape
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main><!-- End #main -->

  <!-- ======= Footer ======= -->
   @include('page.footer')

<style>
/* Style pour les messages de debug */
.debug-info {
    position: fixed;
    bottom: 10px;
    right: 10px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 10px;
    border-radius: 5px;
    font-size: 12px;
    z-index: 10000;
    max-width: 300px;
}
</style>


<!-- Ajoutez ceci juste après l'ouverture du body dans votre layout -->
<div class="debug-info" id="debugInfo" style="display: none;">
    Debug: <span id="debugText"></span>
</div>


    <!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

<script>
// Fonction pour afficher des messages de debug
function showDebug(msg) {
    console.log('DEBUG:', msg);
    const debugEl = document.getElementById('debugInfo');
    const debugText = document.getElementById('debugText');
    if (debugEl && debugText) {
        debugText.textContent = msg;
        debugEl.style.display = 'block';
        setTimeout(() => {
            debugEl.style.display = 'none';
        }, 3000);
    }
}

// Gestion des utilisateurs avec commentaires
let selectedUsers = [];
let currentUserForComment = null;

// Fonction pour mettre à jour le champ caché
function updateHiddenInput() {
    const userData = selectedUsers.map(user => ({
        id: user.id,
        commentaire: user.commentaire || ''
    }));
    document.getElementById('utilisateurs_hidden').value = JSON.stringify(userData);
    console.log('Données utilisateurs:', userData);
}

// Fonction pour ajouter un utilisateur (sans commentaire initial)
function addUser() {
    const selectElement = document.getElementById('utilisateur_select');
    const userId = selectElement.value;
    const userText = selectElement.options[selectElement.selectedIndex].text;
    
    if (!userId) {
        alert('Veuillez sélectionner un utilisateur dans la liste.');
        return;
    }
    
    // Convertir en nombre
    const userIdNum = parseInt(userId);
    
    // Vérifier si déjà sélectionné
    if (selectedUsers.some(user => user.id === userIdNum)) {
        alert('Cet utilisateur est déjà dans la liste.');
        return;
    }
    
    // Mettre à jour l'utilisateur courant pour le commentaire
    currentUserForComment = {
        id: userIdNum,
        text: userText
    };
    
    // Afficher la section de commentaire
    document.getElementById('commentaireUtilisateurSection').style.display = 'block';
    document.getElementById('commentaire_utilisateur').value = '';
    document.getElementById('commentaire_utilisateur').focus();
    
    // Réinitialiser la sélection du dropdown
    selectElement.value = '';
}

// Fonction pour ajouter un utilisateur avec son commentaire
function addUserWithComment() {
    if (!currentUserForComment) {
        return;
    }
    
    const commentaire = document.getElementById('commentaire_utilisateur').value.trim();
    
    // Ajouter à la liste avec commentaire
    selectedUsers.push({
        id: currentUserForComment.id,
        text: currentUserForComment.text,
        commentaire: commentaire
    });
    
    // Mettre à jour l'affichage et le champ caché
    updateHiddenInput();
    displaySelectedUsers();
    
    // Cacher la section de commentaire
    document.getElementById('commentaireUtilisateurSection').style.display = 'none';
    document.getElementById('commentaire_utilisateur').value = '';
    currentUserForComment = null;
}

// Fonction pour supprimer un utilisateur
function removeUser(userId) {
    selectedUsers = selectedUsers.filter(user => user.id !== userId);
    updateHiddenInput();
    displaySelectedUsers();
}

// Fonction pour tout effacer
function clearAllUsers() {
    if (selectedUsers.length === 0) {
        return;
    }
    
    if (confirm('Voulez-vous vraiment supprimer tous les utilisateurs sélectionnés ?')) {
        selectedUsers = [];
        currentUserForComment = null;
        updateHiddenInput();
        displaySelectedUsers();
        document.getElementById('commentaireUtilisateurSection').style.display = 'none';
    }
}

// Fonction pour afficher les utilisateurs sélectionnés avec leurs commentaires
function displaySelectedUsers() {
    const container = document.getElementById('selectedUtilisateurs');
    const noUsersMessage = document.getElementById('noUsersMessage');
    
    if (selectedUsers.length === 0) {
        container.innerHTML = '<p class="text-muted mb-0" id="noUsersMessage">Aucun utilisateur sélectionné. Ajoutez des utilisateurs ci-dessus.</p>';
        return;
    }
    
    let html = '<div class="d-flex flex-wrap">';
    selectedUsers.forEach(user => {
        html += `
            <div class="user-badge">
                <div class="user-badge-header">
                    <div class="user-badge-content">
                        <strong>${user.text}</strong>
                    </div>
                    <span class="remove-user" onclick="removeUser(${user.id})" title="Supprimer cet utilisateur">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
                ${user.commentaire ? `
                    <div class="user-badge-comment">
                        <small><strong>Commentaire :</strong> ${user.commentaire}</small>
                    </div>
                ` : `
                    <div class="user-badge-comment text-muted">
                        <small><em>Aucun commentaire spécifique</em></small>
                    </div>
                `}
            </div>
        `;
    });
    html += '</div>';
    
    container.innerHTML = html;
}

// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé - Initialisation du script');
    showDebug('Script chargé');
    
    // Récupérer les éléments
    const projectSelect = document.getElementById('id_projects_travailler');
    const projectInfo = document.getElementById('projectInfo');
    const parentStepSection = document.getElementById('parentStepSection');
    const firstStepAlert = document.getElementById('firstStepAlert');
    const existingSteps = document.getElementById('existingSteps');
    const stepCount = document.getElementById('stepCount');
    const parentSelect = document.getElementById('id_parent');
    const submitBtn = document.getElementById('submitBtn');
    const btnAjouterUtilisateur = document.getElementById('btnAjouterUtilisateur');
    const btnAjouterCommentaire = document.getElementById('btnAjouterCommentaire');
    const btnEffacerTout = document.getElementById('btnEffacerTout');
    const utilisateurSelect = document.getElementById('utilisateur_select');
    const commentaireUtilisateur = document.getElementById('commentaire_utilisateur');
    
    if (!projectSelect) {
        console.error('❌ Élément id_projects_travailler non trouvé!');
        showDebug('Erreur: Sélecteur projet non trouvé');
        return;
    }
    
    console.log('✅ Tous les éléments trouvés');
    showDebug('Éléments trouvés');
    
    // Désactiver le bouton de soumission initialement
    if (submitBtn) submitBtn.disabled = true;
    
    // Fonction pour masquer toutes les sections
    function hideAllSections() {
        if (projectInfo) projectInfo.style.display = 'none';
        if (parentStepSection) parentStepSection.style.display = 'none';
        if (firstStepAlert) firstStepAlert.style.display = 'none';
        if (existingSteps) existingSteps.style.display = 'none';
        if (submitBtn) submitBtn.disabled = true;
    }
    
    // Écouter les changements sur la sélection de projet
    projectSelect.addEventListener('change', function() {
        const projectId = this.value;
        console.log('📋 Projet sélectionné ID:', projectId);
        showDebug('Projet sélectionné: ' + projectId);
        
        // Masquer toutes les sections
        hideAllSections();
        
        if (!projectId) {
            console.log('ℹ️ Aucun projet sélectionné');
            return;
        }
        
        // Afficher le loader
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Chargement...';
            submitBtn.disabled = true;
        }
        
        // URL de l'API
        const apiUrl = `/workflow-validation/project-steps/${projectId}`;
        console.log('🌐 Appel API:', apiUrl);
        showDebug('Appel API: ' + apiUrl);
        
        // Appeler l'API pour récupérer les étapes du projet
        fetch(apiUrl, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('📥 Réponse HTTP:', response.status, response.statusText);
            showDebug('Statut: ' + response.status);
            
            if (!response.ok) {
                throw new Error(`Erreur HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Données reçues:', data);
            showDebug('Données reçues');
            
            if (!data.success) {
                throw new Error(data.message || 'Erreur inconnue du serveur');
            }
            
            // 1. Afficher les informations du projet
            if (projectInfo && data.project) {
                document.getElementById('projectTitle').textContent = 
                    `${data.project.numero_projet} - ${data.project.titre}`;
                document.getElementById('projectDetails').textContent = 
                    data.project.description || 'Pas de description';
                projectInfo.style.display = 'block';
            }
            
            // 2. Vérifier si c'est la première étape
            if (data.is_first_step) {
                // C'est la première étape pour ce projet
                console.log('🎯 Première étape pour ce projet');
                showDebug('Première étape');
                
                if (parentStepSection) parentStepSection.style.display = 'block';
                if (firstStepAlert) firstStepAlert.style.display = 'block';
                if (existingSteps) existingSteps.style.display = 'none';
                
                // S'assurer que id_parent est vide
                if (parentSelect) {
                    parentSelect.value = '';
                }
                
                // Activer le bouton
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
                
            } else {
                // Il existe déjà des étapes pour ce projet
                console.log('📊 Il y a déjà', data.step_count, 'étape(s) pour ce projet');
                showDebug(data.step_count + ' étape(s) existante(s)');
                
                if (parentStepSection) parentStepSection.style.display = 'block';
                if (firstStepAlert) firstStepAlert.style.display = 'none';
                if (existingSteps) existingSteps.style.display = 'block';
                
                // Afficher le nombre d'étapes existantes
                if (stepCount) stepCount.textContent = data.step_count;
                
                // Vider et remplir la liste déroulante des étapes existantes
                if (parentSelect) {
                    parentSelect.innerHTML = '<option value="">-- Sélectionnez l\'étape parente --</option>';
                    
                    if (data.steps && data.steps.length > 0) {
                        data.steps.forEach(step => {
                            const option = document.createElement('option');
                            option.value = step.id;
                            
                            // Formater la date
                            let dateStr = 'Date inconnue';
                            if (step.date_arriver) {
                                try {
                                    const date = new Date(step.date_arriver);
                                    if (!isNaN(date.getTime())) {
                                        const day = date.getDate().toString().padStart(2, '0');
                                        const month = (date.getMonth() + 1).toString().padStart(2, '0');
                                        const year = date.getFullYear();
                                        dateStr = `${day}/${month}/${year}`;
                                    }
                                } catch (e) {
                                    console.warn('Erreur format date:', e);
                                }
                            }
                            
                            // Déterminer le statut
                            let statusIcon = '⏳';
                            let statusText = 'En attente';
                            if (step.status === 1) {
                                statusIcon = '✅';
                                statusText = 'Validé';
                            } else if (step.status === 2) {
                                statusIcon = '❌';
                                statusText = 'Rejeté';
                            }
                            
                            // Texte de l'option
                            option.textContent = `${statusIcon} ${step.nom_etape} (${dateStr}) - ${statusText}`;
                            option.title = `ID: ${step.id} | Statut: ${statusText}`;
                            
                            parentSelect.appendChild(option);
                        });
                        
                        // Désactiver le bouton tant qu'aucune étape parente n'est sélectionnée
                        if (submitBtn) submitBtn.disabled = true;
                        
                        // Écouter les changements sur la sélection de l'étape parente
                        parentSelect.addEventListener('change', function() {
                            const isSelected = this.value !== '';
                            if (submitBtn) {
                                submitBtn.disabled = !isSelected;
                            }
                            console.log('Étape parente sélectionnée:', this.value);
                            showDebug(isSelected ? 'Étape parente sélectionnée' : 'Aucune étape parente');
                        });
                    }
                }
            }
            
            // Réactiver le bouton de soumission
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i> Créer l\'étape';
            }
            
            console.log('✅ Affichage terminé');
            showDebug('Affichage terminé');
            
        })
        .catch(error => {
            console.error('❌ Erreur lors du chargement des étapes:', error);
            showDebug('Erreur: ' + error.message);
            
            // Afficher un message d'erreur détaillé
            const errorMsg = `Erreur lors du chargement: ${error.message}\n\n` +
                           `URL appelée: /workflow-validation/project-steps/${projectId}\n` +
                           `Vérifiez que cette route existe dans web.php`;
            alert(errorMsg);
            
            // Réactiver le bouton
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i> Créer l\'étape';
                submitBtn.disabled = false;
            }
        });
    });
    
    // Gestion de l'ajout d'utilisateurs
    if (btnAjouterUtilisateur) {
        btnAjouterUtilisateur.addEventListener('click', addUser);
    }
    
    // Gestion de l'ajout de commentaire pour utilisateur
    if (btnAjouterCommentaire) {
        btnAjouterCommentaire.addEventListener('click', addUserWithComment);
    }
    
    // Permettre d'ajouter l'utilisateur avec Enter dans le champ commentaire
    if (commentaireUtilisateur) {
        commentaireUtilisateur.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                addUserWithComment();
            }
        });
    }
    
    // Permettre d'ajouter avec la touche Entrée sur le select
    if (utilisateurSelect) {
        utilisateurSelect.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addUser();
            }
        });
    }
    
    // Gestion du bouton "Tout effacer"
    if (btnEffacerTout) {
        btnEffacerTout.addEventListener('click', clearAllUsers);
    }
    
    // Validation des dates
    const dateDebut = document.getElementById('date_arriver');
    const dateFin = document.getElementById('date_fin_de_validation');
    
    if (dateDebut && dateFin) {
        dateDebut.addEventListener('change', function() {
            if (dateFin.value && new Date(dateFin.value) < new Date(this.value)) {
                alert('La date de fin doit être postérieure ou égale à la date de début.');
                dateFin.value = '';
            }
        });
        
        dateFin.addEventListener('change', function() {
            if (dateDebut.value && new Date(this.value) < new Date(dateDebut.value)) {
                alert('La date de fin doit être postérieure ou égale à la date de début.');
                this.value = '';
            }
        });
    }
    
    // Si un projet est déjà sélectionné (après erreur de validation), déclencher le changement
    if (projectSelect.value) {
        console.log('🔍 Projet présélectionné détecté:', projectSelect.value);
        showDebug('Chargement auto pour projet ' + projectSelect.value);
        setTimeout(() => {
            console.log('🚀 Déclenchement auto du changement');
            projectSelect.dispatchEvent(new Event('change'));
        }, 800);
    }
    
    console.log('✅ Script initialisé avec succès');
    showDebug('Prêt - Sélectionnez un projet');
});
</script>

</body>
</html>