@extends('mainlayout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>My Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contents as $content)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{ config('app.url') . '/uploads/img/' . $content->image }}" alt="">
                                        <h5>{{ $content->name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        KES {{ number_format($content->price) }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty"><span class="dec qtybtn">-</span>
                                                <input type="text" value="{{ $content->qty }}">
                                                <span class="inc qtybtn">+</span></div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        KES {{ number_format($content->price * $content->qty) }}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a href="">
                                            <span class="icon_close"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="{{ route('home') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <button class="btn-success primary-btn cart-btn cart-btn-right">Update Cart</button>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>KES {{ $subtotal }}</span></li>
                            <li>Total <span>KES {{ $subtotal }}</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
