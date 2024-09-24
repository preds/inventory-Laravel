@extends('layouts.app')
@section('title')
    Actifs Educo
@endsection
@section('contenu')
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">
<section class="mt-4">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Gestion des actifs</span></h3>
            <form id="exportForm" method="GET" action="{{ route('assets.exportExcel') }}">
                <input type="hidden" name="category" id="exportCategory">
                <input type="hidden" name="location" id="exportLocation">
                <input type="hidden" name="etat" id="exportEtat">
                <input type="hidden" name="search" id="exportSearch">
                <button type="button" class="btn btn-success btn-sm d-none d-sm-inline-block" onclick="exportData()">
                    <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Exporter en Excel
                </button>
            </form>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Actifs</p>
                            <button class="btn btn-primary" type="button" onclick="window.location.href='{{ route('assets.showAddAssetManagementPage') }}'">
                                <i class="fa fa-star" style="font-size: 1px; width: "></i>&nbsp;Ajouter
                            </button>
                            <div class="d-flex">
                                <form action="/search-assets" method="GET" style="display: flex; gap: 10px; align-items: center;">
                                    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; width: 200px;">
                                    <select name="search_field" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                        <option value="all" {{ request('search_field') === 'all' ? 'selected' : '' }}>All Fields</option>
                                        <option value="designation" {{ request('search_field') === 'designation' ? 'selected' : '' }}>Designation</option>
                                        <option value="marque" {{ request('search_field') === 'marque' ? 'selected' : '' }}>Marque</option>
                                        <option value="modele" {{ request('search_field') === 'modele' ? 'selected' : '' }}>Modele</option>
                                        <option value="situation_exacte_du_materiel" {{ request('search_field') === 'situation_exacte_du_materiel' ? 'selected' : '' }}>situation exacte du materiel</option>
                                        <option value="responsable" {{ request('search_field') === 'responsable' ? 'selected' : '' }}>responsable</option>
                                        <option value="codification" {{ request('search_field') === 'codification' ? 'selected' : '' }}>Codification</option>
                                        <option value="etat" {{ request('search_field') === 'etat' ? 'selected' : '' }}>Etat</option>
                                        <option value="numero_serie_ou_chassis" {{ request('search_field') === 'numero_serie_ou_chassis' ? 'selected' : '' }}>Numéro de série ou Châssis</option>
                                        <!-- Add more fields as needed -->
                                    </select>
                                    <button type="submit" style="padding: 8px 12px; border: none; border-radius: 4px; background-color: #007bff; color: white; cursor: pointer;">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="categoryFilter">Filtrer par catégorie</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="locationFilter">Filtrer par localisation</label>
                                <select id="locationFilter" class="form-select">
                                    <option value="">Toutes les localités</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="etatFilter">Filtrer par État</label>
                                <select id="etatFilter" class="form-select">
                                    <option value="">Tous les États</option>
                                    @foreach($etats as $etat)
                                        <option value="{{ $etat }}">{{ $etat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTableContainer" role="grid" aria-describedby="dataTable_info">
                            <div class="table-responsive fixed-header-scrolls">
                                <table class="table my-0" id="dataTable">
                                    <thead class="table-header">
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Catégorie</th>
                                            <th>Localisation</th>
                                            <th>Désignation</th>
                                            <th>Marque</th>
                                            <th>Modèle</th>
                                            <th>Numéro de série ou Châssis</th>
                                            <th>État</th>
                                            <th>Situation exacte du matériel</th>
                                            <th>Responsable</th>
                                            <th>Quantité</th>
                                            <th>Date d'achat</th>
                                            <th>Valeur</th>
                                            <th>Numéro de pièces comptables</th>
                                            <th>Fournisseur</th>
                                            <th>Bailleur</th>
                                            <th>Projet</th>
                                            <th>Date de sortie</th>
                                            <th>Codification</th>
                                            <th>Amortis</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assetsTableBody">
                                        @foreach($assets as $asset)
                                        <tr class="contenu_tableau">
                                            <td>{{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}</td>
                                            <td>
                                                @if($asset->category && $asset->category->media)
                                                    <img src="{{ asset('storage/' . $asset->category->media->photo) }}" alt="{{ $asset->category->category_name }}" style="max-width: 100px; max-height: 100px;">
                                                @else
                                                    Pas d'image
                                                @endif
                                            </td>
                                            <td>{{ $asset->category->category_name ?? 'Non catégorisé' }}</td>
                                            <td>{{ $asset->localisation }}</td>
                                            <td>
                                                @if(is_numeric($asset->designation))
                                                    {{ \App\Models\Designation::find($asset->designation)->designation_name ?? 'N/A' }}
                                                @else
                                                    {{ $asset->designation }}
                                                @endif
                                            </td>
                                            <td>{{ $asset->marque }}</td>
                                            <td>{{ $asset->modele }}</td>
                                            <td>{{ $asset->numero_serie_ou_chassis }}</td>
                                            <td>{{ $asset->etat }}</td>
                                            <td>{{ $asset->situation_exacte_du_materiel }}</td>
                                            <td>{{ $asset->responsable }}</td>
                                            <td>{{ $asset->quantite }}</td>
                                            <td>{{ \Carbon\Carbon::parse($asset->date_achat)->format('Y M d') }}</td>
                                            <td>{{ $asset->valeur }}</td>
                                            <td>{{ $asset->numero_piece_comptables }}</td>
                                            <td>{{ $asset->fournisseur }}</td>
                                            <td>{{ $asset->bailleur }}</td>
                                            <td>{{ $asset->projet }}</td>
                                            <td>{{ \Carbon\Carbon::parse($asset->date_de_sortie)->format('Y M d') }}</td>
                                            <td>{{ $asset->codification }}</td>
                                            <td>{{ $asset->amortis }}</td>
                                            <td>
                                                @if($groupName== 'Administrator' || ($groupName== 'Simple User' && $asset->localisation == $user->localisation))
                                                    <form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $asset->id }}">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-edit"></i> Modifier
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                @if($groupName== 'Administrator' || ($groupName== 'Simple User' && $asset->localisation == $user->localisation))
                                                    <button class="btn btn-danger delete-btn" data-id="{{ $asset->id }}">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                    Montrer {{ $assets->firstItem() }} à {{ $assets->lastItem() }} de {{ $assets->total() }} entrées
                                </p>
                            </div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    {{ $assets->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                                </nav>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <label for="perPage">Articles par page:</label>
                            <select id="perPage" class="form-select w-auto ml-2" onchange="changePerPage(this)">
                                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<style>
    .nav-link.active {
        background-color: #004d33;
        color: #fff;
    }

    input[type="text"], select, button {
        transition: all 0.3s ease;
    }

    input[type="text"]:focus, select:focus, button:hover {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
    }
</style>
{{--    script de mise en evidence des elements correspondant a la recheche.--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchQuery = new URLSearchParams(window.location.search).get('search');
        if (searchQuery) {
            const regex = new RegExp(searchQuery, 'gi');
            document.querySelectorAll('table tbody td').forEach(function(cell) {
                const text = cell.textContent;
                if (text.match(regex)) {
                    cell.innerHTML = text.replace(regex, function(matched) {
                        return `<span class="highlight">${matched}</span>`;
                    });
                }
            });
        }
    });
</script>
<script>
    function changePerPage(select) {
        var perPage = select.value;
        window.location.href = "{{ route('assets.showAssetManagementPage') }}?perPage=" + perPage;
    }
            //scripts pour exporter les données au clic du boutton
    function exportData() {
        document.getElementById('exportCategory').value = document.getElementById('categoryFilter').value;
        document.getElementById('exportLocation').value = document.getElementById('locationFilter').value;
        document.getElementById('exportEtat').value = document.getElementById('etatFilter').value;
        document.getElementById('exportSearch').value = document.getElementById('searchInput').value;
        document.getElementById('exportForm').submit();
    }
</script>
<script src="{{ asset('clientsAssets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="{{ asset('clientsAssets/js/DataTable---Fully-BSS-Editable-style.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Dynamic-Table-dynamic-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Table-With-Search-search-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/theme.js') }}"></script>

<!-- New scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

{{-- Script pour le filtrage des éléments --}}
<script>
    $(document).ready(function() {
        function fetchFilteredAssets() {
            var category = $('#categoryFilter').val();
            var location = $('#locationFilter').val();
            var etat = $('#etatFilter').val();
            var searchQuery = $('#search-input').val().toLowerCase();

            $.ajax({
                url: '{{ route("filterAssets") }}',
                method: 'GET',
                data: {
                    category: category,
                    location: location,
                    etat: etat,
                    search: searchQuery
                },
                success: function(data) {
                    var tableBody = $('#assetsTableBody');
                    tableBody.empty(); // Vider le contenu actuel du tableau

                    data.forEach(function(asset, index) {
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + (asset.category && asset.category.media ? '<img src="{{ asset("storage/") }}/' + asset.category.media.photo + '" alt="' + asset.category.category_name + '" style="max-width: 100px; max-height: 100px;">' : 'N/A') + '</td>' +
                            '<td>' + (asset.category ? asset.category.category_name : 'N/A') + '</td>' +
                            '<td>' + asset.localisation + '</td>';

                        // Vérifier si la désignation est un ID et obtenir la désignation correspondante
                        if (!isNaN(asset.designation)) {
                            $.ajax({
                                url: '/designations/' + asset.designation, // Assurez-vous que cette route existe pour récupérer une désignation par ID
                                method: 'GET',
                                success: function(data) {
                                    var designation = data.designation_name ?? 'N/A';
                                    row += '<td>' + designation + '</td>' +
                                        '<td>' + asset.marque + '</td>' +
                                        '<td>' + asset.modele + '</td>' +
                                        '<td>' + asset.numero_serie_ou_chassis + '</td>' +
                                        '<td>' + asset.etat + '</td>' +
                                        '<td>' + asset.situation_exacte_du_materiel + '</td>' +
                                        '<td>' + asset.responsable + '</td>' +
                                        '<td>' + asset.quantite + '</td>' +
                                        '<td>' + (asset.date_achat ? new Date(asset.date_achat).toLocaleDateString() : 'N/A') + '</td>' +
                                        '<td>' + asset.valeur + '</td>' +
                                        '<td>' + asset.numero_piece_comptables + '</td>' +
                                        '<td>' + asset.fournisseur + '</td>' +
                                        '<td>' + asset.bailleur + '</td>' +
                                        '<td>' + asset.projet + '</td>' +
                                        '<td>' + (asset.date_de_sortie ? new Date(asset.date_de_sortie).toLocaleDateString() : 'N/A') + '</td>' +
                                        '<td>' + asset.codification + '</td>' +
                                        '<td>' + asset.amortis + '</td>' +
                                        '<td>';

                                    // Vérifiez à nouveau les conditions pour afficher les boutons Modifier et Supprimer
                                    if ("{{ $groupName }}" == 'Administrator' || ("{{ $groupName }}" == 'Simple User' && asset.localisation == "{{ $user->localisation }}")) {
                                        row += '<form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">' +
                                            '@csrf' +
                                            '<input type="hidden" name="id" value="' + asset.id + '">' +
                                            '<button type="submit" class="btn btn-primary">' +
                                            '<i class="fas fa-edit"></i> Modifier' +
                                            '</button>' +
                                            '</form>';
                                    }
                                    row += '</td>' +
                                        '<td>';

                                    if ("{{ $groupName }}" == 'Administrator' || ("{{ $groupName }}" == 'Simple User' && asset.localisation == "{{ $user->localisation }}")) {
                                        row += '<button class="btn btn-danger delete-btn" data-id="' + asset.id + '">' +
                                            '<i class="fas fa-trash"></i> Supprimer' +
                                            '</button>';
                                    }
                                    row += '</td>' +
                                        '</tr>';

                                    tableBody.append(row);
                                },
                                error: function() {
                                    row += '<td>N/A</td>';
                                    tableBody.append(row);
                                }
                            });
                        } else {
                            row += '<td>' + asset.designation + '</td>' +
                                '<td>' + asset.marque + '</td>' +
                                '<td>' + asset.modele + '</td>' +
                                '<td>' + asset.numero_serie_ou_chassis + '</td>' +
                                '<td>' + asset.etat + '</td>' +
                                '<td>' + asset.situation_exacte_du_materiel + '</td>' +
                                '<td>' + asset.responsable + '</td>' +
                                '<td>' + asset.quantite + '</td>' +
                                '<td>' + (asset.date_achat ? new Date(asset.date_achat).toLocaleDateString() : 'N/A') + '</td>' +
                                '<td>' + asset.valeur + '</td>' +
                                '<td>' + asset.numero_piece_comptables + '</td>' +
                                '<td>' + asset.fournisseur + '</td>' +
                                '<td>' + asset.bailleur + '</td>' +
                                '<td>' + asset.projet + '</td>' +
                                '<td>' + (asset.date_de_sortie ? new Date(asset.date_de_sortie).toLocaleDateString() : 'N/A') + '</td>' +
                                '<td>' + asset.codification + '</td>' +
                                '<td>' + asset.amortis + '</td>' +
                                '<td>';

                            // Vérifiez à nouveau les conditions pour afficher les boutons Modifier et Supprimer
                            if ("{{ $groupName }}" == 'Administrator' || ("{{ $groupName }}" == 'Simple User' && asset.localisation == "{{ $user->localisation }}")) {
                                row += '<form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">' +
                                    '@csrf' +
                                    '<input type="hidden" name="id" value="' + asset.id + '">' +
                                    '<button type="submit" class="btn btn-primary">' +
                                    '<i class="fas fa-edit"></i> Modifier' +
                                    '</button>' +
                                    '</form>';
                            }
                            row += '</td>' +
                                '<td>';

                            if ("{{ $groupName }}" == 'Administrator' || ("{{ $groupName }}" == 'Simple User' && asset.localisation == "{{ $user->localisation }}")) {
                                row += '<button class="btn btn-danger delete-btn" data-id="' + asset.id + '">' +
                                    '<i class="fas fa-trash"></i> Supprimer' +
                                    '</button>';
                            }
                            row += '</td>' +
                                '</tr>';

                            tableBody.append(row);
                        }
                    });

                    reloadCustomCSS(); // Rechargez les CSS personnalisés après la mise à jour du tableau
                }
            });
        }
        // Attach event listeners for filter changes and search
        $('#categoryFilter, #locationFilter, #etatFilter, #searchInput').on('change input', fetchFilteredAssets);

        function reloadCustomCSS() {
            var customCssLink = document.getElementById('customCssLink');
            if (customCssLink) {
                var href = customCssLink.getAttribute('href');
                var newHref = href + '?timestamp=' + new Date().getTime();
                customCssLink.setAttribute('href', newHref);
            }
        }
    });
</script>
{{-- Script du bouton supprimer --}}
<script>
    $(document).ready(function() {
        // Gestionnaire d'événement pour le clic sur le bouton Supprimer
        $(document).on('click', '.delete-btn', function() {
            var assetId = $(this).data('id');
            if (confirm('Êtes-vous sûr de vouloir supprimer cet actif?')) {
                $.ajax({
                    url: '{{ route("assets.delete") }}',
                    type: 'DELETE',
                    data: {
                        id: assetId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Rafraîchir la liste des actifs
                            location.reload();
                        } else {
                            alert('Échec de la suppression de l\'actif.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
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
    var navbar = document.querySelector('.navbar');

    sidebarToggle.addEventListener('click', function () {
        navbar.classList.toggle('navbar-reduced');
    });

    // Fonction pour rechercher dans toutes les pages
    function searchInAllPages(filter) {
        var pages = document.querySelectorAll('.pagination-button'); // Sélecteur pour vos boutons de pagination

        pages.forEach(function(page) {
            page.click(); // Simuler le clic sur chaque bouton de page pour déplier les lignes
        });

        setTimeout(function() { // Attendre que toutes les pages soient chargées
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
        }, 1000); // Ajuster le délai en fonction de la vitesse de chargement des pages
    }

    document.getElementById('search-input').addEventListener('input', function() {
        var filter = this.value.toLowerCase();
        searchInAllPages(filter);
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
