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
            <h3>{{ __('facility.Medical Facilities')}}</h3>
            <a href="javascript:void(0)" onclick="addMedicalFecility()" class="btn btn-primary">{{ __('facility.Add Facility')}}</a>
        </div>
        <div class="box-out mb-5">
            <div class="cust-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('facility.Facility ID')}}</th>
                            <th>{{ __('facility.Facility Name')}}</th>
                            <th>{{ __('facility.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medications as $medication)
                        <tr>
                            <td><a href="#" data-bs-toggle="collapse" data-bs-target="#demo{{$medication->id}}" class="accordion-toggle"><i class="fa fa-plus"></i></a></td>
                            <td>{{$medication->facility_id}}</td>
                            <td>{{$medication->facility_name}}</td>
                            <!-- <td>{{$medication->doctors}}</td>
                            <td>{{$medication->patients}}</td> -->
                            <td>
                                <a href="javascript:void(0)" onclick="updateMedicalFecility('{{$medication->id}}',`{{$medication->facility_id}}`,`{{$medication->facility_name}}`,`{{$medication->facility_drs}}`,`{{$medication->facility_patients}}`,`{{$medication->lang}}`)"><i class="fa-regular fa-pen"></i></a>
                                <a href="#" onclick="deleteMedicalFecility('{{$medication->id}}')" class="ms-2"><i class="fa-regular fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="hiddenRow">
                                <div class="accordian-body sub_sec_acc ps-4 pe-4 pb-4 collapse" id="demo{{$medication->id}}">
                                    <div class="p-4 pb-0">
                                        <h4>{{ __('facility.Doctors')}}</h4>
                                    </div>
                                    <table class="table sub_table">
                                            <tr>
                                                <th>{{ __('facility.First Name')}}</th>
                                                <th>{{ __('facility.Last Name')}}</th>
                                                <th>{{ __('facility.Doctor ID')}}</th>
                                            </tr>
                                            @foreach($medication->doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor->firstname}}</td>
                                                <td>{{ $doctor->lastname}}</td>
                                                <td>{{ $doctor->doctor_id}}</td>
                                            </tr>
                                            @endforeach
                                    </table>
                                    <div class="p-4 pb-0">
                                        <h4>{{ __('facility.Patients')}}</h4>
                                    </div>
                                    <table class="table sub_table">
                                            <tr>
                                                <th>{{ __('facility.First Name')}}</th>
                                                <th>{{ __('facility.Last Name')}}</th>
                                                <th>{{ __('facility.Patient ID')}}</th>
                                            </tr>
                                            @foreach($medication->patients as $patient)
                                            <tr>
                                                <td>{{ $patient->first_name}}</td>
                                                <td>{{ $patient->last_name}}</td>
                                                <td>{{ $patient->patient_id}}</td>
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
<div class="modal EditPatients" tabindex="-1" role="dialog" id="medicationModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('store.fecility')}}" method="post" class="modal-form">
                @csrf
                <input type="hidden" name="fec_id" id="fec_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="form_title">{{ __('facility.Add Medical Facility')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4 facility_id d-none">
                        <label for="" class="form-label">{{ __('facility.Facility ID')}} *</label>
                        <input type="text" name="facility_id" id="facility_id" required class="form-control" disabled>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Language')}} *</label>
                        <select name="lang" id="lang" class="form-select" required onchange="getPatient(this)">
                            <option value="en" @if(app()->getLocale()=='en') selected @endif>{{ __('symptom.English')}}</option>
                            <option value="sk" @if(app()->getLocale()=='sk') selected @endif>{{ __('symptom.Slovak')}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('facility.Facility Name')}} *</label>
                        <input type="text" name="facility_name" id="facility_name" required class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">{{ __('facility.Doctors')}}:</label>
                        <div class="input-inline">
                            <select class="selectpicker form-control" name="doctor[]" id="doctor" multiple aria-label="Default select example" data-live-search="true">
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id}}">{{$doctor->firstname}} {{$doctor->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label">{{ __('facility.Patients')}}:</label>
                        <div class="input-inline">
                            <select class="selectpicker  form-control" name="patient[]" id="patient" multiple aria-label="Default select example" data-live-search="true">
                                @foreach($patients as $patient)
                                <option value="{{ $patient->id}}" class="{{$patient->lang}} side_lang" @if(app()->getLocale()!=$patient->lang) hidden @endif>{{$patient->first_name}} {{$patient->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="form_btn">{{ __('facility.Add')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('facility.Close')}}</button>
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
    function updateMedicalFecility(id, fecility_id, fecility_name, doctors, patients,lang) {
        var doctorsid = doctors.split(',').map(function(item) {
            return item.trim();
        });
        var patientsid = patients.split(',').map(function(item) {
            return item.trim();
        });
        $('#fec_id').val(id);
        $('#facility_name').val(fecility_name);
        $('#facility_id').val(fecility_id);
        $('#doctor').val(doctorsid);
        $('#patient').val(patientsid);
        $('#lang').val(lang).trigger('change');
        $('.facility_id').removeClass('d-none');
        // Set the value of the Bootstrap Tags Input field
        $('#form_btn').text("{{ __('facility.Update')}}");
        $('#form_title').text("{{ __('facility.Update Medical Facility')}}");
        $('#medicationModal').modal('show');
        $('#doctor').selectpicker('refresh');
        $('#patient').selectpicker('refresh');

    }
    function getPatient(obj){
        $('.side_lang').attr('hidden',true);
        $('.'+$(obj).val()).removeAttr('hidden');
        $('#patient').selectpicker('refresh');
    }
    function addMedicalFecility() {
        $('#fec_id').val('');
        $('#facility_name').val('');
        $('#facility_id').val('');
        $('#doctor').val('');
        $('#patient').val('');
        $('#doctor').selectpicker('refresh');
        $('#patient').selectpicker('refresh');
        $('.facility_id').addClass('d-none');
        // Set the value of the Bootstrap Tags Input field
        $('#form_btn').text("{{ __('facility.Add')}}");
        $('#form_title').text("{{ __('facility.Add Medical Facility')}}");
        $('#medicationModal').modal('show');
    }

    function deleteMedicalFecility(id) {
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
                var url = "{{ route('delete.fecility',':id')}}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        })
    }
</script>
@endsection