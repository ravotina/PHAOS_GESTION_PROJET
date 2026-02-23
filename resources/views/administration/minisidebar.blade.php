<!-- Navigation -->
<div class="admin-nav">
    <div class="nav-grid">
        <a href="#" class="nav-item_a {{ $activePage === 'users' ? 'active' : '' }}">
            <i class="bi bi-people d-block mb-1"></i>
            Users
        </a>
        <!-- <a href="#" class="nav-item_a">
            <i class="bi bi-person-gear d-block mb-1"></i>
            Roles
        </a> -->
        <a href="{{ route('administration.liste_a_faire') }}" class="nav-item_a {{ $activePage === 'workflow' ? 'active' : '' }}">
            <i class="bi bi-diagram-3 d-block mb-1"></i>
            A Faire pendant la Preparation
        </a>
        <!-- <a href="#" class="nav-item_a">
            <i class="bi bi-bell d-block mb-1"></i>
            Notifs
        </a>
        <a href="#" class="nav-item_a">
            <i class="bi bi-shield-check d-block mb-1"></i>
            Audit
        </a>
        <a href="#" class="nav-item_a">
            <i class="bi bi-graph-up d-block mb-1"></i>
            Reports
        </a>
        <a href="#" class="nav-item_a">
            <i class="bi bi-gear d-block mb-1"></i>
            Config
        </a>
        <a href="#" class="nav-item_a">
            <i class="bi bi-archive d-block mb-1"></i>
            Backup
        </a> -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item_a');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Empêcher le comportement par défaut si c'est un lien #
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
            }
            
            // Retirer la classe active de tous les éléments
            navItems.forEach(nav => {
                nav.classList.remove('active');
            });
            
            // Ajouter la classe active à l'élément cliqué
            this.classList.add('active');
        });
    });
});
</script>