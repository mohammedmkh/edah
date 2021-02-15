@extends('admin.master', ['title' => __('Add Shop')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Shop') ,
        'headerData' => __('Grocery Shop') ,
        'url' => 'GroceryShop' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Add Grocery Shop') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('GroceryShop') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('GroceryShop')}}" autocomplete="off" enctype="multipart/form-data" >
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
                                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                                        <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required >
                                                        @if ($errors->has('phone'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
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
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-category_id">{{ __('Category') }}</label>
                                                    <Select name="category_id[]" id="input-category_id" multiple="multiple" class="form-control select2 select2-multiple form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }}"  required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($category as $item)
                                                        <option value="{{$item->id}}" {{ old('category_id')==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>    
                                                        @endforeach                                                       
                                                    </select>

                                                    @if ($errors->has('category_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('category_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">                                                

                                                <div class="form-group{{ $errors->has('delivery_type') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-delivery_type">{{ __('Delivery Type') }}</label>
                                                    <Select name="delivery_type" id="input-delivery_type" class="form-control form-control-alternative{{ $errors->has('delivery_type') ? ' is-invalid' : '' }}"  required>
                                                        <option value="">Select Delivery Type</option>
                                                        <option value="Home" {{ old('delivery_type')=="Home" ? 'Selected' : ''}}>Delivery at Home</option>
                                                        <option value="Shop" {{ old('delivery_type')=="Shop" ? 'Selected' : ''}}>Arrive product at shop</option>
                                                        <option value="Both" {{ old('delivery_type')=="Both" ? 'Selected' : ''}}>Both</option>
                                                    </select>
        
                                                    @if ($errors->has('delivery_type'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('delivery_type') }}</strong>
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
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-image">{{ __('Shop Logo') }}</label>
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
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('cover_image') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-cover_image">{{ __('Cover Image') }}</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="cover_image" id="cover_image">
                                                        <label class="custom-file-label" for="cover_image">Select file</label>
                                                    </div>
                                                    @if ($errors->has('cover_image'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('cover_image') }}</strong>
                                                        </span>
                                                    @endif
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
