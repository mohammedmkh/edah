@extends('admin.master', ['title' => __('Add Item')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Settings') ,
        'headerData' => __('Settings') ,
        'url' => 'additionalsettings' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Add New Settings') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url(adminPath().'additionalsettings') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url(adminPath().'additionalsettings')}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    
                                    <h6 class="heading-small text-muted mb-4">{{ __('Item Detail') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                                    <input type="text" name="code" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Code') }}" value="{{ old('code') }}" required autofocus>
                                                    @if ($errors->has('code'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('code') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('the_key') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-name">{{ __('Key') }}</label>
                                                    <input type="text" name="the_key" id="input-name" class="form-control form-control-alternative{{ $errors->has('the_key') ? ' is-invalid' : '' }}" placeholder="{{ __('Key') }}" value="{{ old('the_key') }}" required autofocus>
                                                    @if ($errors->has('the_key'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('the_key') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('value') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-name">{{ __('value') }}</label>
                                                    <input type="text" name="value" id="input-name" class="form-control form-control-alternative{{ $errors->has('value') ? ' is-invalid' : '' }}" placeholder="{{ __('value') }}" value="{{ old('value') }}" required autofocus>
                                                    @if ($errors->has('value'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('value') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="col-4"> <label class="form-control-label">{{ __('Status') }} :</label></div>
                                                <div class="col-8">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" value="1" name="status" id="status" checked>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>

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