@extends('layouts.app')

@section('title', 'Gestion des groupes')

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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Gestion des groupes d'utilisateurs</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-4">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Ajouter un nouveau groupe d'utilisateurs</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('groups.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="name"><strong>Nom du groupe</strong></label>
                                    <input class="form-control" type="text" id="name" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="level"><strong>Niveau du groupe</strong></label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="Administrator">Administrator</option>
                                        <option value="Simple User">Simple User</option>
                                        <option value="Guest">Guest</option>
                                    </select>
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
                                    <p class="lead text-info m-0"><strong><span style="color: rgb(7, 25, 195);">Groupes</span></strong></p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table mb-0 pt-3 pe-2">
                                        <div style="overflow-y: auto; height: 400px;">
                                            <table class="table table-striped table-sm my-0 mydatatable">
                                                <thead class="style-en-tete">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nom du groupe</th>
                                                        <th>Niveau du groupe</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($groups as $group)
                                                    <tr class="contenu_tableau">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $group->name }}</td>
                                                        <td>{{ $group->level }}</td>
                                                        <td>{{ $group->status ? 'Active' : 'Inactive' }}</td>
                                                        <td>
                                                            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-outline-warning btn-circle btn-lg btn-circle ml-2">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('groups.changeStatus', $group->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-circle btn-lg btn-circle {{ $group->status ? 'btn-outline-secondary' : 'btn-outline-info' }}">
                                                                    <i class="fa fa-key"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger btn-circle btn-lg btn-circle ml-2">
                                                                    <i class="fa fa-trash"></i>
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
                </div>
            </section>
        </div>
    </div>
</div>
</div>
@endsection
<style>
.contenu_tableau{
  text-align: center;
 
}

</style>