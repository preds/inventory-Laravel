
{{--<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background: rgb(2,100,51);">--}}

        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background:#004b23">
    <div class="container-fluid d-flex flex-column p-0">
        <hr class="sidebar-divider my-0">
        <ul class="navbar-nav text-light" id="accordionSidebar">
            @if(Auth::check())
                @if(auth()->user()->group->level != 'Administrator')
                    <li class="nav-item">
                        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="{{ route('clients.homeClient') }}">
                            <div class="sidebar-brand-icon rotate-n-15"></div>
                            <div class="sidebar-brand-text mx-3">
                                <span>EDUCO INVENTAIRE</span>
                            </div>
                        </a>
                        <a class="nav-link {{ request()->routeIs('clients.showHomePage') ? 'active' : '' }}" href="{{ route('clients.showHomePage') }}">
                            <i class="fa fa-home"></i><span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.showProfilPage') ? 'active' : '' }}" href="{{ route('users.showProfilPage') }}">
                            <i class="fas fa-user"></i><span>Profile</span>
                        </a>
                    </li>
                    <!-- Gestion des actifs pour non-administrateurs -->
                    <li class="nav-item">
                        <a class="nav-link" href="#assetManagementSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-th-list"></i><span>Gestion des actifs</span>
                        </a>
                        <ul class="collapse list-unstyled" id="assetManagementSubMenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('category.showCategoryManagementPage') ? 'active' : '' }}" href="{{ route('category.showCategoryManagementPage') }}">
                                    <i class="fas fa-clipboard-list"></i><span>Categories des actifs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('assets.showAssetManagementPage') ? 'active' : '' }}" href="{{ route('assets.showAssetManagementPage') }}">
                                    <i class="fas fa-th-list"></i><span>Voir les actifs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('assets.showAddAssetManagementPage') ? 'active' : '' }}" href="{{ route('assets.showAddAssetManagementPage') }}">
                                    <i class="far fa-list-alt"></i><span>Ajouter un nouvel actif</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="{{ route('clients.homeClient') }}">
                            <div class="sidebar-brand-icon rotate-n-15"></div>
                            <div class="sidebar-brand-text mx-3"><span>EDUCO INVENTAIRE</span></div>
                        </a>
                        <a class="nav-link {{ request()->routeIs('clients.showHomePage') ? 'active' : '' }}" href="{{ route('clients.showHomePage') }}">
                            <i class="fas fa-tachometer-alt"></i><span>Tableau de bord</span>
                        </a>
                    </li>
                    <!-- Gestion utilisateurs/groupes pour administrateurs -->
                    <li class="nav-item">
                        <a class="nav-link" href="#userManagementSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-users-cog"></i><span>Gestion utilisateurs/groupes</span>
                        </a>
                        <ul class="collapse list-unstyled" id="userManagementSubMenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.showUserManagementPage') ? 'active' : '' }}" href="{{ route('users.showUserManagementPage') }}">
                                    <i class="fas fa-user"></i><span>Gestion des Utilisateurs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('groups.showGroupManagementPage') ? 'active' : '' }}" href="{{ route('groups.showGroupManagementPage') }}">
                                    <i class="fas fa-list"></i><span>Gestion des groupes</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Gestion des actifs pour administrateurs -->
                    <li class="nav-item">
                        <a class="nav-link" href="#assetManagementSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-th-list"></i><span>Gestion des actifs</span>
                        </a>
                        <ul class="collapse list-unstyled" id="assetManagementSubMenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('category.showCategoryManagementPage') ? 'active' : '' }}" href="{{ route('category.showCategoryManagementPage') }}">
                                    <i class="fas fa-clipboard-list"></i><span>Categories des actifs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('assets.showAssetManagementPage') ? 'active' : '' }}" href="{{ route('assets.showAssetManagementPage') }}">
                                    <i class="fas fa-th-list"></i><span>Voir les actifs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('assets.showAddAssetManagementPage') ? 'active' : '' }}" href="{{ route('assets.showAddAssetManagementPage') }}">
                                    <i class="far fa-list-alt"></i><span>Ajouter un nouvel actif</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Administration pour administrateurs -->
                    <li class="nav-item">
                        <a class="nav-link" href="#adminSubMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-cogs"></i><span>Administrations</span>
                        </a>
                        <ul class="collapse list-unstyled" id="adminSubMenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('logs.index') ? 'active' : '' }}" href="{{ route('logs.index') }}">
                                    <i class="fas fa-history"></i><span>Logs Utilisateurs</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('media.showMediaPage') ? 'active' : '' }}" href="{{ route('media.showMediaPage') }}">
                                    <i class="fas fa-photo-video"></i><span>Media</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('designations.showAddDesignationPage') ? 'active' : '' }}" href="{{ route('designations.showAddDesignationPage') }}">
                                    <i class="fas fa-tags"></i><span>Ajouter Désignation</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('task.log') ? 'active' : '' }}" href="{{ route('task.log') }}">
                                    <i class="fas fa-clipboard-list"></i><span class="ml-2">Logs des Tâches</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
            @endif
        </ul>
        <div class="text-center d-none d-md-inline">
            <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
        </div>
    </div>
</nav>

<!-- Fin Nav bar 1  -->
<style>
.nav-link.active {
    /*background-color: #00184d;*/
    background-color: #003c1e;
    color: #fff;
}

ul.navbar-nav ul.collapse .nav-item .nav-link {
    margin-left: 0px;
    /*background-color: #00184d;*/
    /*background-color: #026433;*/
    background-color: #003c1e;
    width: 97%;
}

ul.navbar-nav ul.collapse .nav-item .nav-link.active {
    background-color: #003321;
    color: #fff;
}


.sidebar {
    transition: all 0.3s ease;
}

.sidebar.toggled {
    width: 80px;
}

body.sidebar-toggled .sidebar {
    width: 80px;
}

</style>



<script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-toggled');
        document.querySelector('.sidebar').classList.toggle('toggled');
    });
</script>
