@extends('mainlayout')

@section('content')

    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.png') }}">
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
            @include('partials.alerts')
            <div class="row featured__filter">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                        <div class="product__discount__item">
                            <div class="product__discount__item__pic set-bg"
                                 data-setbg="{{ config('app.url') . '/uploads/img/' . $product->image }}">
                                @if($product->qty_available == 0)
                                    <div class="sidebar__item__size">
                                        <label for="tiny">
                                            Out of Stock
                                            <input type="radio" id="tiny">
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="product__discount__item__text">
                                <span>{{$product->cname}}</span>
                                <h5><a href="#">{{$product->name}}</a></h5>
                                <h5>KES {{number_format($product->price_inc_tax)}}</h5>
                            </div>
                            <form action="{{ route('cart.store') }}" method="post">
                                @csrf

                                <input type="hidden" name="_id" value="{{ $product->id }}">
                                <input type="hidden" name="_pname" value="{{ $product->name }}">
                                <input type="hidden" name="_pprice" value="{{ $product->price_inc_tax }}">
                                <input type="hidden" name="_pimage" value="{{ $product->image }}">
                                <div class="product__details__quantity">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" value="1" name="_pqty">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success"
                                        @if($product->qty_available == 0) disabled @endif>ADD TO CART
                                </button>
                            </form>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </section>

@endsection
