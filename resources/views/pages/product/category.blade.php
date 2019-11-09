@extends('layouts.admin_template')

@section('title')
    Products | Categories
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
@endsection
@section('page_header')
Category
@endsection

@section('main_content')
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="page-header">
                    <h4 align="center"><strong>Add Category</strong></h4>
                    {{--<h1 align="center" class="reference-number"><strong>{{str_pad($referenceNumber, 5, '0', STR_PAD_LEFT)}}</strong></h1>--}}
                </div>
                <div class="box-body">
                    @if(session('success') == true)
                        <div class="alert alert-success">Category Successfully Added!</div>
                        @endif
                    <form role="form" method="post" action="{{route('category.add')}}">
                        @csrf
                        <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                            <label for="name">Name</label><span class="required">*</span>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" />
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group {{$errors->has('permalink') ? 'has-error' : ''}}">
                            <label for="permalink">Permalink</label><span class="required">*</span>
                            <input type="text" name="permalink" class="form-control" value="{{old('permalink')}}" />
                            @error('permalink')
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
                    <table class="table table-bordered" id="category-table">
                        <thead>
                        <tr>
                            <th>Date Created</th>
                            <th>Category</th>
                            <th>Permalink</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--edit category--}}
    <div class="modal fade" id="edit-category">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="edit-category-form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit Category</h4>
                    </div>

                    <div class="modal-body">

                        @csrf
                        <input type="hidden" name="category_id" id="category-id" />
                        <div class="form-group category_name">
                            <label for="category_name">Name</label>
                            <input type="text" name="category_name" class="form-control" id="category_name" value=""/>
                        </div>

                        <div class="form-group permalink">
                            <label for="permalink">Permalink</label>
                            <input type="text" name="permalink" class="form-control" id="permalink" value=""/>
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
    {{--end edit category--}}
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
    <script src="{{asset('/js/product.js')}}"></script>

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
            $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('category.data') !!}',
                columns: [
                    { data: 'created_at', name: 'created_at'},
                    { data: 'name', name: 'name'},
                    { data: 'permalink', name: 'permalink'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection