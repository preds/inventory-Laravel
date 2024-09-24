@extends('layouts.app')
@section('title')
    Edit Group
@endsection
@section('contenu')
<div class="container-fluid">
    <button class="btn btn-primary pull-right" type="button" onclick="window.location.href='{{ route('groups.showGroupManagementPage') }}'">
        <i class="fa fa-star" style="font-size: 1px; background-color: rgb(141, 78, 5);"></i>&nbsp;Return 
    </button>
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Edit User Group</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-4">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Edit Group</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('assets.exportExcel') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category">Catégorie :</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Toutes les catégories</option>
                                        <!-- Inclure les options de catégorie ici -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="location">Localisation :</label>
                                    <select name="location" id="location" class="form-control">
                                        <option value="">Toutes les localisations</option>
                                        <!-- Inclure les options de localisation ici -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="etat">État :</label>
                                    <select name="etat" id="etat" class="form-control">
                                        <option value="">Tous les états</option>
                                        <!-- Inclure les options d'état ici -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search">Recherche :</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher...">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Exporter Excel</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow"></div>
        </div>
    </div>
</div>
</div>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Catégorie</th>
            <th>Localisation</th>
            <th>Désignation</th>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Numéro de série ou Châssis</th>
            <th>État</th>
            <th>Responsable</th>
            <th>Quantité</th>
            <th>Date d'achat</th>
            <th>Valeur</th>
            <th>Fournisseur</th>
            <th>Bailleur</th>
            <th>Date de sortie</th>
            <th>Codification</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assets as $asset)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $asset->category->category_name ?? 'Non catégorisé' }}</td>
                <td>{{ $asset->localisation }}</td>
                <td>{{ $asset->designation }}</td>
                <td>{{ $asset->marque }}</td>
                <td>{{ $asset->modele }}</td>
                <td>{{ $asset->numero_serie_ou_chassis }}</td>
                <td>{{ $asset->etat }}</td>
                <td>{{ $asset->responsable }}</td>
                <td>{{ $asset->quantite }}</td>
                <td>{{ \Carbon\Carbon::parse($asset->date_achat)->format('Y M d') }}</td>
                <td>{{ $asset->valeur }}</td>
                <td>{{ $asset->fournisseur }}</td>
                <td>{{ $asset->bailleur }}</td>
                <td>{{ \Carbon\Carbon::parse($asset->date_de_sortie)->format('Y M d') }}</td>
                <td>{{ $asset->codification }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
