@extends('layouts.app')

@section('title')
    Categories
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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Categories</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-3">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold" style="color: rgb(78, 115, 223);">Ajouter une nouvelle catégorie</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categories.addNewCategoryInDb') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <input class="form-control @error('categoryName') is-invalid @enderror" type="text" id="categoryName" placeholder="Nom de la catégorie" name="categoryName">
                                    @error('categoryName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="photo">Image</label>
                                    <select class="form-control" id="photo" name="photo_id">
                                        <option value="">-- Sélectionner une image --</option>
                                        @foreach($medias as $media)
                                            <option value="{{ $media->id }}">{{ $media->photo_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Ajouter</button></div>
                       
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow">
                <div class="card-header py-2">
                    <p class="lead text-info m-0">
                        <strong><span style="color: rgb(18, 83, 142);">TOUTES LES CATÉGORIES</span></strong>
                    </p>
                  
                    <p class="text-primary m-0 fw-bold">
                        <button id="delete-selected" class="btn btn-danger">Supprimer Sélection</button>
                        <button class="btn pull-right" style="background-color: rgb(220, 49, 142);color:white;" type="button" onclick="window.location.href='{{ route('showdeletedCategoryPage') }}'">
                            <i class="fa fa-star"></i>&nbsp;Voir les catégories supprimées
                        </button>
                    </p>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped table-bordered table-sm my-0 mydatatable">
                            <thead class="table-header">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>#</th>
                                    <th>Categories</th>
                                    <th>Images</th>
                                    <th>Status</th>
                                    <th colspan="3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="contenu_tableau">
                                @foreach($categories as $category)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="category-checkbox" value="{{ $category->id }}">
                                    </td>
                                    <td class="text-center">{{ $category->id }}</td>
                                    <td class="text-center">{{ $category->category_name }}</td>
                                    <td style="text-align: center;">
                                        @if($category->media)
                                            <img src="{{ asset('storage/' . $category->media->photo) }}" alt="{{ $category->category_name }}" style="max-width: 120px; max-height: 120px;">
                                        @else
                                            Pas d'image
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $category->active ? 'Active' : 'Inactive' }}</td>
                                    <td class="text-center">
                                        <form method="GET" action="{{ route('category.showUpdateExistingCategoryPage') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Modifier
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('category.toggleCategoryStatus') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit" class="btn btn-sm {{ $category->active ? 'btn-secondary' : 'btn-success' }}">
                                                <i class="fas fa-check"></i> {{ $category->active ? 'Désactiver' : 'Activer' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('category.deleteCategory') }}">
                                            @csrf
                                            @method('DELETE') <!-- Utilisation de la méthode DELETE -->
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
               
            </div>
        </div>
        
        <!-- Formulaire caché pour suppression multiple -->
        <form id="delete-form" method="POST" action="{{ route('category.deleteMultipleCategories') }}" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="ids" id="delete-ids">
        </form>
        
    </div>
    <div class="card shadow mb-5"></div>
</div>
</div>
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.category-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('delete-selected').addEventListener('click', function() {
        let selectedIds = [];
        document.querySelectorAll('.category-checkbox:checked').forEach(checkbox => {
            selectedIds.push(checkbox.value);
        });

        if (selectedIds.length > 0) {
            if (confirm('Voulez-vous vraiment supprimer les catégories sélectionnées?')) {
                document.getElementById('delete-ids').value = selectedIds.join(',');
                document.getElementById('delete-form').submit();
            }
        } else {
            alert('Veuillez sélectionner au moins une catégorie à supprimer.');
        }
    });
</script>
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
</style>

