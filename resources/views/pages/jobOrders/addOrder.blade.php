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
    @php

        /*$date = Carbon::parse('2019-11-09')->format("Y-m-d");
            $now = Carbon::now('Asia/Manila');

            $diff = Carbon::parse($date)->diffForHumans();

        echo $diff;*/
        /*use Illuminate\Support\Carbon;
            $date = Carbon::parse('2019-11-10');
            $now = Carbon::now('Asia/Manila');

            $diff = $date->diffInDays($now);

        echo $diff;*/
    @endphp
    <div class="box">
        <div class="box-body">
            <form role="form" method="post" action="{{route('job.orders.create')}}">
                @if(session('success') == true)
                    <div class="alert alert-success">Job Order Successfully created</div>
                    @endif
                @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                        <label for="title">Title</label><span class="required">*</span>
                        <input type="text" name="title" class="form-control" value="{{old('title')}}" />
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group description {{$errors->has('description') ? 'has-error' : ''}}">
                        <label for="description">Description</label><span class="required">*</span>
                        <div class="box-body pad">

                            <textarea name="description" id="description" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                {{old('description')}}
                            </textarea>

                        </div>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group {{$errors->has('category') ? 'has-error' : ''}}">
                        <label for="category">Category</label><span class="required">*</span>
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
                </div>
                <div class="col-lg-6">
                    <div class="form-group {{$errors->has('customer_name') ? 'has-error' : ''}}">
                        <label for="customer_name">Customer Name</label><span class="required">*</span>
                        <input type="text" name="customer_name" value="{{old('customer_name')}}" class="form-control" id="customer_name" />
                        @error('customer_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group {{$errors->has('contact_number') ? 'has-error' : ''}}">
                        <label>Customer Contact Number</label><span class="required">*</span>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <input type="text" name="contact_number" class="form-control" data-inputmask='"mask": "(9999) 999-9999"' data-mask value="{{old('contact_number')}}">
                        </div>
                        @error('contact_number')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <!-- /.input group -->
                    </div>
                    <!-- Date -->
                    <div class="form-group {{$errors->has('pickup_date') ? 'has-error' : ''}}">
                        <label>Pickup Date</label><span class="required">*</span>

                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="pickup_date" class="form-control pull-right" id="datepicker" value="{{old('pickup_date')}}">
                        </div>
                        <!-- /.input group -->
                        @error('pickup_date')
                        <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- time Picker -->
                    <div class="bootstrap-timepicker">
                        <div class="form-group {{$errors->has('pickup_time') ? 'has-error' : ''}}">
                            <label>Pick Up Time</label><span class="required">*</span>

                            <div class="input-group">
                                <input type="text" name="pickup_time" class="form-control timepicker" value="{{old('pickup_time')}}">

                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                            </div>
                            <!-- /.input group -->
                            @error('pickup_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- /.form group -->
                    </div>
                    <div class="form-group {{$errors->has('amount') ? 'has-error' : ''}}">
                        <label for="amount">Amount</label><span class="required">*</span>
                        <input type="number" name="amount" class="form-control" value="{{old('amount') ?: 0}}"  step="0.01" min="0"/>
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="form-group {{$errors->has('down_payment') ? 'has-error' : ''}}">
                        <label for="down_payment">Down Payment</label>
                        <input type="number" name="down_payment" class="form-control" value="{{old('down_payment') ?: 0}}"  step="0.01" min="0" />
                        @error('down_payment')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
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