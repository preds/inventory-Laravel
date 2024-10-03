@extends('layouts.app')

@section('title')
    Ajouter Désignations
@endsection

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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Désignations</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-3">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold" style="color: rgb(78, 115, 223);">Ajouter une nouvelle désignation</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('designations.add') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <input class="form-control @error('designation_name') is-invalid @enderror" type="text" id="designation_name" placeholder="Nom de la désignation" name="designation_name">
                                    @error('designation_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Description" name="description"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input class="form-control @error('abbreviation_code') is-invalid @enderror" type="text" id="abbreviation_code" placeholder="Code d'abréviation" name="abbreviation_code">
                                    @error('abbreviation_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Ajouter</button></div>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold" style="color: rgb(78, 115, 223);">Importer des désignations depuis Excel</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('designations.import') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="excelFile">Fichier Excel</label>
                                    <input class="form-control @error('excelFile') is-invalid @enderror" type="file" id="excelFile" name="excelFile">
                                    @error('excelFile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Importer</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow">
                <div class="card-header py-2">
                    <p class="lead text-info m-0"><strong><span style="color: rgb(36, 117, 191);">&nbsp;</span><span style="color: rgb(18, 83, 142);">TOUTES LES DÉSIGNATIONS</span></strong></p>
                
                    <div class="d-flex justify-content-between">
                        <div></div> <!-- This empty div is used to ensure the form is aligned right -->
                        
                        <form action="/search-designations" method="GET" class="d-flex ms-auto" style="gap: 10px; align-items: center;">
                            <input type="text" id="searchInput" name="search" placeholder="Search..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px; width: 200px;">
                
                            <select name="search_field" style="padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                <option value="all" {{ request('search_field') === 'all' ? 'selected' : '' }}>All Fields</option>
                                <option value="designation" {{ request('search_field') === 'designation' ? 'selected' : '' }}>Designation</option>
                                <option value="description" {{ request('search_field') === 'description' ? 'selected' : '' }}>Description</option>
                                <option value="code" {{ request('search_field') === 'code' ? 'selected' : '' }}>Code</option>
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
                
            
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm my-0 mydatatable">
                            <thead class="table-header">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all" />
                                    </th>
                                   
                                    <th>#</th>
                                    <th>Désignations</th>
                                    <th>Descriptions</th>
                                    <th>Code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="contenu_tableau">
                                @foreach($designations as $index => $designation)
                                <tr>
                                    
                                    <td class="text-center">
                                        <input type="checkbox" class="designation-checkbox" value="{{ $designation->id }}" />
                                    </td>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $designation->designation_name }}</td>
                                    <td class="text-center">{{ $designation->description }}</td>
                                    <td class="text-center">{{ $designation->abbreviation_code }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('designations.delete') }}" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $designation->id }}">
                                            <button type="button" class="btn btn-sm btn-danger delete-button">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button id="delete-selected" class="btn btn-sm btn-danger mt-2">Supprimer Sélectionnés</button>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
                        {{-- Pagination --}}
                        <div class="row w-100 mt-2 mt-md-0">
                            <div class="col-md-6 align-self-center">
                                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                    Montrer {{ $designations->firstItem() }} à {{ $designations->lastItem() }} de {{ $designations->total() }} entrées
                                </p>
                            </div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    {{ $designations->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                                </nav>
                            </div>
                        </div>
                    </div>
        
                    {{-- Sélecteur d'éléments par page --}}
                    <div class="d-flex justify-content-center mt-3">
                        <label for="perPage">Items par page:</label>
                        <select id="perPage" class="form-select w-auto ms-2" onchange="changePerPage(this)">
                            <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                        </select>
                    </div>
        
                    <!-- Formulaire caché pour suppression multiple -->
                    <form id="delete-form" method="POST" action="{{ route('designations.delete.bulk') }}" style="display: none;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="delete-ids">
                    </form>
                    
                </div>
            </div>
        </div>
        
    </div>
    <div class="card shadow mb-5"></div>
</div>
@endsection

<style>
    .style-en-tete th {
        text-align: center;
    }
    .table {
        border-collapse: collapse;
    }
    .table th,
    .table td {
        border: 1px solid #dee2e6;
    }
    .table thead th {
        vertical-align: middle;
        text-align: center;
    }
    .btn {
        display: inline-block;
        margin: 0 auto;
    }
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
</style>

<script>
       function changePerPage(select) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', select.value);
        window.location.href = url.href; // Recharger la page avec le nouveau paramètre 'perPage'
    }
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
                const designationName = form.closest('tr').querySelector('td:nth-child(2)').textContent;

                if (confirm(`Êtes-vous sûr de vouloir supprimer la désignation "${designationName}" ?`)) {
                    form.submit();
                }
            });
        });

        // Cocher/Décochez toutes les cases
        document.getElementById('select-all').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.designation-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Gérer la suppression des éléments sélectionnés
        document.getElementById('delete-selected').addEventListener('click', function () {
    const selectedIds = Array.from(document.querySelectorAll('.designation-checkbox:checked')).map(cb => cb.value);
    
    if (selectedIds.length === 0) {
        alert('Veuillez sélectionner au moins une ligne à supprimer.');
        return;
    }

    if (confirm('Êtes-vous sûr de vouloir supprimer ces éléments ?')) {
        const form = document.getElementById('delete-form');
        document.getElementById('delete-ids').value = selectedIds.join(','); // Récupère les IDs sélectionnés
        form.submit(); // Soumet le formulaire
    }
});


    });
</script>
