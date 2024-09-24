@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('contenu')
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">

<style></style>
@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
<div class="d-flex flex-column" id="content-wrapper">

    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0"><strong><span style="color: rgb(9, 179, 94);">Dashboard</span></strong></h3>
            <form id="exportForm" method="GET" action="{{ route('assets.exportExcel') }}">
                <input type="hidden" name="category" id="exportCategory">
                <input type="hidden" name="location" id="exportLocation">
                <input type="hidden" name="etat" id="exportEtat">
                <input type="hidden" name="search" id="exportSearch">
                <button type="button" class="btn btn-success btn-sm d-none d-sm-inline-block" onclick="exportData()">
                    <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Export Excel
                </button>
            </form>
        </div> 
        
        <div class="row">
            <!-- Users/Profile Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                @if(Auth::check())
                                    @if(auth()->user()->group->level === 'Administrator')
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Users</span></div>
                                        <div class="text-dark fw-bold h5 mb-0">
                                            <span>{{$totalUsers}}</span>
                                            <a href="{{ route('users.showUserManagementPage') }}" class="btn btn-sm btn-outline-primary ms-2">View</a>
                                        </div>
                                    @else
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Profile</span></div>
                                        <div class="text-dark  h5 mb-0">
                                            <span>{{ Auth::user()->username }}</span>
                                            <a href="{{ route('users.showProfilPage', Auth::user()->id) }}" class="btn btn-sm btn-outline-primary ms-2">View</a>
                                        </div>
                                    @endif    
                                @endif
                            </div>
                            <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Categories Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Categories</span></div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    <span>{{ $totalCategories }}</span>
                                    <a href="{{ route('category.showCategoryManagementPage') }}" class="btn btn-sm btn-outline-success ms-2">View</a>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Assets Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Assets</span></div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0">
                                            <span>{{ $totalAssets }}</span>
                                            <a href="{{ route('assets.showAssetManagementPage') }}" class="btn btn-sm btn-outline-info ms-2">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Deleted Assets Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                    <span><span style="color: rgb(220, 49, 142);">Deleted Assets</span></span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    <span>{{ $totalDeletedAssets }}</span>
                                    <a href="{{ route('showDeletedAssetsPage') }}" class="btn btn-sm  ms-2"style="border-color: rgb(220, 49, 142);color:rgb(220, 49, 142);">View</a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -32 576 576" width="1em" height="1em" fill="currentColor" class="fa-2x text-gray-300">
                                    <!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M576 384C576 419.3 547.3 448 512 448H205.3C188.3 448 172 441.3 160 429.3L9.372 278.6C3.371 272.6 0 264.5 0 256C0 247.5 3.372 239.4 9.372 233.4L160 82.75C172 70.74 188.3 64 205.3 64H512C547.3 64 576 92.65 576 128V384zM271 208.1L318.1 256L271 303C261.7 312.4 261.7 327.6 271 336.1C280.4 346.3 295.6 346.3 304.1 336.1L352 289.9L399 336.1C408.4 346.3 423.6 346.3 432.1 336.1C442.3 327.6 442.3 312.4 432.1 303L385.9 256L432.1 208.1C442.3 199.6 442.3 184.4 432.1 175C423.6 165.7 408.4 165.7 399 175L352 222.1L304.1 175C295.6 165.7 280.4 165.7 271 175C261.7 184.4 261.7 199.6 271 208.1V208.1z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    


    <section class="mt-4">
        <div class="container-fluid" >
            <div class="row">
                <div class="col">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Clients Assets</p>
                            <div class="d-flex">
                                <input type="text" id="searchInput" class="form-control form-control-sm mr-2" placeholder="Search...">
                                <button class="btn btn-primary" type="button" onclick="window.location.href='{{ route('assets.showAssetManagementPage') }}'">
                                    <i class="fa fa-star" style="font-size: 1px;"></i>&nbsp;Add New
                                </button>
                            </div>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="categoryFilter" class="filter-tile">Filter by Category</label>
                                    <select id="categoryFilter" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>                   
                                         @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="locationFilter" class="filter-tile">Filter by Location</label>
                                    <select id="locationFilter" class="form-select">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}">{{ $location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="etatFilter"class="filter-tile">Filter by État</label>
                                    <select id="etatFilter" class="form-select">
                                        <option value="">All États</option>
                                        @foreach($etats as $etat)
                                            <option value="{{ $etat }}">{{ $etat }}</option>
                                        @endforeach     
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTableContainer" role="grid" aria-describedby="dataTable_info">
                                <div class="table-responsive fixed-header-scroll" >
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
                                                <th>Quantité</th>
                                                <th>Date de sortie</th>
                                                <th>Codification</th>
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
                                                    <td>{{ $asset->category ? $asset->category->category_name : 'N/A' }}</td>
                                                    <td>{{ $asset->localisation ?? 'N/A' }}</td>
                                                    <td>{{ $asset->designation ?? 'N/A' }}</td>
                                                    <td>{{ $asset->marque ?? 'N/A' }}</td>
                                                    <td>{{ $asset->modele ?? 'N/A' }}</td>
                                                    <td>{{ $asset->numero_serie_ou_chassis ?? 'N/A' }}</td>
                                                    <td>{{ $asset->etat ?? 'N/A' }}</td>
                                                    <td>{{ $asset->situation_exacte_du_materiel ?? 'N/A' }}</td>
                                                    <td>{{ $asset->responsable ?? 'N/A' }}</td>
                                                    <td>{{ $asset->quantite ?? 0 }}</td>
                                                    <td>{{ $asset->date_achat ? \Carbon\Carbon::parse($asset->date_achat)->format('Y M d') : 'N/A' }}</td>
                                                    <td>{{ $asset->valeur ?? 0 }}</td>
                                                    <td>{{ $asset->numero_piece_comptables ?? 'N/A' }}</td>
                                                    <td>{{ $asset->fournisseur ?? 'N/A' }}</td>
                                                    <td>{{ $asset->bailleur ?? 'N/A' }}</td>
                                                    <td>{{ $asset->quantite ?? 0 }}</td>
                                                    <td>{{ $asset->date_de_sortie ? \Carbon\Carbon::parse($asset->date_de_sortie)->format('Y M d') : 'N/A' }}</td>
                                                    <td>{{ $asset->codification ?? 'N/A' }}</td>
                                                    <td>
                                                        <form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $asset->id }}">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-edit"></i> Modifier
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger delete-btn" data-id="{{ $asset->id }}">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
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
                                        Showing {{ $assets->firstItem() }} to {{ $assets->lastItem() }} of {{ $assets->total() }} entries
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        {{ $assets->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <label for="perPage">Items per page:</label>
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
</div>
</div>

</div>
</div>

{{-- <style>
    .contenu_tableau{
        font-size: 12px;
    }
</style> --}}
@endsection


<script>
    function changePerPage(select) {
        var perPage = select.value;
        window.location.href = "{{ route('clients.showHomePage')}}?perPage=" + perPage;
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
            var searchQuery = $('#searchInput').val().toLowerCase(); // Récupérer la valeur de la barre de recherche
    
            $.ajax({
                url: '{{ route("filterAssets") }}',
                method: 'GET',
                data: {
                    category: category,
                    location: location,
                    etat: etat,
                    search: searchQuery // Envoyer la valeur de recherche
                },
                success: function(data) {
                    var tableBody = $('#assetsTableBody');
                    tableBody.empty(); // Vider le contenu actuel du tableau
    
                    data.forEach(function(asset, index) {
                        var row = 
                            '<tr>' +
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
                                '<td>' +
                                    '<form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">' +
                                        '@csrf' +
                                        '<input type="hidden" name="id" value="' + asset.id + '">' +
                                        '<button type="submit" class="btn btn-primary">' +
                                            '<i class="fas fa-edit"></i> Modifier' +
                                        '</button>' +
                                    '</form>' +
                                '</td>' +
                                '<td>' +
                                    '<button class="btn btn-danger delete-btn" data-id="' + asset.id + '">' +
                                        '<i class="fas fa-trash"></i> Supprimer' +
                                    '</button>' +
                                '</td>' +
                            '</tr>';
                        
                        // Highlight the search query in the table row if it exists
                        if (searchQuery) {
                            var regex = new RegExp(searchQuery, 'gi');
                            row = row.replace(regex, function(matched) {
                                return '<span class="highlight">' + matched + '</span>';
                            });
                        }
    
                        tableBody.append(row);
                    });
    
                    reloadCustomCSS();
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
   
{{-- script du boutton supprimer --}}
<script>
    // Gestionnaire d'événement pour le clic sur le bouton Supprimer
      $(document).ready(function() {
    
      $('.delete-btn').click(function() {
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
  