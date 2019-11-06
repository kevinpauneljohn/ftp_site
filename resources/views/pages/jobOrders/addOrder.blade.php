@extends('layouts.admin_template')

@section('title')
    Job Orders | Add Order
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
    Add Job Order
@endsection

@section('main_content')
    <div class="box">
        <div class="box-body">
            <form role="form">
            <div class="row">
                <div class="col-lg-6">
                        <div class="form-group {{$errors->has('category') ? 'has-error' : ''}}">
                            <label for="category">Category</label>
                            {{old('$category')}}
                            <select name="category" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"  @if (old('category') == $category->id) {{ 'selected' }} @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    <div class="form-group">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" name="customer_name" value="{{old('customer_name')}}" class="form-control" id="customer_name" />
                    </div>
                    <div class="form-group">
                        <label>Customer Contact Number</label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" name="contact_number" class="form-control" data-inputmask='"mask": "(9999) 999-9999"' data-mask>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Date -->
                    <div class="form-group">
                        <label>Pickup Date</label>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="pickup_date" class="form-control pull-right" id="datepicker">
                        </div>
                        <!-- /.input group -->
                    </div>
                    <!-- time Picker -->
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label>Pick Up Time</label>

                            <div class="input-group">
                                <input type="text" name="pickup_time" class="form-control timepicker">

                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                        </div>
                        <!-- /.form group -->
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" />
                        </div>
                        <div class="form-group description">
                            <label for="description">Description</label>
                            <div class="box-body pad">

                                <textarea name="description" id="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Job Order</button>
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
{{--    <script src="../../plugins/input-mask/jquery.inputmask.js"></script>--}}
{{--    <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>--}}
{{--    <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>--}}
    <script>
        $(function () {
            $('#product-list').DataTable();
            $('.role-assign').select2();
            $('.textarea').wysihtml5();
            $('[data-mask]').inputmask();
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            });
            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false,
                defaultTime: false,
            });
        })
    </script>
@endsection