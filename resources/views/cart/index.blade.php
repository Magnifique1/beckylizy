@extends('mainlayout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.png') }}">
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
        @if(count($contents))
            <div class="container">
                @include('partials.alerts')

                <form action="{{ route('cart.update') }}" method="post">
                    @method('put')
                    @csrf
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
                                        <input type="hidden" name="rowIds[]" value="{{ $content->rowId }}">
                                        <tr>
                                            <td class="shoping__cart__item">
                                                <img src="{{ config('app.url') . '/uploads/img/' . $content->image }}"
                                                     alt="">
                                                <h5>{{ $content->name }}</h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                KES {{ number_format($content->price) }}
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" value="{{ $content->qty }}"
                                                               name="quantities[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                KES {{ number_format($content->price * $content->qty) }}
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <a href="{{ route('cart.remove',  $content->rowId) }}">
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
                                <button type="submit" class="btn-success primary-btn cart-btn cart-btn-right">Update
                                    Cart
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="shoping__checkout">
                                <h5>Cart Total</h5>
                                <ul>
                                    <li>Subtotal <span>KES {{ number_format($subtotal) }}</span></li>
                                    @if($subtotal < 3000)
                                        <li>Delivery Fees <span>KES {{ number_format($deliveryFees) }}</span></li>
                                    @endif
                                    <li>Total <span>KES {{ number_format($subtotal) }}</span></li>
                                </ul>
                                <button type="button" class="primary-btn"
                                        data-toggle="modal"
                                        data-target="#exampleModal">
                                    PROCEED TO CHECKOUT
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @auth()
                                By clicking the button below, a new order will be created and you'll be
                                directed to payment instructions.
                            @else
                                <center>
                                    <a href="{{ route('login') }}" class="primary-btn">
                                        <span class="text-center">Login to proceed</span>
                                    </a>
                                </center>
                            @endauth
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                            </button>
                            <form action="{{ route('cart.create-order') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary" @guest() disabled @endguest>
                                    Create Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="alert alert-info" role="alert">
                            Your cart is empty. Please do some shopping.
                        </div>
                        <div class="shoping__cart__btns">
                            <a href="{{ route('home') }}" class="site-btn">Start Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
