@extends('layouts.admin_template')

@section('title')
    Job Orders | Profile
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/plugins/timepicker/bootstrap-timepicker.min.css')}}">
@endsection
@section('page_header')
    Job Order Profile
@endsection

@section('main_content')
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center">{{$profile->title}}</h3>

                        <p class="text-muted text-center">{{\App\category::find($profile->category_id)->name}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Customer</b> <a class="pull-right">{{ucfirst($profile->customer_name)}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Contact No.</b> <a class="pull-right">{{$profile->customer_contact_number}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pick-up Date</b> <a class="pull-right">{{$profile->pickup_date}} {{$profile->pickup_time}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-calendar margin-r-5"></i> Date Created</strong>

                        <p class="text-muted">
                            {{$profile->created_at}}
                        </p>

                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> Created By</strong>

                        <p class="text-muted">
                            {{\App\User::find($profile->created_by)->username}}
                        </p>

                        <hr>

                        <strong><i class="fa fa-thermometer margin-r-5"></i> Status</strong>

                        <p><small class="label label-warning">{{$profile->status}}</small></p>

                        <hr>

                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                        <p>{!! $profile->description !!}</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <form method="post" action="{{route('job.order.status.complete')}}">
                            @csrf
                            <input type="hidden" name="jobProfileId" value="{{$profile->id}}">
                        @if($profile->status !== 'completed')
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-task">Create task</button>
                        @endif
                        @if($profile->status == 'for-pickup')
                            <button type="submit" class="btn btn-success">Completed</button>
                        @endif
                            </form>
                    </div>
                </div>

                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered table-hover" id="job-orders-table">
                            <thead>
                            <tr>
                                <th>Date Created</th>
                                <th>Job Order</th>
                                <th>Title</th>
                                <th>Deadline</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>

    {{--create task--}}
    <div class="modal fade" id="create-task">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="create-task-form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Create task</h4>
                    </div>

                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="job_order_id" value="{{$profile->id}}"/>
                        <input type="hidden" name="created_by" value="{{auth()->user()->id}}"/>
                        <div class="form-group title">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" value=""/>
                        </div>
                        <div class="form-group description">
                            <label for="description">Description</label><span class="required">*</span>
                            <div class="box-body pad">

                            <textarea name="description" id="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Date -->
                                <div class="form-group deadline_date">
                                    <label>Deadline</label><span class="required">*</span>

                                    <div class="input-group deadline_date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="deadline_date" id="deadline_date" class="form-control pull-right" id="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- time Picker -->
                                <div class="bootstrap-timepicker deadline_time">
                                    <div class="form-group">
                                        <label>Time</label><span class="required">*</span>

                                        <div class="input-group">
                                            <input type="text" name="deadline_time" id="deadline_time" class="form-control timepicker" value="">

                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.form group -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group assignTo">
                                    <label for="assignTo">Assign To</label>
                                    <select class="form-control" name="assignTo" id="assignTo">
                                        <option></option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->username}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-purple"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--end create task--}}
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

    <script src="{{asset('bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

    <script src="{{asset('/js/task.js')}}"></script>

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
            $('#job-order-list').DataTable()
            $('.role-assign').select2();
            $('.textarea').wysihtml5();

            $('[data-mask]').inputmask();
            //Date picker
            $('#deadline_date').datepicker({
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
                ajax: '{!! route('job.orders.tasks', ["jobOrderId" => $profile->id]) !!}',
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