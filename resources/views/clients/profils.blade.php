@extends('layouts.app')

@section('title')
Profile
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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Profile</span></h3>

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
                        <img id="profile-photo" class="rounded-circle mb-3 mt-4" 
                            src="{{ Auth::user()->photo ? asset('storage/avatars_photos/' . Auth::user()->photo) : asset('clientsAssets/img/dogs/image2.jpeg') }}" width="200" height="200">
                        <form action="{{ route('users.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="photo" id="photo" style="display: none;" accept="image/*" onchange="previewPhoto(event)">
                                <label for="photo" class="btn btn-primary btn-sm">Change Photo</label>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-success btn-sm" type="submit">Save Photo</button>
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
                            <p class="text-primary m-0 fw-bold">Parametres</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('users.update', auth()->user()) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="username"><strong>Nom d'utilisateur</strong></label>
                                            <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" placeholder="Enter username" name="username" value="{{ auth()->user()->username }}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="first_name"><strong>Prénom</strong></label>
                                            <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" placeholder="Enter first name" name="first_name" value="{{ auth()->user()->first_name }}">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="last_name"><strong>Nom de famille</strong></label>
                                            <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" placeholder="Enter last name" name="last_name" value="{{ auth()->user()->last_name }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                           
                                    
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="password"><strong>Mot de passe</strong></label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" placeholder="Enter password" name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="password_confirmation"><strong>Confirmer le mot de passe</strong></label>
                                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" placeholder="Confirm password" name="password_confirmation">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-sm" type="submit">Modifier</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    <div class="card shadow"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
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