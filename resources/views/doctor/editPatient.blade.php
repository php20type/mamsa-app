@extends('layouts.patient')
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<style>
   .chart-container {
      position: relative;
      height: 400px;
      width: 100%;
   }

   #myChart,
   #myChart1,
   #myChart2 {
      width: 100%;
      height: 360px !important;
   }
</style>
@endsection
@section('content')
<section class="medi-area" style="padding: 0px;">
   <div class="container-fluid ps-lg-0 px-3">
      <div class="row">
         <div class="col-md-2 px-lg-0" style="background: #6f4d3f;">
            <div class="medi-area-left p-0">
               <div class="box-out p-0">
                  <div class="patient-profile">
                     <div class="top-bgimages">
                        <img src="{{ asset('assets/img/profile-bg.png')}}" alt="">
                     </div>
                     <div class="profile-image">
                        <img src="{{ $patient->image ? asset('storage/patient_images/' . $patient->image) : asset('assets/img/profile-bg.png') }}" alt="Profile Image">
                        <h4>{{ ucfirst($patient->first_name) }} {{ ucfirst($patient->last_name) }}</h4>
                     </div>
                     <div class="profile-info">
                        <ul class="list-inline">
                           <li>
                              <div class="svg-icon">
                                 <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.83331 8.24998C1.83331 6.52115 1.83331 5.65765 2.37048 5.12048C2.90765 4.58331 3.77115 4.58331 5.49998 4.58331H16.5C18.2288 4.58331 19.0923 4.58331 19.6295 5.12048C20.1666 5.65765 20.1666 6.52115 20.1666 8.24998C20.1666 8.68173 20.1666 8.89806 20.0328 9.03281C19.8981 9.16665 19.6808 9.16665 19.25 9.16665H2.74998C2.31823 9.16665 2.1019 9.16665 1.96715 9.03281C1.83331 8.89806 1.83331 8.68081 1.83331 8.24998ZM1.83331 16.5C1.83331 18.2288 1.83331 19.0923 2.37048 19.6295C2.90765 20.1666 3.77115 20.1666 5.49998 20.1666H16.5C18.2288 20.1666 19.0923 20.1666 19.6295 19.6295C20.1666 19.0923 20.1666 18.2288 20.1666 16.5V11.9166C20.1666 11.4849 20.1666 11.2686 20.0328 11.1338C19.8981 11 19.6808 11 19.25 11H2.74998C2.31823 11 2.1019 11 1.96715 11.1338C1.83331 11.2686 1.83331 11.4858 1.83331 11.9166V16.5Z" fill="white" />
                                    <path d="M6.41663 2.75V5.5M15.5833 2.75V5.5" stroke="white" stroke-width="2" stroke-linecap="round" />
                                 </svg>
                              </div>
                              <div class="info-sec">
                                 <h5>{{ __('medication.Date of Birth')}}</h5>
                                 <p>{{ \Carbon\Carbon::parse($patient->DOB)->format('F j, Y') }}</p>
                              </div>
                           </li>
                           <li>
                              <div class="svg-icon">
                                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 11.5C11.337 11.5 10.7011 11.2366 10.2322 10.7678C9.76339 10.2989 9.5 9.66304 9.5 9C9.5 8.33696 9.76339 7.70107 10.2322 7.23223C10.7011 6.76339 11.337 6.5 12 6.5C12.663 6.5 13.2989 6.76339 13.7678 7.23223C14.2366 7.70107 14.5 8.33696 14.5 9C14.5 9.3283 14.4353 9.65339 14.3097 9.95671C14.1841 10.26 13.9999 10.5356 13.7678 10.7678C13.5356 10.9999 13.26 11.1841 12.9567 11.3097C12.6534 11.4353 12.3283 11.5 12 11.5ZM12 2C10.1435 2 8.36301 2.7375 7.05025 4.05025C5.7375 5.36301 5 7.14348 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 7.14348 18.2625 5.36301 16.9497 4.05025C15.637 2.7375 13.8565 2 12 2Z" fill="white" />
                                 </svg>
                              </div>
                              <div class="info-sec">
                                 <h5>{{ __('medication.Address')}}</h5>
                                 <p>{{ $patient->address }}</p>
                              </div>
                           </li>
                           <li>
                              <div class="svg-icon">
                                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.556 12.906L16.101 13.359C16.101 13.359 15.018 14.435 12.063 11.497C9.108 8.55898 10.191 7.48298 10.191 7.48298L10.477 7.19698C11.184 6.49498 11.251 5.36698 10.634 4.54298L9.374 2.85998C8.61 1.83998 7.135 1.70498 6.26 2.57498L4.69 4.13498C4.257 4.56698 3.967 5.12498 4.002 5.74498C4.092 7.33198 4.81 10.745 8.814 14.727C13.061 18.949 17.046 19.117 18.675 18.965C19.191 18.917 19.639 18.655 20 18.295L21.42 16.883C22.38 15.93 22.11 14.295 20.882 13.628L18.972 12.589C18.166 12.152 17.186 12.28 16.556 12.906Z" fill="white" />
                                 </svg>
                              </div>
                              <div class="info-sec">
                                 <h5>{{ __('medication.Phone Number')}}</h5>
                                 <p>{{ $patient->phone_number }}</p>
                              </div>
                           </li>
                           <li>
                              <div class="svg-icon">
                                 <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.75 2.5C3.75 1.83696 4.01339 1.20107 4.48223 0.732233C4.95107 0.263392 5.58696 0 6.25 0L13.75 0C14.413 0 15.0489 0.263392 15.5178 0.732233C15.9866 1.20107 16.25 1.83696 16.25 2.5V17.5C16.25 18.163 15.9866 18.7989 15.5178 19.2678C15.0489 19.7366 14.413 20 13.75 20H6.25C5.58696 20 4.95107 19.7366 4.48223 19.2678C4.01339 18.7989 3.75 18.163 3.75 17.5V2.5ZM11.25 16.25C11.25 15.9185 11.1183 15.6005 10.8839 15.3661C10.6495 15.1317 10.3315 15 10 15C9.66848 15 9.35054 15.1317 9.11612 15.3661C8.8817 15.6005 8.75 15.9185 8.75 16.25C8.75 16.5815 8.8817 16.8995 9.11612 17.1339C9.35054 17.3683 9.66848 17.5 10 17.5C10.3315 17.5 10.6495 17.3683 10.8839 17.1339C11.1183 16.8995 11.25 16.5815 11.25 16.25Z" fill="white" />
                                 </svg>
                              </div>
                              <div class="info-sec">
                                 <h5>{{ __('medication.Other Number')}}</h5>
                                 <p>{{ $patient->other_number }}</p>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
               <div class="box-out pb-1">
                  <div class="patient-monitorin">
                     <a href="#" class="btn btn-outline-primary mb-2">{{ __('medication.Patient Monitoring')}}</a>
                     <a href="#" class="btn btn-outline-primary edit-profile" onclick="openEditProfileModal()">{{ __('medication.Edit Profile')}}</a>
                  </div>
               </div>
               <div class="box-out pt-2 mb-3">
                  <div class="patient-monitorin">
                     <div class="sec-title">
                        <h5>{{__('dashboard.Send Message via Mamsa')}}</h5>
                        <p>{{__('dashboard.Message Type')}}</p>
                     </div>
                     <form class="mt-4" method="post" action="{{ route('sendMessage')}}">
                        @csrf
                        <input type="hidden" name="patient_id" id="patient_id" value="{{$patient->id}}">
                        <div class="form-check mb-2">
                           <input class="form-check-input" type="radio" value="1" name="message_type" id="additional">
                           <label class="form-check-label" for="flexCheckDefault">
                              {{__('dashboard.Additional Question')}}
                           </label>
                        </div>
                        <div class="form-check mb-2">
                           <input class="form-check-input" type="radio" value="2" name="message_type" id="lab_test">
                           <label class="form-check-label" for="flexResult">
                              {{__('dashboard.Lab test result')}}
                           </label>
                        </div>
                        <div class="form-check mb-4">
                           <input class="form-check-input" type="radio" value="3" name="message_type" id="appointment">
                           <label class="form-check-label" for="flexRequest">
                              {{__('dashboard.Request Appointment')}}
                           </label>
                        </div>
                        <div class="form-group mb-4">
                           <textarea rows="4" class="form-control" placeholder="Type your message here.."></textarea>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary w-100">{{__('dashboard.Send')}}</button>
                        </div>
                     </form>
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
            <div class="medi-area-right">
               <div class="box-out">
                  <!-- <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>Medical conditions and problems</h4>
                        <a href="#" class="edit-btn"><i class="fa-light fa-pen"></i></a>
                     </div>
                     <div class="medical-body" style="height: 200px;">
                     </div>
                  </div> -->
                  <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>{{__('patient.Areas of Monitoring')}}</h4>
                        <a href="javascript:void()" id="edit-btn-area-of-monitoring" class="edit-btn"><i class="fa-light fa-pen"></i></a>
                     </div>
                     <div class="medical-body">
                        <h5 class="mb-3"><strong>{{__('patient.Medical Conditions')}}</strong></h5>
                        <form class="" action="">
                           @csrf
                           <div class="row">
                              <div class="col-lg-8 col-md-6">
                                 <div class="form-check mb-2">
                                    <?php
                                    // Get the first medication treatment record
                                    $medicalCondition = $patient->PatientMedicalCondition->first();
                                    ?>
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="overall_health" data-patient-id="{{ $patient->id }}" data-model="PatientMedicalCondition" data-column="overall_health" {{ $medicalCondition && $medicalCondition->overall_health ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="overall_health">
                                       {{__('patient.Overall Health')}}
                                       <svg data-toggle="tooltip" aria-label="Overall Health" data-bs-original-title="Overall Health" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="chronic_pain" data-patient-id="{{ $patient->id }}" data-model="PatientMedicalCondition" data-column="chronic_pain" {{ $medicalCondition && $medicalCondition->chronic_pain ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="chronic_pain">
                                       {{__('patient.Chronic Pain')}}
                                       <svg data-toggle="tooltip" aria-label="Chronic Pain" data-bs-original-title="Chronic Pain" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="pulmonary_disease" data-patient-id="{{ $patient->id }}" data-model="PatientMedicalCondition" data-column="pulmonary_disease" {{ $medicalCondition && $medicalCondition->pulmonary_disease ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="pulmonary_disease">
                                       {{__('patient.Pulmonary disease')}}
                                       <svg data-toggle="tooltip" aria-label="Pulmonary disease" data-bs-original-title="Pulmonary disease" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                 <div class="form-check mb-2">
                                    <label class="form-label">{{__('patient.Are you missing a medical Condition for Monitoring')}}</label>
                                    <div class="d-flex">
                                       <input type="text" class="form-control" />
                                       <button type="text" class="btn btn-primary ms-2">{{__('patient.Request')}}</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="medical-body">
                        <h5 class="mb-3"><strong>{{__('patient.Medications and Treatment')}}</strong></h5>
                        <form class="" action="">
                           <div class="row">
                              <div class="col-lg-8 col-md-6">
                                 <div class="form-check mb-2">
                                    <?php
                                    // Get the first medication treatment record
                                    $medicationsTreatment = $patient->PatientMedicationsTreatment->first();
                                    ?>
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="use_of_medication" data-patient-id="{{ $patient->id }}" data-model="PatientMedicationsTreatment" data-column="use_of_medication" {{ $medicationsTreatment && $medicationsTreatment->use_of_medication ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="use_of_medication">
                                       {{__('patient.Use of medication')}}
                                       <svg data-toggle="tooltip" aria-label="Use of medication" data-bs-original-title="Use of medication" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="medication_use_reminders" data-patient-id="{{ $patient->id }}" data-model="PatientMedicationsTreatment" data-column="medication_use_reminders" {{ $medicationsTreatment && $medicationsTreatment->medication_use_reminders ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="medication_use_reminders">
                                       {{__('patient.Medication use remind us')}}
                                       <svg data-toggle="tooltip" aria-label="Medication use remind us" data-bs-original-title="Medication use remind us" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="medication_side_effects" data-patient-id="{{ $patient->id }}" data-model="PatientMedicationsTreatment" data-column="medication_side_effects" {{ $medicationsTreatment && $medicationsTreatment->medication_side_effects ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="medication_side_effects">
                                       {{__('patient.Medication side effects')}}
                                       <svg data-toggle="tooltip" aria-label="Medication side effects" data-bs-original-title="Medication side effects" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                 <div class="form-check mb-2">
                                    <label class="form-label">{{__('patient.Request additional monitoring of medicines & treatment')}}</label>
                                    <div class="d-flex">
                                       <input type="text" class="form-control" />
                                       <button type="text" class="btn btn-primary ms-2">{{__('patient.Request')}}</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="medical-body">
                        <h5 class="mb-3"><strong>{{__('patient.Quantitative Indicators')}}</strong></h5>
                        <form class="" action="">
                           <div class="row">
                              <div class="col-lg-8 col-md-6">
                                 <div class="form-check mb-2">
                                    <?php
                                    // Get the first medication treatment record
                                    $quantitativeIndicators = $patient->PatientQuantitativeIndicators->first();
                                    ?>
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="blood_pressure" data-patient-id="{{ $patient->id }}" data-model="PatientQuantitativeIndicators" data-column="blood_pressure" {{ $quantitativeIndicators && $quantitativeIndicators->blood_pressure ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="blood_pressure">
                                       {{__('patient.Blood pressure')}}
                                       <svg data-toggle="tooltip" aria-label="Blood pressure" data-bs-original-title="Blood pressure" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" value="" id="weight" data-patient-id="{{ $patient->id }}" data-model="PatientQuantitativeIndicators" data-column="weight" {{ $quantitativeIndicators && $quantitativeIndicators->weight ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="weight">
                                       {{__('patient.Weight')}}
                                       <svg data-toggle="tooltip" aria-label="Weight" data-bs-original-title="Weight" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="physical_exercise_activity" data-patient-id="{{ $patient->id }}" data-model="PatientQuantitativeIndicators" data-column="physical_exercise_activity" {{ $quantitativeIndicators && $quantitativeIndicators->physical_exercise_activity ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="physical_exercise_activity">
                                       {{__('patient.Physical exercise/activity')}}
                                       <svg data-toggle="tooltip" aria-label="Oxy geometer" data-bs-original-title="Qxy gometer" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                 <div class="form-check mb-2">
                                    <label class="form-label">{{__('patient.Are you missing measures Or any indicators?')}}</label>
                                    <div class="d-flex">
                                       <input type="text" class="form-control" />
                                       <button type="text" class="btn btn-primary ms-2">{{__('patient.Request')}}</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="medical-body">
                        <h5 class="mb-3"><strong>{{__('patient.Lifestyle and Wellbeing')}}</strong></h5>
                        <form class="" action="">
                           <div class="row">
                              <div class="col-lg-8 col-md-6">
                                 <div class="form-check mb-2">
                                    <?php
                                    // Get the first medication treatment record
                                    $lifestyleAndWellbeing = $patient->PatientLifestyleAndWellbeing->first();
                                    ?>
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="regular_food_intake" data-patient-id="{{ $patient->id }}" data-model="PatientLifestyleAndWellbeing" data-column="regular_food_intake" {{ $lifestyleAndWellbeing && $lifestyleAndWellbeing->regular_food_intake ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="regular_food_intake">
                                       {{__('patient.Regular food food intake')}}
                                       <svg data-toggle="tooltip" aria-label="Regular food food intake" data-bs-original-title="Regular food food intake" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="hydration" data-patient-id="{{ $patient->id }}" data-model="PatientLifestyleAndWellbeing" data-column="hydration" {{ $lifestyleAndWellbeing && $lifestyleAndWellbeing->hydration ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="hydration">
                                       {{__('patient.Hydration')}}
                                       <svg data-toggle="tooltip" aria-label="Hydration" data-bs-original-title="Hydration" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="qxy_gometer" data-patient-id="{{ $patient->id }}" data-model="PatientLifestyleAndWellbeing" data-column="qxy_gometer" {{ $lifestyleAndWellbeing && $lifestyleAndWellbeing->qxy_gometer ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="qxy_gometer">
                                       {{__('patient.Oxy geometer')}}
                                       <svg data-toggle="tooltip" aria-label="Physical exercise/activity" data-bs-original-title="Physical exercise/activity" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                                 <div class="form-check mb-2">
                                    <input class="form-check-input checkbox_monitoring" type="checkbox" id="quality_of_sleep" data-patient-id="{{ $patient->id }}" data-model="PatientLifestyleAndWellbeing" data-column="quality_of_sleep" {{ $lifestyleAndWellbeing && $lifestyleAndWellbeing->quality_of_sleep ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="quality_of_sleep">
                                       {{__('patient.Quality of sleep')}}
                                       <svg data-toggle="tooltip" aria-label="Quality of sleep" data-bs-original-title="Quality of sleep" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686" />
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686" />
                                       </svg>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                 <div class="form-check mb-2">
                                    <label class="form-label">{{__('patient.Which other indicators of lifestyle & wellbeing would you like to see?')}}</label>
                                    <div class="d-flex">
                                       <input type="text" class="form-control" />
                                       <button type="text" class="btn btn-primary ms-2">{{__('patient.Request')}}</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>{{ __('medication.Medications')}}</h4>
                        <a href="#" class="edit-btn" id="edit-btn-area-of-medication"><i class="fa-light fa-pen"></i></a>
                     </div>
                     <div class="medical-body medical-body-medication border-0">
                        <div id="medication-forms-container">
                           @if($patientMedications->isEmpty())
                           <!-- Display default form if there are no records -->
                           <form class="medication-form" action="" data-form-id="1">
                              <div class="row">
                                 <div class="col-lg-1 col-md-4">
                                    <div class="form-group">
                                       <label class="mb-2"><strong>{{ __('medication.Medication')}}</strong></label>
                                       <input type="hidden" class="form-control" name="patient_id" value="{{ $patient->id }}">
                                       <input type="text" class="form-control" name="medication" placeholder="Melyd 60x2 mg" value="" disabled>
                                    </div>
                                 </div>
                                 <div class="col-lg-2 col-md-4">
                                    <div class="form-group">
                                       <label class="mb-2"><strong>{{ __('medication.Purpose Of Medication')}}</strong></label>
                                       <input type="text" class="form-control" name="purpose_of_medication" placeholder="" value="" disabled>
                                    </div>
                                 </div>
                                 <div class="col-lg-3 col-md-4">
                                    <div class="use-column">
                                       <div class="mfrequency">
                                          <p class=""><strong>{{ __('medication.Use schedule')}}</strong></p>
                                          <div class="mfrequency-form">
                                             @foreach(['6:00', '12:00', '18:00', '24:00'] as $time)
                                             <div class="form-check ps-0">
                                                <p class="form-check-label">{{ $time }}</p>
                                                <input class="form-check-input ms-0" type="checkbox" name="use_schedule[]" value="{{ $time }}" disabled>
                                             </div>
                                             @endforeach
                                          </div>
                                       </div>
                                       <div class="food-use">
                                          <p class="mb-2"><strong>{{ __('medication.Food and use')}}</strong></p>
                                          <select class="form-select" name="food_use" aria-label="Default select example" disabled>
                                             <option selected>{{ __('medication.Food and use')}}</option>
                                             <option value="1">One</option>
                                             <option value="2">Two</option>
                                             <option value="3">Three</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6">
                                    <div class="dose-column">
                                       <div class="form-group">
                                          <label class="mb-1">{{ __('medication.Dose/Use(x units)')}}</label>
                                          <input type="text" class="form-control" name="dose_use" value="" disabled>
                                       </div>
                                       <div class="form-group">
                                          <label class="mb-1">{{ __('medication.Doses per package')}}</label>
                                          <input type="text" class="form-control" name="doses_per_package" value="" disabled>
                                       </div>
                                       <div class="form-group">
                                          <label class="mb-1">{{ __('medication.Last prescription start')}}</label>
                                          <div class="d-flex">
                                             <input type="date" class="form-control me-1" name="last_prescription_start" value="" disabled>
                                             <a href="#" class="btn btn-success me-1 save-btn-area-of-medication" style="pointer-events: none; opacity: 0.5;" disabled><i class="fa-solid fa-check"></i></a>
                                             <a href="#" class="btn btn-danger close-btn-area-of-medication" style="pointer-events: none; opacity: 0.5;" disabled><i class="fa-solid fa-times"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                           @else
                           @foreach($patientMedications as $medication)
                           <form class="medication-form" action="" data-form-id="{{ $loop->index + 1 }}">
                              <input type="hidden" name="id" value="{{ $medication->id }}">
                              <div class="row">
                                 <div class="col-lg-1 col-md-4">
                                    <div class="form-group">
                                       <label class="mb-2"><strong>{{ __('medication.Medication')}}</strong></label>
                                       <input type="hidden" class="form-control" name="patient_id" value="{{ $patient->id }}">
                                       <input type="text" class="form-control" name="medication" placeholder="Melyd 60x2 mg" value="{{ old('medication', $medication->medication) }}" disabled>
                                    </div>
                                 </div>
                                 <div class="col-lg-2 col-md-4">
                                    <div class="form-group">
                                       <label class="mb-2"><strong>{{ __('medication.Purpose Of Medication')}}</strong></label>
                                       <input type="text" class="form-control" name="purpose_of_medication" placeholder="" value="{{ old('purpose_of_medication', $medication->purpose_of_medication) }}" disabled>
                                    </div>
                                 </div>
                                 <div class="col-lg-3 col-md-4">
                                    <div class="use-column">
                                       <div class="mfrequency">
                                          <p class=""><strong>{{ __('medication.Use schedule')}} </strong></p>
                                          <div class="mfrequency-form">
                                             @foreach(['6:00', '12:00', '18:00', '24:00'] as $time)
                                             <div class="form-check ps-0">
                                                <p class="form-check-label">{{ $time }}</p>
                                                <input class="form-check-input ms-0" type="checkbox" name="use_schedule[]" value="{{ $time }}" {{ in_array($time, json_decode($medication->use_schedule, true)) ? 'checked' : '' }} disabled>
                                             </div>
                                             @endforeach
                                          </div>
                                       </div>
                                       <div class="food-use">
                                          <p class="mb-2"><strong>{{ __('medication.Food and use')}}</strong></p>
                                          <select class="form-select" name="food_use" aria-label="Default select example" disabled>
                                             <option selected>{{ __('medication.Food and use')}}</option>
                                             <option value="1" {{ old('food_use', $medication->food_use) == 1 ? 'selected' : '' }}>One</option>
                                             <option value="2" {{ old('food_use', $medication->food_use) == 2 ? 'selected' : '' }}>Two</option>
                                             <option value="3" {{ old('food_use', $medication->food_use) == 3 ? 'selected' : '' }}>Three</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6">
                                    <div class="dose-column">
                                       <div class="form-group">
                                          <label class="mb-1">{{ __('medication.Dose/Use(x units)')}}</label>
                                          <input type="text" class="form-control" name="dose_use" value="{{ old('dose_use', $medication->dose_use) }}" disabled>
                                       </div>
                                       <div class="form-group">
                                          <label class="mb-1">{{ __('medication.Doses per package')}} </label>
                                          <input type="text" class="form-control" name="doses_per_package" value="{{ old('doses_per_package', $medication->doses_per_package) }}" disabled>
                                       </div>
                                       <div class="form-group">
                                          <label class="mb-1">{{ __('medication.Last prescription start')}}</label>
                                          <div class="d-flex">
                                             <input type="date" class="form-control me-1" name="last_prescription_start" value="{{ old('last_prescription_start', $medication->last_prescription_start) }}" disabled>
                                             <a href="#" class="btn btn-success me-1 save-btn-area-of-medication" style="pointer-events: none; opacity: 0.5;" disabled><i class="fa-solid fa-check"></i></a>
                                             <a href="#" class="btn btn-danger close-btn-area-of-medication" style="pointer-events: none; opacity: 0.5;" disabled><i class="fa-solid fa-times"></i></a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                           @endforeach
                           @endif
                        </div>
                        <div class="row mt-lg-4 mt-3">
                           <div class="col-lg-12">
                              <a href="#" class="btn btn-primary" id="add-medication-btn" style="pointer-events: none; opacity: 0.5;"> {{ __('medication.Add Medication')}} <i class="fa-solid fa-plus ms-2"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>{{ __('medication.Monitoring Frequency')}}</h4>
                        <a href="#" class="edit-btn" id="edit-btn-monitoring-frequency"><i class="fa-light fa-pen"></i></a>
                     </div>
                     <div class="medical-body medical-body-monitoring-frequency border-0 mb-0">
                        <form class="monitoring-frequency-form" action="">
                           <div class="row">
                              <input type="hidden" class="form-control" name="patient_id" value="{{ $patient->id }}">
                              <div class="col-lg-3 col-md-6">
                                 <h5 class="mb-2"><strong>{{ __('medication.Frequency')}}</strong></h5>
                                 <div class="mfrequency-form">
                                    @php
                                    // Decode the frequency JSON or set an empty array if no record
                                    $frequency = $monitoringFrequency ? json_decode($monitoringFrequency->frequency, true) : [];
                                    @endphp
                                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                    <div class="form-check ps-0">
                                       <p class="form-check-label">{{ $day }}</p>
                                       <input class="form-check-input ms-0" type="checkbox" name="frequency[]" value="{{ __('patient.'.$day) }}" {{ in_array($day, $frequency) ? 'checked' : '' }} disabled>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                              <div class="col-lg-2 col-md-6">
                                 <h5 class="mb-2"><strong>{{ __('medication.Preferred call time')}}</strong></h5>
                                 <div class="Preferred-call">
                                    <select class="form-select" name="preferred_call_time" disabled>
                                       <option value="10:12 PM" {{ old('preferred_call_time', $monitoringFrequency->preferred_call_time ?? '') == '10:12 PM' ? 'selected' : '' }}>10:12 PM</option>
                                       <option value="12:14 PM" {{ old('preferred_call_time', $monitoringFrequency->preferred_call_time ?? '') == '12:14 PM' ? 'selected' : '' }}>12:14 PM</option>
                                       <option value="14:16 PM" {{ old('preferred_call_time', $monitoringFrequency->preferred_call_time ?? '') == '14:16 PM' ? 'selected' : '' }}>14:16 PM</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-2 col-md-6 mt-4 pt-2">
                                 <a href="#" class="btn btn-success save-btn-monitoring-frequency" style="pointer-events: none; opacity: 0.5;" disabled><i class="fa-solid fa-check"></i></a>
                                 <a href="#" class="btn btn-danger close-btn-monitoring-frequency" style="pointer-events: none; opacity: 0.5;" disabled><i class="fa-solid fa-times"></i></a>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>{{ __('medication.Family members')}}</h4>
                        <a href="javascript:void(0)" onclick="editFemilyMember()" class="edit-btn"><i class="fa-light fa-pen"></i></a>
                     </div>
                     <div class="medical-body border-0 mb-0">
                        <form class="" action="" id="familyMemberForm" onsubmit="addFamilyMembers(event,this)">
                           <input type="hidden" name="patient_id" value="{{$patient->id}}">
                           @if(count($patientmembers)>0)
                           @foreach($patientmembers as $member)
                           <div class="row">
                              <input type="hidden" name="member_id[]" id="member_id[]" value="{{$member->id}}">
                              <div class="col-lg-3 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Member Name')}}</label>
                                    <input type="text" id="name[]" name="name[]" placeholder="Member Name" required class="form-control femily-member-sec" disabled value="{{$member->name}}" />
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Mobile Number')}}</label>
                                    <input type="text" id="phone[]" name="phone[]" placeholder="`+420 435 783 230" required class="form-control femily-member-sec" disabled value="{{$member->phone}}" />
                                 </div>
                              </div>
                              <div class="col-lg-2 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Relationship')}}</label>
                                    <input type="text" id="relation[]" name="relation[]" placeholder="Daughter" class="form-control femily-member-sec" disabled value="{{$member->relation}}" />
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Email Address')}}</label>
                                    <input type="email" id="email[]" name="email[]" placeholder="john@gmail.com" class="form-control  femily-member-sec" disabled value="{{$member->email}}" />
                                 </div>
                              </div>
                              <div class="col-lg-1 col-md-6">
                                 <button type="submit" class="btn btn-success femily-member-sec" style="margin-top: 30px" disabled><i class="fa-solid fa-check"></i></button>
                                 <button type="button" class="btn btn-danger delete-family-member femily-member-sec" onclick="removeFamilyMember(this,'{{$member->id}}')" style="margin-top: 30px" disabled><i class="fa-solid fa-times"></i></button>
                              </div>
                              <!-- <div class="col-lg-12 col-md-12">
                                 <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                       Invite to Mamsa Family <svg data-toggle="tooltip" aria-label="Invite to Mamsa Family" data-bs-original-title="Invite to Mamsa Family" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686"></path>
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686"></path>
                                       </svg>
                                    </label>
                                 </div>
                              </div> -->

                           </div>
                           @endforeach
                           @else
                           <div class="row">
                              <input type="hidden" name="member_id[]" id="member_id[]" value="">
                              <div class="col-lg-3 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Member Name')}}</label>
                                    <input type="text" id="name[]" name="name[]" placeholder="Member Name" required class="form-control femily-member-sec" disabled value="" />
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Mobile Number')}}</label>
                                    <input type="text" id="phone[]" name="phone[]" placeholder="`+420 435 783 230" required class="form-control femily-member-sec" disabled value="" />
                                 </div>
                              </div>
                              <div class="col-lg-2 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Relationship')}}</label>
                                    <input type="text" id="relation[]" name="relation[]" placeholder="Daughter" class="form-control femily-member-sec" disabled value="" />
                                 </div>
                              </div>
                              <div class="col-lg-3 col-md-6">
                                 <div class="form-group mb-4">
                                    <label class="form-label">{{ __('medication.Email Address')}}</label>
                                    <input type="email" id="email[]" name="email[]" placeholder="john@gmail.com" class="form-control  femily-member-sec" disabled />
                                 </div>
                              </div>
                              <div class="col-lg-1 col-md-6">
                                 <button type="submit" class="btn btn-success femily-member-sec" style="margin-top: 30px" disabled><i class="fa-solid fa-check"></i></button>
                                 <button type="button" class="btn btn-danger delete-family-member femily-member-sec" onclick="removeFamilyMember(this)" style="margin-top: 30px" disabled><i class="fa-solid fa-times"></i></button>
                              </div>
                              <!-- <div class="col-lg-12 col-md-12">
                                 <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                       Invite to Mamsa Family <svg data-toggle="tooltip" aria-label="Invite to Mamsa Family" data-bs-original-title="Invite to Mamsa Family" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686"></path>
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686"></path>
                                       </svg>
                                    </label>
                                 </div>
                              </div> -->

                           </div>
                           @endif

                        </form>
                        <div class="col-lg-12 col-md-12">
                           <div class="form-group">
                              <button type="button" onclick="addMemberRow()" class="btn btn-primary  femily-member-sec" disabled> {{ __('medication.Add Family Member')}} <i class="fa-solid fa-plus ms-2"></i></button>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>{{ __('medication.Areas of interest and hobbies')}}</h4>
                        <a href="#" class="edit-btn" id="edit-btn-area-of-hobbies"><i class="fa-light fa-pen"></i></a>
                     </div>
                     <h5 class="mb-3"><strong>{{ __('medication.Hobbies')}}</strong></h5>
                     <form class="" action="">
                        <div class="row">
                           @foreach($hobbies as $hobby)
                           <div class="col-lg-4 col-md-6">
                              <div class="form-check mb-2">
                                 <input class="form-check-input checkbox_hobby" type="checkbox" value="{{ $hobby->id }}" id="flex{{ $hobby->name }}" data-patient-id="{{ $patient->id }}" {{ in_array($hobby->id, $selectedHobbies) ? 'checked' : '' }} disabled>
                                 <label class="form-check-label" for="flex{{ $hobby->name }}">
                                    {{ __('medication.'.$hobby->name) }}
                                    <svg data-toggle="tooltip" aria-label="{{ $hobby->name }}" data-bs-original-title="{{ $hobby->name }}" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686"></path>
                                       <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686"></path>
                                    </svg>
                                 </label>
                              </div>
                           </div>
                           @endforeach
                        </div>
                     </form>
                  </div>
                  <div class="medical-conditions mb-4">
                     <div class="sec-title">
                        <h4>{{ __('medication.Doctors and Facilities')}}</h4>
                        {{-- <a href="#" class="edit-btn"><i class="fa-light fa-pen"></i></a> --}}
                     </div>
                     <div class="medical-body border-0 mb-0">
                        <form class="" action="">
                           <div class="row">
                              <div class="col-lg-4 col-md-6">
                                 <label class="form-label">{{ __('medication.Medical Facilities')}}</label>
                                 @foreach($patient->facilities as $facility)
                                 <div class="form-group mb-3">
                                    <div class="d-flex">
                                       <input type="text" disabled class="form-control" value="{{$facility->facility_name}}">
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                              <div class="col-lg-4 col-md-6">
                                 <label class="form-label">{{ __('medication.Doctor')}}</label>
                                 @foreach($patient->doctors as $doctor)
                                 <div class="form-group mb-3">
                                    <div class="d-flex">
                                       <input type="text" disabled class="form-control" value="{{$doctor->firstname}} {{$doctor->lastname}}">
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <!-- Edit Profile Modal Start-->
   <!-- Display validation errors -->
   <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="editProfileModalLabel">{{ __('medication.Edit Profile')}}</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form action="{{ route('update.profile') }}" method="POST" enctype="multipart/form-data">

               <div class="modal-body">
                  <!-- Form content goes here -->
                  @csrf
                  <div class="form-group">
                     <label for="image">{{ __('medication.Profile Image')}}</label>
                     <input type="hidden" id="patient_id" name="patient_id" value="{{ old('id', $patient->id) }}">
                     <input type="file" class="form-control" id="image" name="image">
                  </div>

                  <div class="form-group">
                     <label for="first_name">{{ __('patient.First Name')}}</label>
                     <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $patient->first_name) }}">
                  </div>

                  <div class="form-group">
                     <label for="last_name">{{ __('patient.Last Name')}}</label>
                     <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $patient->last_name) }}">
                  </div>

                  <!-- <div class="form-group">
                  <label for="phone_number">Phone Number</label>
                  <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $patient->phone_number) }}">
               </div> -->

                  <!-- <div class="form-group">
                  <label for="other_number">Other Number</label>
                  <input type="text" class="form-control" id="other_number" name="other_number" value="{{ old('other_number', $patient->other_number) }}">
               </div> -->

                  <div class="form-group">
                     <label for="address">{{ __('medication.Address')}}</label>
                     <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $patient->address) }}">
                  </div>

                  <div class="form-group">
                     <label for="DOB">{{ __('medication.Date of Birth')}}</label>
                     <input type="date" class="form-control" id="DOB" name="DOB" value="{{ old('DOB', $patient->DOB) }}">
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="weight">{{__('patient.Weight')}}</label>
                           <input type="text" class="form-control" id="weight" name="weight" value="{{ old('weight', $patient->weight) }}">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="gender">{{__('patient.Gender')}}</label>
                           <select name="gender" id="gender" class="form-control" required>
                              <option value="m" @if($patient->gender=='m') selected @endif>{{__('patient.Male')}}</option>
                              <option value="f" @if($patient->gender=='f') selected @endif>{{__('patient.Female')}}</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('medication.Close')}}</button>
                  <button type="submit" class="btn btn-primary">{{ __('medication.Save changes')}}</button>
               </div>
            </form>

         </div>
      </div>
   </div>
   <!-- Edit Profile Modal End-->
</section>
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
               <a href="#">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <circle cx="23" cy="23" r="23" fill="white" />
                     <path d="M29 11.5619C29 11.4146 28.9377 11.2734 28.8269 11.1692C28.7161 11.0651 28.5658 11.0066 28.4091 11.0066H25.4545C23.9668 10.9369 22.5102 11.4235 21.4029 12.3601C20.2957 13.2967 19.6279 14.607 19.5455 16.0049V19.0039H16.5909C16.4342 19.0039 16.2839 19.0625 16.1731 19.1666C16.0623 19.2708 16 19.412 16 19.5593V22.4473C16 22.5945 16.0623 22.7358 16.1731 22.84C16.2839 22.9441 16.4342 23.0026 16.5909 23.0026H19.5455V34.4446C19.5455 34.5919 19.6077 34.7332 19.7185 34.8373C19.8293 34.9415 19.9796 35 20.1364 35H23.6818C23.8385 35 23.9888 34.9415 24.0997 34.8373C24.2105 34.7332 24.2727 34.5919 24.2727 34.4446V23.0026H27.3691C27.5005 23.0044 27.6288 22.965 27.7337 22.8905C27.8385 22.8161 27.914 22.7109 27.9482 22.5917L28.7991 19.7037C28.8226 19.6217 28.8258 19.5356 28.8083 19.4522C28.7909 19.3688 28.7533 19.2903 28.6985 19.2227C28.6437 19.1551 28.5732 19.1003 28.4922 19.0623C28.4113 19.0244 28.3222 19.0044 28.2318 19.0039H24.2727V16.0049C24.3021 15.73 24.4395 15.4752 24.658 15.2904C24.8766 15.1055 25.1605 15.0039 25.4545 15.0053H28.4091C28.5658 15.0053 28.7161 14.9467 28.8269 14.8426C28.9377 14.7384 29 14.5972 29 14.4499V11.5619Z" fill="#6371E8" />
                  </svg>
               </a>
               <a href="#">
                  <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
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
<div id="familymemberrow" class="d-none">
   <div class="row">
      <input type="hidden" name="member_id[]" id="member_id[]" value="">
      <div class="col-lg-3 col-md-6">
         <div class="form-group mb-4">
            <label class="form-label">{{ __('medication.Member Name')}}</label>
            <input type="text" id="name[]" name="name[]" placeholder="Member Name" required class="form-control femily-member-sec" disabled value="" />
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="form-group mb-4">
            <label class="form-label">{{ __('medication.Mobile Number')}}</label>
            <input type="text" id="phone[]" name="phone[]" placeholder="`+420 435 783 230" required class="form-control femily-member-sec" disabled value="" />
         </div>
      </div>
      <div class="col-lg-2 col-md-6">
         <div class="form-group mb-4">
            <label class="form-label">{{ __('medication.Relationship')}}</label>
            <input type="text" id="relation[]" name="relation[]" placeholder="Daughter" class="form-control femily-member-sec" disabled value="" />
         </div>
      </div>
      <div class="col-lg-3 col-md-6">
         <div class="form-group mb-4">
            <label class="form-label">{{ __('medication.Email Address')}}</label>
            <input type="email" id="email[]" name="email[]" placeholder="john@gmail.com" class="form-control  femily-member-sec" disabled />
         </div>
      </div>
      <div class="col-lg-1 col-md-6">
         <button type="submit" class="btn btn-success femily-member-sec" style="margin-top: 30px" disabled><i class="fa-solid fa-check"></i></button>
         <button type="button" class="btn btn-danger delete-family-member femily-member-sec" onclick="removeFamilyMember(this)" style="margin-top: 30px" disabled><i class="fa-solid fa-times"></i></button>
      </div>
      <!-- <div class="col-lg-12 col-md-12">
                                 <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                       Invite to Mamsa Family <svg data-toggle="tooltip" aria-label="Invite to Mamsa Family" data-bs-original-title="Invite to Mamsa Family" class="ms-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.5 10C0.5 4.7533 4.7533 0.5 10 0.5C15.2467 0.5 19.5 4.7533 19.5 10C19.5 15.2467 15.2467 19.5 10 19.5C4.7533 19.5 0.5 15.2467 0.5 10Z" fill="#868686" fill-opacity="0.05" stroke="#868686"></path>
                                          <path d="M9.9795 5C10.8815 5 11.6105 5.26217 12.1663 5.78652C12.7221 6.31086 13 7.01311 13 7.89326C13 8.8764 12.7039 9.60674 12.1116 10.0843C11.5194 10.5524 10.7175 10.7865 9.70615 10.7865L9.66515 12.1208H8.58542L8.53075 9.90169H8.92711C9.82916 9.90169 10.5353 9.76124 11.0456 9.48034C11.5558 9.19944 11.8109 8.67041 11.8109 7.89326C11.8109 7.33146 11.6469 6.8867 11.3189 6.55899C10.9909 6.23127 10.549 6.06742 9.99317 6.06742C9.42825 6.06742 8.98178 6.22659 8.65376 6.54494C8.33485 6.85393 8.1754 7.27996 8.1754 7.82303H7C7 7.26124 7.12301 6.76966 7.36902 6.34831C7.61503 5.9176 7.96128 5.58521 8.40775 5.35112C8.86333 5.11704 9.38724 5 9.9795 5ZM9.11845 15C8.88155 15 8.68109 14.9157 8.51708 14.7472C8.35308 14.5787 8.27107 14.3727 8.27107 14.1292C8.27107 13.8858 8.35308 13.6798 8.51708 13.5112C8.68109 13.3427 8.88155 13.2584 9.11845 13.2584C9.34624 13.2584 9.53759 13.3427 9.69248 13.5112C9.85649 13.6798 9.9385 13.8858 9.9385 14.1292C9.9385 14.3727 9.85649 14.5787 9.69248 14.7472C9.53759 14.9157 9.34624 15 9.11845 15Z" fill="#868686"></path>
                                       </svg>
                                    </label>
                                 </div>
                              </div> -->

   </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function openEditProfileModal() {
      $('#editProfileModal').modal('show');
   }

   function addMemberRow() {
      $('#familyMemberForm').append($('#familymemberrow').html());
   }

   function editFemilyMember() {
      $('.femily-member-sec').prop('disabled', false);
   }

   function addFamilyMembers(event, formobj) {
      event.preventDefault();
      Swal.fire({
         title: 'Confirm',
         text: 'Are you sure to update family member changes ?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes',
         cancelButtonText: 'No'
      }).then((result) => {
         if (result.isConfirmed) {
            // Perform AJAX request to update the database
            $.ajax({
               url: '{{ route("addMember")}}',
               method: 'POST',
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  "Accept": "application/json"
               },
               dataType: "json",
               processData: false, // Prevent jQuery from processing the data
               contentType: false, // Prevent jQuery from setting the Content-Type header
               data: new FormData(formobj),
               success: function(response) {
                  if (response.status && response.member_ids) {
                     // Iterate over each member_id and set it to the corresponding hidden field
                     response.member_ids.forEach(function(member_id, index) {
                        // Select the nth hidden input for member_id[]
                        var hiddenInput = $('input[name="member_id[]"]').eq(index);
                        hiddenInput.val(member_id);
                        var removeButton = hiddenInput.closest('.row').find('.delete-family-member');
                        removeButton.attr('onclick', 'removeFamilyMember(this, ' + member_id + ')');
                        Swal.fire('Updated!', `The Family member data is updated`, 'success');
                     });
                  }
               },
            });
         }
      });
   }

   function removeFamilyMember(obj, member_id = '') {
      Swal.fire({
         title: 'Confirm',
         text: 'Are you sure to delete family member row ?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes',
         cancelButtonText: 'No'
      }).then((result) => {
         if (result.isConfirmed) {
            // Perform AJAX request to update the database
            if (member_id != '') {
               var memberurl = '{{ route("deleteMember",":member_id")}}';
               memberurl = memberurl.replace(":member_id", member_id);
               $.ajax({
                  url: memberurl,
                  method: 'GET',
                  contentType: 'application/json',
                  data: JSON.stringify({
                     member_id: member_id,
                  }),
                  success: function(data) {
                     if (data.status) {
                        const row = obj.closest('.row');
                        row.remove();
                        Swal.fire('Deleted!', `The Family member row is deleted`, 'success');
                     } else {
                        Swal.fire('Error!', `Something wrong in delete entry`, 'error');

                     }
                  },
               });
            } else {
               const row = obj.closest('.row');
               row.remove();
               Swal.fire('Deleted!', `The Family member row is deleted`, 'success');
            }
         }
      });

      // Remove the row element from the DOM
   }
   $(document).ready(function() {

      /* Script of area of monitoring section Satrt */
      $('#edit-btn-area-of-monitoring').click(function(event) {
         event.preventDefault(); // Prevent default button behavior

         // Toggle the disabled attribute for all checkboxes
         $('.checkbox_monitoring').each(function() {
            $('.checkbox_monitoring').prop('disabled', false);
         });

      });

      $('.checkbox_monitoring').on('change', function() {
         const checkbox = $(this);
         const isChecked = checkbox.prop('checked');
         const model = checkbox.data('model');
         const column = checkbox.data('column');
         const patientId = checkbox.data('patient-id');
         const actionMessage = isChecked ? `Are you sure you want to add this ${model}?` : `Are you sure you want to remove this ${model}?`;

         Swal.fire({
            title: 'Confirm Change',
            text: actionMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
         }).then((result) => {
            if (result.isConfirmed) {
               // Perform AJAX request to update the database
               $.ajax({
                  url: '/doctor/update-medical-condition',
                  method: 'POST',
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  contentType: 'application/json',
                  data: JSON.stringify({
                     patientId: patientId,
                     model: model,
                     column: column,
                     value: isChecked
                  }),
                  success: function(data) {
                     if (data.success) {
                        Swal.fire('Updated!', `The ${column} has been updated for ${model}.`, 'success');
                     } else {
                        Swal.fire('Error!', `There was an error updating the ${column}.`, 'error');
                     }
                  },
                  error: function() {
                     Swal.fire('Error!', 'There was an error with the request.', 'error');
                  }
               });
            } else {
               // Revert the checkbox if the user cancels
               checkbox.prop('checked', !isChecked);
            }
         });
      });
      /* Script of area of monitoring section End */

      /* Script of area of hobbies section Satrt */
      $('#edit-btn-area-of-hobbies').click(function(event) {
         event.preventDefault(); // Prevent default button behavior

         // Toggle the disabled attribute for all checkboxes
         $('.checkbox_hobby').each(function() {
            $('.checkbox_hobby').prop('disabled', false);
         });

      });

      $('.checkbox_hobby').on('change', function() {
         const hobbyId = $(this).val();
         const isChecked = $(this).is(':checked');
         const patientId = $(this).data('patient-id');
         const actionText = isChecked ? 'add' : 'remove';
         const actionMessage = isChecked ? 'add this hobby?' : 'remove this hobby?';

         Swal.fire({
            title: `Do you want to ${actionText} this hobby?`,
            text: actionMessage,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
         }).then(result => {
            if (result.isConfirmed) {
               updateHobbyStatus(hobbyId, isChecked, patientId);
            } else {
               // Revert the checkbox state if action is canceled
               $(this).prop('checked', !isChecked);
            }
         });
      });

      function updateHobbyStatus(hobbyId, isChecked, patientId) {
         $.ajax({
            url: '{{ route("update.hobby.status") }}',
            method: 'POST',
            data: {
               _token: $('meta[name="csrf-token"]').attr('content'),
               hobby_id: hobbyId,
               patient_id: patientId,
               is_checked: isChecked
            },
            success: function(response) {
               if (response.success) {
                  Swal.fire({
                     title: 'Success',
                     text: `Hobby ${isChecked ? 'added' : 'removed'} successfully.`,
                     icon: 'success'
                  });
               } else {
                  Swal.fire({
                     title: 'Error',
                     text: 'An error occurred while updating the hobby.',
                     icon: 'error'
                  });
               }
            },
            error: function() {
               Swal.fire({
                  title: 'Error',
                  text: 'An error occurred while updating the hobby.',
                  icon: 'error'
               });
            }
         });
      }
      /* Script of area of hobbies section End */

      /* Script of area of medication section Satrt */

      // Ensure save and close buttons are disabled and styled on page load
      $('.save-btn-area-of-medication, .close-btn-area-of-medication').css({
         'pointer-events': 'none',
         'opacity': '0.5'
      }).prop('disabled', true);

      // Click event to enable editing
      $('#edit-btn-area-of-medication').on('click', function(e) {
         e.preventDefault();

         // Enable all inputs and selects in the form
         $('.medical-body-medication input, .medical-body-medication select').prop('disabled', false);

         // Enable the Add Medication button
         $('#add-medication-btn').css('pointer-events', 'auto').css('opacity', '1');

         // Enable the buttons
         $('.save-btn-area-of-medication, .close-btn-area-of-medication').css({
            'pointer-events': 'auto',
            'opacity': '1'
         }).prop('disabled', false);


      });

      $('#add-medication-btn').on('click', function(e) {
         e.preventDefault();

         // Clone the form row(s) above the Add Medication button
         var formToClone = $('#medication-forms-container .medication-form:first').clone(true);

         // Remove the specific hidden input with name form 'id'
         formToClone.find('input[type="hidden"][name="id"]').remove();

         // Generate a new unique ID for the cloned form
         var newFormId = $('#medication-forms-container .medication-form').length + 1;
         formToClone.attr('data-form-id', newFormId);

         // Reset form fields
         formToClone.find('input').not('input[type="hidden"]').not(':checkbox').val(''); // Reset all inputs except checkboxes
         formToClone.find('input[type="checkbox"]').prop('checked', false); // Uncheck all checkboxes
         formToClone.find('select').prop('selectedIndex', 0); // Reset all selects

         // Retain checkbox values (if needed, update this part according to your logic)
         var checkboxValues = ['6:00', '12:00', '18:00', '24:00'];
         formToClone.find('input[type="checkbox"]').each(function(index) {
            $(this).val(checkboxValues[index]);
         });

         // Enable save and close buttons
         formToClone.find('.save-btn-area-of-medication, .close-btn-area-of-medication').css({
            'pointer-events': 'auto',
            'opacity': '1'
         }).prop('disabled', false);

         // Insert the cloned form at the bottom of the medication forms container
         $('#medication-forms-container').append(formToClone);
      });

      // Save button click event
      $(document).on('click', '.save-btn-area-of-medication', function(e) {
         e.preventDefault();
         var form = $(this).closest('form');
         var formData = new FormData(form[0]); // Create FormData object from the form
         var isUpdate = formData.get('id'); // Check if the form has an ID for updating

         // Determine the action text (save or update)
         var actionText = isUpdate ? 'update' : 'save';

         // Show confirmation dialog
         Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${actionText} this medication?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
         }).then((result) => {
            if (result.isConfirmed) {
               // User confirmed, proceed with saving or updating

               var url = isUpdate ? '{{ route("update.medication") }}' : '{{ route("save.medication") }}'; // Determine the URL for the AJAX request

               // Append CSRF token to FormData
               var csrfToken = $('meta[name="csrf-token"]').attr('content');
               formData.append('_token', csrfToken);

               $.ajax({
                  url: url, // The URL for the AJAX request
                  method: 'POST',
                  data: formData,
                  contentType: false, // Required for FormData
                  processData: false, // Required for FormData
                  success: function(response) {
                     if (!isUpdate) {
                        // If it's a new row, add the ID to the form
                        form.append('<input type="hidden" name="id" value="' + response.id + '">');
                     }

                     // Display success alert
                     Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                     });
                  },
                  error: function(xhr) {
                     // Display error alert
                     Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error saving medication! ' + (xhr.responseJSON.message || ''),
                        confirmButtonText: 'OK'
                     });
                  }
               });
            } else {
               // User canceled, no action taken
               Swal.fire({
                  icon: 'info',
                  title: 'Cancelled',
                  text: 'Your medication update was not saved.',
                  confirmButtonText: 'OK'
               });
            }
         });
      });

      // Delete medication click event   
      $(document).on('click', '.close-btn-area-of-medication', function(e) {
         e.preventDefault();

         var form = $(this).closest('form');
         var medicationId = form.find('input[name="id"]').val(); // Adjust if ID is stored differently

         Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
         }).then((result) => {
            if (result.isConfirmed) {
               if (medicationId) {
                  // Existing row - send AJAX request to delete from the database
                  $.ajax({
                     url: '{{ route("delete.medication") }}', // Check this URL is correct
                     method: 'POST',
                     data: {
                        id: medicationId,
                        _token: '{{ csrf_token() }}' // Ensure CSRF token is included
                     },
                     success: function(response) {
                        if (response.success) {
                           Swal.fire(
                              'Deleted!',
                              'The medication has been deleted.',
                              'success'
                           );
                           form.remove(); // Remove the row from the DOM
                        } else {
                           Swal.fire(
                              'Error!',
                              'Error: ' + response.message,
                              'error'
                           );
                        }
                     },
                     error: function(xhr) {
                        Swal.fire(
                           'Error!',
                           'Error deleting medication!',
                           'error'
                        );
                     }
                  });
               } else {
                  // New row - just remove the row from the DOM
                  form.remove();
               }
            }
         });
      });
      /* Script of area of medication section End */

      /* Script of monitoring frequency section Start */
      $(document).on('click', '#edit-btn-monitoring-frequency', function(e) {
         e.preventDefault();

         // Find the form in the same section as the clicked edit button
         const form = $(this).closest('.medical-conditions').find('form');

         // Enable all inputs and selects in the form
         form.find('input, select').prop('disabled', false);

         // Enable the save and close buttons
         form.find('.save-btn-monitoring-frequency, .close-btn-monitoring-frequency')
            .css({
               'pointer-events': 'auto',
               'opacity': '1'
            })
            .prop('disabled', false);
      });


      $(document).on('click', '.save-btn-monitoring-frequency', function(e) {
         e.preventDefault();

         Swal.fire({
            title: 'Confirmation',
            text: 'Do you want to save this monitoring frequency?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'No, cancel!',
         }).then((result) => {
            if (result.isConfirmed) {
               var form = $(this).closest('form');
               var formData = new FormData(form[0]);
               var url = '{{ route("save.monitoring_frequency") }}';

               formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

               $.ajax({
                  url: url,
                  method: 'POST',
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {
                     form.append('<input type="hidden" name="id" value="' + response.id + '">');
                     Swal.fire('Saved!', response.message, 'success');
                  },
                  error: function(xhr) {
                     Swal.fire('Error!', 'Error saving monitoring frequency!', 'error');
                  }
               });
            }
         });
      });

      /* Script of monitoring frequency section End */
   });
</script>
@endsection