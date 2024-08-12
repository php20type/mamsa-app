@extends('layouts.app')

@section('content')

  
  <section class="banner-section">
      <div class="container-fluid">
          <div class="row align-items-center">
              <div class="col-lg-7">
                   <div class="banner-caption">
                       <h2>{{ __('home.Welcom to Mamsa')}} </h2>
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab praesentium qui ipsa inventore enim, perspiciatis deserunt maiores tenetur adipisci sit officia assumenda velit atque quidem quae in odit! Cumque, atque!</p>
                       <a href="{{ route('register') }}" class="btn btn-theme px-5">{{ __('home.Register Here')}}</a>
                   </div>
              </div>
          </div>
      </div>
  </section>

  <!-- main screen end -->
@endsection
