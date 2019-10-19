@extends('layouts.admin_template')

@section('title')
    Roles
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
Roles
@endsection

@section('main_content')
    <div class="row">
        <div class="col-lg-3">
            {{--Roles--}}
            <div class="box">
                <div class="box-header">
                    Add Role
                </div>
                <div class="box-body">
                    @if(session('success') == true)
                        <div class="alert alert-success">Role Successfully Added!</div>
                    @endif
                    <form action="{{route('roles')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="roleName">Role Name</label>
                            <input type="text" name="roleName" class="roleName form-control {{$errors->has('roleName') ? 'is-invalid' : ''}}" id="roleName"/>
                            @error('roleName')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

            {{--Permission--}}
            <div class="box">
                <div class="box-header">
                    Add Permission
                </div>
                <div class="box-body">
                    @if(session('success') == true)
                        <div class="alert alert-success">Role Successfully Added!</div>
                    @endif
                    <form action="{{route('permissions')}}" method="post" class="permission-form">
                        @csrf
                        <div class="form-group">
                            <label for="permission">Permission Label</label>
                            <input type="text" name="permission" class="permission form-control {{$errors->has('permission') ? 'is-invalid' : ''}}" id="roleName"/>
                            @error('permission')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Assign to Roles</label>
                            <select name="roleAssignment" class="form-control role-assign" multiple="multiple" data-placeholder="Select roles"
                                    style="width: 100%;">
                                @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                            </select>
                            @error('roleAssignment')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="box">
                <div class="box-body">
                    <table id="role-list" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="8%">Date Created</th>
                            <th width="8%">Role Name</th>
                            <th width="70%">Permissions</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->created_at}}</td>
                                        <td>{{$role->name}}</td>
                                        <td></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th width="8%">Date Created</th>
                            <th width="8%">Role Name</th>
                            <th width="70%">Permissions</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('extra_script')
    <!-- DataTables -->
    <script src="{{asset('/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{asset('/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- FastClick -->
    <script src="{{asset('/bower_components/fastclick/lib/fastclick.js')}}"></script>

    <!-- growl notification -->
{{--    <script src="{{asset('bower_components/remarkable-bootstrap-notify/bootstrap-notify.min.js')}}"></script>--}}
    <!-- Select2 -->
    <script src="{{asset('/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

    <script src="{{asset('/js/rolesPermissions.js')}}"></script>

    <script>
        $(function () {
            $('#role-list').DataTable()
            $('.role-assign').select2()
        })
    </script>
@endsection