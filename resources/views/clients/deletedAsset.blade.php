@extends('layouts.app')

@section('title')
    Educo clientsAssets
@endsection

@section('contenu')
<section class="mt-4">
    
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(220, 49, 142);">Deleted Asset</span></h3>
          
    
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <p class=" m-0 fw-bold" style="color: rgb(220, 49, 142);">
                            <button class="btn btn-primary pull-right" type="button" onclick="window.location.href='{{ route('clients.showHomePage') }}'">
                                <i class="fa fa-star" style="font-size: 1px;  background-color: rgb(141, 78, 5);"></i>&nbsp;Return to Home Page
                            </button>
                            Assets
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="categoryFilter">Filter by Category</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="locationFilter">Filter by Location</label>
                                <select id="locationFilter" class="form-select">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="etatFilter">Filter by État</label>
                                <select id="etatFilter" class="form-select">
                                    <option value="">All États</option>
                                    @foreach($etats as $etat)
                                        <option value="{{ $etat }}">{{ $etat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTableContainer" role="grid" aria-describedby="dataTable_info">
                            <div class="table-responsive fixed-header-scroll">
                            <table class="table my-0" id="dataTable">
                                <thead class="table-header">
                                    <tr>
                                        <th>#</th>
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
                                    @foreach($deletedAssets as $asset)
                                        <tr class="contenu_tableau">
                                            <td>{{ $loop->iteration }}</td>
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
                                            <td>{{ $asset->quantite }}</td>
                                            <td>{{ \Carbon\Carbon::parse($asset->date_de_sortie)->format('Y M d') }}</td>
                                            <td>{{ $asset->codification }}</td>
                                            <td>
                                                <button class="btn btn-primary restore-btn" data-id="{{ $asset->id }}">Restore</button>
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
                                    Showing {{ $numberOfDeletedAssets->firstItem() }} to {{ $numberOfDeletedAssets->lastItem() }} of {{ $numberOfDeletedAssets->total() }} entries
                                </p>
                            </div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    {{ $numberOfDeletedAssets->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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


@endsection

{{-- centrer les header de mon tableau --}}


<script>
function changePerPage(select) {
    var perPage = select.value;
    var url = new URL(window.location.href);
    url.searchParams.set('perPage', perPage);
    window.location.href = url.toString();
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

{{-- new script --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

{{-- script pour le filtrage des elements --}}
<script>
$(document).ready(function() {
    function fetchFilteredAssets() {
        var category = $('#categoryFilter').val();
        var location = $('#locationFilter').val();
        var etat = $('#etatFilter').val();

        $.ajax({
            url: '{{ route("filterAssetsforAssetManagment") }}',
            method: 'GET',
            data: {
                category: category,
                location: location,
                etat: etat
            },
            success: function(data) {
                var tableBody = $('#assetsTableBody');
                tableBody.empty();

                data.forEach(function(asset) {
                    var row = '<tr>' +
                        '<td>' + asset.category + '</td>' +
                        '<td>' + asset.localisation + '</td>' +
                        '<td>' + asset.designation + '</td>' +
                        '<td>' + asset.marque + '</td>' +
                        '<td>' + asset.modele + '</td>' +
                        '<td>' + asset.numero_serie_ou_chassis + '</td>' +
                        '<td>' + asset.etat + '</td>' +
                        '<td>' + asset.situation_exacte_du_materiel + '</td>' +
                        '<td>' + asset.responsable + '</td>' +
                        '<td>' + asset.quantite + '</td>' +
                        '<td>' + new Date(asset.date_achat).getFullYear() + '</td>' +
                        '<td>' + asset.valeur + '</td>' +
                        '<td>' + asset.numero_piece_comptables + '</td>' +
                        '<td>' + asset.fournisseur + '</td>' +
                        '<td>' + asset.bailleur + '</td>' +
                        '<td>' + new Date(asset.date_de_sortie).getFullYear() + '</td>' +
                        '<td>' + asset.codification + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });
            }
        });
    }

    $('#categoryFilter').on('change', fetchFilteredAssets);
    $('#locationFilter').on('change', fetchFilteredAssets);
    $('#etatFilter').on('change', fetchFilteredAssets);
});
</script>

<script>
document.getElementById('addNewButton').addEventListener('click', function() {
    window.open("{{ route('assets.showAddAssetManagementPage') }}", "_blank", "width=600,height=600");
});
</script>

{{-- gestion du boutton restore --}}
<script>
    // Ajoute cet événement de clic pour le bouton "Restore"
$(document).ready(function() {
    $('.restore-btn').click(function() {
        var assetId = $(this).data('id');
        // Envoyer une requête AJAX pour restaurer l'actif
        $.ajax({
            url: '{{ route("assets.restore") }}',
            method: 'POST',
            data: {
                id: assetId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Si la restauration réussit, vous pouvez effectuer une action, comme recharger la page ou mettre à jour la vue
                    location.reload(); // Recharge la page après la restauration
                } else {
                    alert('Échec de la restauration de l\'actif.');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
</script>