@extends('layouts.admin')
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
            <h3>Patients</h3>
            <a href="javascript:void(0)" onclick="addPatient()" class="btn btn-primary">Add Patient</a>
        </div>
        <div class="box mb-5">
            <form class="search-form" accept="" method="get" action="{{ route('patients')}}">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" id="search" placeholder="Type..." class="form-control" value="{{ $search}}" />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">Medical Facility</label>
                            <select class="form-select" name="facility" id="facility" aria-label="Default select example">
                                <option value="">--Select Option--</option>
                                @foreach($facilities as $facility)
                                <option value="{{$facility->id}}" @if($facility->id==$facility_id) selected @endif>{{$facility->facility_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">Doctor</label>
                            <select class="form-select" name="doctor" id="doctor" aria-label="Default select example">
                                <option value="">--Select Option--</option>
                                @foreach($doctors as $doctor)
                                <option value="{{$doctor->id}}" @if($doctor->id==$doctor_id) selected @endif>{{$doctor->firstname}} {{$doctor->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <button class="btn btn-primary w-100 search-btn">Search</button>
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
                            <th>Patient ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Frequency</th>
                            <th>Action</th>
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
                                        <label class="form-check-label" for="inlineCheckbox1">Mon</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox1" data-id="{{ $patient->id }}" data-day="0" @if(isset($frequency[0]) && $frequency[0]==1) checked @endif value="option1">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox2">Tue</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox2" data-id="{{ $patient->id }}" data-day="1" @if(isset($frequency[1]) && $frequency[1]==1) checked @endif value="option2">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox3">Wed</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox3" data-id="{{ $patient->id }}" data-day="2" @if(isset($frequency[2]) && $frequency[2]==1) checked @endif value="option3">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox4">Thu</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox4" data-id="{{ $patient->id }}" data-day="3" @if(isset($frequency[3]) && $frequency[3]==1) checked @endif value="option4">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox5">Fri</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox5" data-id="{{ $patient->id }}" data-day="4" @if(isset($frequency[4]) && $frequency[4]==1) checked @endif value="option5">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox6">Sat</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox6" data-id="{{ $patient->id }}" data-day="5" @if(isset($frequency[5]) && $frequency[5]==1) checked @endif value="option6">
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox7">Sun</label>
                                        <input class="form-check-input freq-checkbox" type="checkbox" id="inlineCheckbox7" data-id="{{ $patient->id }}" data-day="6" @if(isset($frequency[6]) && $frequency[6]==1) checked @endif value="option7">
                                    </div>
                                </div>
                            </td>
                            <td><a href="javascript:void(0)" onclick="updatePatient(`{{$patient->id}}`,`{{$patient->patient_id}}`,`{{$patient->first_name}}`,`{{$patient->last_name}}`,`{{$patient->phone_number}}`,`{{$patient->doctor_ids}}`,`{{$patient->facility_ids}}`,`{{$patient->preferred_time_from}}`,`{{$patient->preferred_time_to}}`,`{{$patient->frequency}}`)"><i class="fa-regular fa-pen"></i></a>
                                <a href="#" class="ms-2" onclick="deletePatient('{{$patient->id}}')"><i class="fa-regular fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="hiddenRow">
                                <div class="accordian-body collapse" id="demo{{$patient->id}}">
                                    <div class="p-4 pb-0">
                                        <h4>Doctors</h4>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Doctor ID</th>
                                        </tr>
                                        @foreach($patient->doctors as $doctor)
                                        <tr>
                                            <td>{{ $doctor->firstname}}</td>
                                            <td>{{ $doctor->lastname}}</td>
                                            <td>{{ $doctor->doctor_id}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    <div class="p-4 pb-0">
                                        <h4>Facilities</h4>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th>Facility Name</th>
                                            <th>Facility ID</th>
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


@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.js" integrity="sha512-FbWDiO6LEOsPMMxeEvwrJPNzc0cinzzC0cB/+I2NFlfBPFlZJ3JHSYJBtdK7PhMn0VQlCY1qxflEG+rplMwGUg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

<script>

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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.freq-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                let patientId = this.getAttribute('data-id');
                let dayIndex = this.getAttribute('data-day');
                let checked = this.checked ? 1 : 0;

                // Prepare data to be sent to the server
                let data = {
                    patient_id: patientId,
                    day_index: dayIndex,
                    checked: checked,
                    _token: '{{ csrf_token() }}' // Ensure CSRF token is included for Laravel
                };

                // Send AJAX request to update the frequency
                fetch('/update-frequency', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Frequency updated successfully.');
                        } else {
                            console.error('Failed to update frequency.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>
@endsection