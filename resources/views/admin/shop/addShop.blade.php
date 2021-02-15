@extends('admin.master', ['title' => __('Add Shop')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Shop') ,
        'headerData' => __('Shops') ,
        'url' => 'Shop' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Add Shop') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('Shop') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('Shop')}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    
                                    <h6 class="heading-small text-muted mb-4">{{ __('Shop Detail') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-name">{{ __('Shop Name') }}</label>
                                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Shop Name') }}" value="{{ old('name') }}" required autofocus>
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-address">{{ __('Shop Address') }}</label>
                                                        <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Shop Address') }}" value="{{ old('address') }}" required >
                                                        @if ($errors->has('address'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('address') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div> 
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                                                <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('Description') }}" required >{{ old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('location') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-location">{{ __('Location') }}</label>
                                                    <select name="location" id="input-location" class="form-control form-control-alternative{{ $errors->has('location') ? ' is-invalid' : '' }}"  required>
                                                        <option value="">Select Location</option>
                                                        @foreach ($location as $item)
                                                        <option value="{{$item->id}}" {{ old('location')==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>    
                                                        @endforeach
                                                    </select>
                    
                                                    @if ($errors->has('location'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('location') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                    <div class="form-group{{ $errors->has('pincode') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-pincode">{{ __('Pincode') }}</label>
                                                        <input type="text" name="pincode" id="input-pincode" class="form-control form-control-alternative{{ $errors->has('pincode') ? ' is-invalid' : '' }}" placeholder="{{ __('Pincode') }}" value="{{ old('pincode') }}" required >
                                                        @if ($errors->has('pincode'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('pincode') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('latitude') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-latitude">{{ __('Latitude') }}</label>
                                                    <input type="text" name="latitude" id="input-latitude" class="form-control form-control-alternative{{ $errors->has('latitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Latitude') }}" value="{{ old('latitude') }}" required >
                                                    @if ($errors->has('latitude'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('latitude') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('longitude') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-longitude">{{ __('Longitude') }}</label>
                                                    <input type="text" name="longitude" id="input-longitude" class="form-control form-control-alternative{{ $errors->has('longitude') ? ' is-invalid' : '' }}" placeholder="{{ __('Longitude') }}" value="{{ old('longitude') }}" required >
                                                    @if ($errors->has('longitude'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('longitude') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                          
                                        </div>

                                        <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-phone">{{ __('Phone:') }}</label>
                                                        <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required >
                                                        @if ($errors->has('phone'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group{{ $errors->has('website') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-website">{{ __('Website') }}</label>
                                                        <input type="text" name="website" id="input-website" class="form-control form-control-alternative{{ $errors->has('website') ? ' is-invalid' : '' }}" placeholder="{{ __('Website') }}" value="{{ old('website') }}" >
                                                        @if ($errors->has('website'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('website') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('delivery_time') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-delivery_time">{{ __('Approx Delivery Time (Minutes)') }}</label>
                                                    <input type="text" name="delivery_time" id="input-delivery_time" class="form-control form-control-alternative{{ $errors->has('delivery_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Approx Delivery Time') }}" value="{{ old('delivery_time') }}" required >
                                                    @if ($errors->has('delivery_time'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('delivery_time') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('licence_code') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-licence_code">{{ __('Certificate/License Code') }}</label>
                                                    <input type="text" name="licence_code" id="input-licence_code" class="form-control form-control-alternative{{ $errors->has('licence_code') ? ' is-invalid' : '' }}" placeholder="{{ __('Certificate/License Code') }}" value="{{ old('licence_code') }}" required >
                                                    @if ($errors->has('licence_code'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('licence_code') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('rastaurant_charge') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-rastaurant_charge">{{ __('Shop Charge (Packing/Extra)') }}</label>
                                                    <input type="number" name="rastaurant_charge" min="0" id="input-rastaurant_charge" class="form-control form-control-alternative{{ $errors->has('rastaurant_charge') ? ' is-invalid' : '' }}" placeholder="{{ __('Shop Charge') }}" value="{{ old('rastaurant_charge') }}" required >
                                                    @if ($errors->has('rastaurant_charge'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('rastaurant_charge') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('avarage_plate_price') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-avarage_plate_price">{{ __('Avarage price for two plate') }}</label>
                                                    <input type="number" name="avarage_plate_price" min="0" id="input-avarage_plate_price" class="form-control form-control-alternative{{ $errors->has('avarage_plate_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Avarage price for two plate') }}" value="{{ old('avarage_plate_price') }}" required >
                                                    @if ($errors->has('avarage_plate_price'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('avarage_plate_price') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                           
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('delivery_charge') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-delivery_charge">{{ __('Delivery Charge') }}</label>
                                                    <input type="number" name="delivery_charge" min="0" id="input-delivery_charge" class="form-control form-control-alternative{{ $errors->has('delivery_charge') ? ' is-invalid' : '' }}" placeholder="{{ __('Delivery Charge') }}" value="{{ old('delivery_charge') }}" required >
                                                    @if ($errors->has('delivery_charge'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('delivery_charge') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('cancle_charge') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-cancle_charge">{{ __('Cancle Charge') }}</label>
                                                    <input type="number" name="cancle_charge" min="0" id="input-cancle_charge" class="form-control form-control-alternative{{ $errors->has('cancle_charge') ? ' is-invalid' : '' }}" placeholder="{{ __('Cancle Charge') }}" value="{{ old('cancle_charge') }}" required >
                                                    @if ($errors->has('cancle_charge'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('cancle_charge') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('radius') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-radius">{{ __('Shop Radius') }}</label>
                                                    <input type="number" name="radius" min="0" id="input-radius" class="form-control form-control-alternative{{ $errors->has('radius') ? ' is-invalid' : '' }}" placeholder="{{ __('Shop Radius') }}" value="{{ old('radius') }}" required >
                                                    @if ($errors->has('radius'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('radius') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                                    <Select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}"  required>
                                                        <option value="">Select Status</option>
                                                        <option value="0" {{ old('status')=="0" ? 'Selected' : ''}}>Active</option>
                                                        <option value="1" {{ old('status')=="1" ? 'Selected' : ''}}>Deactive</option>
                                                    </select>
                
                                                    @if ($errors->has('status'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-image">{{ __('Image') }}</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="image">
                                                <label class="custom-file-label" for="image">Select file</label>
                                            </div>
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('open_time') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-open_time">{{ __('Open Time') }}</label>
                                                    <input type="time" name="open_time" id="input-open_time" class="form-control form-control-alternative{{ $errors->has('open_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Open Time') }}" value="{{ old('open_time') }}" >
                                                    @if ($errors->has('open_time'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('open_time') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('close_time') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-close_time">{{ __('Close Time') }}</label>
                                                    <input type="time" name="close_time" id="input-close_time" class="form-control form-control-alternative{{ $errors->has('close_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Close Time ') }}" value="{{ old('close_time') }}" >
                                                    @if ($errors->has('close_time'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('close_time') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('veg') ? ' has-danger' : '' }}">                                            
                                            <div class="row">
                                                <div class="col-2"> <label class="form-control-label">{{ __('Is Pure Veg') }}?</label></div>
                                                <div class="col-10">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" name="veg" value="1" id="veg">
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('featured') ? ' has-danger' : '' }}">                                            
                                            <div class="row">
                                                <div class="col-2"> <label class="form-control-label">{{ __('Is Featured') }}?</label></div>
                                                <div class="col-10">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" value="1" name="featured" id="featured">
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('exclusive') ? ' has-danger' : '' }}">                                            
                                            <div class="row">
                                                <div class="col-2"> <label class="form-control-label">{{ __('Is Exclusive') }}?</label></div>
                                                <div class="col-10">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" value="1" name="exclusive" id="exclusive">
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