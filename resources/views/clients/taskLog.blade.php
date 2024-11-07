@extends('layouts.app')

@section('title', 'Journal sur la mise a jours des états des assets')

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
<link id="customCssLink" rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/tabStyle.css') }}">

<section class="mt-4">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Journal sur la mise a jours de l'états des assets</span></h3>

        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-primary m-0 fw-bold">Logs</p>
                            <div class="d-flex">
                                <input type="text" id="search-input" class="form-control form-control-sm mr-2" placeholder="Recherche...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form id="deleteForm" method="POST" action="{{ route('logs.deleteMultiple') }}">
                                @csrf
                                <div class="mb-3">
                                    <button type="button" id="selectAllBtn" class="btn btn-primary">Sélectionner tout</button>
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer les lignes sélectionnées ?')">Supprimer les lignes sélectionnées</button>
                                </div>
                                <table class="table table-bordered" id="logsTable">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th> <!-- Case à cocher pour tout sélectionner -->
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Message</th>
                                        <th>Timestamp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logs as $index => $log)
                                        <tr>
                                            <td><input type="checkbox" name="selectedLogs[]" value="{{ $log->id }}"></td> <!-- Case à cocher pour chaque ligne -->
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $log->status }}</td>
                                            <td>{{ $log->message }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        {{-- Ajout d'un ascenseur pour le tableau --}}
                        <div style="max-height: 400px; overflow-y: auto;">
                            {{-- Pagination --}}
                            <div class="row">
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

{{--suppression multiple--}}
<script >
    
    document.getElementById('selectAll').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('input[name="selectedLogs[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('selectAllBtn').addEventListener('click', function () {
        let checkboxes = document.querySelectorAll('input[name="selectedLogs[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = true);
    });

// fonction par page
    function changePerPage(select) {
        const url = new URL(window.location.href);
        url.searchParams.set('perPage', select.value);
        window.location.href = url.href; // Recharger la page avec le nouveau paramètre 'perPage'
    }

</script>
<script src="{{ asset('clientsAssets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('clientsAssets/js/DataTable---Fully-BSS-Editable-style.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Dynamic-Table-dynamic-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/Table-With-Search-search-table.js') }}"></script>
<script src="{{ asset('clientsAssets/js/theme.js') }}"></script>

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
