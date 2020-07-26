@extends('mainlayout')

@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Register</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ route('home') }}">Home</a>
                            <span>Register</span>
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

            <form action="{{ route('auth.register') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your name" required
                               value="{{ old('name') }}">
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" placeholder="07xxxxxxxx" required
                               value="{{ old('phone_number') }}">
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Your Password" required>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               placeholder="Confirm Password" required>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <label for="region">Region</label>
                        <select name="region" id="region" class="form-control" required>
                            <option disabled selected>-- Select Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->name }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 text-center mt-3">
                        <button type="submit" class="site-btn">Create Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
