@extends('admin.master', ['title' => __('User Management')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Edit User') ,
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
                                        <h3 class="mb-0">{{ __('Edit User') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('Customer') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('updateDriver/'.$data->id)}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    {{-- @method('put') --}}




                                    <h6 class="heading-small text-muted mb-4">{{ __('Driver information') }}</h6>
                                    <div class="pl-lg-4">

                                        <div class="form-group col-lg-6 {{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name' , $data->name) }}" required autofocus>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6 {{ $errors->has('identity') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-password">{{ __('identity') }}</label>
                                            <input type="text" name="identity" id="input-password" class="form-control form-control-alternative{{ $errors->has('identity') ? ' is-invalid' : '' }}" placeholder="{{ __('identity' ) }}" value="{{old('identity' , $data->identity) }}" required>

                                            @if ($errors->has('identity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('identity') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email' , $data->email) }}" required>

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
                                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" value="{{ old('phone' , $data->phone) }}" required>

                                                    @if ($errors->has('phone'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
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
                                            <div class="row">
                                            <div class="form-group col-6 {{ $errors->has('image') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-image">{{ $doc->document_description }}</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="file{{$doc->id}}" id="file">
                                                    <label class="custom-file-label" for="image">Select file</label>
                                                </div>
                                            </div>
                                            <div class="col-6 ">
                                                   <?php
                                                     $is_documents_has = \App\TechStoreDocuments::where('document_id' , $doc->id)->where('user_id' , $data->id)->first();
                                                     if($is_documents_has){
                                                    ?>
                                                 <div style="margin-top: 40px">
                                                       <a href="{{ url('/').'/'.$is_documents_has->document_link }}" > link to download </a>
                                                 </div>
                                                    <?php
                                                     }else{
                                                    ?>

                                                       <div style="margin-top: 40px"> {{ __('Not Has This Document') }}</div>

                                                    <?php
                                                      }
                                                    ?>



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
                                            <input type="text" name="identity" id="input-password" class="form-control form-control-alternative{{ $errors->has('identity') ? ' is-invalid' : '' }}" placeholder="{{ __('identity' ) }}" value="{{old('identity' , $data->identity) }}" required>

                                            @if ($errors->has('identity'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('identity') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('hour_work') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-hour_work">{{ __('Hour Work') }}</label>
                                            <input type="text" name="hour_work" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('hour_work') ? ' is-invalid' : '' }}" placeholder="{{ __('Hour Work') }}" value="{{old('hour_work' , $data->techstore->hour_work ?? '') }}" required>

                                            @if ($errors->has('hour_work'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('hour_work') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('min_order_value') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-hour_work">{{ __('min order value') }}</label>
                                            <input type="text" name="min_order_value" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('min_order_value') ? ' is-invalid' : '' }}" placeholder="{{ __('min order value') }}" value="{{old('min_order_value' , $data->techstore->min_order_value ?? '') }}" required>

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
                                                    <input type="checkbox" value="1" name="have_vehicle" id="have_vehicle" {{ $data->techstore->have_vehicle ? 'checked' : '' }}>
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
                                                    <option value="{{$cat->id}}" {{ in_array($cat->id , $data->techstore->cats) ? 'selected' : '' }}>{{ $cat->translation()->name }}  </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group {{ $errors->has('priority') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-hour_work">{{ __('priority') }}</label>
                                                    <input type="text" name="priority" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('priority') ? ' is-invalid' : '' }}" placeholder="{{ __('priority') }}" value="{{old('priority' , $data->techstore->priority ?? '')}}" required >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group {{ $errors->has('app_benifit_percentage') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-hour_work">{{ __('app benifit percentage') }}</label>
                                                    <input type="text" name="app_benifit_percentage" id="input-hour_work" class="form-control form-control-alternative{{ $errors->has('app_benifit_percentage') ? ' is-invalid' : '' }}" placeholder="{{ __('app benifit percentage') }}" value="{{old('app_benifit_percentage' , $data->techstore->app_benifit_percentage ?? '')}}" required >
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

@section('javascript')
    <script>
        $(document).ready(function(){
            if($('#have_vehicle').is(":checked")){

                $('#secTypeVe').show();
            }else{
                $('#secTypeVe').hide();
            }
            $('#input-categories').select2();

        });
        $('#have_vehicle').change(function(){

            if($('#have_vehicle').is(":checked")){

                $('#secTypeVe').show();
            }else{
                $('#secTypeVe').hide();
            }
        });
    </script>
@endsection