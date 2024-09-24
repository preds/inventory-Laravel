@extends('layouts.app')

@section('title', 'Ajouter Actif')

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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Ajouter un nouvel actif</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-5">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Ajouter un nouvel actif</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('assets.addNewAssetInDb') }}">
                        @csrf
                        <div class="row">
                            {{-- categories --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="categoryName"><strong>Categorie</strong></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- localisation --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="localisation"><strong>Localisation</strong></label>
                                    <select class="form-control @error('localisation') is-invalid @enderror" id="localisation" name="localisation">
                                        <option value="Ouagadougou" {{ old('localisation') == 'Ouagadougou' ? 'selected' : '' }}>Ouagadougou</option>
                                        <option value="Ouahigouya" {{ old('localisation') == 'Ouahigouya' ? 'selected' : '' }}>Ouahigouya</option>
                                        <option value="Koudougou" {{ old('localisation') == 'Koudougou' ? 'selected' : '' }}>Koudougou</option>
                                        <option value="Kaya" {{ old('localisation') == 'Kaya' ? 'selected' : '' }}>Kaya</option>
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
                                    <select class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation">
                                        <option value="">-- Sélectionner une désignation --</option>
                                        @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" data-abbreviation="{{ $designation->abbreviation_code }}">{{ $designation->designation_name }}</option>
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
                                    <input class="form-control @error('marque') is-invalid @enderror" type="text" id="marque" name="marque" value="{{ old('marque') }}">
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
                                    <input class="form-control @error('modele') is-invalid @enderror" type="text" id="modele" name="modele" value="{{ old('modele') }}">
                                    @error('modele')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- numero de serie --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="numero_serie_ou_chassis"><strong>Numéro de série ou Châssis</strong></label>
                                    <input class="form-control @error('numero_serie_ou_chassis') is-invalid @enderror" type="text" id="numero_serie_ou_chassis" name="numero_serie_ou_chassis" value="{{ old('numero_serie_ou_chassis') }}">
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
                                        <option value="À Réparer" {{ old('etat') == 'À Réparer' ? 'selected' : '' }}>À Réparer - Nécessite des réparations pour être pleinement fonctionnel</option>
                                        <option value="À Déclasser" {{ old('etat') == 'À Déclasser' ? 'selected' : '' }}>À Déclasser - À retirer du service actif mais peut avoir une certaine valeur pour des pièces ou autres utilisations</option>
                                        <option value="Hors Service Bon" {{ old('etat') == 'Hors Service Bon' ? 'selected' : '' }}>Hors Service Bon - Considéré hors service mais en bon état pour certaines pièces de rechange</option>
                                        <option value="Hors Service" {{ old('etat') == 'Hors Service' ? 'selected' : '' }}>Hors Service - Totalement inutilisable et à retirer</option>
                                    </select>
                                    @error('etat')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- situation exacte --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="situation_exacte_du_materiel"><strong>Situation exacte du matériel</strong></label>
                                    <input class="form-control @error('situation_exacte_du_materiel') is-invalid @enderror" type="text" id="situation_exacte_du_materiel" name="situation_exacte_du_materiel" value="{{ old('situation_exacte_du_materiel') }}">
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
                                    <input class="form-control @error('responsable') is-invalid @enderror" type="text" id="responsable" name="responsable" value="{{ old('responsable') }}">
                                    @error('responsable')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- quantite --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="quantite"><strong>Quantité</strong></label>
                                    <input class="form-control @error('quantite') is-invalid @enderror" type="number" id="quantite" name="quantite" value="{{ old('quantite') }}">
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
                                    <input class="form-control @error('date_achat') is-invalid @enderror" type="date" id="date_achat" name="date_achat" value="{{ old('date_achat') }}">
                                    @error('date_achat')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- valeur --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="valeur"><strong>Valeur</strong></label>
                                    <input class="form-control @error('valeur') is-invalid @enderror" type="number" id="valeur" name="valeur" value="{{ old('valeur') }}">
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
                                    <input class="form-control @error('numero_piece_comptables') is-invalid @enderror" type="text" id="numero_piece_comptables" name="numero_piece_comptables" value="{{ old('numero_piece_comptables') }}">
                                    @error('numero_piece_comptables')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Fournisseur --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="fournisseur"><strong>Fournisseur</strong></label>
                                    <input class="form-control @error('fournisseur') is-invalid @enderror" type="text" id="fournisseur" name="fournisseur" value="{{ old('fournisseur') }}">
                                    @error('fournisseur')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- bailleur --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="bailleur"><strong>Bailleur</strong></label>
                                    <input class="form-control @error('bailleur') is-invalid @enderror" type="text" id="bailleur" name="bailleur" value="{{ old('bailleur') }}">
                                    @error('bailleur')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- projet --}}

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="projet"><strong>Projet</strong></label>
                                    <input class="form-control @error('projet') is-invalid @enderror" type="text" id="projet" name="projet" value="{{ old('projet') }}">
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
                                    <input class="form-control @error('date_de_sortie') is-invalid @enderror" type="date" id="date_de_sortie" name="date_de_sortie" value="{{ old('date_de_sortie') }}">
                                    @error('date_de_sortie')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- codification --}}
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="codification"><strong>Codification</strong></label>
                                    <input class="form-control @error('codification') is-invalid @enderror" type="text" id="codification" name="codification" value="{{ old('codification') }}" readonly>
                                    @error('codification')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">Ajouter</button>
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
                                    <p class="lead text-info m-0"><span style="color: rgb(12, 38, 174);">Actifs</span></p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table mb-0 pt-3 pe-2">
                                        <table class="table table-striped table-sm my-0 mydatatable">
                                            <thead class="table-header">
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Modèle</th>
                                                    <th>Catégorie</th>
                                                    <th>Détenteur</th>
                                                    <th>Année d'acquisition></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lastAssets as $asset)
                                                <tr>

                                                    <!-- Vue Blade pour afficher les désignations -->
                                                    <td>
                                                        @if(is_numeric($asset->designation))
                                                        {{ \App\Models\Designation::find($asset->designation)->designation_name ?? 'N/A' }}
                                                        @else
                                                        {{ $asset->designation }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $asset->modele }}</td>
                                                    <td>{{ $asset->category->category_name ?? 'Non catégorisé' }}</td>
                                                    <td>{{ $asset->responsable }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($asset->date_achat) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary pull-right" type="button" onclick="window.location='{{ route('assets.showAssetManagementPage') }}'">
                                <i class="fa fa-star" style="font-size: 0px;"></i>More
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


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Sélecteurs pour les champs du formulaire
        const localisationField = document.getElementById('localisation');
        const projetField = document.getElementById('projet');
        const bailleurField = document.getElementById('bailleur');
        const designationField = document.getElementById('designation');
        const codificationField = document.getElementById('codification');

        const localisationMapping = {
            'Ouagadougou': 'OUA'
            , 'Ouahigouya': 'OHG'
            , 'Kaya': 'KYA'
            , 'Koudougou': 'KDG'
        };

        function generateCodification(sequenceNumber) {
            // Récupération des valeurs des champs
            const localisation = localisationMapping[localisationField.value.trim()] || localisationField.value.trim();
            const projet = projetField.value.trim();
            const bailleur = bailleurField.value.trim();
            const designation = designationField.options[designationField.selectedIndex].getAttribute('data-abbreviation') || designationField.value.trim();

            // Format de la date YYYY-MM-DD
            const dateActuel = new Date().toISOString().slice(0, 10);

            // Création d'un tableau des valeurs non vides
            const parts = [
                'BF'
                , localisation
                , projet
                , bailleur
                , designation
                , dateActuel
                , sequenceNumber.toString().padStart(3, '0')
            ].filter(part => part !== '');

            // Joindre les parties avec un seul slash
            const codification = parts.join('/');

            // Mise à jour du champ codification
            codificationField.value = codification;
        }

        // Fonction pour récupérer le dernier numéro de séquence depuis le serveur
        async function fetchLatestSequenceNumber() {
            try {
                const response = await fetch('/api/latest-sequence-number');
                const data = await response.json();
                return data.sequenceNumber + 1;
            } catch (error) {
                console.error('Erreur lors de la récupération du numéro de séquence:', error);
                return 1; // Valeur par défaut en cas d'erreur
            }
        }

        async function updateCodification() {
            const sequenceNumber = await fetchLatestSequenceNumber();
            generateCodification(sequenceNumber);
        }

        // Écouteurs d'événements pour mettre à jour la codification à chaque changement de champ
        localisationField.addEventListener('input', updateCodification);
        projetField.addEventListener('input', updateCodification);
        bailleurField.addEventListener('input', updateCodification);
        designationField.addEventListener('input', updateCodification);

        // Initialisation de la codification au chargement de la page
        updateCodification();
    });

</script>


@endsection

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
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
<script src="assets/js/DataTable---Fully-BSS-Editable-style.js"></script>
<script src="assets/js/Dynamic-Table-dynamic-table.js"></script>
<script src="assets/js/Table-With-Search-search-table.js"></script>
<script src="assets/js/theme.js"></script>


<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.mydatatable').DataTable();
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const localisationField = document.getElementById('localisation');
        const projetField = document.getElementById('projet');
        const bailleurField = document.getElementById('bailleur');
        const designationField = document.getElementById('designation');
        const dateReceptionField = document.getElementById('date_reception');
        const codificationField = document.getElementById('codification');

        function generateCodification() {
            const localisation = localisationField.value || '';
            const projet = projetField.value || '';
            const bailleur = bailleurField.value || '';
            const designation = designationField.options[designationField.selectedIndex].dataset.abbreviation || '';
            const date = new Date(dateReceptionField.value);
            const formattedDate = date instanceof Date && !isNaN(date) ? `${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getDate().toString().padStart(2, '0')}` : '';
            const codification = `BF/${localisation}/${projet}/${bailleur}/${designation}/${formattedDate}/001`;
            codificationField.value = codification;
        }

        localisationField.addEventListener('input', generateCodification);
        projetField.addEventListener('input', generateCodification);
        bailleurField.addEventListener('input', generateCodification);
        designationField.addEventListener('change', generateCodification);
        dateReceptionField.addEventListener('input', generateCodification);
    });

</script>