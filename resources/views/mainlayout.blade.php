<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Becky Lizy | Online Store</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
</head>

<body>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="{{asset('img/logo.png')}}" alt=""></a>
    </div>

    <div class="humberger__menu__widget">
        <div class="header__top__right__auth">
            <a href="{{ route('register') }}"><i class="fa fa-user"></i> Register</a>
        </div>
    </div>

    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="/">Home</a></li>
            <li><a href="#">Categories</a>
                <ul class="header__menu__dropdown">
                    @foreach($categories as $cg)
                        <li><a href="/products/{{$cg->id}}">{{$cg->name}} (<span>{{$cg->pcount}}</span>)</a></li>
                    @endforeach
                </ul>
            </li>
{{--            <li><a href="#">About Us</a></li>--}}
            <li><a href="{{route('contactus')}}">Contact Us</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> info@beckylizy.com</li>
            <li>Service & Delivery That Goes Above & Beyond</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->


<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> info@beckylizy.com</li>
                            <li>Free Delivery for all Orders above KES 3000</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">

                        @if(Auth::guest())
                            <div class="header__top__right__auth" style="margin-right: 10px">
                                <a href="{{ route('register') }}"><i class="fa fa-user"></i> Register</a>
                            </div>

                            <div class="header__top__right__auth">
                                <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
                            </div>
                        @else
                            <div class="header__top__right__auth" style="margin-right: 10px">
                                <a href="#"><i class="fa fa-user"></i> Welcome - {{Auth::user()->name}}</a>
                            </div>

                            <div class="header__top__right__auth" style="margin-right: 10px">
                                <a href="{{route('order_history')}}"><i class="fa fa-shopping-cart"></i> My Orders </a>
                            </div>

                            <div class="header__top__right__auth">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="#"><img src="{{asset('img/logo.png')}}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="{{\Illuminate\Support\Facades\Route::currentRouteName() == 'home' ? 'active':null}}">
                            <a href="/">Home</a></li>
{{--                        <li><a href="#">About Us</a></li>--}}
                        <li><a href="{{route('contactus')}}">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li>
                            <a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
                                <span>{{ count(Cart::content()) }}</span>
                            </a>
                        </li>
                    </ul>
                    <div class="header__cart__price">Subtotal: <span>KES {{ Cart::subtotal() }}</span></div>
                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Categories</span>
                    </div>
                    <ul>
                        @foreach($categories as $cg)
                            <li><a href="/products/{{$cg->id}}">{{$cg->name}} (<span>{{$cg->pcount}}</span>)</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+254-741-118-613</h5>
                            <span>Place Your Order Today!</span>
                        </div>
                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'home')
                <div class="hero__item set-bg" data-setbg="{{asset('img/hero/banner.png')}}">
                    <div class="hero__text">
                        <span>AJAB UNGA</span>
                        <h2>Home Baking <br />100% Fresh</h2>
                        <p>Free Delivery Available</p>
                        <a href="/products/6" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->
@yield('content')
<!-- Banner End -->
<br>
<br>
<br>
<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="#"><img src="{{asset('img/logo.png')}}" alt=""></a>
                    </div>
                    <ul>
                        <li>Address: Nairobi - Kenya</li>
                        <li>Phone: +254-741-118-613</li>
                        <li>Email: info@beckylizy.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text"><p>Copyright &copy; {{ now()->year }} All rights reserved | Becky Lizy Online Store</p></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Js Plugins -->
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
{{--<script src="{{asset('js/jquery.nice-select.min.js')}}"></script>--}}
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/jquery.slicknav.js')}}"></script>
<script src="{{asset('js/mixitup.min.js')}}"></script>
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#orderHistory').DataTable({
            "responsive":true
        });
    } );
</script>

<script>
    $(document).ready( function () {
        $('#orderHistoryProducts').DataTable({
            "responsive":true
        });
    } );
</script>

<script>
    $(document).ready( function () {
        $('#orderPayments').DataTable({
            "searching": false,
            "lengthChange": false,
            "responsive":true
        });
    } );
</script>

</body>
</html>
