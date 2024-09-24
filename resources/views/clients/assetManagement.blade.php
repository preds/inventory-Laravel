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
                                   {{-- <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; width: 200px;"> --}}
                                        <input type="text" id="searchInput" name="search" placeholder="Search..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; width: 200px;">

                                        <select name="search_field" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                            <option value="all" {{ request('search_field') === 'all' ? 'selected' : '' }}>All Fields</option>
                                            <option value="designation" {{ request('search_field') === 'designation' ? 'selected' : '' }}>Designation</option>
                                            <option value="marque" {{ request('search_field') === 'marque' ? 'selected' : '' }}>Marque</option>
                                            <option value="responsable" {{ request('search_field') === 'responsable' ? 'selected' : '' }}>Responsable</option>
                                            <option value="modele" {{ request('search_field') === 'modele' ? 'selected' : '' }}>Modele</option>
                                            <option value="codification" {{ request('search_field') === 'codification' ? 'selected' : '' }}>Codification</option>
                                            <option value="etat" {{ request('search_field') === 'etat' ? 'selected' : '' }}>Etat</option>
                                            <option value="numero_serie_ou_chassis" {{ request('search_field') === 'numero_serie_ou_chassis' ? 'selected' : '' }}>Numéro de série ou Châssis</option>
                                            <!-- Add more fields as needed -->
                                        </select>
                                        <button type="submit" style="padding: 8px 12px; border: none; border-radius: 4px; background-color: #007bff; color: white; cursor: pointer;">Search</button>
                                        <select name="perPage" onchange="this.form.submit()" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                            <option value="5" {{ request('perPage') == '5' ? 'selected' : '' }}>5 per page</option>
                                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10 per page</option>
                                            <option value="15" {{ request('perPage') == '15' ? 'selected' : '' }}>15 per page</option>
                                            <option value="20" {{ request('perPage') == '20' ? 'selected' : '' }}>20 per page</option>
                                        </select>
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
<script>
    // Export Data (Déplacé en dehors du DOMContentLoaded)
    function exportData() {
        console.log('Export button clicked');
        document.getElementById('exportCategory').value = document.getElementById('categoryFilter').value;
        document.getElementById('exportLocation').value = document.getElementById('locationFilter').value;
        document.getElementById('exportEtat').value = document.getElementById('etatFilter').value;
        document.getElementById('exportSearch').value = document.getElementById('searchInput').value;
        document.getElementById('exportForm').submit();
    }

    document.addEventListener('DOMContentLoaded', function () {

        // Highlight Search Results
        function highlightSearchResults() {
            const searchQuery = new URLSearchParams(window.location.search).get('search');
            if (searchQuery) {
                const regex = new RegExp(searchQuery, 'gi');
                document.querySelectorAll('table tbody td').forEach(function (cell) {
                    const text = cell.textContent;
                    if (text.match(regex)) {
                        cell.innerHTML = text.replace(regex, function (matched) {
                            return `<span class="highlight">${matched}</span>`;
                        });
                    }
                });
            }
        }

        // Change Items Per Page
        function changePerPage(select) {
            const perPage = select.value;
            window.location.href = "{{ route('assets.showAssetManagementPage') }}?perPage=" + perPage;
        }

        // Fetch Filtered Assets
        function fetchFilteredAssets() {
            const category = $('#categoryFilter').val();
            const location = $('#locationFilter').val();
            const etat = $('#etatFilter').val();
            const searchQuery = $('#search-input').val().toLowerCase();

            $.ajax({
                url: '{{ route("filterAssets") }}',
                method: 'GET',
                data: {
                    category: category,
                    location: location,
                    etat: etat,
                    search: searchQuery
                },
                success: function (data) {
                    const tableBody = $('#assetsTableBody');
                    tableBody.empty(); // Clear current table content

                    data.forEach(function (asset, index) {
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${asset.category && asset.category.media ? '<img src="{{ asset("storage/") }}/' + asset.category.media.photo + '" alt="' + asset.category.category_name + '" style="max-width: 100px; max-height: 100px;">' : 'N/A'}</td>
                            <td>${asset.category ? asset.category.category_name : 'N/A'}</td>
                            <td>${asset.localisation}</td>`;

                        if (!isNaN(asset.designation)) {
                            $.ajax({
                                url: '/designations/' + asset.designation,
                                method: 'GET',
                                success: function (data) {
                                    const designation = data.designation_name ?? 'N/A';
                                    row += `<td>${designation}</td>
                                            <td>${asset.marque}</td>
                                            <td>${asset.modele}</td>
                                            <td>${asset.numero_serie_ou_chassis}</td>
                                            <td>${asset.etat}</td>
                                            <td>${asset.situation_exacte_du_materiel}</td>
                                            <td>${asset.responsable}</td>
                                            <td>${asset.quantite}</td>
                                            <td>${asset.date_achat ? new Date(asset.date_achat).toLocaleDateString() : 'N/A'}</td>
                                            <td>${asset.valeur}</td>
                                            <td>${asset.numero_piece_comptables}</td>
                                            <td>${asset.fournisseur}</td>
                                            <td>${asset.bailleur}</td>
                                            <td>${asset.projet}</td>
                                            <td>${asset.date_de_sortie ? new Date(asset.date_de_sortie).toLocaleDateString() : 'N/A'}</td>
                                            <td>${asset.codification}</td>
                                            <td>${asset.amortis}</td>
                                            <td>${getActionButtons(asset)}</td>
                                            <td>${getDeleteButton(asset)}</td>
                                        </tr>`;
                                    tableBody.append(row);
                                },
                                error: function () {
                                    row += '<td>N/A</td>';
                                    tableBody.append(row);
                                }
                            });
                        } else {
                            row += `<td>${asset.designation}</td>
                                    <td>${asset.marque}</td>
                                    <td>${asset.modele}</td>
                                    <td>${asset.numero_serie_ou_chassis}</td>
                                    <td>${asset.etat}</td>
                                    <td>${asset.situation_exacte_du_materiel}</td>
                                    <td>${asset.responsable}</td>
                                    <td>${asset.quantite}</td>
                                    <td>${asset.date_achat ? new Date(asset.date_achat).toLocaleDateString() : 'N/A'}</td>
                                    <td>${asset.valeur}</td>
                                    <td>${asset.numero_piece_comptables}</td>
                                    <td>${asset.fournisseur}</td>
                                    <td>${asset.bailleur}</td>
                                    <td>${asset.projet}</td>
                                    <td>${asset.date_de_sortie ? new Date(asset.date_de_sortie).toLocaleDateString() : 'N/A'}</td>
                                    <td>${asset.codification}</td>
                                    <td>${asset.amortis}</td>
                                    <td>${getActionButtons(asset)}</td>
                                    <td>${getDeleteButton(asset)}</td>
                                </tr>`;
                            tableBody.append(row);
                        }
                    });

                    reloadCustomCSS();
                }
            });
        }

        // Generate Action Buttons HTML
        function getActionButtons(asset) {
            let buttons = '';
            if ("{{ $groupName }}" == 'Administrator' || ("{{ $groupName }}" == 'Simple User' && asset.localisation == "{{ $user->localisation }}")) {
                buttons = `<form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">
                                @csrf
                                <input type="hidden" name="id" value="${asset.id}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                           </form>`;
            }
            return buttons;
        }

        // Generate Delete Button HTML
        function getDeleteButton(asset) {
            let button = '';
            if ("{{ $groupName }}" == 'Administrator' || ("{{ $groupName }}" == 'Simple User' && asset.localisation == "{{ $user->localisation }}")) {
                button = `<button class="btn btn-danger delete-btn" data-id="${asset.id}">
                              <i class="fas fa-trash"></i> Supprimer
                          </button>`;
            }
            return button;
        }

        // Reload Custom CSS
        function reloadCustomCSS() {
            const customCssLink = document.getElementById('customCssLink');
            if (customCssLink) {
                const href = customCssLink.getAttribute('href');
                const newHref = href + '?timestamp=' + new Date().getTime();
                customCssLink.setAttribute('href', newHref);
            }
        }

        // Handle Delete Button Click
        function handleDeleteButtonClick() {
            $(document).on('click', '.delete-btn', function () {
                const assetId = $(this).data('id');
                if (confirm('Êtes-vous sûr de vouloir supprimer cet actif?')) {
                    $.ajax({
                        url: '{{ route("assets.delete") }}',
                        type: 'DELETE',
                        data: {
                            id: assetId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Échec de la suppression de l\'actif.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        }

        // Handle Sidebar Toggle
        function handleSidebarToggle() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const navbar = document.querySelector('.navbar');

            sidebarToggle.addEventListener('click', function () {
                navbar.classList.toggle('navbar-reduced');
            });
        }

        // Search Functionality
        function searchInAllPages(filter) {
            const pages = document.querySelectorAll('.pagination-button');

            pages.forEach(function (page) {
                page.click();
            });

            setTimeout(function () {
                const rows = document.querySelectorAll('table tbody tr');

                rows.forEach(function (row) {
                    const cells = row.querySelectorAll('td');
                    let match = false;
                    cells.forEach(function (cell) {
                        const text = cell.textContent.toLowerCase();
                        if (text.indexOf(filter) > -1 && filter !== '') {
                            match = true;
                            const regex = new RegExp(filter, 'gi');
                            cell.innerHTML = cell.textContent.replace(regex, function (matched) {
                                return '<span class="highlight">' + matched + '</span>';
                            });
                        } else {
                            cell.innerHTML = cell.textContent;
                        }
                    });
                    row.style.display = match ? '' : 'none';
                });
            }, 1000);
        }

        // Event Listeners
        $('#categoryFilter, #locationFilter, #etatFilter, #searchInput').on('change input', fetchFilteredAssets);
        document.getElementById('search-input').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            searchInAllPages(filter);
        });

        handleDeleteButtonClick();
        handleSidebarToggle();
        highlightSearchResults();
    });
</script>

