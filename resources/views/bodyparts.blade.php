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
            <h3>{{ __('bodypart.Body Parts')}}</h3>
            <a href="javascript:void(0)" onclick="addBodypart()" class="btn btn-primary">{{ __('bodypart.Add BodyPart')}}</a>
        </div>
        <div class="box-out mb-5">
            <div class="cust-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="20%">{{ __('symptom.Title')}}</th>
                            <th width="20%">{{ __('symptom.Value')}}</th>
                            <th width="50%">{{ __('symptom.Synonyms')}}</th>
                            <th width="10%">{{ __('symptom.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bodyparts as $bodypart)
                        <tr>
                            <td width="20%">{{$bodypart->title}}</td>
                            <td width="20%">{{$bodypart->value}}</td>
                            <td width="50%">{{$bodypart->synonyms}}</td>
                            <td width="10%">
                                <a href="javascript:void(0)" onclick="updateBodypart('{{$bodypart->id}}','{{$bodypart->title}}','{{$bodypart->value}}','{{$bodypart->synonyms}}')"><i class="fa-regular fa-pen"></i></a>
                                <a href="#" onclick="deleteBodypart('{{$bodypart->id}}')"><i class="fa-regular fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<div class="modal EditPatients" tabindex="-1" role="dialog" id="bodypartModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('store.bodyparts')}}" method="post" class="modal-form">
                @csrf
                <input type="hidden" name="bodypart_id" id="bodypart_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="form_title">{{ __('symptom.Add BodyPart')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Language')}} *</label>
                        <select name="lang" id="lang" class="form-select">
                            <option value="en" @if(app()->getLocale()=='en') selected @endif>{{ __('symptom.English')}}</option>
                            <option value="sk" @if(app()->getLocale()=='sk') selected @endif>{{ __('symptom.Slovak')}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{__('symptom.Title')}} *</label>
                        <input type="text" name="title" id="title" required class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{__('symptom.Value')}} *</label>
                        <input type="text" name="value" id="value" required class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{__('symptom.Synonyms')}} *</label>
                        <input type="text" name="synonyms" id="synonyms" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="form_btn">{{__('symptom.Add')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('symptom.Close')}}</button>
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
    function updateBodypart(id, title, value, synonyms) {
        $('#bodypart_id').val(id);
        $('#title').val(title);
        $('#value').val(value);
        // Set the value of the Bootstrap Tags Input field
        $('#synonyms').tagsinput('add', synonyms);
        $('#form_btn').text("{{ __('bodypart.Update')}}");
        $('#form_title').text("{{ __('bodypart.Update BodyPart')}}");
        $('#bodypartModal').modal('show');
    }

    function addBodypart() {
        $('#bodypart_id').val('');
        $('#bodypart').val(0);
        $('#title').val('');
        $('#value').val('');
        // Set the value of the Bootstrap Tags Input field
        $('#synonyms').tagsinput('removeAll');
        $('#form_btn').text("{{ __('symptom.Add')}}");
        $('#form_title').text("{{ __('bodypart.Add BodyPart')}}");
        $('#bodypartModal').modal('show');
    }

    function deleteBodypart(id) {
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
                var url = "{{ route('delete.bodyparts',':id')}}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        })
    }
    $(document).ready(function() {
        $('input[name="synonyms"]').tagsinput({
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