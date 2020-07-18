@extends('mainlayout')

@section('content')

    <section class="breadcrumb-section set-bg" data-setbg="{{asset('img/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        @foreach($selected_cat as $sc)
                        <h2>{{$sc->name}}</h2>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row featured__filter">
                @foreach($products as $pd)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
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
                            <button type="button" class="btn btn-success" @if($pd->qty_available == 0) disabled @endif>ADD TO CART</button>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </section>

@endsection
