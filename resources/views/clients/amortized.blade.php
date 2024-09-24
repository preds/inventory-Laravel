@extends('layouts.app')

@section('title', 'Amortized Asset Details')

@section('contenu')
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">

<section class="mt-4">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);"> Details Des Assets Amortis</span></h3>
            <form id="exportForm" method="GET" action="{{ route('assets.exportLogExcel') }}">
                <button type="button" class="btn btn-success btn-sm d-none d-sm-inline-block" onclick="exportData()">
                    <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Export Excel
                </button>
            </form>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Amortized Asset Details</p>
                            <div class="d-flex">
                                <input type="text" id="search-input" class="form-control form-control-sm mr-2" placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                 
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
                    <div class="card-body">
                        <div class="table-responsive">
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
                                        <th>Date de sortie</th>
                                        <th>Codification</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="assetsTableBody">
                                    @foreach ($amortizedAssets as $asset)
                                    <tr class="contenu_tableau">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($asset->category && $asset->category->media)
                                                <img src="{{ asset('storage/' . $asset->category->media->photo) }}" alt="{{ $asset->category->category_name }}" style="max-width: 100px; max-height: 100px;">
                                            @else
                                                Pas d'image
                                            @endif
                                        </td>
                                        <td>{{ $asset->category->category_name ?? 'Non catégorisé' }}</td>
                                        <td>{{ $asset->localisation }}</td>
                                        <td>{{ $asset->designation }}</td>
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
                                        <td>{{ \Carbon\Carbon::parse($asset->date_de_sortie)->format('Y M d') }}</td>
                                        <td>{{ $asset->codification }}</td>
                                        <td>
                                            @if($groupName == 'Administrator' || ($groupName == 'Simple User' && $asset->localisation == $user->localisation))
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
                                            @if($groupName == 'Administrator' || ($groupName == 'Simple User' && $asset->localisation == $user->localisation))
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
                           {{-- Pagination --}}
    <div class="row">
        <div class="col-md-6 align-self-center">
            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                Montrer {{ $amortizedAssets->firstItem() }} à {{ $amortizedAssets->lastItem() }} de {{ $amortizedAssets->total() }} entrées
            </p>
        </div>
        <div class="col-md-6">
            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                {{ $amortizedAssets->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    </div>

    {{-- Sélecteur d'éléments par page --}}
    <div class="d-flex justify-content-center mt-3">
        <label for="perPage">Items par page:</label>
        <select id="perPage" class="form-select w-auto ml-2" onchange="changePerPage(this)">
            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
        </select>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<style>
    .table-responsive {
        max-height: 700px;
        overflow-y: auto;
    }

    .table-responsive thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: #fff;
    }

    .highlight {
        background-color: yellow;
    }
</style>
<script>
    function exportData() {
        document.getElementById('exportForm').submit();
    }

    function changePerPage(select) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', select.value);
        window.location.href = url.href; // Recharger la page avec le nouveau paramètre 'perPage'
    }
</script>

<script src="{{ asset('clientsAssets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('clientsAssets/js/DataTable---Fully-BSS-Editable-style.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Dynamic-Table-dynamic-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Table-With-Search-search-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/theme.js') }}"></script>



    
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
                    '<td>' + asset.localisation + '</td>' +
                    '<td>' + asset.designation + '</td>' +
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
                    '<td>' + (asset.date_de_sortie ? new Date(asset.date_de_sortie).toLocaleDateString() : 'N/A') + '</td>' +
                    '<td>' + asset.codification + '</td>' +
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
        var navbar = document.querySelector('.navbar'); // Remplacez '.navbar' par la classe ou l'ID de votre navbar

        sidebarToggle.addEventListener('click', function () {
            navbar.classList.toggle('navbar-reduced');
        });
    });
</script>
@endsection
