@extends('layouts.patient')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css">

<style>
    .bootstrap-tagsinput {
        margin: 0;
        width: 100%;
        padding: 0.5rem 0.75rem 0;
        font-size: 1rem;
        line-height: 1.25;
        transition: border-color 0.15s ease-in-out;
    }

    .bootstrap-tagsinput.has-focus {
        background-color: #fff;
        border-color: #5cb3fd;
    }

    .bootstrap-tagsinput .label-info {
        display: inline-block;
        background-color: #636c72;
        padding: 0 0.4em 0.15em;
        border-radius: 0.25rem;
        margin-bottom: 0.4em;
    }

    .bootstrap-tagsinput input {
        margin-bottom: 0.5em;
    }

    .bootstrap-tagsinput .tag [data-role=remove]:after {
        content: "×";
    }

    .close {
        border: none;
        background-color: transparent;
    }

    .bootstrap-tagsinput input {
        width: 100% !important;
    }

    .active .nav-link {
        color: blue;
    }

    .cust-table .table tr td .btn-action a {
        color: #996b57;
    }
</style>
@endsection
@section('content')

<section class="medi-area">
    <div class="container-fluid">
        @if(session()->has('success'))
        <div class="alert alert-success">
            <span>{{session()->get('success')}}</span>
        </div>
        @endif
        <div class="d-flex justify-content-between mb-4">
            <h3>{{ __('patient.Patients')}}</h3>
            <a href="javascript:void(0)" onclick="addPatient()" class="btn btn-primary">{{ __('patient.Add Patient')}}</a>
        </div>
        <div class="box mb-5">
            <form class="search-form" accept="" method="get" action="{{ route('doctor.patients')}}">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">{{ __('patient.Search')}}</label>
                            <input type="text" name="search" id="search" placeholder="Type..." class="form-control" value="{{ $search}}" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">{{ __('patient.Medical Facility')}}</label>
                            <select class="form-select" name="facility" id="facility" aria-label="Default select example">
                                <option value="">--Select Option--</option>
                                @foreach($facilities as $facility)
                                <option value="{{$facility->id}}" @if(app()->getLocale()!=$facility->lang) hidden @endif @if($facility->id==$facility_id && app()->getLocale()==$facility->lang) selected @endif>{{$facility->facility_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex">
                                <button class="btn btn-primary w-100 search-btn me-2">{{ __('patient.Search')}}</button>
                                <a class="btn btn-primary w-100 search-btn" href="{{ route('doctor.patients')}}">{{ __('patient.Clear')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-out mb-5">
            <div class="cust-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('patient.Patient ID')}}</th>
                            <th>{{ __('patient.First Name')}}</th>
                            <th>{{ __('patient.Last Name')}}</th>
                            <th>{{ __('patient.Phone')}}</th>
                            <th>{{ __('patient.Frequency')}}</th>
                            <th>{{ __('patient.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        @php
                        $frequency=explode(',',$patient->frequency);
                        @endphp
                        <tr>
                            <td><a href="#" data-bs-toggle="collapse" data-bs-target="#demo{{$patient->id}}" class="accordion-toggle"><i class="fa fa-plus"></i></a></td>
                            <td>{{$patient->patient_id}}</td>
                            <td>{{$patient->first_name}}</td>
                            <td>{{$patient->last_name}}</td>
                            <td>{{$patient->phone_number}}</td>
                            <td>
                                <div class="check-container">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox1">{{ __('patient.Mon')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox1" data-id="{{ $patient->id }}" data-day="0" @if(isset($frequency[0]) && $frequency[0]==1) checked @endif value="option1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox2">{{ __('patient.Tue')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox2" data-id="{{ $patient->id }}" data-day="1" @if(isset($frequency[1]) && $frequency[1]==1) checked @endif value="option2">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox3">{{ __('patient.Wed')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox3" data-id="{{ $patient->id }}" data-day="2" @if(isset($frequency[2]) && $frequency[2]==1) checked @endif value="option3">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox4">{{ __('patient.Thu')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox4" data-id="{{ $patient->id }}" data-day="3" @if(isset($frequency[3]) && $frequency[3]==1) checked @endif value="option4">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox5">{{ __('patient.Fri')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox5" data-id="{{ $patient->id }}" data-day="4" @if(isset($frequency[4]) && $frequency[4]==1) checked @endif value="option5">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox6">{{ __('patient.Sat')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox6" data-id="{{ $patient->id }}" data-day="5" @if(isset($frequency[5]) && $frequency[5]==1) checked @endif value="option6">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox7">{{ __('patient.Sun')}}</label>
                                        <input class="form-check-input freq-checkbox" disabled type="checkbox" id="inlineCheckbox7" data-id="{{ $patient->id }}" data-day="6" @if(isset($frequency[6]) && $frequency[6]==1) checked @endif value="option7">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-action">
                                    <a href="{{ route('patientDetail',$patient->patient_id)}}"><i class="fa-regular fa-file"></i></a>
                                    <a href="{{ route('editPatient',$patient->id)}}" class="ms-2"><i class="fa-regular fa-pen"></i></a>
                                    <a href="#" class="ms-2" onclick="deletePatient('{{$patient->id}}')"><i class="fa-regular fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="hiddenRow">
                                <div class="accordian-body collapse" id="demo{{$patient->id}}">
                                    <div class="p-4 pb-0">
                                        <h4>{{ __('patient.Facilities') }}</h4>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th>{{ __('patient.Facility Name')}}</th>
                                            <th>{{ __('patient.Facility ID')}}</th>
                                        </tr>
                                        @foreach($patient->facilities as $facility)
                                        <tr>
                                            <td>{{ $facility->facility_name}}</td>
                                            <td>{{ $facility->facility_id}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="modal EditPatients fade" id="EditPatients" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 d-none" id="patient_id_sec">
                <h1 class="modal-title fs-3" id="exampleModalLabel"><strong>{{__('patient.Patient ID')}}:</strong> <span id="patient_id_label"> </span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="modal-form" method="post" action="{{ route('doctor.store.patient')}}">
                <input type="hidden" name="patient_id" id="patient_id">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label for="" class="form-label">{{ __('symptom.Language')}} *</label>
                                <select name="lang" id="lang" class="form-select" required onchange="getFacility(this)">
                                    <option value="en" @if(app()->getLocale()=='en') selected @endif>{{ __('symptom.English')}}</option>
                                    <option value="sk" @if(app()->getLocale()=='sk') selected @endif>{{ __('symptom.Slovak')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.First Name')}}:</label>
                                <input type="text" name="first_name" id="first_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.Last Name')}}:</label>
                                <input type="text" name="last_name" id="last_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.Phone Number')}}:</label>
                                <input type="text" name="phone_number" id="phone_number" required class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.Date Of Birth')}}:</label>
                                <input type="date" name="DOB" id="DOB" required class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.Weight')}}:</label>
                                <input type="text" name="weight" id="weight" required class="form-control">
                            </div>
                        </div>
                        <!-- <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.Medical Facility')}}:</label>
                                <div class="input-inline">
                                    <select class="selectpicker" name="facility_ids[]" id="facility_ids" multiple aria-label="Default select example" data-live-search="true">
                                        @foreach($facilities as $facility)
                                        <option value="{{$facility->id}}" class="{{$facility->lang}} side_lang" @if(app()->getLocale()!=$facility->lang) hidden @endif>{{$facility->facility_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group cust-table mb-4">
                                <label class="form-label">{{__('patient.Frequency')}}:</label>
                                <div class="check-container">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox1">{{ __('patient.Mon')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[0]" id="inlineCheckbox1" value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox2">{{ __('patient.Tue')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[1]" id="inlineCheckbox2" value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox3">{{ __('patient.Wed')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[2]" id="inlineCheckbox3" value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox4">{{ __('patient.Thu')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[3]" id="inlineCheckbox4" value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox5">{{ __('patient.Fri')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[4]" id="inlineCheckbox5" value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox6">{{ __('patient.Sat')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[5]" id="inlineCheckbox6" value="1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox7">{{ __('patient.Sun')}}</label>
                                        <input class="form-check-input" type="checkbox" name="frequency[6]" id="inlineCheckbox7" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label class="form-label">{{__('patient.Preferred Time')}}:</label>
                                <div class="check-container d-flex align-items-center">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label mb-1" for="inlineCheckbox1">{{__('patient.From')}}</label>
                                        <input type="time" name="preferred_time_from" id="preferred_time_from" class="form-control">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label mt-4">-</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label mb-1" for="inlineCheckbox1">{{__('patient.To')}}</label>
                                        <input type="time" name="preferred_time_to" id="preferred_time_to" class="form-control">
                                    </div>
                                    <!-- <div class="form-check form-check-inline">
                                        <label class="form-check-label mb-1" for="inlineCheckbox1">Time Zone</label>
                                        <select class="form-select">
                                            <option value="">Time </option>
                                            <option value="">Time </option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-theme px-5" data-bs-dismiss="modal">{{__('patient.Cancel')}}</button>
                    <button type="submit" class="btn btn-theme px-5">{{__('patient.Save')}}</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

<script>
    function addPatient() {
        $('#patient_id').val('');
        $('#patient_id_label').text('');
        $('#patient_id_sec').addClass('d-none');
        $('#first_name').val('');
        $('#last_name').val('');
        $('#phone_number').val('');
        $('#DOB').val('');
        $('#weight').val('');
        $('#doctor_ids').val('');
        $('#facility_ids').val('');
        $('#preferred_time_from').val('')
        $('#preferred_time_to').val('');
        $('#doctor_ids').selectpicker('refresh');
        $('#facility_ids').selectpicker('refresh');
        $('.form-check-input').prop('checked', false);
        $('#EditPatients').modal('show');
    }
    function getFacility(obj) {
        $('.side_lang').attr('hidden', true);
        $('.' + $(obj).val()).removeAttr('hidden');
        $('#facility_ids').selectpicker('refresh');
    }

    function updatePatient(id, patient_id, first_name, last_name, phone_number, doctor_ids, facility_ids, from_time, to_time, frequency,lang,dob,weight) {
        var doctorsid = doctor_ids.split(',').map(function(item) {
            return item.trim();
        });
        var facilityid = facility_ids.split(',').map(function(item) {
            return item.trim();
        });

        const frequencyArray = frequency.split(',').map(Number);

        // Set the checkboxes based on the array
        for (let i = 0; i < frequencyArray.length; i++) {
            const checkbox = document.querySelector(`input[name='frequency[${i}]']`);
            if (checkbox) {
                checkbox.checked = frequencyArray[i] === 1;
            }
        }

        $('#patient_id').val(id);
        $('#patient_id_label').text(patient_id);
        $('#lang').val(lang).trigger('change');
        $('#patient_id_sec').removeClass('d-none');
        $('#first_name').val(first_name);
        $('#last_name').val(last_name);
        $('#phone_number').val(phone_number);
        $('#DOB').val(dob);
        $('#weight').val(weight);
        $('#doctor_ids').val(doctorsid);
        $('#facility_ids').val(facilityid);
        $('#preferred_time_from').val(from_time)
        $('#preferred_time_to').val(to_time);
        $('#doctor_ids').selectpicker('refresh');
        $('#facility_ids').selectpicker('refresh');
        $('#EditPatients').modal('show');

    }
    $(document).ready(function() {
        $('input[name="symptoms"]').tagsinput({
            trimValue: true,
            confirmKeys: [13, 44],
            focusClass: 'my-focus-class'
        });
        $('.bootstrap-tagsinput input').prop("style", null);
        $('.bootstrap-tagsinput input').on('focus', function() {
            $(this).closest('.bootstrap-tagsinput').addClass('has-focus');
        }).on('blur', function() {
            $(this).closest('.bootstrap-tagsinput').removeClass('has-focus');
        });

    });

    function deletePatient(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('delete.patient',':id')}}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        })
    }
    // document.addEventListener('DOMContentLoaded', function() {
    //     document.querySelectorAll('.freq-checkbox').forEach(function(checkbox) {
    //         checkbox.addEventListener('change', function() {
    //             let patientId = this.getAttribute('data-id');
    //             let dayIndex = this.getAttribute('data-day');
    //             let checked = this.checked ? 1 : 0;

    //             // Prepare data to be sent to the server
    //             let data = {
    //                 patient_id: patientId,
    //                 day_index: dayIndex,
    //                 checked: checked,
    //                 _token: '{{ csrf_token() }}' // Ensure CSRF token is included for Laravel
    //             };

    //             // Send AJAX request to update the frequency
    //             fetch('/update-frequency', {
    //                     method: 'POST',
    //                     headers: {
    //                         'Content-Type': 'application/json',
    //                         'Accept': 'application/json'
    //                     },
    //                     body: JSON.stringify(data)
    //                 })
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     if (data.success) {
    //                         console.log('Frequency updated successfully.');
    //                     } else {
    //                         console.error('Failed to update frequency.');
    //                     }
    //                 })
    //                 .catch(error => {
    //                     console.error('Error:', error);
    //                 });
    //         });
    //     });
    // });
</script>
@endsection