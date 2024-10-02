@extends('layouts.app')

@section('title', 'Journal des activités de l\'utilisateur')
<!-- Inclure Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Inclure Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

@section('contenu')
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">

<section class="mt-4">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Journal des activités de l'utilisateur</span></h3>
            <form id="exportForm" method="GET" action="{{ route('assets.exportLogExcel') }}">
                <button type="button" class="btn btn-success btn-sm d-none d-sm-inline-block" onclick="exportData()">
                    <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Exporter en Excel
                </button>
            </form>
        </div>
        <div class="d-flex align-items-center mb-2">
            <label for="startDate" class="me-2">Date de début:</label>
            <input type="text" id="startDate" class="form-control form-control-sm me-2" placeholder="Sélectionner la date de début">
            <label for="endDate" class="me-2">Date de fin:</label>
            <input type="text" id="endDate" class="form-control form-control-sm me-2" placeholder="Sélectionner la date de fin">
            <button class="btn btn-primary btn-sm" id="filterByDateBtn">Filtrer</button>
        </div>
        
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Logs</p>
                            <div class="d-flex">
                                <input type="text" id="search-input" class="form-control form-control-sm mr-2" placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="logsTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>#</th>
                                        <th>Action</th>
                                        <th>Asset</th>
                                        <th>Marque</th>
                                        <th>Modele</th>
                                        <th>User</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $index => $log)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="log-checkbox" value="{{ $log->id }}">
                                        </td>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $log->action }}</td>
                                        <td>{{ $log->asset->designation }}</td>
                                        <td>{{ $log->asset->marque }}</td>
                                        <td>{{ $log->asset->modele }}</td>
                                        <td>{{ $log->user->username }}</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button id="delete-selected" class="btn btn-danger mb-2 mb-md-0">Supprimer Sélection</button>
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
        
                            {{-- Pagination --}}
                            <div class="row w-100 mt-2 mt-md-0">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                        Montrer {{ $logs->firstItem() }} à {{ $logs->lastItem() }} de {{ $logs->total() }} entrées
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        {{ $logs->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                                    </nav>
                                </div>
                            </div>
                        </div>
        
                        {{-- Sélecteur d'éléments par page --}}
                        <div class="d-flex justify-content-center mt-3">
                            <label for="perPage">Items par page:</label>
                            <select id="perPage" class="form-select w-auto ml-2" onchange="changePerPage(this)">
                                <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('perPage') == 15 ? 'selected' : '' }}>15</option>
                            </select>
                        </div>
        
                        <!-- Formulaire caché pour suppression multiple -->
                        <form id="delete-form" method="POST" action="{{ route('logs.deleteMultipleLogs') }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="ids" id="delete-ids">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
</section>
<style>
    .table-responsive {
        max-height: 500px;
        overflow-y: auto;
    }

    .table-responsive thead th {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: #fff;
    }


</style>
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.log-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('delete-selected').addEventListener('click', function() {
        let selectedIds = [];
        document.querySelectorAll('.log-checkbox:checked').forEach(checkbox => {
            selectedIds.push(checkbox.value);
        });

        if (selectedIds.length > 0) {
            if (confirm('Voulez-vous vraiment supprimer les logs sélectionnés?')) {
                document.getElementById('delete-ids').value = selectedIds.join(',');
                document.getElementById('delete-form').submit();
            }
        } else {
            alert('Veuillez sélectionner au moins un log à supprimer.');
        }
    });
</script>

<script>
    
    function exportData() {
        document.getElementById('exportForm').submit();
    }

    function changePerPage(select) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', select.value);
        window.location.href = url.href; // Recharger la page avec le nouveau paramètre 'perPage'
    }
</script>

<script>
$(document).ready(function() {
    // Initialiser Bootstrap Datepicker
    $('#startDate, #endDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        clearBtn: true,
        todayHighlight: true
    });

    // Fonction pour filtrer les logs par date
    $('#filterByDateBtn').on('click', function() {
        var startDate = $('#startDate').datepicker('getFormattedDate');
        var endDate = $('#endDate').datepicker('getFormattedDate');
        
        filterLogsByDate(startDate, endDate);
    });

    function filterLogsByDate(startDate, endDate) {
        // Envoyer une requête AJAX pour filtrer les logs par date
        $.ajax({
            url: '{{ route("filterLogsByDate") }}',
            method: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(data) {
                var tableBody = $('#logsTable tbody');
                tableBody.empty(); // Vider le contenu actuel du tableau

                // Remplir le tableau avec les données filtrées
                data.forEach(function(log) {
                    var row = '<tr>' +
                        '<td><input type="checkbox" class="log-checkbox" value="{{ $log->id }}"></td>' +
                        '<td>' + log.id + '</td>' +
                        '<td>' + log.action + '</td>' +
                        '<td>' + log.asset.designation + '</td>' +
                        '<td>' + log.asset.marque + '</td>' +
                        '<td>' + log.asset.modele + '</td>' +
                        '<td>' + log.user.username + '</td>' +
                        '<td>' + log.created_at + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });

                reloadCustomCSS(); // Rechargez les CSS personnalisés après la mise à jour du tableau
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function reloadCustomCSS() {
        var customCssLink = document.getElementById('customCssLink');
        if (customCssLink) {
            var href = customCssLink.getAttribute('href');
            var newHref = href + '?timestamp=' + new Date().getTime();
            customCssLink.setAttribute('href', newHref);
        }
    }
});

</script>



<!-- Inclure jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Inclure Bootstrap JS et Bootstrap Datepicker JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script src="{{ asset('clientsAssets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('clientsAssets/js/DataTable---Fully-BSS-Editable-style.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Dynamic-Table-dynamic-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Table-With-Search-search-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/theme.js') }}"></script>
@endsection
