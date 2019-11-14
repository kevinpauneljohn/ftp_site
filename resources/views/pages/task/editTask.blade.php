@extends('layouts.admin_template')

@section('title')
    Tasks | Edit Task
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
    <style type="text/css">
        .page-header{
            font-size: 15px;
        }
    </style>
@endsection
@section('page_header')
    Edit Task
@endsection

@section('main_content')
    <div class="box">
        <div class="box-body">
            <form role="form" method="post" action="{{route('job.orders.create')}}">
                @if(session('success') == true)
                    <div class="alert alert-success">Task Successfully Updated</div>
                @endif
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                            <label for="title">Title</label><span class="required">*</span>
                            <input type="text" name="title" class="form-control" value="{{old('title')?: $task->title}}" />
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group description {{$errors->has('description') ? 'has-error' : ''}}">
                            <label for="description">Description</label><span class="required">*</span>
                            <div class="box-body pad">

                            <textarea name="description" id="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                {{old('description') ?: $task->description}}
                            </textarea>

                            </div>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Date -->
                        <div class="form-group {{$errors->has('deadline_date') ? 'has-error' : ''}}">
                            <label>Deadline</label><span class="required">*</span>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="deadline_date" class="form-control pull-right" id="datepicker" value="{{old('deadline_date') ?: $task->deadline_date}}">
                            </div>
                            <!-- /.input group -->
                            @error('deadline_date')
                            <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <!-- time Picker -->
                        <div class="bootstrap-timepicker">
                            <div class="form-group {{$errors->has('deadline_time') ? 'has-error' : ''}}">
                                <label>Time</label><span class="required">*</span>

                                <div class="input-group">
                                    <input type="text" name="deadline_time" class="form-control timepicker" value="{{old('deadline_time') ?: $task->deadline_time}}">

                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                                <!-- /.input group -->
                                @error('deadline_time')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <!-- /.form group -->
                        </div>
                        <div class="form-group assignTo">
                            <label for="assignTo">Assign To</label>
                            <select class="form-control" name="assignTo" id="assignTo">
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" @if($user->id == $task->assigned_to) selected="selected" @endif>{{$user->username}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
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
    <script src="{{asset('bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

    <!-- InputMask -->
    <script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

    <!-- bootstrap datepicker -->
    <script src="{{asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- bootstrap time picker -->
    <script src="{{asset('/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

    <script>
        $(function () {
            $('#product-list').DataTable();
            $('.role-assign').select2();
            $('.textarea').wysihtml5();
            $('[data-mask]').inputmask();
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false,
                defaultTime: false,
            });
        })
    </script>
    <script>

        $(function() {
            $('#job-orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('task.all.list') !!}',
                columns: [
                    { data: 'created_at', name: 'created_at'},
                    { data: 'job_order_id', name: 'job_order_id'},
                    { data: 'title', name: 'title' },
                    { data: 'deadline_date', name: 'deadline_date'},
                    { data: 'assigned_to', name: 'assigned_to'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection