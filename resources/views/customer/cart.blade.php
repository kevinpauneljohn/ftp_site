@extends('layouts.customer_template')

@section('title')
Cart
@endsection

@section('content')
    <!-- Cart view section -->
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-view-area">
                        <div class="cart-view-table">
                            <form action="">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\Gloudemans\Shoppingcart\Facades\Cart::content() as $row)
                                            <tr>
                                                <td><a class="remove" href="#"><fa class="fa fa-close"></fa></a></td>
                                                <td><a href="{{route('product.show',[
                                                'category' => \App\category::find($row->model->category_id)->permalink,
                                                'id'       => $row->model->id
                                                ])}}"><img src="{{asset('/images/'.$row->model->productImage)}}" alt="img"></a></td>
                                                <td><a class="aa-cart-title" href="{{route('product.show',[
                                                'category' => \App\category::find($row->model->category_id)->permalink,
                                                'id'       => $row->model->id
                                                ])}}">{{$row->model->title}}</a></td>
                                                <td>&#8369; {{$row->model->price}}</td>
                                                <td><input class="aa-cart-quantity" type="number" value="{{$row->qty}}" min="0" max="{{$row->model->quantity}}"></td>
                                                <td>&#8369; {{number_format($row->qty * $row->model->price, 2)}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            <!-- Cart Total view -->
                            <div class="cart-view-total">
                                <h4>Cart Totals</h4>
                                <table class="aa-totals-table">
                                    <tbody>
                                    <tr>
                                        <th>Subtotal</th>
                                        <td>&#8369; {{\Gloudemans\Shoppingcart\Facades\Cart::subtotal()}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>&#8369; {{\Gloudemans\Shoppingcart\Facades\Cart::total()}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="aa-cart-view-btn">Proced to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
@endsection

@section('extra_script')
    <script src="{{asset('/js/product.js')}}"></script>
@endsection