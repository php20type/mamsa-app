@extends('layouts.auth')

@section('title')
{{__('register.Login')}}
@endsection

@section('content')
<section class="login-section">
    <div class="row mx-0">
        <div class="col-lg-5 px-0">
            <div class="login-form"> 
            <div class="sub-title"><h4>{{__('register.Login')}}</h4></div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-4">
                            <label class="form-label">{{__('register.Email Address')}}</label>
                            <input id="email" type="email" placeholder="" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-4">
                            <label class="form-label">{{__('register.Password')}}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group mb-4">
                            <div class="remember">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                    {{__('register.Remember me')}}
                                    </label>
                                  </div>
                                @if (Route::has('password.request'))
                                <div class="forgot-password">
                                   <a href="{{ route('password.request') }}">{{__('register.Forgot password')}}?</a>
                               </div>
                               @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-theme rounded-pill w-100">{{__('register.Login')}}</button>
                         </div>
                         <div class="bottom-bar">
                            <p>{{__('register.Not a user yet')}}? <a href="{{ route('register') }}">{{__('register.Create an Account')}}</a></p>
                          <!--   <span>Or</span>
                            <a href="#" class="google">
                                <img src="{{ asset('assets/img/google.svg') }}" alt="">
                                Sign Up with Google
                            </a> -->
                        </div>
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
                        <a href="{{ route('login') }}"> <img src="{{ asset('assets/img/logo/main.svg') }}"  alt=""> </a>
                    </div>
                    <div class="right-content-in">
                        <h2>Lorem Ipsum</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br>Etiam non leo sed erat venenatis.</p>
                        <a href="{{ route('register') }}">{{__('register.Sign Up')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
