<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - Brand</title>
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
</head>
<body class="bg-gradient-primary" style="background: rgb(78, 115, 223);">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background: url('{{ asset('clientsAssets/img/dogs/educo.jpg') }}') no-repeat; box-shadow: 0px 0px 17px 9px rgb(11,203,99);"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Create an Account!</h4>
                            </div>
                            <form class="user" method="POST" action="{{ route('clients.register') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user @error('first_name') is-invalid @enderror" type="text" placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user @error('last_name') is-invalid @enderror" type="text" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input class="form-control form-control-user @error('email') is-invalid @enderror" type="email" aria-describedby="emailHelp" placeholder="Email Address" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input class="form-control form-control-user @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input class="form-control form-control-user" type="password" placeholder="Repeat Password" name="password_confirmation">
                                    </div>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit">Register Account</button>
                                <hr>
                            </form>
                            <div class="text-center"><a class="small" href="{{ route('clients.requestPassword') }}">Forgot Password?</a></div>
                            <div class="text-center"><a class="small" href="{{ route('clients.login') }}">Already have an account? Login!</a></div>
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
</body>
</html>
