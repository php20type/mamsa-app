@extends('layouts.auth')

@section('title')
{{__('register.Sign Up')}}
@endsection

@section('content')
<section class="login-section">
    <div class="row mx-0">
        <div class="col-lg-7 px-0">
            <div class="login-image position-relative">
                <img src="{{ asset('assets/img/home/signup-image.png') }}" class="img-fluid" />
                <div class="login-right-content ps-0">
                    <div class="logo">
                        <a href="#"> <img src="{{ asset('assets/img/logo/main.svg') }}" alt=""> </a>
                    </div>
                    <div class="right-content-in">
                        <h2>Lorem Ipsum</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br>Etiam non leo sed erat
                            venenatis.</p>
                        <a href="{{ route('login') }}">{{__('register.Log in')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 px-0">
            <div class="login-form ps-0">
                <div class="sub-title">
                    <h4>{{__('register.Sign Up')}}</h4>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('register.First Name')}}</label>
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus />
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('register.Last Name')}}
                                </label>
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus />
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('register.Email Address')}}
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" />
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('register.Confirm Password')}}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" />
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
                                        <input class="form-check-input" type="checkbox" name="term_conditions" value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                        {{__('register.I agree with')}} <a href="#">{{__('register.term and conditions')}}</a>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="submit" value="" class="btn btn-theme rounded-pill w-100">{{__('register.Sign Up')}}</button>
                            </div>
                            <div class="bottom-bar">
                                <p>{{__('register.Already have an account')}}?<a href="{{ route('login') }}">{{__('register.Log in')}}</a></p>
                                <!-- <span>Or</span>
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

    </div>
</section>
@endsection