<style>
    .sidebar {
        background-color: var(--couleur_sidebar);
    } 

</style>

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/tableau_de_bord') }}" style="color: #6c380b; background-color: #087a8a29;">
                <i class="bi bi-speedometer2" style="color: #6c380b;"></i>
                <span>Tableau de bord</span>
            </a>
        </li>
      
        @if(app('permission')->hasModule('projet'))
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#projet-nav" data-bs-toggle="collapse" href="#" style="color: #6c380b; background-color: #087a8a29;">
                <i class="bi bi-folder" style="color: #6c380b;"></i>
                <span>Projet</span>
                <i class="bi bi-chevron-down ms-auto" style="color: #6c380b;"></i>
            </a>
            <ul id="projet-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                @if(app('permission')->hasPermission('projet', 'creer'))
                <li>
                    <a href="{{ route('projets.create') }}" style="color: #b15d15;">
                        <i class="bi bi-plus-square" style="color: #b15d15;"></i>
                        <span>Création de Projet</span>
                    </a>
                </li>
                @endif

                @if(app('permission')->hasPermission('projet', 'lire'))
                <li>
                    <a href="{{ url('/projets') }}" style="color: #b15d15;">
                        <i class="bi bi-list-task" style="color: #b15d15;"></i>
                        <span>Liste des projets</span>
                    </a>
                </li>
                @endif

            </ul>
        </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="" style="color: #6c380b; background-color: #087a8a29;">
                <i class="bi bi-clock-history" style="color: #6c380b;"></i>
                <span>Historique</span>
            </a>
        </li>

       @if(app('permission')->hasModule('api') && app('permission')->hasPermission('api', 'apikey'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('parametre.index') }}" 
                    style="color: #6c380b; font-weight: 500; background-color: #087a8a29;">
                    <i class="bi bi-gear" style="color: #6c380b;"></i>
                    <span>Paramétrage</span>
                </a>
            </li>
        @endif

    </ul>
</aside>