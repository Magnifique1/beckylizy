@extends('mainlayout')

@section('content')
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/flour.png">
                            <h5><a href="#">UNGA</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/sugar.png">
                            <h5><a href="#">SUGAR</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/rice.png">
                            <h5><a href="#">RICE</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/sweets.png">
                            <h5><a href="#">SWEETS</a></h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="img/categories/colgate.png">
                            <h5><a href="#">TOILETRIES</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Categories</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach($categories_featured as $cg)
                                <li data-filter=".{{\Illuminate\Support\Str::slug($cg->name)}}">{{$cg->name}}</li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <br>
                @foreach($products as $pd)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix {{\Illuminate\Support\Str::slug($pd->cname)}}">
                        <div class="product__discount__item">
                            <div class="product__discount__item__pic set-bg" data-setbg="{{ config('app.url') . '/uploads/img/' . $pd->image }}">
                                @if($pd->qty_available == 0)
                                    <div class="sidebar__item__size">
                                        <label for="tiny">
                                            Out of Stock
                                            <input type="radio" id="tiny">
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="product__discount__item__text">
                                <span>{{$pd->cname}}</span>
                                <h5><a href="#">{{$pd->name}}</a></h5>
                                <h5>KES {{number_format($pd->price_inc_tax)}}</h5>
                            </div>
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" value="1">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success add-to-cart-btn" @if($pd->qty_available == 0) disabled @endif>ADD TO CART</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
