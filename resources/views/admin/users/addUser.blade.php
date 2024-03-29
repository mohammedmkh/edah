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
                                <h3 class="mb-0">{{ __('Add User') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ url('panel/Customer') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{url('panel/Customer')}}" autocomplete="off"  enctype="multipart/form-data">
                            @csrf




                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required>

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                            <label class="form-control-label " for="input-image">{{ __('Image') }}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input read-image" name="image" id="image">
                                                <label class="custom-file-label" for="image">Select file</label>
                                            </div>
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('image') }}</strong>
                                                        </span>
                                            @endif

                                        </div>

                                    </div>
                                    <div class="col-2">
                                        <img class=" avatar-lg round-5 view-image" style="width: 100%;height: 90px;" src="{{url('images/upload/user.png')}}">
                                    </div>
                                </div>
                                {{--                    <div class="form-group{{ $errors->has('dateOfBirth') ? ' has-danger' : '' }}">
                                                            <label class="form-control-label" for="input-dateOfBirth">{{ __('Date of Birth') }}</label>
                                                            <input type="date" name="dateOfBirth" id="input-dateOfBirth" class="form-control form-control-alternative{{ $errors->has('dateOfBirth') ? ' is-invalid' : '' }}" placeholder="{{ __('Date Of Birth') }}" value="{{ old('dateOfBirth') }}">
=======

                                             {{--
                                      <div class="form-group{{ $errors->has('dateOfBirth') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-dateOfBirth">{{ __('Date of Birth') }}</label>
                                                <input type="date" name="dateOfBirth" id="input-dateOfBirth" class="form-control form-control-alternative{{ $errors->has('dateOfBirth') ? ' is-invalid' : '' }}" placeholder="{{ __('Date Of Birth') }}" value="{{ old('dateOfBirth') }}">


                                                            @if ($errors->has('dateOfBirth'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                                                </span>
                                                            @endif
                                                    </div>--}}





                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" value="" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                    @endif
                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
