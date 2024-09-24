<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Brand</title>
    <link rel="stylesheet" href="{{ asset('clientsAssets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Abril%20Fatface.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Nunito.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Bootstrap-4---Table-Fixed-Header.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Dynamic-Table.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Manage-Users.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Navbar-Dropdown-List-Item.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/tablaresponsive-tablares.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/tablaresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Table-With-Search-search-table.css') }}">
    <link rel="stylesheet" href="{{ asset('clientsAssets/css/Table-With-Search.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Styles spécifiques pour l'icône de visibilité */
        .toggle-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gradient-primary" style="background: url('{{ asset('clientsAssets/img/educofont.jpg') }}') no-repeat center center; background-size: cover; background-color: rgb(78, 115, 223); border-color: rgb(17, 200, 123);">
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 147px;">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background: url('{{ asset('clientsAssets/img/dogs/educo.jpg') }}') no-repeat; box-shadow: 0px 0px 17px 9px rgb(11,203,99); border-style: none; border-color: rgb(10,195,118);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Bienvenue !</span></h4>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="text" id="username" aria-describedby="emailHelp" placeholder="Nom d'utilisateur" name="username" value="{{ old('username') }}">
                                        </div>
                                   
                                        <div class="form-group position-relative">
                                            
                                            <input type="password" class="form-control form-control-user" id="password" placeholder="mot de passe"  name="password" required>
                                            <span class="toggle-icon ml-2" onclick="togglePasswordVisibility('password')"><i class="fas fa-eye"></i></span>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                {{-- <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">Remember Me</label> --}}
                                            </div>
                                        </div>
                                        <button class="btn btn-primary d-block btn-user w-100" type="submit">Login</button>
                                        <hr>
                                    </form>
                                    {{-- <div class="text-center"><a class="small" href="{{ route('password.request') }}">Forgot Password?</a></div>
                                    <div class="text-center"><a class="small" href="{{ route('register') }}">Create an Account!</a></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('clientsAssets/bootstrap/js/bootstrap.min.js') }}"></script>
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
    <script src="{{ asset('clientsAssets/js/DataTable---Fully-BSS-Editable-style.js') }}"></script>
    <script src="{{ asset('clientsAssets/js/Dynamic-Table-dynamic-table.js') }}"></script>
    <script src="{{ asset('clientsAssets/js/Table-With-Search-search-table.js') }}"></script>
    <script src="{{ asset('clientsAssets/js/theme.js') }}"></script>

    
    <script>
         function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var icon = passwordField.nextElementSibling.querySelector('i');
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
