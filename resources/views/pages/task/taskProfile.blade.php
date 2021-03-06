@extends('layouts.admin_template')

@section('title')
    Task | Profile
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
    Task Profile
@endsection

@section('main_content')

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center">{{$profile->title}}</h3>

                        <p class="text-muted text-center">{{\App\category::find($profile->category_id)->name}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Job Order Number</b> <a class="pull-right" href="{{route('job.order.profile',['jobOrderId' => $profile->id])}}">{{str_pad($profile->id, 5, '0', STR_PAD_LEFT)}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Customer</b> <a class="pull-right">{{ucfirst($profile->customer_name)}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Contact No.</b> <a class="pull-right">{{$profile->customer_contact_number}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Pick-up Date</b> <a class="pull-right">{{date_format(date_create($profile->pickup_date),"d/M/Y")}} {{$profile->pickup_time}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Total Amount</b> <a class="pull-right">&#8369; {{number_format($profile->amount,2)}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Down Payment</b> <a class="pull-right">&#8369; {{number_format($profile->down_payment,2)}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Balance</b> <a class="pull-right">&#8369; {{number_format(($profile->amount - $profile->down_payment),2)}}</a>
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
                            @if($task->assigned_to == auth()->user()->id)
                            <button type="button" class="btn btn-{{($task->status == 'pending') ? 'primary' : 'default'}} operation" @if($task->status == "on-going" || $task->status == 'for-approval' || $task->status == 'completed') disabled="disabled" @endif value="start-{{$task->id}}">Start</button>
                            <button type="button" class="btn btn-{{($task->status == 'on-going') ? 'warning' : 'default'}} operation" @if($task->status == "pending" || $task->status == 'for-approval' || $task->status == 'completed') disabled="disabled" @endif value="end-{{$task->id}}">stop</button>
                                @endif
                                @if($task->status == 'for-approval' || $task->status == 'completed')
                                <button type="button" class="btn btn-{{($task->status == 'for-approval') ? 'success' : 'default'}} operation" @if($task->status == "completed") disabled="disabled" @endif value="completed-{{$task->id}}">completed</button>
                                @endif
                            <span class="pull-right"><strong>Status:</strong> {{$task->status}} </span>
                        </div>
                    </div>

                <div class="box">
                    <div class="box-header">
                        <h2 class="page-header">{{ucfirst($task->title)}}
                            @php $date=date_create($task->deadline_date); @endphp
                            <small class="pull-right"><strong>Deadline:</strong> {{date_format($date,"d/M/Y")}} {{$task->deadline_time}}</small></h2>

                    </div>
                    <div class="box-body">
                        {!! $task->description !!}
                    </div>
                    <div class="box-footer">

                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

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

        <script src="{{asset('/js/task.js')}}"></script>

    <script>
        $(function () {
            $('#job-order-list').DataTable()
            $('.role-assign').select2()
        })
    </script>


@endsection