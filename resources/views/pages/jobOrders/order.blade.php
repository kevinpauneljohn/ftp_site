@extends('layouts.admin_template')

@section('title')
    Job Orders | Orders
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
    Job Orders
@endsection

@section('main_content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
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
                <h4></h4>
                <span class="">
                    <small class="label bg-red">1 day or less</small>
                  <small class="label bg-yellow">3 days</small>
                  <small class="label bg-light-blue">4 days to 1 week</small>
                </span>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered" id="job-orders-table">
                <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Job Order No.</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Customer Name</th>
                    <th>Customer Contact Number</th>
                    <th>Pick Up Date</th>
                    <th>Pick Up Time</th>
                    <th>Created by</th>
                    <th>Task Count</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    {{--delete job order--}}
    <div class="modal modal-danger fade" id="delete-job-order">
        <div class="modal-dialog">
            <form class="delete-job-order-form">
                @csrf
                <input type="hidden" name="jobOrderId" id="job-order-id"/>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>

                </div>
                <div class="modal-body">
                    Delete Job Order: <span class="job-order-name"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline">Delete</button>
                </div>
            </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--end delete job order--}}
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

        <script src="{{asset('/js/jobOrder.js')}}"></script>

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
                ajax: '{!! route('job.orders.datatables') !!}',
                columns: [
                    { data: 'created_at', name: 'created_at'},
                    { data: 'id', name: 'id'},
                    { data: 'category_id', name: 'category_id'},
                    { data: 'title', name: 'title' },
                    { data: 'customer_name', name: 'customer_name'},
                    { data: 'customer_contact_number', name: 'customer_contact_number'},
                    { data: 'pickup_date', name: 'pickup_date'},
                    { data: 'pickup_time', name: 'pickup_time'},
                    { data: 'created_by', name: 'created_by'},
                    { data: 'task_count', name: 'task_count'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                responsive:true,
                order:[0,'asc']
            });
        });
    </script>

@endsection