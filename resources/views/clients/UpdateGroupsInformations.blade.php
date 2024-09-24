@extends('layouts.app')
@section('title')
    Edit Group
@endsection
@section('contenu')
    
<div class="container-fluid">
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Update Users Groups&nbsp;</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-12">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Update Users Group</p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="groupname"><strong>Group Name</strong></label><input class="form-control" type="text" id="groupname" placeholder="" name="groupname"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="groupLevel"><strong>Group Level</strong></label><input class="form-control" type="text" id="groupLevel" placeholder="" name="groupLevel"></div>
                            </div>
                            <div class="col">
                                <div class="mb-3"><label class="form-label" for="Status"><strong>Status</strong></label><input class="form-control" type="text" id="status" placeholder="" name="status"></div>
                            </div>
                        </div>
                        <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit">Update</button></div>
                    </form>
                </div>
            </div>
            <div class="card shadow"></div>
        </div>
    </div>
    <div class="card shadow mb-5"></div>
</div>
</div>
@endsection
    <script src="clientsAssets/bootstrap/js/bootstrap.min.js"></script>
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
    <script src="clientsAssets/js/DataTable---Fully-BSS-Editable-style.js"></script>
    <script src="clientsAssets/js/Dynamic-Table-dynamic-table.js"></script>
    <script src="clientsAssets/js/Table-With-Search-search-table.js"></script>
    <script src="clientsAssets/js/theme.js"></script>
