@extends('layouts.app')

@section('title', 'Invalid Date Assets')

@section('contenu')
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">

<section class="mt-4">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Invalid Date Assets</span></h3>
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
                            <p class="text-primary m-0 fw-bold">Invalid Date Assets</p>
                            <div class="d-flex">
                                <input type="text" id="search-input" class="form-control form-control-sm mr-2" placeholder="Search...">
                            </div>
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
                                    @foreach ($invalidAssets as $asset)
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
                                            <form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $asset->id }}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot></tfoot>
                            </table>
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
        max-height: 600px;
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
@endsection
