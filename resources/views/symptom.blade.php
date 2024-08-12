@extends('layouts.admin')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css" integrity="sha512-OWGg8FcHstyYFwtjfkiCoYHW2hG3PDWwdtczPAPUcETobBJOVCouKig8rqED0NMLcT9GtE4jw6IT1CSrwY87uw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" rel="stylesheet" />
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
            <h3>{{ __('symptom.Symptoms')}}</h3>
            <a href="javascript:void(0)" onclick="addSymptoms()" class="btn btn-primary">{{ __('symptom.Add Symptoms')}}</a>
        </div>
        <div class="box-out mb-5">
            <div class="cust-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('symptom.Title')}}</th>
                            <th class="w-150px">{{ __('symptom.Synonyms')}}</th>
                            <th>{{ __('symptom.Body Part')}}</th>
                            <th>{{ __('symptom.Emg.')}}</th>
                            <th>{{ __('symptom.Category')}}</th>
                            <th>{{ __('symptom.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($symptoms as $symptom)
                        <tr>
                            <td>{{$symptom->title}}</td>
                            <td>{{$symptom->synonyms}}</td>
                            <td>@if($symptom->bodypart==1) Yes @else No @endif</td>
                            <td>@if($symptom->emergency==1) Yes @else No @endif</td>
                            <td>{{$symptom->category}}</td>
                            <td><a href="javascript:void(0)" onclick="updateSymptoms('{{$symptom->id}}','{{$symptom->title}}','{{$symptom->value}}','{{$symptom->bodypart}}','{{$symptom->synonyms}}','{{$symptom->category}}','{{$symptom->emergency}}','{{$symptom->lang}}')"><i class="fa-regular fa-pen"></i></a>
                                <a href="#" onclick="deleteSymptoms('{{$symptom->id}}')" class="ms-2"><i class="fa-regular fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="modal EditPatients" tabindex="-1" role="dialog" id="symptomsModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('store.symptoms')}}" method="post" class="modal-form">
                @csrf
                <input type="hidden" name="symptom_id" id="symptom_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="form_title">{{ __('symptom.Add Symptom')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Language')}} *</label>
                        <select name="lang" id="lang" class="form-select" required>
                            <option value="en" @if(app()->getLocale()=='en') selected @endif>{{ __('symptom.English')}}</option>
                            <option value="sk" @if(app()->getLocale()=='sk') selected @endif>{{ __('symptom.Slovak')}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Title')}} *</label>
                        <input type="text" name="title" id="title" required class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Value')}} *</label>
                        <input type="text" name="value" id="value" required class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Body Part')}}</label>
                        <select name="bodypart" id="bodypart" class="form-control">
                            <option value="0">{{ __('symptom.No')}}</option>
                            <option value="1">{{ __('symptom.Yes')}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Category')}} *</label>
                        <select name="category" id="category" class="form-control">
                            <option value="Respiratory system">{{ __('symptom.Respiratory system')}}</option>
                            <option value="Digestive system/excretory system">{{ __('symptom.Digestive system/excretory system')}}</option>
                            <option value="Integumentary system">{{ __('symptom.Integumentary system')}}</option>
                            <option value="Eyes">{{ __('symptom.Eyes')}}</option>
                            <option value="Sickness">{{ __('symptom.Sickness')}}</option>
                            <option value="Mental">{{ __('symptom.Mental')}}</option>
                            <option value="Circulatory system">{{ __('symptom.Circulatory system')}}</option>
                            <option value="Urinary system">{{ __('symptom.Urinary system')}}</option>
                            <option value="Skeletal system">{{ __('symptom.Skeletal system')}}</option>
                            <option value="Muscular system">{{ __('symptom.Muscular system')}}</option>
                            <option value="Endocrine system">{{ __('symptom.Endocrine system')}}</option>
                            <option value="Lymphatic system">{{ __('symptom.Lymphatic system')}}</option>
                            <option value="Nervous system">{{ __('symptom.Nervous system')}}</option>
                            <option value="Reproductive system">{{ __('symptom.Reproductive system')}}</option>
                            <option value="Other">{{ __('symptom.Other')}}</option>
                            <option value="Emergency">{{ __('symptom.Emergency')}}</option>


                            
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Synonyms')}} *</label>
                        <input type="text" name="symptoms" id="symptoms" required class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Emergency')}}</label>
                        <select name="emergency" id="emergency" class="form-control">
                            <option value="0">{{ __('symptom.No')}}</option>
                            <option value="1">{{ __('symptom.Yes')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="form_btn">{{ __('symptom.Add')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('symptom.Close')}}</button>
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
<script>
    function updateSymptoms(id, title, value, bodypart, synonyms, category, emergency,lang) {
        $('#symptom_id').val(id);
        $('#title').val(title);
        $('#value').val(value);
        $('#category').val(category);
        $('#emergency').val(emergency);
        $('#lang').val(lang);
        // Set the value of the Bootstrap Tags Input field
        $('#symptoms').tagsinput('add', synonyms);
        $('#bodypart').val(bodypart);
        $('#form_btn').text("{{ __('bodypart.Update')}}");
        $('#form_title').text("{{__('symptom.Update Symptoms')}}");
        $('#symptomsModal').modal('show');
    }

    function addSymptoms() {
        $('#symptom_id').val('');
        $('#bodypart').val(0);
        $('#title').val('');
        $('#value').val('');
        // Set the value of the Bootstrap Tags Input field
        $('#symptoms').tagsinput('removeAll');
        $('#form_btn').text('Add');
        $('#form_title').text("{{__('symptom.Add Symptoms')}}");
        $('#symptomsModal').modal('show');
    }

    function deleteSymptoms(id) {
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
                var url = "{{ route('delete.symptoms',':id')}}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        })
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
</script>
@endsection