@extends('layouts.app')
@section('title')
    Edit Group
@endsection
@section('contenu')
<div class="container-fluid">
    <button class="btn btn-primary pull-right" type="button" onclick="window.location.href='{{ route('groups.showGroupManagementPage') }}'">
        <i class="fa fa-star" style="font-size: 1px; background-color: rgb(141, 78, 5);"></i>&nbsp;Return 
    </button>
    <h3 class="text-dark mb-4"><span style="color: rgb(9, 179, 94);">Edit User Group</span></h3>
    <div class="row mb-3">
        <div class="col-xxl-4">
            <div class="card shadow mb-3">
                <div class="card-header py-3">
                    <p class="text-primary m-0 fw-bold">Edit Group</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('groups.update', $group->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="groupname"><strong>Group Name</strong></label>
                                    <input class="form-control" type="text" id="groupname" name="groupname" value="{{ $group->name }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="level"><strong>Group Level</strong></label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="Administrator" {{ $group->level == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        <option value="Simple User" {{ $group->level == 'Simple User' ? 'selected' : '' }}>Simple User</option>
                                        <option value="Guest" {{ $group->level == 'Guest' ? 'selected' : '' }}>Guest</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow"></div>
        </div>
    </div>
</div>
</div>
@endsection
