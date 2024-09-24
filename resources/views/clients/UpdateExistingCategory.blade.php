@extends('layouts.app')

@section('title')
Mise à jour de la catégorie
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
    <button class="btn btn-primary pull-right" type="button" onclick="window.location.href='{{ route('category.showCategoryManagementPage') }}'">
        <i class="fa fa-star" style="font-size: 1px; background-color: rgb(141, 78, 5);"></i>&nbsp;retour 
    </button>
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Modifer la categorie "{{ $category->category_name }}" </span></h3>
    <div class="row mb-3">
        <div class="col-xxl-3">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold" style="color: rgb(78, 115, 223);">Modifer la categorie "{{ $category->category_name }}" </p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('categoryUpdate', ['id' => $category->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <input class="form-control @error('categoryName') is-invalid @enderror" type="text" id="categoryName" name="categoryName" value="{{ $category->category_name }}">
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
                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Modifier</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow">
                <div class="card-header py-2">
                    <p class="lead text-info m-0"><strong><span style="color: rgb(36, 117, 191);">&nbsp;</span><span style="color: rgb(18, 83, 142);">TOUTES LES CATÉGORIES</span></strong></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped table-bordered table-sm my-0 mydatatable">
                            <thead class="table-header">
                                <tr>
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
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $category->category_name }}</td>
                                    <td style="text-align: center;">
                                        @if($category->media)
                                            <img src="{{ asset('storage/' . $category->media->photo) }}" alt="{{ $category->category_name }}" style="max-width: 100px; max-height: 100px;">
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-5"></div>
</div>
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
</style>
