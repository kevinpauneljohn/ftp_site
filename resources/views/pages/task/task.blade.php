@extends('layouts.admin_template')

@section('title')
    Tasks
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
    <style type="text/css">
        .page-header{
            font-size: 15px;
        }
    </style>
@endsection
@section('page_header')
    My Tasks
@endsection

@section('main_content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$onGoing}}</h3>

                    <p>On-going Tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-plane"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$completed}}</h3>

                    <p>Completed tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{$pending}}</h3>

                    <p>Pending Tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-stop-circle-o"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{$forApproval}}</h3>

                    <p>For Approval</p>
                </div>
                <div class="icon">
                    <i class="fa fa-thumbs-o-up"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="box">
        <div class="box-header">
            <div class="page-header">
                <input type="hidden" name="action" class="action" value="mine"/>
                <select class="status-display">
                    <option value="all" @if(session('statusMyTask') == null) selected="selected" @endif>all</option>
                    <option value="pending" @if(session('statusMyTask') == "pending") selected="selected" @endif>Pending</option>
                    <option value="on-going" @if(session('statusMyTask') == "on-going") selected="selected" @endif>On-going</option>
                    <option value="for-approval" @if(session('statusMyTask') == "for-approval") selected="selected" @endif>For approval</option>
                    <option value="completed" @if(session('statusMyTask') == "completed") selected="selected" @endif>Completed</option>
                </select>
                Choose Status To Display
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover" id="job-orders-table">
                <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Job Order</th>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
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

        <script src="{{asset('/js/task.js')}}"></script>

    <script>
        $(function () {
            $('#job-order-list').DataTable()
            $('.role-assign').select2()
        })
    </script>

    <script>
        $(function() {
            $('#job-orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('task.list') !!}',
                columns: [
                    { data: 'created_at', name: 'created_at'},
                    { data: 'job_order_id', name: 'job_order_id'},
                    { data: 'title', name: 'title' },
                    { data: 'deadline_date', name: 'deadline_date'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection