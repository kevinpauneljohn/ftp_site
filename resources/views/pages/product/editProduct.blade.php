@extends('layouts.admin_template')

@section('title')
    Product | Edit Product
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
    Edit Product
@endsection

@section('main_content')
    <div class="box">
        <div class="box-body">
            <form action="{{route('product.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="productId" value="{{$product->id}}"/>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{$product->title}}" class="form-control" id="title"/>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="size">Size</label>
                            <input type="text" name="size" value="{{$product->size}}" class="form-control" id="size"/>
                        </div>
                        <div class="form-group {{$errors->has('price') ? 'has-error' : ''}}">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" value="{{$product->price}}" step="0.01"/>
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" style="min-height: 300px;">
                                {{$product->description}}
                            </textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group {{$errors->has('category') ? 'has-error' : ''}}">
                            <label for="category">Category</label>
                            <select name="category" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"{{($product->category_id == $category->id ? ' selected=selected':'')}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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

    <script>
        $(function () {
            $('#role-list').DataTable()
            $('.role-assign').select2()
        })
    </script>
@endsection