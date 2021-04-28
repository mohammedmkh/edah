@extends('admin.master', ['title' => __('User Management')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add User') ,
        'headerData' => __('Users') ,
        'url' => 'Customer' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card form-card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Notifications') }}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div><br/>
                        @endif
                        <form method="post" action="{{url(adminPath().'notifications')}}" autocomplete="off"
                              enctype="multipart/form-data">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('User Type') }}</label>
                                    <Select name="role" id="role"
                                            class="form-control select2 form-control-alternative" required>
                                        <option value="">{{__('User Type')}}</option>
                                        @foreach($role as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('role') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('user_id[]') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Users') }}</label>
                                    <button type="button" id="selectall"
                                            class="btn btn-success ">{{ __('Select All') }}</button>

                                    <Select multiple name="user_id[]" id="user_id"
                                            class="form-control select2 form-control-alternative" required>
                                        <option value="">{{__('Users')}}</option>

                                    </select>

                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('role') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Title') }}</label>
                                    <input type="text" name="title" id="input-phone"
                                           class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('Title') }}" value="{{ old('title') }}" required>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('body') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Body') }}</label>
                                    <textarea name="body" id="input-phone"
                                              class="form-control form-control-alternative{{ $errors->has('body') ? ' is-invalid' : '' }}"
                                              placeholder="{{ __('Body') }}" value="{{ old('body') }}"
                                              required></textarea>

                                    @if ($errors->has('body'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('body') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                {{--                    <div class="form-group{{ $errors->has('dateOfBirth') ? ' has-danger' : '' }}">
                                                            <label class="form-control-label" for="input-dateOfBirth">{{ __('Date of Birth') }}</label>
                                                            <input type="date" name="dateOfBirth" id="input-dateOfBirth" class="form-control form-control-alternative{{ $errors->has('dateOfBirth') ? ' is-invalid' : '' }}" placeholder="{{ __('Date Of Birth') }}" value="{{ old('dateOfBirth') }}">

                                                            @if ($errors->has('dateOfBirth'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                                                </span>
                                                            @endif
                                                    </div>--}}


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Send') }}</button>
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

    <script type="text/javascript">
        var x = 1;

        $(document.body).on("click", "#selectall", function () {


            if (x === 1) {
                $("#user_id > option").prop("selected", "selected");
                $("#user_id").trigger("change");
                x = 0;
            } else {

                $('#user_id').val("-1").trigger("change");

                x = 1;

            }


        });
        $(document).ready(function () {
            $('#user_id').select2({
                closeOnSelect: false
            });
            $('#role').change(function () {
                var role = $(this).val()
                !!$('#user_id').find('option').not(':first').not('#selectall').remove();


                if (role > 0) {


                    $.ajax({
                        type: "POST",
                        url: '{{url('').'/panel/getUsersByRole'}}',
                        data: {_token: '{{csrf_token()}}', role: role,},


                        success: function (response) {
                            $.each(response, function (i, field) {
                                var newOption = new Option(field.name, field.id, false, false);
                                $('#user_id').append(newOption).trigger('change');
                            });

                        },
                        error: function (error) {

                        }
                    });

                }
                return false;

            });


        });


    </script>
@endsection
