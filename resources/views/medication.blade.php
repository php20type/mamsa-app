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

    .autocomplete-wrapper {
        position: relative;
    }

    .autocomplete-list {
        border: 1px solid #ddd;
        background: #fff;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        width: 100%;
        z-index: 1000;
        display: none;
    }

    .autocomplete-list .autocomplete-item {
        padding: 10px;
        cursor: pointer;
    }

    .autocomplete-list .autocomplete-item:hover {
        background-color: #f0f0f0;
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
            <h3>{{ __('medication.Medications')}}</h3>
            <a href="javascript:void(0)" onclick="addMedication()" class="btn btn-primary">{{ __('medication.Add Medication')}}</a>
        </div>
        <div class="box-out mb-5">
            <div class="cust-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('medication.Med Name')}}</th>
                            <th>{{ __('medication.Med ID')}}</th>
                            <th>{{ __('medication.Med Form')}}</th>
                            <th>{{ __('medication.Med Form Look')}}</th>
                            <th>{{ __('medication.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medications as $medication)
                        <tr>
                            <td>{{$medication->med_name}}</td>
                            <td>{{$medication->med_id}}</td>
                            <td>{{$medication->med_form}}</td>
                            <td>{{$medication->med_form_look}}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="updateMedication('{{$medication->id}}',`{{$medication->med_name}}`,`{{$medication->med_id}}`,`{{$medication->med_form}}`,`{{$medication->med_form_look}}`,`{{$medication->med_pack_look}}`,`{{$medication->med_contraindications}}`,`{{$medication->med_sideeffects}}`,`{{$medication->lang}}`)"><i class="fa-regular fa-pen"></i></a>
                                <a href="#" onclick="deleteMedication('{{$medication->id}}')" class="ms-2"><i class="fa-regular fa-trash"></i></a>
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
            <form action="{{ route('store.medication')}}" method="post" class="modal-form">
                @csrf
                <input type="hidden" name="medication_id" id="medication_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="form_title">{{ __('medication.Add Medication')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('symptom.Language')}} *</label>
                        <select name="lang" id="lang" class="form-select" required onchange="getSideeffects(this)">
                            <option value="en" @if(app()->getLocale()=='en') selected @endif>{{ __('symptom.English')}}</option>
                            <option value="sk" @if(app()->getLocale()=='sk') selected @endif>{{ __('symptom.Slovak')}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('medication.Med Name')}} *</label>
                        <input type="text" name="med_name" id="med_name" required class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('medication.Med Form')}} </label>
                        <input type="text" name="med_form" id="med_form" class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('medication.Med Form Look')}}</label>
                        <input type="text" name="med_form_look" id="med_form_look" class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('medication.Med Pack Look')}}</label>
                        <input type="text" name="med_pack_look" id="med_pack_look" class="form-control">
                    </div>
                    <!-- <div class="form-group mb-4">
                        <label for="" class="form-label">Med Contraindications</label>
                        <input list="browsers" name="med_contraindications" id="med_contraindications" class="form-control" oninput="filterSuggestions()" autocomplete="off">
                        <div id="suggestions" class="autocomplete-list"></div>
                       
                    </div> -->
                    <div class="form-group mb-4">
                        <label for="" class="form-label">{{ __('medication.Med Sideeffects')}}</label>
                        <div class="input-inline">
                            <select class="selectpicker" name="med_sideeffects[]" id="med_sideeffects" multiple aria-label="Default select example" data-live-search="true">
                                @foreach($sideeffect as $side)
                                <option value="{{$side->title}}" class="{{$side->lang}} side_lang" @if(app()->getLocale()!=$side->lang) hidden @endif>{{$side->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- <input list="browsers" name="med_sideeffects" id="med_sideeffects" class="form-control" oninput="filterSuggestions()" autocomplete="off">
                        <div id="suggestions" class="autocomplete-list"></div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="form_btn">{{ __('medication.Add')}}</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('medication.Close')}}</button>
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
    function updateMedication(id, med_name, med_id, med_form, med_form_look, med_pack_look, med_contraindications, med_sideeffects,lang) {
        $('#medication_id').val(id);
        $('#med_name').val(med_name);
        $('#med_form').val(med_form);
        $('#med_form_look').val(med_form_look);
        $('#med_pack_look').val(med_pack_look);
        $('#lang').val(lang).trigger('change');
        // $('#med_contraindications').val(med_contraindications);
        var medsideeffects = med_sideeffects.split(',').map(function(item) {
            return item.trim();
        });
        $('#med_sideeffects').val(medsideeffects);
        $('#med_sideeffects').selectpicker('refresh');
        // Set the value of the Bootstrap Tags Input field
        $('#form_btn').text("{{ __('medication.Update')}}");
        $('#form_title').text("{{ __('medication.Update Medication')}}");
        $('#medicationModal').modal('show');

    }
    function getSideeffects(obj){
        $('.side_lang').attr('hidden',true);
        $('.'+$(obj).val()).removeAttr('hidden');
        $('#med_sideeffects').selectpicker('refresh');
    }
    function addMedication() {
        $('#medication_id').val('');
        $('#med_name').val('');
        $('#med_form').val('');
        $('#med_form_look').val('');
        $('#med_pack_look').val('');
        // $('#med_contraindications').val('');
        $('#med_sideeffects').val('');

        // Set the value of the Bootstrap Tags Input field
        $('#form_btn').text("{{ __('medication.Add')}}");
        $('#form_title').text("{{ __('medication.Add Medication')}}");
        $('#medicationModal').modal('show');
    }

    function deleteMedication(id) {
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
                var url = "{{ route('delete.medication',':id')}}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        })
    }

    const suggestions = <?php echo json_encode($sideeffect); ?>;

    function filterSuggestions() {
        const input = document.getElementById('med_sideeffects');
        const suggestionBox = document.getElementById('suggestions');
        const value = input.value.toLowerCase();

        suggestionBox.innerHTML = '';

        if (value.length === 0) {
            suggestionBox.style.display = 'none';
            return;
        }

        const filteredSuggestions = suggestions.filter(suggestion =>
            suggestion.toLowerCase().includes(value)
        );

        if (filteredSuggestions.length === 0) {
            suggestionBox.style.display = 'none';
            return;
        }

        filteredSuggestions.forEach(suggestion => {
            const div = document.createElement('div');
            div.classList.add('autocomplete-item');
            div.innerHTML = suggestion;
            div.addEventListener('click', () => {
                input.value = suggestion;
                suggestionBox.innerHTML = '';
                suggestionBox.style.display = 'none';
            });
            suggestionBox.appendChild(div);
        });

        suggestionBox.style.display = 'block';
    }
</script>
@endsection