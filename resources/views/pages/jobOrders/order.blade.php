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
            <table id="job-order-list" class="table table-bordered table-hover">
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
                <tbody>
                @foreach($jobOrders as $jobOrder)
                    <tr>
                        <td>{{$jobOrder->created_at}}</td>
                        <td>{{\App\category::find($jobOrder->category_id)->name}}</td>
                        <td>{{$jobOrder->title}}</td>
                        <td>{{$jobOrder->customer_name}}</td>
                        <td>{{$jobOrder->customer_contact_number}}</td>
                        <td>{{$jobOrder->pickup_date}}</td>
                        <td>{{$jobOrder->pickup_time}}</td>
                        <td>{{\App\User::find($jobOrder->created_by)->username}}</td>
                        <td>{{$jobOrder->status}}</td>
                        <td>
                            <a><button type="button" class="btn btn-primary" title="view"><i class="fa fa-eye"></i></button></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
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

@endsection