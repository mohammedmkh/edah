@extends('admin.master', ['title' => __('User Management')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Technician') ,
        'headerData' => __('Technician') ,
        'url' => 'deliveryGuys' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Add Driver') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('deliveryGuys') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url(adminPath().'addTechnician')}}" autocomplete="off"  enctype="multipart/form-data">
                                    @csrf

                                    <h6 class="heading-small text-muted mb-4">{{ __('Driver information') }}</h6>
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
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required>

                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone') }}" required>

                                                    @if ($errors->has('phone'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
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
                                        {{-- <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('driver_radius') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-driver_radius">{{ __('Radius') }}</label>
                                                    <input type="number" min="0" name="driver_radius" id="input-driver_radius" class="form-control form-control-alternative{{ $errors->has('driver_radius') ? ' is-invalid' : '' }}" placeholder="{{ __('Radius') }}" value="{{ old('driver_radius') }}" required>

                                                    @if ($errors->has('driver_radius'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('driver_radius') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">

                                            </div>
                                        </div> --}}



                                        @foreach($documents as $doc)
                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-image">{{ $doc->document_description }}</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file{{$doc->id}}" id="file">
                                                    <label class="custom-file-label" for="image">Select file</label>
                                                </div>
                                        </div>
                                       @endforeach
                                        {{-- <div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-role">{{ __('Role') }}</label>
                                                <Select name="role" id="input-role" class="form-control form-control-alternative{{ $errors->has('role') ? ' is-invalid' : '' }}"  required>
                                                    <option value="">Select Role</option>
                                                    <option value="0" {{ old('role')=="0" ? 'Selected' : ''}}>Customer</option>
                                                    <option value="1" {{ old('role')=="1" ? 'Selected' : ''}}>Shop Owner</option>
                                                    <option value="2" {{ old('role')=="2" ? 'Selected' : ''}}>Delivery Guy</option>
                                                </select>

                                                @if ($errors->has('role'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('role') }}</strong>
                                                    </span>
                                                @endif
                                        </div> --}}
                                        <div class="form-group{{ $errors->has('identity') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-password">{{ __('identity') }}</label>
                                            <input type="text" name="identity" id="input-password" class="form-control form-control-alternative{{ $errors->has('identity') ? ' is-invalid' : '' }}" placeholder="{{ __('identity') }}" value="" required>

                                            @if ($errors->has('identity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('identity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('hour_work') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-hour_work">{{ __('Hour Work') }}</label>
                                            <input type="text" name="hour_work" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('hour_work') ? ' is-invalid' : '' }}" placeholder="{{ __('Hour Work') }}" value="" required>

                                            @if ($errors->has('hour_work'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('hour_work') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('min_order_value') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-hour_work">{{ __('min order value') }}</label>
                                            <input type="text" name="min_order_value" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('min_order_value') ? ' is-invalid' : '' }}" placeholder="{{ __('min order value') }}" value="" required>

                                            @if ($errors->has('min_order_value'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('min_order_value') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <div class="col-4"> <label class="form-control-label">{{ __('Have Vehicle') }} :</label></div>
                                            <div class="col-8">
                                                <label class="custom-toggle">
                                                    <input type="checkbox" value="1" name="have_vehicle" id="have_vehicle" checked>
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="form-group " id="secTypeVe">
                                          <label class="form-control-label">{{ __('Type Vehicle') }} :</label>
                                            <select class="form-control">
                                                <option value="Car">{{ __('Car') }}  </option>
                                                <option value="Motorcycle">{{ __('Motorcycle') }}  </option>
                                            </select>
                                        </div>



                                        <div class="form-group " id="secTypeVe">
                                            <label class="form-control-label">{{ __('Type Services') }} :</label>



                                            <select name="categories[]" multiple="multiple" id="input-categories"  class="form-control select2 select2-multiple form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }}"  required >
                                                @foreach($categories as $cat)
                                                <option value="{{$cat->id}}">{{ $cat->translation()->name }}  </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="row">
                                        <div class="col-6">
                                            <div class="form-group {{ $errors->has('priority') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-hour_work">{{ __('priority') }}</label>
                                                <input type="text" name="priority" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('priority') ? ' is-invalid' : '' }}" placeholder="{{ __('priority') }}" value="0" required >
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group {{ $errors->has('app_benifit_percentage') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-hour_work">{{ __('app benifit percentage') }}</label>
                                                <input type="text" name="app_benifit_percentage" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('priority') ? ' is-invalid' : '' }}" placeholder="{{ __('priority') }}" value="1" required >
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

@section('java_script')
    <script>

        $('#have_vehicle').change(function(){

            if($('#have_vehicle').is(":checked")){

                $('#secTypeVe').show();
            }else{
                $('#secTypeVe').hide();
            }
        });

        $(document).ready(function() {
            $('#input-categories').select2();
        });
    </script>
@endsection
