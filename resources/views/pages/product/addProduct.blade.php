@extends('layouts.admin_template')

@section('title')
    Product
@endsection
@section('extra_stylesheet')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('/bower_components/select2/dist/css/select2.min.css')}}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
@endsection
@section('page_header')
    Add Product
@endsection

@section('main_content')
    <div class="box">
        <div class="box-body">
            <form action="{{route('product.create')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="row">
               <div class="col-lg-6">
                   <div class="form-group {{$errors->has('image') ? 'has-error' : ''}}">
                       <label for="image">Image</label>
                       <input type="file" name="image" value="{{old('image')}}" class="form-control" id="image"/>
                       @error('image')
                       <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                       @enderror
                   </div>
                        <div class="form-group {{$errors->has('title') ? 'has-error' : ''}}">
                           <label for="title">Title</label>
                           <input type="text" name="title" value="{{old('title')}}" class="form-control" id="title"/>
                           @error('title')
                           <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                           @enderror
                       </div>
                   <div class="form-group">
                       <label for="size">Size</label>
                       <div class="row">
                           <div class="col-lg-10">
                               <input type="number" name="size" value="{{old('size')}}" class="form-control" id="size"/>
                           </div>
                           <div class="col-lg-2">
                               <select name="measurement" class="form-control">
                                   <option></option>
                                    <option value="in">in</option>
                                    <option value="cm">cm</option>
                                    <option value="mm">mm</option>
                                    <option value="ft">ft</option>
                                    <option value="px">px</option>
                                    <option value="pt">pt</option>
                               </select>
                           </div>
                       </div>
                   </div>
                   <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                       <label for="description">Description</label>
                       <textarea name="description" class="form-control" id="description" style="min-height: 300px;">
                        {{old('description')}}
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
                                    <option value="{{$category->id}}">{{$category->name}}</option>
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