@extends('layouts.app')

@section('title')
    Mise à Jours Des Informations Utilisateur
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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Mise à Jours Des Informations Utilisateur </span></h3>

    {{-- Affichage des messages d'erreur --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    @if($user->photo)
                    <img src="{{ asset('storage/avatars_photos/' . $user->photo) }}" width="200" height="200">
                @else
                    <img src="{{ asset('clientsAssets/img/dogs/image2.jpeg') }}" width="200" height="200">
                @endif
                <form action="{{ route('users.updateUsersPhoto', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="photo" id="photo" style="display: none;" accept="image/*" onchange="previewPhoto(event)">
                        <label for="photo" class="btn btn-primary btn-sm">Changer la photo</label>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success btn-sm" type="submit">Sauvegarder la Photo</button>
                    </div>
                </form>

                    @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif
                    @if($errors->has('photo'))
                        <div class="alert alert-danger mt-3">{{ $errors->first('photo') }}</div>
                    @endif
            </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Parametres utilisateurs </p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="localisation"><strong>Localisation</strong></label>
                                            <select class="form-control @error('localisation') is-invalid @enderror" id="localisation" name="localisation">
                                                @foreach($localisations as $localisation)
                                                    <option value="{{ $localisation }}" {{ old('localisation', $user->localisation) == $localisation ? 'selected' : '' }}>
                                                        {{ $localisation }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('localisation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="first_name"><strong>Prénom</strong></label>
                                            <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" placeholder="Enter first name" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="last_name"><strong>Nom</strong></label>
                                            <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" placeholder="Enter last name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username"><strong>Nom d'utilisateur</strong></label>
                                            <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" placeholder="Enter username" name="username" value="{{ old('username', $user->username) }}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="group_id"><strong>Group</strong></label>
                                            <select class="form-control @error('group_id') is-invalid @enderror" id="group_id" name="group_id">
                                                @foreach($groups as $group)
                                                    <option value="{{ $group->id }}" {{ old('group_id', $user->group_id) == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('group_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-sm mr-2" type="submit">modifier l'utilisateur</button>
                                    <button class="btn btn-warning btn-sm" type="button" id="reset-password-btn">Reinitialiser le mot de passe</button>
                                </div>
                            </form>
                            @if(session('new_password'))
                                <div class="alert alert-success mt-3">
                                    New Password: <strong>{{ session('new_password') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card shadow"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
document.getElementById('reset-password-btn').addEventListener('click', function() {
    if (confirm('Are you sure you want to reset the password for this user?')) {
        fetch('{{ route('users.reset_password', $user->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Password reset successfully! The new password is: ' + data.new_password);

            } else {
                alert('Error resetting password: ' + data.message);
            }
        });
    }
});
</script>

<script>
    function previewPhoto(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function() {
        var imgElement = document.querySelector('.card-body img');
        imgElement.src = reader.result;
        var saveButton = document.querySelector('.btn-success');
        saveButton.style.display = 'block';
    }
    reader.readAsDataURL(input.files[0]);
}
</script>
@endsection
