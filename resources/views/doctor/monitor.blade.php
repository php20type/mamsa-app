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
            <h3>{{ __('monitor.Monitor Conditions')}}</h3>
            <a href="javascript:void(0)" onclick="addMonitorCondition()" class="btn btn-primary">{{ __('monitor.Add Monitor Condition')}}</a>
        </div>

        <div class="box-out mb-5">
            <div class="cust-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('monitor.Patient ID')}}</th>
                            <th>{{ __('monitor.Monitor Condition')}}</th>
                            <th>{{ __('monitor.Medication')}}</th>
                            <th>{{ __('monitor.Dose')}}</th>
                            <th>{{ __('monitor.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monitor_conditions as $condition)
                        <tr>
                            <td>{{ $condition->patient->patient_id}} </td>
                            <td>{{ $condition->symptom->title}} </td>
                            <td>{{ $condition->medications->med_name}} </td>
                            <td>{{ $condition->dose}} </td>
                            <td>
                                <div class="btn-action">
                                    <a href="{{ route('outboundCall',$condition->id)}}"><i class="fa fa-phone"></i></a>
                                    <a href="javascript:void(0)" class="ms-2" onclick="updateMonitorCondition('{{$condition->id}}',`{{$condition->patient_id}}`,`{{$condition->monitor_condition}}`,`{{$condition->medication}}`,`{{$condition->dose}}`,`{{$condition->lang}}`)"><i class="fa-regular fa-pen"></i></a>
                                    <a href="#" onclick="deleteMonitorCondition('{{$condition->id}}')" class="ms-2"><i class="fa-regular fa-trash"></i></a>
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
<div class="modal EditPatients fade" id="MonitorCondition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="form_title">{{ __('monitor.Add Monitor Condition')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="modal-form" method="post" action="{{ route('doctor.store.monitoring')}}">
                <input type="hidden" name="monitor_id" id="monitor_id">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label for="" class="form-label">{{ __('symptom.Language')}} *</label>
                                <select name="lang" id="lang" class="form-select" required onchange="getPatient(this)">
                                    <option value="en" @if(app()->getLocale()=='en') selected @endif>{{ __('symptom.English')}}</option>
                                    <option value="sk" @if(app()->getLocale()=='sk') selected @endif>{{ __('symptom.Slovak')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{ __('monitor.Patient')}}:</label>
                                <select name="patient_id" id="patient_id" class="form-select">
                                    @foreach($patients as $patient)
                                    <option value="{{ $patient->id}}" class="{{$patient->lang}} side_lang" @if(app()->getLocale()!=$patient->lang) hidden @endif>{{ $patient->first_name}} {{ $patient->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{ __('monitor.Monitor Condition')}}:</label>
                                <select name="monitor_condition" id="monitor_condition" class="form-select">
                                    @foreach($symptoms as $symptom)
                                    <option value="{{ $symptom->id}}" class="{{$symptom->lang}} side_lang" @if(app()->getLocale()!=$symptom->lang) hidden @endif>{{ $symptom->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{ __('monitor.Medication')}}:</label>
                                <select name="medication" id="medication" class="form-select">
                                    @foreach($medications as $medication)
                                    <option value="{{ $medication->id}}" class="{{$medication->lang}} side_lang" @if(app()->getLocale()!=$medication->lang) hidden @endif>{{ $medication->med_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label">{{ __('monitor.Medication Use Dose')}}:</label>
                                <input type="text" name="dose" id="dose" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-theme px-5">{{ __('monitor.Save')}}</button>
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
    function addMonitorCondition() {
        $('#patient_id').val('');
        $('#monitor_id').val('');
        $('#monitor_condition').val('');
        $('#medication').val('');
        $('#dose').val('');
        $('#form_title').text("{{ __('monitor.Add Monitor Condition')}}");
        $('#MonitorCondition').modal('show');
    }

    function updateMonitorCondition(id, patient_id, monitor_condition, medication, dose,lang) {
        $('#monitor_id').val(id);
        $('#lang').val(lang).trigger('change');
        $('#patient_id').val(patient_id);
        $('#monitor_condition').val(monitor_condition);
        $('#medication').val(medication);
        $('#dose').val(dose);
        $('#form_title').text("{{ __('monitor.Update Monitor Condition')}}");
        $('#MonitorCondition').modal('show');

    }
    function getPatient(obj){
        $('.side_lang').attr('hidden', true);
        $('.' + $(obj).val()).removeAttr('hidden');
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

    function deleteMonitorCondition(id) {
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
                var url = "{{ route('doctor.delete.monitoring',':id')}}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        })
    }
</script>
@endsection