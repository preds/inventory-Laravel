@extends('layouts.app')

@section('title', 'Mise à jour de l\'actif')

@section('contenu')
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

<div class="container-fluid">
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Modifation de l'actif "{{ $designations->firstWhere('id', $asset->designation)?->designation_name ?? 'N/A';}}" </span></h3>
    <div class="row mb-3">
        <div class="col-xxl-5">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">"{{ $designations->firstWhere('id', $asset->designation)?->designation_name ?? 'N/A';}}"</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('assetUpdate', ['id' => $asset->id]) }}">
                        @csrf
                        @method('PUT')


                        <div class="row">
                            {{-- Catégorie --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="categoryName"><strong>Catégorie</strong></label>
                                    <select class="form-control @error('categoryName') is-invalid @enderror" id="categoryName" name="category">
                                        @foreach($categoriesInDb as $category)
                                        <option value="{{ $category->id }}" {{ $asset->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('categoryName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Localisation --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="localisation"><strong>Localisation</strong></label>
                                    <select class="form-control @error('localisation') is-invalid @enderror" id="localisation" name="localisation">
                                        <option value="Ouagadougou" {{ $asset->localisation == 'Ouagadougou' ? 'selected' : '' }}>Ouagadougou</option>
                                        <option value="Ouahigouya" {{ $asset->localisation == 'Ouahigouya' ? 'selected' : '' }}>Ouahigouya</option>
                                        <option value="Koudougou" {{ $asset->localisation == 'Koudougou' ? 'selected' : '' }}>Koudougou</option>
                                        <option value="Kaya" {{ $asset->localisation == 'Kaya' ? 'selected' : '' }}>Kaya</option>
                                    </select>
                                    @error('localisation')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- Designation --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="designation"><strong>Désignation</strong></label>
                                    <select class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation" onchange="updateCodification()">
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}" data-abbreviation="{{ $designation->abbreviation_code }}" 
                                                {{ $designation->id == $currentDesignationId ? 'selected' : '' }}>
                                                {{ $designation->designation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                   

                            {{-- marque --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="marque"><strong>Marque</strong></label>
                                    <input class="form-control @error('marque') is-invalid @enderror" type="text" id="marque" name="marque" value="{{ $asset->marque }}">
                                    @error('marque')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- modele --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="modele"><strong>Modèle</strong></label>
                                    <input class="form-control @error('modele') is-invalid @enderror" type="text" id="modele" name="modele" value="{{ $asset->modele }}">
                                    @error('modele')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- numero de serie --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="numero_serie_ou_chassis"><strong>Numéro de série ou Châssis</strong></label>
                                    <input class="form-control @error('numero_serie_ou_chassis') is-invalid @enderror" type="text" id="numero_serie_ou_chassis" name="numero_serie_ou_chassis" value="{{ $asset->numero_serie_ou_chassis }}">
                                    @error('numero_serie_ou_chassis')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            {{-- etats --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="etat"><strong>État</strong></label>
                                    <select class="form-control @error('etat') is-invalid @enderror" id="etat" name="etat">
                                        <option value="Neuf" {{ old('etat') == 'Neuf' ? 'selected' : '' }}>Neuf - État parfait, jamais utilisé</option>
                                        <option value="Bon" {{ old('etat') == 'Bon' ? 'selected' : '' }}>Bon - État général bon, pleinement fonctionnel</option>
                                        <option value="Passable" {{ old('etat') == 'Passable' ? 'selected' : '' }}>Passable - Fonctionnel mais montre des signes d'usure ou de dégradation</option>
                                        {{-- <option value="À Réparer" {{ old('etat') == 'À Réparer' ? 'selected' : '' }}>À Réparer - Nécessite des réparations pour être pleinement fonctionnel</option>
                                        <option value="À Déclasser" {{ old('etat') == 'À Déclasser' ? 'selected' : '' }}>À Déclasser - À retirer du service actif mais peut avoir une certaine valeur pour des pièces ou autres utilisations</option>
                                        <option value="Hors Service Bon" {{ old('etat') == 'Hors Service Bon' ? 'selected' : '' }}>Hors Service Bon - Considéré hors service mais en bon état pour certaines pièces de rechange</option>
                                        <option value="Hors Service" {{ old('etat') == 'Hors Service' ? 'selected' : '' }}>Hors Service - Totalement inutilisable et à retirer</option> --}}
                                    </select>
                                    @error('etat')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- etats --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="situation_exacte_du_materiel"><strong>Situation exacte du matériel</strong></label>
                                    <input class="form-control @error('situation_exacte_du_materiel') is-invalid @enderror" type="text" id="situation_exacte_du_materiel" name="situation_exacte_du_materiel" value="{{ $asset->situation_exacte_du_materiel }}">
                                    @error('situation_exacte_du_materiel')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- responsable --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="responsable"><strong>Responsable</strong></label>
                                    <input class="form-control @error('responsable') is-invalid @enderror" type="text" id="responsable" name="responsable" value="{{ $asset->responsable }}">
                                    @error('responsable')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- quantite --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="quantite"><strong>Quantité</strong></label>
                                    <input class="form-control @error('quantite') is-invalid @enderror" type="number" id="quantite" name="quantite" value="{{ $asset->quantite }}">
                                    @error('quantite')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- date_achat --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="date_achat"><strong>Date d'achat</strong></label>
                                    <input class="form-control @error('date_achat') is-invalid @enderror" type="date" id="date_achat" name="date_achat" value="{{ $asset->date_achat }}">
                                    @error('date_achat')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- valeur --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="valeur"><strong>Valeur</strong></label>
                                    <input class="form-control @error('valeur') is-invalid @enderror" type="number" id="valeur" name="valeur" value="{{ $asset->valeur }}">
                                    @error('valeur')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- numero de piece comptables --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="numero_piece_comptables"><strong>Numéro de pièces comptables</strong></label>
                                    <input class="form-control @error('numero_piece_comptables') is-invalid @enderror" type="text" id="numero_piece_comptables" name="numero_piece_comptables" value="{{ $asset->numero_piece_comptables }}">
                                    @error('numero_piece_comptables')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Fournisseur --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="fournisseur"><strong>Fournisseur</strong></label>
                                    <input class="form-control @error('fournisseur') is-invalid @enderror" type="text" id="fournisseur" name="fournisseur" value="{{ $asset->fournisseur }}">
                                    @error('fournisseur')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                                {{-- Bailleur --}}
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="bailleur"><strong>Bailleur</strong></label>
                                        <select class="form-control @error('bailleur') is-invalid @enderror" id="bailleur" name="bailleur" onchange="updateCodification()">
                                            @foreach($bailleurs as $bailleur)
                                                <option value="{{ $bailleur->id }}" data-abbreviation="{{ $bailleur->abbreviation_code }}" 
                                                    {{ $bailleur->id == $currentBailleurId ? 'selected' : '' }}>
                                                    {{ $bailleur->bailleur_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bailleur')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            
                                {{-- Projet --}}
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="projet"><strong>Projet</strong></label>
                                        <select class="form-control @error('projet') is-invalid @enderror" id="projet" name="projet" onchange="updateCodification()">
                                            @foreach($projets as $projet)
                                                <option value="{{ $projet->id }}" data-abbreviation="{{ $projet->abbreviation_code }}" 
                                                    {{ $projet->id == $currentProjetId ? 'selected' : '' }}>
                                                    {{ $projet->projet_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('projet')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="date_de_sortie"><strong>Date de sortie</strong></label>
                                    <input class="form-control @error('date_de_sortie') is-invalid @enderror" type="date" id="date_de_sortie" name="date_de_sortie" value="{{ $asset->date_de_sortie }}">
                                    @error('date_de_sortie')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="codification"><strong>Codification</strong></label>
                                    <input class="form-control @error('codification') is-invalid @enderror" type="text" id="codification" name="codification" value="{{ old('codification', $asset->codification) }}" readonly>
                                    @error('codification')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">modifier</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow"></div>
        </div>
        <div class="col">
            <section class="mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card shadow">
                                <div class="card-header py-2" style="margin-top: -19px;padding-bottom: 0px;margin-bottom: 10px;">
                                    <p class="lead text-info m-0"><span style="color: rgb(12, 38, 174);">Apprecu</span></p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table mb-0 pt-3 pe-2">
                                        <table class="table table-striped table-sm my-0 mydatatable">
                                            <thead>
                                                <tr>
                                                    <th><span style="color: rgb(11, 12, 17);">Désignation</span></th>
                                                    <th><span style="color: rgb(11, 12, 17);">Marque</span></th>
                                                    <th><span style="color: rgb(11, 12, 17);">Modele</span></th>
                                                    <th><span style="color: rgb(11, 12, 17);">Responsable</span></th>
                                                    <th><span style="color: rgb(11, 12, 17);">Année d'acquisition</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach($assets as $asset)
                                                    <tr>
                                                        <td>{{ $asset->designation }}</td>
                                                <td>{{ $asset->modele }}</td>
                                                <td>{{ $asset->category ? $asset->category->category_name : 'Non catégorisé' }}</td>

                                                <td>{{ $asset->responsable }}</td>
                                                <td>{{ \Carbon\Carbon::parse($asset->date_achat)->format('Y M d') }}</td>
                                                </tr>
                                                @endforeach --}}
                                                <tr>
                                                    @php
                                                    // Si la valeur de `designation` est un nombre, il s'agit d'un ID
                                                    if (is_numeric($asset->designation)) {
                                                    $designationName = $designations->firstWhere('id', $asset->designation)?->designation_name ?? 'N/A';
                                                    } else {
                                                    // Sinon, il s'agit directement du nom de la désignation
                                                    $designationName = $asset->designation ?? 'N/A';
                                                    }
                                                    @endphp

                                                    <td>{{ $designationName }}</td>


                                                    <td>{{$asset->marque}}</td>
                                                    <td>{{$asset->modele}}</td>
                                                    <td>{{$asset->responsable}}</td>
                                                    <td>{{$asset->date_achat}}</td>
                                                </tr>




                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary pull-right" type="button" onclick="window.location='{{ route('assets.showAssetManagementPage') }}'">
                                <i class="fa fa-star" style="font-size: 0px;"></i>voir plus
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </section>
</div>
</div>
<div class="card shadow mb-5"></div>
</div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="clientsAssets/bootstrap/js/bootstrap.min.js"></script>
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
<script src="clientsAssets/js/DataTable---Fully-BSS-Editable-style.js"></script>
<script src="clientsAssets/js/Dynamic-Table-dynamic-table.js"></script>
<script src="clientsAssets/js/Table-With-Search-search-table.js"></script>
<script src="clientsAssets/js/theme.js"></script>


<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.mydatatable').DataTable();
    });

</script>


<script>
    $(document).ready(function() {
        $('.mydatatable').DataTable();
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Sélecteurs pour les champs du formulaire
    const localisationField = document.getElementById('localisation');
    const projetField = document.getElementById('projet');
    const bailleurField = document.getElementById('bailleur');
    const designationField = document.getElementById('designation');
    const codificationField = document.getElementById('codification');

    const localisationMapping = {
        'Ouagadougou': 'OUA',
        'Ouahigouya': 'OHG',
        'Kaya': 'KYA',
        'Koudougou': 'KDG'
    };

    // Récupère la valeur actuelle du champ Désignation
    const currentDesignationId = designationField.value;

    // Fonction pour préremplir le champ Désignation avec la valeur actuelle
    function setDesignationValue() {
        // Trouve l'option correspondante au currentDesignationId
        const currentDesignationOption = [...designationField.options].find(option => option.value == currentDesignationId);

        // Préremplit le champ Désignation avec la valeur actuelle
        if (currentDesignationOption) {
            designationField.value = currentDesignationId;
        }
    }

    // Fonction pour récupérer le code du bailleur
    function getBailleurCode() {
        const bailleurId = bailleurField.value;
        const selectedBailleur = [...bailleurField.options].find(option => option.value === bailleurId);
        return selectedBailleur ? selectedBailleur.getAttribute('data-abbreviation') : '';
    }

    // Fonction pour récupérer le code du projet
    function getProjetCode() {
        const projetId = projetField.value;
        const selectedProjet = [...projetField.options].find(option => option.value === projetId);
        return selectedProjet ? selectedProjet.getAttribute('data-abbreviation') : '';
    }

    // Fonction pour générer la codification
    function generateCodification(sequenceNumber) {
        const localisation = localisationMapping[localisationField.value.trim()] || localisationField.value.trim();
        const projetCode = getProjetCode();
        const bailleurCode = getBailleurCode();
        const designation = designationField.options[designationField.selectedIndex]?.getAttribute('data-abbreviation') || designationField.value.trim();

        // Utilise uniquement l'année actuelle
        const dateActuel = new Date().getFullYear().toString();

        // Création du code de codification
        const parts = [
            'BF', // Code pays
            localisation,
            projetCode || '_', // Utiliser un underscore si vide
            bailleurCode || '_', // Utiliser un underscore si vide
            designation,
            dateActuel,
            sequenceNumber.toString().padStart(3, '0')
        ].filter(part => part !== '');

        // Joindre les parties avec un slash
        const codification = parts.join('/');
        codificationField.value = codification;
    }

    function setCodificationWithFixedSequence(existingSequence) {
        const sequenceNumber = existingSequence || '001';  // Garder la séquence fixe si déjà existante
        generateCodification(sequenceNumber);
    }

    async function fetchExistingSequenceNumber() {
        // Récupérer la séquence existante depuis un attribut ou un autre moyen
        const existingSequence = codificationField.value.split('/').pop() || '001';
        setCodificationWithFixedSequence(existingSequence);
    }

    async function updateCodification() {
        await fetchExistingSequenceNumber();  // Utiliser la séquence existante pour l'update
    }

    // Mise à jour de la codification lors de la sélection
    bailleurField.addEventListener('change', updateCodification);
    projetField.addEventListener('change', updateCodification);
    localisationField.addEventListener('input', updateCodification);
    designationField.addEventListener('change', updateCodification);

    // Initialisation de la codification au chargement
    fetchExistingSequenceNumber();  // Conserver la séquence existante au chargement

    // Préremplir le champ Désignation avec la valeur actuelle
    setDesignationValue();
});
</script>



