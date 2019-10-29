@extends('layouts.customer_template')

@section('title')

@endsection

@section('content')
    <!-- product category -->
    <section id="aa-product-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-product-details-area">
                        <div class="aa-product-details-content">
                            <div class="row">
                                <!-- Modal view slider -->
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="aa-product-view-slider">
                                        <div id="demo-1" class="simpleLens-gallery-container">
                                            <div class="simpleLens-container">
                                                <div class="simpleLens-big-image-container">
                                                    <img src="{{asset('/images/'.$product->productImage)}}" class="simpleLens-big-image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal view content -->
                                <div class="col-md-7 col-sm-7 col-xs-12">
                                    @if(session('success') == true)
                                        <div class="alert alert-success">Item Successfully added to cart</div>
                                        @endif
                                    <div class="aa-product-view-content">
                                        <h3>{{$product->title}}</h3>
                                        <div class="aa-price-block">
                                            <span class="aa-product-view-price">&#8369; {{$product->price}}</span>
                                            <p class="aa-product-avilability">Availability: <span>{{$product->quantity}}</span></p>
                                        </div>
                                        <h4>Size</h4>
                                        <div class="aa-prod-view-size">
                                            @foreach(explode(',',$product->size) as $size)
                                                <a>{{$size}}</a>
                                                @endforeach
                                        </div>
                                        <form action="{{route('orders.cart')}}" method="post">
                                        <div class="aa-prod-quantity">

                                                @csrf
                                                <input type="hidden" name="product" value="{{$product->id}}">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group {{$errors->has('quantity') ? 'has-error' : ''}}">
                                                        <input type="number" name="quantity" class="form-control" id="quantity" min="0" value="{{old('quantity')}}" max="{{$product->quantity}}">
                                                        @error('quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                            @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <p class="aa-prod-category">
                                                        Category: <a href="{{route('customer.single',['category' => $category->permalink])}}">{{$category->name}}</a>
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="aa-prod-view-bottom">
                                            <button type="submit" class="aa-prod-view-bottom btn btn-default">Add To Cart</button>
                                            {{--<a class="aa-add-to-cart-btn" href="#">Add To Cart</a>
                                            <a class="aa-add-to-cart-btn" href="#">Wishlist</a>
                                            <a class="aa-add-to-cart-btn" href="#">Compare</a>--}}
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="aa-product-details-bottom">
                            <ul class="nav nav-tabs" id="myTab2">
                                <li><a href="#description" data-toggle="tab">Description</a></li>
                                <li><a href="#review" data-toggle="tab">Reviews</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="description">
                                    {{$product->description}}
                                </div>
                                <div class="tab-pane fade " id="review">
                                    <div class="aa-product-review-area">
                                        <h4>2 Reviews for T-Shirt</h4>
                                        <ul class="aa-review-nav">
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March 26, 2016</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March 26, 2016</span></h4>
                                                        <div class="aa-product-rating">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star-o"></span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <h4>Add a review</h4>
                                        <div class="aa-your-rating">
                                            <p>Your Rating</p>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                            <a href="#"><span class="fa fa-star-o"></span></a>
                                        </div>
                                        <!-- review form -->
                                        <form action="" class="aa-review-form">
                                            <div class="form-group">
                                                <label for="message">Your Review</label>
                                                <textarea class="form-control" rows="3" id="message"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" placeholder="Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" placeholder="example@gmail.com">
                                            </div>

                                            <button type="submit" class="btn btn-default aa-review-submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Related product -->
                        <div class="aa-product-related-item">
                            <h3>Related Products</h3>
                            <ul class="aa-product-catg aa-related-item-slider">
                                <!-- start single product item -->
                                @foreach($allProduct as $item)
                                    <li>
                                        <figure>
                                            <a class="aa-product-img" href="{{route('product.show',['category' => \App\category::find($item->category_id)->permalink ,'id' => $item->id])}}"><img src="{{asset('/images/'.$item->productImage)}}" alt="{{$item->title}}" style="width:250px;height:300px;"></a>
                                            <a class="aa-add-card-btn"href="#"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a href="#">{{ucfirst($item->title)}}</a></h4>
                                                <span class="aa-product-price">&#8369; {{$item->price}}</span>
                                            </figcaption>
                                        </figure>
                                        <div class="aa-product-hvr-content">
                                            <button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add to Wishlist"><i class="fa fa-heart-o"></i></button>
                                            <button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="" data-original-title="Compare"><i class="fa fa-exchange"></i></button>
                                            <button class="btn btn-default quick-view" data-toggle2="tooltip" data-placement="top" title="" data-toggle="modal" data-target="#quick-view-modal" data-original-title="Quick View" id="quick-view-{{$item->id}}"><i class="fa fa-search"></i></button>
                                        </div>
                                    </li>
                                    @endforeach
                            </ul>
                            <!-- quick view modal -->
                            <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <div class="row">
                                                <!-- Modal view slider -->
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="aa-product-view-slider">
                                                        <div class="simpleLens-gallery-container" id="demo-1">
                                                            <div class="simpleLens-container">
                                                                <div class="simpleLens-big-image-container">
                                                                    <a class="simpleLens-lens-image">
                                                                        <img src="" class="simpleLens-big-image">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            {{--<div class="simpleLens-thumbnails-container">
                                                                    <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal view content -->
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="aa-product-view-content">
                                                        <h3 class="title"></h3>
                                                        <div class="aa-price-block">
                                                            <span class="aa-product-view-price"></span>
                                                            <p class="aa-product-avilability">Availability: <span class="stock">In stock</span></p>
                                                        </div>
                                                        <p class="description"></p>
                                                        <h4>Size</h4>
                                                        <div class="aa-prod-view-size">
                                                            <a href="#">S</a>
                                                            <a href="#">M</a>
                                                            <a href="#">L</a>
                                                            <a href="#">XL</a>
                                                        </div>
                                                        <div class="aa-prod-quantity">
                                                            <form action="">
                                                                <input type="number" class="form-control qty_input" value="">
                                                            </form>
                                                            <p class="aa-prod-category">
                                                                Category: <a href="#" class="category-link"></a>
                                                            </p>
                                                        </div>
                                                        <div class="aa-prod-view-bottom">
                                                            <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                            <a href="#" class="aa-add-to-cart-btn">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div>
                            <!-- / quick view modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / product category -->

@endsection

@section('extra_script')
    <script src="{{asset('/js/product.js')}}"></script>
@endsection