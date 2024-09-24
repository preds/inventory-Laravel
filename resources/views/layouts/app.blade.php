<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<title>@yield('title')</title>
<link rel="stylesheet" href="{{ asset('clientsAssets/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Abril%20Fatface.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Nunito.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/fonts/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/fonts/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/fonts/fontawesome5-overrides.min.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Bootstrap-4---Table-Fixed-Header.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Dynamic-Table.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Manage-Users.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Navbar-Dropdown-List-Item.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/tablaresponsive-tablares.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/tablaresponsive.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Table-With-Search-search-table.css') }}">
<link rel="stylesheet" href="{{ asset('clientsAssets/css/Table-With-Search.css') }}">
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .nav-link.active {
        background-color: #004d33;
        color: #fff;
        
    }
    .highlight {
    color: #007754; /* Couleur modifiée */
}
</style>
</head>




<body id="page-top">
    <div id="wrapper">

            @include('layouts.navbar')
            @include('layouts.navbar2')


            {{-- debut du contenue --}}
            @yield('contenu')
            {{-- fin du contenue --}}

    
            {{-- debut footer --}}
            <footer class="bg-dark sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright Educo Burkina</span></div>
                </div>
            </footer>
                {{-- fin footer --}}
    </div>
        
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
        
</body>

</html>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var sidebarToggle = document.getElementById('sidebarToggle');
        var navbar = document.querySelector('.navbar');

        sidebarToggle.addEventListener('click', function () {
            navbar.classList.toggle('navbar-reduced');
        });

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
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var sidebarToggle = document.getElementById('sidebarToggle');
        var navbar = document.querySelector('.navbar'); // Remplacez '.navbar' par la classe ou l'ID de votre navbar

        sidebarToggle.addEventListener('click', function () {
            navbar.classList.toggle('navbar-reduced');
        });
    });
</script>




