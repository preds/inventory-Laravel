<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

     {{-- debut Nav bar2  --}}

     <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input id="search-input" class="bg-light form-control border-0 small" type="text" placeholder="Rechercher ...">
                            <button class="btn btn-primary py-0" type="button" style="background: rgb(2,100,51);border-color: rgb(2,100,51);">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>


                    <ul class="navbar-nav flex-nowrap ms-auto">
                        <li class="nav-item dropdown d-sm-none no-arrow">
                            <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                            <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="me-auto navbar-search w-100">
                                    <div class="input-group">
                                        <input id="mobileSearchInput" class="bg-light form-control border-0 small" type="text" placeholder="Search for ..." oninput="fetchFilteredAssets()">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary py-0" type="button" onclick="fetchFilteredAssets()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <div class="d-none d-sm-block topbar-divider"></div>
                        <li class="nav-item dropdown no-arrow">
                            <div class="nav-item dropdown no-arrow">
                                @if(Auth::check())
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                                        <span class="d-none d-lg-inline me-2 text-gray-600 small">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                        <img class="border rounded-circle img-profile"
                                            src="{{ Auth::user()->photo ? asset('storage/avatars_photos/' . Auth::user()->photo) : asset('clientsAssets/img/dogs/image2.jpeg') }}"
                                            width="40" height="40">
                                    </a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" href="{{ route('users.showProfilPage') }}">
                                            <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profile
                                        </a>
                                        <a class="dropdown-item" href="{{ route('assets.showAssetManagementPage') }}">
                                            <i class="fas fa-eye fa-sm fa-fw me-2 text-gray-400"></i> View Asset
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                @else


                                    <a class="nav-link" href="{{ route('login') }}">
                                        <span class="d-none d-lg-inline me-2 text-gray-600 small">Guest</span>
                                        <span class="d-none d-lg-inline me-2 text-gray-600 small">Login</span>
                                    </a>
                                @endif

                                                                <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

{{-- Fin Nav bar 2  --}}

 <script>
    document.getElementById('search-input').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        var rows = document.querySelectorAll('table tbody tr');

        rows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            var match = false;
            cells.forEach(function(cell) {
                var text = cell.textContent.toLowerCase();
                if (text.indexOf(filter) > -1 && filter !== '') {
                    match = true;
                    var regex = new RegExp(filter, 'gi');
                    cell.innerHTML = cell.textContent.replace(regex, function(matched) {
                        return '<span class="highlight">' + matched + '</span>';
                    });
                } else {
                    cell.innerHTML = cell.textContent; // Clear previous highlights
                }
            });
            row.style.display = match ? '' : 'none';
        });
    });
</script>



<style>
    .sidebar {
    transition: all 0.3s ease;
}

.sidebar.toggled {
    margin-left: -250px; /* Ajustez cette valeur en fonction de la largeur de votre sidebar */
}

body.sidebar-toggled .sidebar {
    margin-left: 0;
}

</style>

<script>
    document.getElementById('sidebarToggleTop').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-toggled');
        document.querySelector('.sidebar').classList.toggle('toggled');
    });
</script>
