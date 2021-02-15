@extends('admin.master', ['class' => 'bg-default'])

@section('content')
    @include('layouts.guestHeader')
    <div class="container mt--9 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-transparent pb-4">
                        
                        <div class="btn-wrapper text-center">
                            <h2 class="text-muted pt-4" style="font-size:22px;">Renew Licence</h2>
                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="POST" action="{{ url('activeLicence') }}">
                            @csrf                                
                                <div class="form-group{{ $errors->has('license_code') ? ' has-danger' : '' }}">                                            
                                    <label class="form-control-label" for="input-license_code">{{ __('License code') }}</label>
                                    <input type="text" name="license_code" id="input-license_code" class="form-control form-control-alternative{{ $errors->has('license_code') ? ' is-invalid' : '' }}" placeholder="{{ __('License code') }}" required autofocus>
                                    @if ($errors->has('license_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('license_code') }}</strong>
                                        </span>
                                    @endif
                                    @if(Session::has('error_msg'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{Session::get('error_msg')}}</strong>
                                        </span>  
                                    @endif                                                    
                                </div>
                                
                              

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">                                            
                                <label class="form-control-label" for="input-name">{{ __('Your name') }}</label>
                                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Your Name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">                           
                            </div>
                            <div class="text-center login-btn">
                                <button type="submit" class="btn btn-primary my-4"> {{ __('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
               
                </div>
            </div>
        </div>
    </div>
@endsection
