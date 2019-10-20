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
    Product
@endsection

@section('main_content')
    <div class="box">
        <div class="box-body">
            <table id="product-list" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th width="8%">Date Created</th>
                    <th width="8%">Price</th>
                    <th width="8%">Thumbnail</th>
                    <th width="8%">Name</th>
                    <th width="30%">Description</th>
                    <th width="12%">Author</th>
                    <th width="12%">Category</th>
                    <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->created_at}}</td>
                            <td>&#8369; {{$product->price}}</td>
                            <td><img src="{{asset('images/'.$product->productImage)}}" class="img-thumbnail"/></td>
                            <td>{{$product->title}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$user->getAuthor($product->id)->username}}</td>
                            <td>{{$category->getCategory($product->category_id)->name}}</td>
                            <td>
                                @if($currentUser->can('edit-product') || $currentUser->hasAnyRole(['super admin','admin']))
                                    <button class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></button>
                                @endif
                                    @if($currentUser->can('delete-product') || $currentUser->hasAnyRole(['super admin']))
                                    <button class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th width="8%">Date Created</th>
                    <th width="8%">Price</th>
                    <th width="8%">Thumbnail</th>
                    <th width="8%">Name</th>
                    <th width="30%">Description</th>
                    <th width="12%">Author</th>
                    <th width="12%">Category</th>
                    <th width="15%">Action</th>
                </tr>
                </tfoot>
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
            $('#product-list').DataTable()
            $('.role-assign').select2()
        })
    </script>
@endsection