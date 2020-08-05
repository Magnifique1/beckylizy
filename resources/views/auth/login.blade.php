@extends('mainlayout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>LOGIN</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Login</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="contact-form spad">
        <div class="container">
            @include('partials.alerts')
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" placeholder="07xxxxxxxx" required
                               value="{{ old('phone_number') }}">
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Your Password" required>
                    </div>
                    <div class="col-lg-12 text-center mt-3">
                        <button type="submit" class="site-btn">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
