@extends('layouts.app')

@section('title')
    Media
@endsection

@section('contenu')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('warning'))
<div class="alert alert-danger">
    {{ session('warning') }}
</div>
@endif
<div class="container-fluid">
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Media</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-3">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold" style="color: rgb(78, 115, 223);">Ajouter des images d'actifs</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('media.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="photo"><strong>Photo</strong></label>
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">Ajouter</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            <div class="card shadow"></div>
        </div>
        <div class="col-xxl-9">
            <div class="card-body">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered table-sm my-0 mydatatable">
                        <thead class="table-header">
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" />
                                </th>
                                <th>Photos</th>
                                <th>Photo Name</th>
                                <th>Photo Type</th>
                            </tr>
                        </thead>
                        <tbody class="contenu_tableau">
                            @foreach($medias as $media)
                            <tr>
                                <td>
                                    <input type="checkbox" class="media-checkbox" value="{{ $media->id }}" />
                                </td>
                                <td><img src="{{ asset('storage/' . $media->photo) }}" alt="{{ $media->photo_name }}" width="100"></td>
                                <td>{{ $media->photo_name }}</td>
                                <td>{{ $media->photo_type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                <button id="delete-selected" class="btn btn-sm btn-danger mt-2">Supprimer Sélectionnés</button>
            
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
                    <div class="row w-100 mt-2 mt-md-0">
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                Montrer {{ $medias->firstItem() }} à {{ $medias->lastItem() }} de {{ $medias->total() }} entrées
                            </p>
                        </div>
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                {{ $medias->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                </div>
            
                <div class="d-flex justify-content-center mt-3">
                    <label for="perPage">Items par page:</label>
                    <select id="perPage" class="form-select w-auto ms-2" onchange="changePerPage(this)">
                        <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                    </select>
                </div>
            
                <!-- Formulaire caché pour suppression multiple -->
                <form id="delete-form" method="POST" action="{{ route('medias.delete.bulk') }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="delete-ids">
                </form>
            </div>
            
          
            
        </div>
   
    </div>
    <div class="card shadow mb-5"></div>
</div>
</div>
<script>
    // Script pour sélectionner/désélectionner tous les éléments
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.media-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Script pour la suppression multiple
    document.getElementById('delete-selected').addEventListener('click', function() {
        const selectedIds = Array.from(document.querySelectorAll('.media-checkbox:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) {
            alert('Veuillez sélectionner au moins un média à supprimer.');
            return;
        }
        document.getElementById('delete-ids').value = selectedIds.join(',');
        document.getElementById('delete-form').submit();
    });
</script>
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

@endsection
