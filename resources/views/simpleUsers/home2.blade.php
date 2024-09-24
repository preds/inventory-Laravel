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
        <nav class="navbar navbar-light navbar-expand-md sticky-top navigation-clean-button" style="height: 80px;color: #ffffff;background: rgb(2,100,51);">
            <div class="container-fluid"><a class="navbar-brand" href="#"><i class="fa fa-globe"></i>&nbsp;Educo Iventory</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link active" style="color: #ffffff;" href="#"><i class="fa fa-home"></i>&nbsp;Home</a></li>
                        <li class="nav-item"><a class="nav-link active" style="color: #ffffff;" href="#"><i class="fa fa-wpexplorer"></i>&nbsp;Assets</a></li>
                        <li class="nav-item"><a class="nav-link active" style="color: #ffffff;" href="#"><i class="fa fa-star-o"></i>&nbsp;Print</a></li>
                        <li class="nav-item"></li>
                        <li class="nav-item"><a class="nav-link active" style="color: #ffffff;" href="#"><i class="fa fa-sign-in"></i>&nbsp;Sign In</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <header class="text-center text-white d-flex masthead" style="background: url(&quot;homeClientAssets/img/educo%20font.jpg&quot;) no-repeat;background-size: cover;">
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="text-uppercase"><strong>Educo Burkina&nbsp;</strong></h1>
                    <hr style="--bs-primary: #026433;/*--bs-primary-rgb: 2,100,51;*/background: var(--bs-purple);border-color: rgb(11,166,89);">
                </div>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="text-faded mb-5"><span style="color: rgb(247, 251, 249);">Eduquer, c'est guérir</span></p><a class="btn btn-primary btn-xl" role="button" href="#services" style="background: rgb(2,100,51);--bs-primary: rgb(2,100,51);--bs-primary-rgb: 2,100,51;">View Assets</a>
            </div>
        </div>
    </header>
  
    <section class="mt-4">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Assets Management</span></h3>
            <a class="btn btn-success btn-sm d-none d-sm-inline-block" role="button" href="#" style="color: rgb(255, 255, 255);">
                <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Export Excel
            </a>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Clients Assets</p>
                            <div class="d-flex">
                                <input type="text" id="searchInput" class="form-control form-control-sm mr-2" placeholder="Search...">
                                <button class="btn btn-primary" type="button" onclick="window.location.href='{{ route('assets.showAddAssetManagementPage') }}'">
                                    <i class="fa fa-star" style="font-size: 1px;"></i>&nbsp;Add New
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="categoryFilter">Filter by Category</label>
                                <select id="categoryFilter" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="locationFilter">Filter by Location</label>
                                <select id="locationFilter" class="form-select">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="etatFilter">Filter by État</label>
                                <select id="etatFilter" class="form-select">
                                    <option value="">All États</option>
                                    @foreach($etats as $etat)
                                        <option value="{{ $etat }}">{{ $etat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive table mt-2" id="dataTableContainer" role="grid" aria-describedby="dataTable_info">
                            <div class="table-responsive fixed-header-scrolls">
                                <table class="table my-0" id="dataTable">
                                    <thead class="table-header">
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Catégorie</th>
                                            <th>Localisation</th>
                                            <th>Désignation</th>
                                            <th>Marque</th>
                                            <th>Modèle</th>
                                            <th>Numéro de série ou Châssis</th>
                                            <th>État</th>
                                            <th>Situation exacte du matériel</th>
                                            <th>Responsable</th>
                                            <th>Quantité</th>
                                            <th>Date d'achat</th>
                                            <th>Valeur</th>
                                            <th>Numéro de pièces comptables</th>
                                            <th>Fournisseur</th>
                                            <th>Bailleur</th>
                                            <th>Date de sortie</th>
                                            <th>Codification</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assetsTableBody">
                                        @foreach($assets as $asset)
                                            <tr class="contenu_tableau">
                                                <td>{{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}</td>
                                                <td>
                                                    @if($asset->category && $asset->category->media)
                                                        <img src="{{ asset('storage/' . $asset->category->media->photo) }}" alt="{{ $asset->category->category_name }}" style="max-width: 100px; max-height: 100px;">
                                                    @else
                                                        Pas d'image
                                                    @endif
                                                </td>
                                                <td>{{ $asset->category->category_name ?? 'Non catégorisé' }}</td>
                                                <td>{{ $asset->localisation }}</td>
                                                <td>{{ $asset->designation }}</td>
                                                <td>{{ $asset->marque }}</td>
                                                <td>{{ $asset->modele }}</td>
                                                <td>{{ $asset->numero_serie_ou_chassis }}</td>
                                                <td>{{ $asset->etat }}</td>
                                                <td>{{ $asset->situation_exacte_du_materiel }}</td>
                                                <td>{{ $asset->responsable }}</td>
                                                <td>{{ $asset->quantite }}</td>
                                                <td>{{ \Carbon\Carbon::parse($asset->date_achat)->format('Y M d') }}</td>
                                                <td>{{ $asset->valeur }}</td>
                                                <td>{{ $asset->numero_piece_comptables }}</td>
                                                <td>{{ $asset->fournisseur }}</td>
                                                <td>{{ $asset->bailleur }}</td>
                                                <td>{{ \Carbon\Carbon::parse($asset->date_de_sortie)->format('Y M d') }}</td>
                                                <td>{{ $asset->codification }}</td>
                                                <td>
                                                    <form method="GET" action="{{ route('assets.showUpdateExistingAssetsPage') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $asset->id }}">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-edit"></i> Modifier
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger delete-btn" data-id="{{ $asset->id }}">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                    Showing {{ $assets->firstItem() }} to {{ $assets->lastItem() }} of {{ $assets->total() }} entries
                                </p>
                            </div>
                            <div class="col-md-6">
                                <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                    {{ $assets->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                                </nav>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <label for="perPage">Items per page:</label>
                            <select id="perPage" class="form-select w-auto ml-2" onchange="changePerPage(this)">
                                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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