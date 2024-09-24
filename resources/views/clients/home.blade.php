@extends('layouts.app')
@section('title')
Tableau De Bord
@endsection
@section('contenu')
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">
<!-- Import Chart.js and plugins -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<!-- Optionally, if you need a specific version -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>


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

<div class="d-flex flex-column" id="content-wrapper">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0"><strong><span style="color: rgb(9, 179, 94);">Tableau De Bord</span></strong></h3>

        </div>

        <div class="row">
            <!-- Users/Profile Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                @if(Auth::check())
                                    @if(auth()->user()->group->level === 'Administrator')
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Utilisateurs</span></div>
                                        <div class="text-dark fw-bold h5 mb-0">
                                            <span>{{$totalUsers}}</span>
                                            <a href="{{ route('users.showUserManagementPage') }}" class="btn btn-sm btn-outline-primary ms-2">Voir</a>
                                        </div>
                                    @else
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Profile</span></div>
                                        <div class="text-dark  h5 mb-0">
                                            <span>{{ Auth::user()->username }}</span>
                                            <a href="{{ route('users.showProfilPage', Auth::user()->id) }}" class="btn btn-sm btn-outline-primary ms-2">Voir</a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>Categories</span></div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    <span>{{ $totalCategories }}</span>
                                    <a href="{{ route('category.showCategoryManagementPage') }}" class="btn btn-sm btn-outline-success ms-2">Voir</a>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assets Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>Actifs</span></div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0">
                                            <span>{{ $totals->totalAssets }}</span>
                                            <a href="{{ route('assets.showAssetManagementPage') }}" class="btn btn-sm btn-outline-info ms-2">Voir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deleted Assets Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                    <span><span style="color: rgb(220, 49, 142);">Actifs Supprimés</span></span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0">
                                    @if(auth()->user()->level == 'Administrator')
                                        <span>{{ $totals->totalDeletedAssets }}</span>
                                    @else
                                        <span>{{ $userDeletedAssets }}</span>
                                    @endif
                                    <a href="{{ route('showDeletedAssetsPage') }}" class="btn btn-sm ms-2" style="border-color: rgb(220, 49, 142); color:rgb(220, 49, 142);">Voir</a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -32 576 576" width="1em" height="1em" fill="currentColor" class="fa-2x text-gray-300">
                                    <!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M576 384C576 419.3 547.3 448 512 448H205.3C188.3 448 172 441.3 160 429.3L9.372 278.6C3.371 272.6 0 264.5 0 256C0 247.5 3.372 239.4 9.372 233.4L160 82.75C172 70.74 188.3 64 205.3 64H512C547.3 64 576 92.65 576 128V384zM271 208.1L318.1 256L271 303C261.7 312.4 261.7 327.6 271 336.1C280.4 346.3 295.6 346.3 304.1 336.1L352 289.9L399 336.1C408.4 346.3 423.6 346.3 432.1 336.1C442.3 327.6 442.3 312.4 432.1 303L385.9 256L432.1 208.1C442.3 199.6 442.3 184.4 432.1 175C423.6 165.7 408.4 165.7 399 175L352 222.1L304.1 175C295.6 165.7 280.4 165.7 271 175C261.7 184.4 261.7 199.6 271 208.1V208.1z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row" style="margin-top: 2%;">
        <!-- First Graph Section -->
        <div class="col-md-6">
            <section class="mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Répartition des actifs</h5>
                        <div class="chart-container">
                            <canvas id="assetsChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Second Graph Section -->
        <div class="col-md-6">
            <section class="mt-2 small-height-section">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">État des actifs</h5>
                        <br>
                        <div id="progress-bars-container"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<!-- Third Graph Section -->
 <!-- Third Graph Section -->
 <div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="chart-container2 mx-auto">
                    <canvas id="amortizationPieChart"></canvas>
                </div>
                <div class="ml-4">
                    <h5 class="card-title">Informations complémentaires</h5>
                    <!-- Informations supplémentaires cliquables -->
                    <div id="additionalInfo" style="cursor: pointer;">
                        Cliquez ici pour voir les détails
                    </div>
                    <!-- Tableau des détails (initialisé masqué) -->
                    <div id="detailsTable" style="display: none;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Amorti</th>
                                    <th>Non Amorti</th>
                                    <th>Date Invalide</th>
                                </tr>
                            </thead>
                            <tbody id="detailsTableBody">
                                <!-- Contenu du tableau généré dynamiquement -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<style>
    .card-title {
        font-weight: 300;
        font-family: 'Times New Roman', Times, serif;
    }

    .full-width {
        width: 100%;
        height: 100%;
    }

    .chart-container {
        position: relative;
        height: 40vh;
        width: 100%;
    }

    .chart-container2 {
        position: relative;
        height: 40vh;
        width: 100%;
    }

    .progress {
        height: 30px;
    }

    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        color: black;
        font-weight: bold;
    }

    .small-height-section {
        height: 455px;
        overflow-y: auto;
    }
</style>



{{-- script pour le premier graph bar --}}
<script>
    console.log('Labels:', @json($assetsLabels));
    console.log('Values:', @json($assetsValues));

    var assetsLabels = @json($assetsLabels); // Libellés des catégories d'actifs
    var assetsValues = @json($assetsValues); // Nombres d'actifs par catégorie

    var assetsData = {
        labels: assetsLabels,
        datasets: [{
            data: assetsValues,
            backgroundColor: [
                'rgba(2, 99, 51, 0.9)',
                'rgba(0, 119, 182, 0.9)',
                'rgba(230, 57, 70, 0.9)',
                'rgba(78, 115, 223, 0.9)',
                'rgba(56, 163, 165, 0.9)',
                'rgba(131, 56, 236, 0.9)',
                'rgba(240, 128, 128, 0.9)'
            ],
            hoverBackgroundColor: [
               'rgba(2, 99, 51, 1)',
                'rgba(0, 119, 182, 1)',
                'rgba(230, 57, 70, 1)',
                'rgba(78, 115, 223,1)',
                'rgba(56, 163, 165, 1)',
                'rgba(131, 56, 236, 1)',
                'rgba(240, 128, 128,1)'
            ]
        }]
    };

    console.log('assetsData:', assetsData);

    var ctx = document.getElementById('assetsChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: assetsData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    anchor: 'center',
                    align: 'center',
                    color: 'white',
                    font: {

                        size: 16
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            console.log('Tooltip Context:', context);
                            var label = context.label || '';
                            var value = context.raw || 0;
                            return label + ': ' + value;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels]
    });
</script>

{{-- script pour le deuxieme graph progress bar --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les données des états et leurs pourcentages depuis les variables PHP passées à la vue
        var assetsStateLabels = @json($assetsStateLabels); // ['State1', 'State2', 'State3']
        var assetsStateValues = @json($assetsStateValues); // [20, 40, 60]
        var totalAssets = @json($totals->totalAssets); // Total number of assets

        // Couleurs pour les barres de progression
        var assetsStateColors = ['bg-success', 'bg-warning', 'bg-primary', 'bg-info', 'bg-danger'];

        // Création d'un tableau d'objets représentant les états des actifs
        var assetsStates = assetsStateLabels.map(function(label, index) {
            // Calcul du pourcentage pour chaque état
            var percentage = (assetsStateValues[index] / totalAssets) * 100;
            return {
                name: label,
                percentage: percentage.toFixed(2), // Pourcentage avec deux décimales
                color: assetsStateColors[index % assetsStateColors.length] // Boucle sur les couleurs si nécessaire
            };
        });

        // Sélection du conteneur
        var container = document.getElementById('progress-bars-container');

        // Génération du contenu HTML pour chaque état
        assetsStates.forEach(function(state) {
            // Création des éléments
            var h4 = document.createElement('h4');
            h4.classList.add('small', 'fw-bold');
            h4.innerHTML = state.name + '<span class="float-end">' + (state.percentage == 100 ? 'Complete!' : state.percentage + '%') + '</span>';

            var progress = document.createElement('div');
            progress.classList.add('progress', 'mb-2'); // Réduire la hauteur ici

            var progressBar = document.createElement('div');
            progressBar.classList.add('progress-bar', state.color);
            progressBar.setAttribute('aria-valuenow', state.percentage);
            progressBar.setAttribute('aria-valuemin', '0');
            progressBar.setAttribute('aria-valuemax', '100');
            progressBar.style.width = state.percentage + '%';
            progressBar.innerHTML = '<span class="visually-hidden">' + state.percentage + '%</span>';

            // Assemblage des éléments
            progress.appendChild(progressBar);
            container.appendChild(h4);
            container.appendChild(progress);
        });
    });
</script>



{{-- script pour le graph2 (progression bar) --}}
</div>
@endsection

<script>
    function exportData() {
        document.getElementById('exportCategory').value = document.getElementById('categoryFilter').value;
        document.getElementById('exportLocation').value = document.getElementById('locationFilter').value;
        document.getElementById('exportEtat').value = document.getElementById('etatFilter').value;
        document.getElementById('exportSearch').value = document.getElementById('searchInput').value;
        document.getElementById('exportForm').submit();
    }
</script>

{{-- Script pour le graphique circulaire d'amortissement --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('amortizationPieChart').getContext('2d');
        var amortizationValues = @json($amortizationValues); // [amortizedCount, notAmortizedCount, invalidDateCount]
        var amortizationLabels = @json($amortizationLabels); // ['Amorti', 'Non Amorti', 'Date Invalide']
        var backgroundColors = ['#dd2d4a', '#2ec4b6', '#072ac8']; // Couleurs pour chaque section

        // Initialisation des données d'amortissement
        var amortizationData = @json($amortizationData); // { 'Category': { 'amorti': value, 'non_amorti': value, 'invalid_date': value }, ... }

        var amortizationPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: amortizationLabels,
                datasets: [{
                    data: amortizationValues,
                    backgroundColor: backgroundColors,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                                var value = tooltipItem.raw;
                                var percentage = ((value / total) * 100).toFixed(2);
                                return tooltipItem.label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    },
                    datalabels: {
                        display: true,
                        color: '#fff',
                        formatter: function(value, context) {
                            var total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            var percentage = ((value / total) * 100).toFixed(2);
                            return value + ' (' + percentage + '%)';
                        },
                        anchor: 'end',
                        align: 'start',
                        offset: 10,
                        font: {
                            weight: 'bold'
                        },
                        color: function(context) {
                            var index = context.dataIndex;
                            var value = context.dataset.data[index];
                            return value > 0 ? '#ffc107' : '#fff';
                        }
                    }
                }
            }
        });

// Section d'informations supplémentaires
var additionalInfo = document.getElementById('additionalInfo');
var infoHtml = '';
for (var category in amortizationData) {
    if (amortizationData.hasOwnProperty(category)) {
        var dateInvalide = typeof amortizationData[category].date_invalide !== 'undefined' ? amortizationData[category].date_invalide : '-';
        infoHtml += `
            <p>
                <strong>${category}:</strong>
                <span style="color: #dd2d4a;">amorti = ${amortizationData[category].amorti}</span> /
                <span style="color: #2ec4b6;">non amorti = ${amortizationData[category].non_amorti}</span> /
                <span style="color: #072ac8;">date invalide = ${dateInvalide}</span>
            </p>`;
    }
}
additionalInfo.innerHTML = infoHtml;

     // Gérer le clic sur les informations supplémentaires
additionalInfo.addEventListener('click', function () {
    var detailsTable = document.getElementById('detailsTable');
    var detailsTableBody = document.getElementById('detailsTableBody');

    // Effacer le contenu précédent
    detailsTableBody.innerHTML = '';

  // Générer le tableau des détails pour chaque catégorie
  for (var category in amortizationData) {
        if (amortizationData.hasOwnProperty(category)) {
            var row = document.createElement('tr');
            var dateInvalide = typeof amortizationData[category].date_invalide !== 'undefined' ? amortizationData[category].date_invalide : '-';
            row.innerHTML = `
                <td>${category}</td>
                <td><a href="/assets/amortized?category=${encodeURIComponent(category)}">${amortizationData[category].amorti}</a></td>
                <td><a href="/assets/non-amortized?category=${encodeURIComponent(category)}">${amortizationData[category].non_amorti}</a></td>

                <td><a href="/assets/invalid-dates?category=${encodeURIComponent(category)}">${dateInvalide}</a></td>
            `;
            detailsTableBody.appendChild(row);
        }
    }

    // Afficher le tableau des détails et masquer les informations supplémentaires
    detailsTable.style.display = 'block';
    additionalInfo.style.display = 'none';
});


      // Gérer le clic sur les liens des actifs amortis, non amortis et date invalide
document.getElementById('detailsTableBody').addEventListener('click', function (event) {
    var target = event.target;
    if (target.tagName === 'A') {
        // Empêcher le comportement par défaut du lien
        event.preventDefault();

        // Obtenir la catégorie à partir de l'URL du lien
        var category = decodeURIComponent(target.getAttribute('href').split('?category=')[1]);

        // Redirection vers la vue correspondante avec la catégorie spécifiée
        window.location.href = target.getAttribute('href');
    }
});
});
</script>

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

<!-- New scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
