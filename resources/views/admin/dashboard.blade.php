@extends('layouts.admin')

@section('content')
<section class="cust-card-area admin">
    <div class="container-fluid">
        <div class="medi-area">
            <div class="box mb-5">
                <div class="heading-section mb-4">
                    <h4 class="heading-sm mb-3">{{ __('dashboard.Database')}}</h4>
                    <p class="fw-semibold">{{ __('dashboard.Manage knowledge base')}}</p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0">
                            <a href="{{route('symptoms')}}">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ asset('assets/img/home/card-icon6.png')}}" alt="Icon1" class="img-fluid" />
                                    <h5 class="card-title text-white ms-4">{{ __('dashboard.Symptoms')}}</h5>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0">
                            <a href="{{ route('bodyparts')}}">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ asset('assets/img/home/card-icon7.png')}}" alt="Icon1" class="img-fluid" />
                                    <h5 class="card-title text-white ms-4">{{ __('dashboard.Body Parts')}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0">
                            <a href="{{ route('medications')}}">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ asset('assets/img/home/card-icon8.png')}}" alt="Icon1" class="img-fluid" />
                                    <h5 class="card-title text-white ms-4">{{ __('dashboard.Medication')}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box mb-5">
                <div class="heading-section mb-4">
                    <h4 class="heading-sm mb-3">{{ __('dashboard.User management')}}</h4>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0">
                            <a href="{{ route('medical-fecilities')}}">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ asset('assets/img/home/card-icon9.png')}}" alt="Icon1" class="img-fluid" />
                                    <h5 class="card-title text-white ms-4">{{ __('dashboard.Medical facility')}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0">
                            <div class="card-body d-flex align-items-center">
                                <img src="{{ asset('assets/img/home/card-icon10.png')}}" alt="Icon1" class="img-fluid" />
                                <h5 class="card-title text-white ms-4">{{ __('dashboard.Doctors')}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0">
                            <a href="{{ route('patients')}}">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ asset('assets/img/home/card-icon11.png')}}" alt="Icon1" class="img-fluid" />
                                    <h5 class="card-title text-white ms-4">{{ __('dashboard.Patients')}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection