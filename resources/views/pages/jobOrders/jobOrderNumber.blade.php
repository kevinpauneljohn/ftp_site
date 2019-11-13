@extends('layouts.admin_template')

@section('title')
    Job Orders | Reference Number
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

    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
    <style type="text/css">
        .col-form-label-sm{
            text-align: center;
            font-size: 20px;
            color: #73706f;
        }
        .reference-number{
            font-size:50px;
        }
    </style>
@endsection
@section('page_header')

@endsection

@section('main_content')
    <br/><br/>
    <div class="box">
        <div class="page-header">
            <h1 align="center" class="reference-number"><strong>{{str_pad($referenceNumber, 5, '0', STR_PAD_LEFT)}}</strong></h1>
            <div class="col-form-label-sm">Job Order Number</div>
        </div>
        <div class="box-body">
            <div align="center">
                <button class="btn btn-default print"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-info"><i class="fa fa-tasks"></i> Create Task</button>
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
@endsection