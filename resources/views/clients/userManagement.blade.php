@extends('layouts.app')

@section('title')
Gestion des utilisateurs
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
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Gestion des utilisateurs</span></h3>

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
                    <img class="rounded-circle mb-3 mt-4" src="clientsAssets/img/dogs/image2.jpeg" width="160" height="160">
                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">Changer Photo</button></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Creer un nouvel Utilisateur </p>
                        </div>
                        <div class="card-body">
                          <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row">
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
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="first_name"><strong>Prénom</strong></label>
                                        <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" placeholder="Enter first name" name="first_name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="last_name"><strong>Nom de famille</strong></label>
                                        <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" placeholder="Enter last name" name="last_name" value="{{ old('last_name') }}">
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
                                        <input class="form-control @error('username') is-invalid @enderror" type="text" id="username" placeholder="Enter username" name="username" value="{{ old('username') }}">
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="group_id"><strong>Groupe</strong></label>
                                        <select class="form-control @error('group_id') is-invalid @enderror" id="group_id" name="group_id">
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('group_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
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
            </div>
        </div>
    </div>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title   mb-0">Utilisateurs</h5>
                    </div>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table no-wrap user-table mb-0">
                            <thead  class="table-header">
                                <tr>
                                    <th scope="col" class="border-0   font-medium pl-4">#</th>
                                    <th scope="col" class="border-0   font-medium">localisation</th>
                                    <th scope="col" class="border-0   font-medium">Nom</th>
                                    <th scope="col" class="border-0   font-medium">Nom d'utilisateur</th>
                                    <th scope="col" class="border-0   font-medium">Role Utilisateur</th>
                                    <th scope="col" class="border-0   font-medium">Status</th>
                                    <th scope="col" class="border-0   font-medium">Last Login</th>
                                    <th scope="col" class="border-0   font-medium">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="text-center">
                                        <td >{{ $loop->iteration }}</td>
                                        <td>{{ $user->localisation }}</td>
                                        <td>{{ $user->first_name.' '.$user->last_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->group->name }}</td>
                                        <td>{{ $user->status ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->last_login) }}</td>
                                        <td >
                                            <button type="button" class="btn btn-outline-info btn-circle btn-lg btn-circle" onclick="toggleUserStatus({{ $user->id }})"><i class="fa fa-key"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-circle btn-lg btn-circle ml-2" onclick="deleteUser({{ $user->id }})"><i class="fa fa-trash"></i></button>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning btn-circle btn-lg btn-circle ml-2"><i class="fa fa-edit"></i></a>
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const firstNameInput = document.getElementById('first_name');
        const lastNameInput = document.getElementById('last_name');
        const usernameInput = document.getElementById('username');

        function generateUsername() {
            const firstName = firstNameInput.value.toLowerCase().trim();
            const lastName = lastNameInput.value.toLowerCase().trim();
            if (firstName && lastName) {
                let baseUsername = firstName + '.' + lastName;
                checkUsernameAvailability(baseUsername);
            }
        }

        async function checkUsernameAvailability(baseUsername) {
            try {
                let username = baseUsername;
                let counter = 0;
                let exists = true;

                while (exists) {
                    const response = await fetch(`{{ route('check-username') }}?username=${username}`);
                    const data = await response.json();
                    exists = data.exists;

                    if (exists) {
                        counter++;
                        username = baseUsername + counter;
                    }
                }

                usernameInput.value = username;
            } catch (error) {
                console.error('Error checking username availability:', error);
            }
        }

        firstNameInput.addEventListener('input', generateUsername);
        lastNameInput.addEventListener('input', generateUsername);
    });
</script>
@yield('scripts')
@endsection
@section('scripts')
<script>
    function toggleUserStatus(userId) {
        if (confirm('Are you sure you want to change the status of this user?')) {
            fetch('{{ url('/users/toggle-status') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    }

    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            fetch('{{ url('/users/delete') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        }
    }
</script>


