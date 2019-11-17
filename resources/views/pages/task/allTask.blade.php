@extends('layouts.admin_template')

@section('title')
    Tasks | All Tasks
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
    All Tasks
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
                <input type="hidden" name="action" class="action" value="all"/>
                <select class="status-display">
                    <option value="all" @if(session('status') == null) selected="selected" @endif>all</option>
                    <option value="pending" @if(session('status') == "pending") selected="selected" @endif>Pending</option>
                    <option value="on-going" @if(session('status') == "on-going") selected="selected" @endif>On-going</option>
                    <option value="for-approval" @if(session('status') == "for-approval") selected="selected" @endif>For approval</option>
                    <option value="completed" @if(session('status') == "completed") selected="selected" @endif>Completed</option>
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
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    {{--delete task--}}
    <div class="modal modal-danger fade" id="delete-task">
        <div class="modal-dialog">
            <form class="task-form">
                @csrf
                <input type="hidden" name="taskId" id="taskId"/>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>

                    </div>
                    <div class="modal-body">
                        Delete task: <span class="task-name"></span>?
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-outline pull-left" data-dismiss="modal">Close</a>
                        <button type="submit" class="btn btn-outline">Delete</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--end delete task--}}
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
        $(document).on('click','.delete-task-btn',function (a) {
            a.preventDefault();
            let value  = this.id;

            $.ajax({
                'url'   : '{{route('task.data.display')}}',
                'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                'type'  : 'POST',
                'data'  : {
                    'id' : value
                },
                'cache' : false,
                success: function (result) {
                    console.log(result);
                    $('.task-name').html('<strong>'+result.title+'</strong>')
                    $('#taskId').val(result.id);
                },error: function (result) {
                    console.log(result.status);
                }
            });
        });

        $(document).on('submit','.task-form',function (form) {
            form.preventDefault();
            let value  = $('.task-form').serialize();

            $.ajax({
                'url'   : '{{route('task.data.delete')}}',
                'headers': {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                'type'  : 'POST',
                'data'  : value,
                'cache' : false,
                success: function (result) {
                    console.log(result);
                    if(result.success == true)
                    {
                        location.reload();
                    }
                },error: function (result) {
                    console.log(result.status);
                }
            });
        });
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