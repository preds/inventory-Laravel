@extends('layouts.app')

@section('title')
    Categories supprimées
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
    <h3 class="text-dark mb-4"><span style="color: rgb(220, 49, 142);">Catégories supprimées</span></h3>
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-2">
                    <p class="lead text-info m-0"><strong><span style="color: rgb(18, 83, 142);">TOUTES LES CATÉGORIES</span></strong></p>
                    <p class="text-primary m-0 fw-bold">
                       
         
                    </p>
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
                                @foreach($deletedCategories as $category)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $category->category_name }}</td>
                                    <td class="text-center">
                                        @if($category->media)
                                            <img src="{{ asset('storage/' . $category->media->photo) }}" alt="{{ $category->category_name }}" style="max-width: 120px; max-height: 120px;">
                                        @else
                                            Pas d'image
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $category->active ? 'Active' : 'Inactive' }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('category.restoreOrDeleteCategory') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $category->id }}">
                                            <input type="hidden" name="action" value="{{ $category->deleted ? 'restore' : 'delete' }}">
                                            <button type="submit" class="btn btn-sm {{ $category->deleted ? 'btn-warning' : 'btn-danger' }}">
                                                <i class="fas fa-trash"></i> {{ $category->deleted ? 'Restaurer' : 'Supprimer' }}
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
        width: 100%; /* Ensure the table takes the full width of the card */
    }
    .table th,
    .table td {
        border: 1px solid #dee2e6;
        text-align: center; /* Center align text in table cells */
    }
    .table thead th {
        vertical-align: middle;
    }
    .btn {
        display: inline-block;
        margin: 0 auto;
    }
</style>
