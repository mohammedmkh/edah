@extends('admin.master', ['title' => __('Add Question')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Question') ,
        'headerData' => __('Question') ,
        'url' => 'GroceryQuestion' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card form-card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add Question') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ url(adminPath().'Question') }}"
                                   class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <form method="post" action="{{url(adminPath().'Question')}}" autocomplete="off"
                              enctype="multipart/form-data" id="thisForm">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Question Detail') }}</h6>


                            <div class="row">

                                <div class="col-12">

                                    @foreach($languages as $lang)

                                        <div
                                            class="form-group{{ $errors->has('name.*') ? ' has-danger' : '' }}">

                                            <label class="form-control-label"
                                                   for="input-name">{{ __('Question')  .'  '.$lang->name }}</label>
                                            <input type="text" name="name[{{$lang->id}}]" id="input-name"
                                                   class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Name') }}"
                                                   value="{{ old('name.'.$lang->id) }}" required autofocus>
                                            @if ($errors->has('name.'.$lang->id))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name.'.$lang->id) }}</strong>
                                                             </span>
                                            @endif
                                        </div>

                                    @endforeach
                                        <br>

                                    @foreach($languages as $lang)


                                        <div class="form-group{{ $errors->has('option.*') ? ' has-danger' : '' }}">

                                            <label class="form-control-label"
                                                   for="input-name">{{ __('Option') .'  '.$lang->name }}</label>

                                            <input type="text" name="option[]"
                                                   class="form-control option form-control-alternative{{ $errors->has('option') ? ' is-invalid' : '' }}"
                                                   placeholder="{{ __('Option') }}"
                                                   value="{{ old('option.'.$lang->id) }}" required autofocus>
                                            @if ($errors->has('name.'.$lang->id))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('option.'.$lang->id) }}</strong>
                                                             </span>
                                            @endif

                                        </div>
                                    @endforeach
                                        <br>

                                        <button type="button" class="btn addButton btn-success mt-1">+</button>

                                        <div style="display: none; " class="form-groupp" id="optionTemplate">
                                        @foreach($languages as $lang)


                                            <div
                                                 class="form-groupp form-group{{ $errors->has('option.*') ? ' has-danger' : '' }}">

                                                <label class="form-control-label"
                                                       for="input-name">{{ __('Option') .'  '.$lang->name }}</label>

                                                <input type="text" name="option[]"
                                                       class="form-control option form-control-alternative{{ $errors->has('option') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('Option') }}"
                                                       value="{{ old('option.'.$lang->id) }}" required autofocus>
                                                @if ($errors->has('name.'.$lang->id))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('option.'.$lang->id) }}</strong>
                                                             </span>
                                                @endif

                                            </div>
                                        @endforeach
                                        <button type="button" class="btn removeButton btn-success mt-1"
                                        >-
                                        </button>

                                    </div>
                                </div>
                            </div>


                            <div class="pl-lg-4">


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4"
                                            id="addbutton">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('java_script')
    <script>


        $('#addbutton').click(function () {
            var error = 0;
            var msg = 'An Error Has Occured.\n\nRequired Fields missed are :\n';
            $(':input[required]').each(function () {
                $(this).css('border', '1px solid rgb(202, 209, 215)');
                if ($(this).attr('type') == 'file') {
                    $(this).attr('placeholder', 'Placeholder text');
                    $(this).close('label').attr('border', '19px solid rgb(202, 209, 215)');
                    console.log('error file input');
                }


                if ($(this).val() == '') {
                    msg += '\n' + $(this).attr('id') + ' Is A Required Field..';
                    $(this).css('border', '1px solid red');
                    if (error == 0) {
                        $(this).focus();
                    }
                    error = 1;
                }
            });


            if (error == 1) {
                var id = $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');

                // Find the link that corresponds to the pane and have it show
                console.log('the id is' + id);
                $('.nav a[href="#' + id + '"]').tab('show');

                // Only want to do it once
                return false;
            }
        });
        $('#thisForm').bootstrapValidator({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                'option[]': {
                    // The receipt is placed inside a .col-xs-6 element
                    row: '.col-xs-6',
                    validators: {
                        notEmpty: {
                            message: 'هذا الحقل مطلوب'
                        }
                    }
                },

            }
        })
            .on('added.field.bv', function (e, data) {

                if (data.field === 'fk_customer[]') {

                    data.element.select2({
                        placeholder: 'الإسم',
                        minimumInputLength: 3,
                        allowClear: true,
                        ajax: {
                            url: cus_search,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.cs_name,
                                            id: item.pk_id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });

                }
            })

            // Add button click handler
            .on('click', '.addButton', function () {
                var $template = $('#optionTemplate'),
                    $clone = $template
                        .clone()
                        .show('hide')
                        .removeAttr('id')
                        .addClass('removeFields')
                        .insertBefore($template)
                // Add new fields
                // Note that we DO NOT need to pass the set of validators
                // because the new field has the same name with the original one
                // which its validators are already set
                $('#thisForm')
                    .bootstrapValidator('addField', $clone.find('.option'))


            })

            // Remove button click handler
            .on('click', '.removeButton', function () {
                var $row = $(this).closest('.form-groupp');

                // Remove fields
                $('#thisForm')

                    .bootstrapValidator('removeField', $row.find('.option'))


                // Remove element containing the fields
                $row.remove();
            });

    </script>

@endsection
