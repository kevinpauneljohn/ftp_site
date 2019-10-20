@extends('layouts.admin_template')

@section('title')
    Users
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
    Users
@endsection

@section('main_content')
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-body">
                    @if(session('success') == true)
                        <div class="alert alert-success">User successfully added!</div>
                        @endif
                    <h4>Name</h4>
                    <hr/>
                    <form action="{{route('users.create')}}" method="post">
                        @csrf
                        <div class="form-group {{$errors->has('firstname') ? 'has-error' : ''}}">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" value="{{old('firstname')}}" class="form-control" id="firstname"/>
                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="middlename">Middle Name</label>
                            <input type="text" name="middlename" value="{{old('middlename')}}" class="form-control" id="middlename"/>
                        </div>

                        <div class="form-group {{$errors->has('lastname') ? 'has-error' : ''}}">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" value="{{old('lastname')}}" class="form-control" id="lastname"/>
                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <h4>Access Details</h4>
                        <hr/>
                        <div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{old('email')}}" class="form-control" id="email"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="{{old('username')}}" class="form-control" id="username"/>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password"/>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"/>
                        </div>
                        <div class="form-group {{$errors->has('role') ? 'has-error' : ''}}">
                            <label for="role">Role</label>
                            <select name="role" class="form-control" id="role">
                                <option></option>
                                @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group {{$errors->has('permissions') ? 'has-error' : ''}}">
                            <label>Assign to Roles</label>
                            <select name="permissions[]" class="form-control permissions-assign" multiple="multiple" data-placeholder="Select Permission"
                                    style="width: 100%;">
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->name}}">{{$permission->name}}</option>
                                @endforeach
                            </select>
                            @error('permissions')
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

        <div class="col-lg-8">
            <div class="box">
                <div class="box-body">
                    <table id="role-list" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="8%">Date Created</th>
                            <th width="8%">Roles</th>
                            <th width="30%">Full name</th>
                            <th width="30%">Username</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    @foreach($user->getRoleNames() as $roleName)
                                        {{$roleName}}
                                        @endforeach
                                </td>
                                <td>
                                    {{ucfirst($user->firstname)}}
                                    {{ucfirst($user->middlename)}}
                                    {{ucfirst($user->lastname)}}
                                </td>
                                <td>{{$user->username}}</td>
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
                            <th width="8%">Roles</th>
                            <th width="30%">Full name</th>
                            <th width="30%">Username</th>
                            <th width="15%">Action</th>
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

    {{--    <script src="{{asset('/js/rolesPermissions.js')}}"></script>--}}

    <script>
        $(function () {
            $('#role-list').DataTable()
            $('.permissions-assign').select2()
        })
    </script>
@endsection