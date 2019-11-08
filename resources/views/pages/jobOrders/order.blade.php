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
    <div class="box">
        <div class="box-body">
            <table class="table table-bordered" id="job-orders-table">
                <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Customer Name</th>
                    <th>Customer Contact Number</th>
                    <th>Pick Up Date</th>
                    <th>Pick Up Time</th>
                    <th>Created by</th>
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

    {{--    <script src="{{asset('/js/rolesPermissions.js')}}"></script>--}}

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
                    { data: 'category_id', name: 'category_id'},
                    { data: 'title', name: 'title' },
                    { data: 'customer_name', name: 'customer_name'},
                    { data: 'customer_contact_number', name: 'customer_contact_number'},
                    { data: 'pickup_date', name: 'pickup_date'},
                    { data: 'pickup_time', name: 'pickup_time'},
                    { data: 'created_by', name: 'created_by'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

@endsection