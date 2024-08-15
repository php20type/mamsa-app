@extends('layouts.patient')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">
<style>
  /*       
        canvas {
            width: 100% !important;
            height: 140px !important;
        } */
</style>
@endsection
@section('content')

<section class="medi-area" style="padding: 0px;">
  <div class="container-fluid ps-lg-0 px-3">
    <div class="row">
      <div class="col-md-2 px-lg-0" style="background: #6f4d3f;">
        <div class="medi-area-left">
          <div class="box-out mb-5">
            <h3 class="heading-sm mb-4">Action Button</h3>
            <div class="box">
              <button class="btn btn-light d-block w-100 mb-3">Alerts</button>
              <button class="btn btn-light d-block w-100 mb-3" onclick="sendGroupMessage()">Send Group Message</button>
              <button class="btn btn-light d-block w-100 mb-3">TBD</button>
              <button class="btn btn-light d-block w-100">TBD</button>
            </div>
          </div>
          <div class="box-out mb-5">
            <h3 class="heading-sm mb-4">{{__('patient.Patients')}}</h3>
            <div class="box">
              <form>
                <div class="cust-search-input d-flex align-items-center">
                  <div class="input-icon">
                    <a href="#"><i class="fa-light fa-magnifying-glass"></i></a>
                  </div>
                  <input type="text" class="form-control border-0" onkeyup="getPatientList()" id="search" placeholder="Search">
                </div>
              </form>
              <div class="list-block" id="filterPatients">
              
              </div>
            </div>
          </div>
          <div class="box-out mb-5">
            <h3 class="heading-sm mb-4">{{ __('dashboard.Dashboard Filter')}}</h3>
            <div class="box">
              <h4>{{ __('dashboard.Filter by')}}:</h4>
              <div class="list-input  mb-4">
                <ul class="mb-0">
                  <li><a href="#">{{ __('dashboard.Diagnosis')}}</a></li>
                </ul>

                <div class="chk-block">
                  @foreach($topSymptoms as $symptom)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="Diabetes">
                    <label class="form-check-label" for="Diabetes">
                      {{$symptom->title}} <span class="count">({{$symptom->patient_count}})</span>
                    </label>
                  </div>
                  @endforeach
                </div>
              </div>
              <div class="list-input">
                <ul class="mb-0">
                  <li><a href="#">{{__('dashboard.Age Group')}}</a></li>
                </ul>

                <div class="chk-block">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="age64">
                    <label class="form-check-label" for="age64">
                      < 64 </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="age75">
                    <label class="form-check-label" for="age75">
                      65 - 75
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="age85">
                    <label class="form-check-label" for="age85">
                      75 - 85
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        @if(session()->has('success'))
        <div class="alert alert-success mt-4">
          <span>{{session()->get('success')}}</span>
        </div>
        @endif
        <div class="cust-card-area">
          <div class="row">
            <div class="col">
              <div class="card border-0">
                <div class="card-counter">3</div>
                <div class="card-body d-flex align-items-center">
                  <img src="{{ asset('assets/img/home/card-icon1.png')}}" alt="Icon1" class="img-fluid" />
                  <h5 class="card-title text-white ms-4">Alerts</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card border-0">
                <div class="card-counter">4</div>
                <div class="card-body d-flex align-items-center">
                  <img src="{{ asset('assets/img/home/card-icon2.png')}}" alt="Icon1" class="img-fluid" />
                  <h5 class="card-title text-white ms-4">Overall Decline</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card border-0">
                <div class="card-counter">3</div>
                <div class="card-body d-flex align-items-center">
                  <img src="{{ asset('assets/img/home/card-icon3.png')}}" alt="Icon1" class="img-fluid" />
                  <h5 class="card-title text-white ms-4">Monitored Cond. Decline</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card border-0">
                <div class="card-counter" style="background: #fca524;">0</div>
                <div class="card-body d-flex align-items-center">
                  <img src="{{ asset('assets/img/home/card-icon4.png')}}" alt="Icon1" class="img-fluid" />
                  <h5 class="card-title text-white ms-4">Prescription Alerts</h5>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card border-0">
                <div class="card-counter">3</div>
                <div class="card-body d-flex align-items-center">
                  <img src="{{ asset('assets/img/home/card-icon5.png')}}" alt="Icon1" class="img-fluid" />
                  <h5 class="card-title text-white ms-4">Message</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="medi-area-right">

          <div class="box-out mb-5">
            <h3 class="heading-sm mb-4">Medical Alerts</h3>
            <div class="cust-table">
              <table class="table ">
                <thead>
                  <tr>
                    <th scope="col" width="15%" align="center" class="text-center">Checked</th>
                    <th scope="col" width="35%">Alert</th>
                    <th scope="col" width="30%">Patient</th>
                    <th scope="col" width="20%">Time Since</th>
                  </tr>
                </thead>
              </table>
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td width="15%" align="center"><input class="form-check-input" type="checkbox" value="" id="fst"></td>
                    <td width="35%">Longterm Aiquihea </td>
                    <td width="30%">M. Fillovm / 1952</td>
                    <td width="20%">19 h</td>
                  </tr>
                  <tr>
                    <td align="center"><input class="form-check-input" type="checkbox" value="" id="fst"></td>
                    <td>Stool Blood </td>
                    <td>F. Groge / 1947</td>
                    <td>4 h</td>
                  </tr>
                  <tr>
                    <td align="center"><input class="form-check-input" type="checkbox" value="" id="fst"></td>
                    <td>Ulcer Clamps </td>
                    <td>B. Beyoke / 1937</td>
                    <td>5 h</td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
          <div class="box-out mb-5">
            <div class="d-sm-flex justify-content-between mb-4">
              <h3 class="heading-sm">{{__('dashboard.Overall Health Decline')}}</h3>
              <a href="#" class="text-black-50">{{__('dashboard.View More')}} <i class="fa-regular fa-chevron-right"></i></a>
            </div>
            <div class="cust-table">
              <table class="table ">
                <thead>
                  <tr>
                    <th scope="col" width="30%">{{__('dashboard.Patient')}}</th>
                    <th scope="col" width="25%">{{__('dashboard.Monitor')}}</th>
                    <th scope="col" width="25%" align="center" class="text-center">{{__('dashboard.Value')}}</th>
                    <th scope="col" width="20%">{{__('dashboard.Duration')}}</th>
                  </tr>
                </thead>
              </table>
              <table class="table table-bordered">
                <tbody>
                  @foreach($paientslist as $patient)
                  @if($patient->patientHistory!=null)
                  <tr>
                    <td width="30%">{{strtoupper(substr($patient->first_name, 0, 1))}}. {{ ucfirst($patient->last_name)}}</td>
                    <td width="25%"><canvas id="myChart{{$patient->id}}" class="overallChart" data-report="{{$patient->patientHistory->over_rep_combined}}" data-labels="{{$patient->patientHistory->rep_dates}}"></canvas>
                    </td>
                    <td width="25%" align="center" class="text-center">{{$patient->patientHistory->total_value}}</td>
                    <td width="20%">{{$patient->patientHistory->total_days}} {{__('dashboard.days')}}</td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-out mb-5">
            <div class="d-sm-flex justify-content-between mb-4">
              <h3 class="heading-sm">Monitored Condition Decline</h3>
              <a href="#" class="text-black-50">View More <i class="fa-regular fa-chevron-right"></i></a>
            </div>
            <div class="cust-table">
              <table class="table ">
                <thead>
                  <tr>
                    <th scope="col" width="25%">Patient</th>
                    <th scope="col" width="25%">Monitor</th>
                    <th scope="col" width="20%" align="center" class="text-center">Conditions</th>
                    <th scope="col" width="15%">Value</th>
                    <th scope="col" width="15%">Duration</th>
                  </tr>
                </thead>
              </table>
              <table class="table table-bordered">
                <tbody>
                  @foreach($paientsMonitoredCondition as $patient)
                    @foreach($patient->patientMonitors as $monitor)
                       @foreach($patient->patientHistoryList as $history)
                        @if($history->monitor_id==$monitor->id)
                            <tr>
                                <td width="25%">{{ strtoupper(substr($patient->first_name, 0, 1)) }}. {{ ucfirst($patient->last_name) }} / {{ \Carbon\Carbon::parse($patient->DOB)->year }}</td>
                                <td width="25%">
                                    <canvas id="myChart{{$patient->id}}_{{$monitor->id}}" class="overallChart" data-report="{{ $history->over_rep_combined }}" data-labels="{{ $history->rep_dates }}"></canvas>
                                </td>
                                <td width="20%">
                                    {{ $monitor->symptom->title ?? 'N/A' }}
                                </td>
                                <td width="15%" align="center" class="text-center">
                                    {{ $history->total_value }}
                                </td>
                                <td width="20%">
                                    {{ $history->total_days }} {{ __('dashboard.days') }}
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-out mb-5">
            <div class="d-sm-flex justify-content-between mb-4">
              <h3 class="heading-sm">{{__('dashboard.Messages')}}</h3>
              <!-- <a href="#" class="text-black-50">View More <i class="fa-regular fa-chevron-right"></i></a> -->
            </div>
            <div class="cust-table">
              <table class="table ">
                <thead>
                  <tr>
                    <th scope="col" width="30%">{{__('dashboard.Patient')}}</th>
                    <th scope="col" width="50%">{{__('dashboard.Message')}}</th>
                    <th scope="col" width="20%" class="text-center">{{__('dashboard.Action')}}</th>
                  </tr>
                </thead>
              </table>
              <table class="table table-bordered">
                <tbody>
                  @foreach($messages as $message)
                  <tr>
                    <td>{{strtoupper(substr($message->patientDetails->first_name, 0, 1))}}. {{ ucfirst($message->patientDetails->last_name)}}</td>
                    <td>{{ $message->message}}</td>
                    <td><a href="#" class="btn btn-theme w-100" onclick="replyMessage('{{$message->id}}')">{{__('dashboard.Reply')}}</a> </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal EditPatients" tabindex="-1" role="dialog" id="messageModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('sendGroupMessage')}}" method="post" class="modal-form">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="form_title">{{__('dashboard.Send Message')}}</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="fw-bold mb-4">{{__('dashboard.Message Type')}}</h4>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" value="1" name="message_type" id="additional">
            <label class="form-check-label" for="flexCheckDefault">
            {{__('dashboard.Additional Question')}}
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" value="2" name="message_type" id="lab_test">
            <label class="form-check-label" for="flexCheckDefault">
            {{__('dashboard.Lab test result')}}
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" value="3" name="message_type" id="appointment">
            <label class="form-check-label" for="flexCheckDefault">
            {{__('dashboard.Request Appointment')}}
            </label>
          </div>
          <div class="form-group mb-4">
            <label class="form-label">{{__('dashboard.Patients')}}:</label>
            <div class="input-inline">
              <select class="selectpicker  form-control" name="patient[]" id="patient" multiple aria-label="Default select example" data-live-search="true" required>
                @foreach($patients as $patient)
                <option value="{{ $patient->id}}">{{$patient->first_name}} {{$patient->last_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group mb-4">
            <textarea name="message" id="message" placeholder="Type your message here" class="form-control" rows="6"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="form_btn">{{__('dashboard.Send')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal EditPatients" tabindex="-1" role="dialog" id="messageReplyModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('replyMessage')}}" method="post" class="modal-form">
        @csrf
        <input type="hidden" name="message_id" id="message_id">
        <div class="modal-header">
          <h5 class="modal-title" id="form_title">{{__('dashboard.Send Reply')}}</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
          <div class="form-group mb-4">
            <textarea name="message" id="message" placeholder="Type your message here" class="form-control" rows="6"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="form_btn">{{__('dashboard.Send')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
<footer class="footer">
  <div class="container-fluid">
    <div class="row border-bottom-1">
      <div class="col-lg-6">
        <div class="logo-sec">
          <a href="#"><img src="{{ asset('assets/img/logo/light-logo.svg')}}" alt="" /></a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="social-link text-md-end">
          <a href="#"><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="23" cy="23" r="23" fill="white" />
              <path d="M29 11.5619C29 11.4146 28.9377 11.2734 28.8269 11.1692C28.7161 11.0651 28.5658 11.0066 28.4091 11.0066H25.4545C23.9668 10.9369 22.5102 11.4235 21.4029 12.3601C20.2957 13.2967 19.6279 14.607 19.5455 16.0049V19.0039H16.5909C16.4342 19.0039 16.2839 19.0625 16.1731 19.1666C16.0623 19.2708 16 19.412 16 19.5593V22.4473C16 22.5945 16.0623 22.7358 16.1731 22.84C16.2839 22.9441 16.4342 23.0026 16.5909 23.0026H19.5455V34.4446C19.5455 34.5919 19.6077 34.7332 19.7185 34.8373C19.8293 34.9415 19.9796 35 20.1364 35H23.6818C23.8385 35 23.9888 34.9415 24.0997 34.8373C24.2105 34.7332 24.2727 34.5919 24.2727 34.4446V23.0026H27.3691C27.5005 23.0044 27.6288 22.965 27.7337 22.8905C27.8385 22.8161 27.914 22.7109 27.9482 22.5917L28.7991 19.7037C28.8226 19.6217 28.8258 19.5356 28.8083 19.4522C28.7909 19.3688 28.7533 19.2903 28.6985 19.2227C28.6437 19.1551 28.5732 19.1003 28.4922 19.0623C28.4113 19.0244 28.3222 19.0044 28.2318 19.0039H24.2727V16.0049C24.3021 15.73 24.4395 15.4752 24.658 15.2904C24.8766 15.1055 25.1605 15.0039 25.4545 15.0053H28.4091C28.5658 15.0053 28.7161 14.9467 28.8269 14.8426C28.9377 14.7384 29 14.5972 29 14.4499V11.5619Z" fill="#6371E8" />
            </svg>
          </a>
          <a href="#"><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="23" cy="23" r="23" fill="white" />
              <path fill-rule="evenodd" clip-rule="evenodd" d="M29.3017 17.5714C28.9193 17.0211 27.8966 16.2476 26.2402 16.5812C25.2738 16.7751 24.6964 17.2529 24.3292 17.8834C23.9381 18.5551 23.7485 19.4683 23.7485 20.5311C23.7485 20.8184 23.6344 21.0939 23.4312 21.2971C23.228 21.5003 22.9525 21.6144 22.6652 21.6144C20.102 21.6144 17.6623 20.8528 15.6094 18.7934C15.4544 19.629 15.3934 20.4793 15.4274 21.3284C15.4848 22.5049 15.7654 23.6846 16.4317 24.6954C17.0871 25.6888 18.165 26.5988 19.9677 27.1708C20.1443 27.2268 20.3036 27.3273 20.4304 27.4624C20.5571 27.5976 20.6471 27.7631 20.6917 27.9429C20.7362 28.1228 20.7339 28.3111 20.6849 28.4898C20.6359 28.6686 20.5419 28.8317 20.4118 28.9637C19.8344 29.556 19.18 30.0679 18.4662 30.4858C19.6145 30.605 20.7217 30.6136 21.7487 30.5205C23.8287 30.332 25.4851 29.7372 26.5208 28.8955C28.7015 27.1275 29.8683 24.4906 29.6516 20.0728C29.6148 19.347 30.3157 18.5637 30.6537 17.969C30.1434 18.0643 29.6321 18.047 29.3017 17.5714ZM14.9768 15.3993C15.1729 15.3765 15.3715 15.4078 15.5512 15.4897C15.7309 15.5716 15.8847 15.701 15.9962 15.8641C17.5952 18.203 19.5148 19.1758 21.6458 19.3968C21.7498 18.4857 21.9957 17.5855 22.4583 16.7925C23.1364 15.629 24.2393 14.7731 25.8144 14.4568C27.9919 14.0191 29.6494 14.8078 30.6103 15.7731L32.5517 15.4101C32.7548 15.3721 32.9646 15.3929 33.1563 15.4702C33.348 15.5475 33.5136 15.678 33.6335 15.8463C33.7534 16.0147 33.8227 16.2138 33.8331 16.4202C33.8436 16.6266 33.7948 16.8317 33.6924 17.0113L31.8291 20.2851C31.9992 25.0096 30.6862 28.3072 27.8868 30.579C26.4027 31.7836 24.2772 32.4672 21.9448 32.6785C19.5939 32.8908 16.9365 32.6341 14.2953 31.8627C14.0697 31.7969 13.8715 31.6595 13.7308 31.4711C13.5901 31.2828 13.5145 31.0539 13.5154 30.8188C13.5162 30.5837 13.5935 30.3553 13.7356 30.168C13.8777 29.9807 14.0768 29.8447 14.3029 29.7806C15.6311 29.4025 16.6429 29.0764 17.5562 28.5055C16.2573 27.8165 15.3007 26.9151 14.6236 25.8881C13.6833 24.4603 13.3344 22.8678 13.2651 21.4324C13.1958 19.997 13.4027 18.6666 13.6215 17.7079C13.7461 17.1608 13.8913 16.6126 14.0917 16.0883C14.1624 15.9035 14.2823 15.7415 14.4386 15.6201C14.5948 15.4986 14.7802 15.4223 14.9768 15.3993Z" fill="#6371E8" />
            </svg>
          </a>
          <a href="#">
            <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="23" cy="23" r="23" fill="white" />
              <path d="M18.8 13H27.2C30.4 13 33 15.6 33 18.8V27.2C33 28.7383 32.3889 30.2135 31.3012 31.3012C30.2135 32.3889 28.7383 33 27.2 33H18.8C15.6 33 13 30.4 13 27.2V18.8C13 17.2617 13.6111 15.7865 14.6988 14.6988C15.7865 13.6111 17.2617 13 18.8 13ZM18.6 15C17.6452 15 16.7295 15.3793 16.0544 16.0544C15.3793 16.7295 15 17.6452 15 18.6V27.4C15 29.39 16.61 31 18.6 31H27.4C28.3548 31 29.2705 30.6207 29.9456 29.9456C30.6207 29.2705 31 28.3548 31 27.4V18.6C31 16.61 29.39 15 27.4 15H18.6ZM28.25 16.5C28.5815 16.5 28.8995 16.6317 29.1339 16.8661C29.3683 17.1005 29.5 17.4185 29.5 17.75C29.5 18.0815 29.3683 18.3995 29.1339 18.6339C28.8995 18.8683 28.5815 19 28.25 19C27.9185 19 27.6005 18.8683 27.3661 18.6339C27.1317 18.3995 27 18.0815 27 17.75C27 17.4185 27.1317 17.1005 27.3661 16.8661C27.6005 16.6317 27.9185 16.5 28.25 16.5ZM23 18C24.3261 18 25.5979 18.5268 26.5355 19.4645C27.4732 20.4021 28 21.6739 28 23C28 24.3261 27.4732 25.5979 26.5355 26.5355C25.5979 27.4732 24.3261 28 23 28C21.6739 28 20.4021 27.4732 19.4645 26.5355C18.5268 25.5979 18 24.3261 18 23C18 21.6739 18.5268 20.4021 19.4645 19.4645C20.4021 18.5268 21.6739 18 23 18ZM23 20C22.2044 20 21.4413 20.3161 20.8787 20.8787C20.3161 21.4413 20 22.2044 20 23C20 23.7956 20.3161 24.5587 20.8787 25.1213C21.4413 25.6839 22.2044 26 23 26C23.7956 26 24.5587 25.6839 25.1213 25.1213C25.6839 24.5587 26 23.7956 26 23C26 22.2044 25.6839 21.4413 25.1213 20.8787C24.5587 20.3161 23.7956 20 23 20Z" fill="#6371E8" />
            </svg>

          </a>
          <a href="#">
            <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="23" cy="23" r="23" fill="white" />
              <path d="M22.9998 14.3333C23.9261 14.3333 24.8762 14.3571 25.797 14.3961L26.8847 14.4481L27.9258 14.5099L28.9008 14.576L29.7913 14.6453C30.7576 14.7193 31.667 15.1317 32.3593 15.8099C33.0517 16.4882 33.4826 17.3889 33.5764 18.3536L33.6198 18.814L33.701 19.7998C33.7768 20.8214 33.8332 21.9351 33.8332 23C33.8332 24.0649 33.7768 25.1786 33.701 26.2001L33.6198 27.186C33.6057 27.3441 33.5916 27.4969 33.5764 27.6464C33.4826 28.6112 33.0515 29.5121 32.3589 30.1903C31.6664 30.8686 30.7567 31.2809 29.7902 31.3546L28.9018 31.4229L27.9268 31.4901L26.8847 31.5518L25.797 31.6038C24.8652 31.6443 23.9326 31.6653 22.9998 31.6666C22.0671 31.6653 21.1345 31.6443 20.2027 31.6038L19.115 31.5518L18.0739 31.4901L17.0989 31.4229L16.2084 31.3546C15.242 31.2807 14.3327 30.8683 13.6403 30.19C12.948 29.5118 12.517 28.6111 12.4233 27.6464L12.3799 27.186L12.2987 26.2001C12.2158 25.1354 12.1718 24.068 12.1665 23C12.1665 21.9351 12.2228 20.8214 12.2987 19.7998L12.3799 18.814C12.394 18.6558 12.4081 18.5031 12.4233 18.3536C12.517 17.3891 12.9478 16.4885 13.6399 15.8103C14.3321 15.132 15.2411 14.7195 16.2073 14.6453L17.0968 14.576L18.0718 14.5099L19.1139 14.4481L20.2016 14.3961C21.1338 14.3557 22.0668 14.3347 22.9998 14.3333ZM22.9998 16.5C22.1061 16.5 21.1863 16.5238 20.2915 16.5606L19.232 16.6116L18.2148 16.6711L17.2593 16.7361L16.3839 16.8044C15.9239 16.837 15.4902 17.0315 15.1599 17.3533C14.8295 17.6752 14.6237 18.1036 14.5791 18.5626C14.4523 19.8724 14.3332 21.5028 14.3332 23C14.3332 24.4971 14.4523 26.1276 14.5791 27.4373C14.6712 28.382 15.4208 29.1165 16.3839 29.1956L17.2593 29.2627L18.2148 29.3277L19.232 29.3884L20.2915 29.4393C21.1863 29.4761 22.1061 29.5 22.9998 29.5C23.8936 29.5 24.8133 29.4761 25.7082 29.4393L26.7677 29.3884L27.7849 29.3288L28.7404 29.2638L29.6158 29.1956C30.0758 29.1629 30.5095 28.9684 30.8398 28.6466C31.1702 28.3248 31.3759 27.8964 31.4206 27.4373C31.5473 26.1276 31.6665 24.4971 31.6665 23C31.6665 21.5028 31.5473 19.8724 31.4206 18.5626C31.3759 18.1036 31.1702 17.6752 30.8398 17.3533C30.5095 17.0315 30.0758 16.837 29.6158 16.8044L28.7404 16.7372L27.7849 16.6722L26.7677 16.6116L25.7082 16.5606C24.8059 16.5218 23.9029 16.5016 22.9998 16.5ZM20.8332 20.3729C20.8331 20.267 20.8589 20.1627 20.9083 20.0691C20.9577 19.9754 21.0293 19.8953 21.1167 19.8356C21.2042 19.7759 21.3049 19.7385 21.4101 19.7266C21.5153 19.7147 21.6218 19.7287 21.7204 19.7673L21.8082 19.8106L26.3582 22.4366C26.4488 22.4889 26.5254 22.5623 26.5816 22.6505C26.6378 22.7388 26.6718 22.8393 26.6809 22.9435C26.6899 23.0477 26.6737 23.1526 26.6335 23.2491C26.5934 23.3457 26.5305 23.4312 26.4503 23.4983L26.3582 23.5633L21.8082 26.1904C21.7165 26.2435 21.6132 26.2734 21.5073 26.2774C21.4014 26.2815 21.2962 26.2596 21.2007 26.2137C21.1052 26.1677 21.0224 26.0992 20.9595 26.0139C20.8966 25.9287 20.8554 25.8293 20.8397 25.7246L20.8332 25.6271V20.3729Z" fill="#6371E8" />
            </svg>

          </a>
          <a href="#">
            <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="23" cy="23" r="23" fill="white" />
              <path d="M27.9835 16.305C27.243 15.4596 26.8349 14.3739 26.8352 13.25H23.4877V26.6833C23.4619 27.4103 23.1549 28.0988 22.6316 28.604C22.1082 29.1092 21.4092 29.3916 20.6818 29.3917C19.1435 29.3917 17.8652 28.135 17.8652 26.575C17.8652 24.7117 19.6635 23.3142 21.516 23.8883V20.465C17.7785 19.9667 14.5068 22.87 14.5068 26.575C14.5068 30.1825 17.4968 32.75 20.671 32.75C24.0727 32.75 26.8352 29.9875 26.8352 26.575V19.7608C28.1926 20.7357 29.8223 21.2587 31.4935 21.2558V17.9083C31.4935 17.9083 29.4568 18.0058 27.9835 16.305Z" fill="#6371E8" />
            </svg>

          </a>
        </div>
      </div>
    </div>
    <div class="copyright text-center">
      <p class="text-white ">Copyright © 2024 loremipsum. All Rights Reserved</p>
    </div>
  </div>
</footer>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

<script defer>
  // Chart 1

  const colors = {
    purple: {
      default: "#fc9700",
      half: "rgba(255, 0, 42, 0.5)",
      quarter: "rgba(255, 0, 42, 0.25)",
      zero: "rgba(255, 0, 42, 0)"
    },
    indigo: {
      default: "rgba(80, 102, 120, 1)",
      quarter: "rgba(80, 102, 120, 0.25)"
    }
  };
  function replyMessage(message_id){
    $('#message_id').val(message_id);
    $('#messageReplyModal').modal('show');
  }
  function createChart(ctx,labels, weight,gradient) {
    return new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [{
          fill: true,
          backgroundColor: gradient,
          pointBackgroundColor: colors.purple.default,
          borderColor: colors.purple.default,
          data: weight,
          lineTension: 0.2,
          borderWidth: 2,
          pointRadius: 3
        }]
      },
      options: {
        layout: {
          padding: 5
        },
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: false
            },
            ticks: {
              padding: 5,
              autoSkip: false
            }
          }],
          yAxes: [{
            scaleLabel: {
              display: true,
              padding: 5
            },
            gridLines: {
              display: false,
              color: colors.indigo.quarter
            },
            ticks: {
              beginAtZero: false,
              max: 1,
              min: -1,
              padding: 5,
              display: true
            }
          }]
        }
      }
    });
  }
  function getPatientList(){
    var searchtext=$('#search').val()
    $.ajax({
        url : "{{ route('doctor.getPatientList') }}",
        data : {'search' : searchtext},
        type : 'GET',
        success : function(result){
          $('#filterPatients').html(result);
        }
    });
  }
  $(document).ready(function(){
    getPatientList();
  });
  window.onload = function() {
    const charts = document.querySelectorAll('.overallChart');
    
    charts.forEach(function(chart) {
        const ctx = chart.getContext('2d');
        const labels = chart.getAttribute('data-labels').split(',');
        const data = chart.getAttribute('data-report').split(',').map(Number); // Convert the data-report values to numbers
        console.log('labels',labels);
        const gradient = ctx.createLinearGradient(0, 25, 0, 300);
        gradient.addColorStop(0, "rgba(252, 151, 0, 0.1)");
        gradient.addColorStop(0.35, "rgba(252, 151, 0, 0.25)");
        gradient.addColorStop(1, "rgba(252, 151, 0, 0)");

        createChart(ctx, labels, data, gradient);
    });

    Chart.defaults.global.defaultFontColor = colors.indigo.default;
};


  function sendGroupMessage() {
    $('#messageModal').modal('show');
  }
</script>
@endsection