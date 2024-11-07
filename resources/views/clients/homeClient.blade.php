<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Brand</title>
    <link rel="stylesheet" href="homeClientAssets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic&amp;display=swap">
    <link rel="stylesheet" href="homeClientAssets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="homeClientAssets/css/aos.min.css">
    <link rel="stylesheet" href="homeClientAssets/css/baguetteBox.min.css">
    <link rel="stylesheet" href="homeClientAssets/css/custom-buttons.css">
    <link rel="stylesheet" href="homeClientAssets/css/Dark-NavBar-Navigation-with-Button.css">
    <link rel="stylesheet" href="homeClientAssets/css/Dark-NavBar-Navigation-with-Search.css">
    <link rel="stylesheet" href="homeClientAssets/css/Dark-NavBar.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="homeClientAssets/css/Table-With-Search-search-table.css">
    <link rel="stylesheet" href="homeClientAssets/css/Table-With-Search.css">
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="57">
    <div>
        <nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean-button" style="height: 80px; color: #ffffff; background: rgb(2, 100, 51);">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link" style="color: #ffffff;" href="{{ route('clients.showHomePage') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-home"></i>
                                    <div class="sidebar-brand-text mx-3"><span>Home</span></div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" style="color: #ffffff;" href="{{ route('assets.showAssetManagementPage') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-wpexplorer"></i>
                                    <div class="sidebar-brand-text mx-3"><span>Actifs</span></div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color: #ffffff;" href="{{ route('users.showProfilPage') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-star-o"></i>
                                    <div class="sidebar-brand-text mx-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link" style="color: #ffffff; background: transparent; border: none; cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-sign-out"></i>
                                        <div class="sidebar-brand-text mx-3"><span>se déconnecter</span></div>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>




    </div>
    <header class="text-center text-white d-flex masthead" style="background: url('homeClientAssets/img/a.jpg') no-repeat; background-size: cover;">

        <div class="container my-auto" style="background-color: rgba(0, 0, 0, 0.5); padding: 20px;">

        <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="text-uppercase"><strong>Educo Burkina&nbsp;</strong></h1>
                    <hr style="--bs-primary: #026433;/*--bs-primary-rgb: 2,100,51;*/background: var(--bs-purple);border-color: rgb(11,166,89);">
                </div>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="text-faded mb-5"><span style="color: rgb(247, 251, 249);">Eduquer, c'est guérir</span></p><a class="btn btn-primary btn-xl" role="button" href="{{ route('assets.showAssetManagementPage') }}" style="background: rgb(2,100,51);--bs-primary: rgb(2,100,51);--bs-primary-rgb: 2,100,51;">Voir les actifs</a>
            </div>
        </div>
    </header>

    <section id="contact" class="text-white bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center mx-auto">
                    <h2 class="section-heading">Educo Burkina</h2>
                    <hr class="my-4" style="background: rgb(2,100,51);color: rgb(2,100,51);border-color: rgb(2,100,51);">
                    <p class="mb-5">Eduquer, c'est guérir</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 text-center ms-auto"><i class="fa fa-phone fa-3x mb-3 sr-contact" data-aos="zoom-in" data-aos-duration="300" data-aos-once="true"></i>
                    <p>25 37 51 68</p>
                </div>
                <div class="col-lg-4 text-center me-auto"><i class="fa fa-envelope-o fa-3x mb-3 sr-contact" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="300" data-aos-once="true"></i>
                    <p style="color: rgb(9,179,94);">info.burkina@educo.org</p>
                </div>
            </div>
        </div>
    </section>
    <script src="homeClientAssets/bootstrap/js/bootstrap.min.js"></script>
    <script src="homeClientAssets/js/aos.min.js"></script>
    <script src="homeClientAssets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="homeClientAssets/js/baguetteBox.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="homeClientAssets/js/creative.js"></script>
    <script src="homeClientAssets/js/DataTable---Fully-BSS-Editable-style.js"></script>
    <script src="homeClientAssets/js/Table-With-Search-search-table.js"></script>
</body>

</html>
