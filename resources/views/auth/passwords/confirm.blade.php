@extends('layouts.auth')

@section('content')
<section class="login-section">
    <div class="row mx-0">
        <div class="col-lg-5 px-0">
            <div class="login-form">
                <div class="sub-title">
                    <h4>{{ __('Confirm Password') }}</h4>
                </div>
                {{ __('Please confirm your password before continuing.') }}
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-theme rounded-pill w-100">{{ __('Confirm Password') }}</button>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="col-lg-7 px-0">
            <div class="login-image position-relative">
                <img src="{{ asset('assets/img/home/login-image.png') }}" class="img-fluid" />
                <div class="login-right-content">
                    <div class="logo">
                        <a href="#"> <img src="{{ asset('assets/img/your-logo.png') }}" alt=""> </a>
                    </div>
                    <div class="right-content-in">
                        <h2>Lorem Ipsum</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br>Etiam non leo sed erat
                            venenatis.</p>
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
