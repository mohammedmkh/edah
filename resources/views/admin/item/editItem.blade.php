@extends('admin.master', ['title' => __('Edit Item')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Edit Item') ,
        'headerData' => __('Items') ,
        'url' => 'Item' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Edit Item') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('Item') }}" class="btn btn-sm btn-primary">{{   __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('Item/'.$data->id)}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    @method('put')

                                    <h6 class="heading-small text-muted mb-4">{{ __('Item Detail') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ $data->name }}" required autofocus>
                                                        @if ($errors->has('name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                    <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-price">{{ __('Price') }}</label>
                                                        <input type="number" name="price" id="input-price" class="form-control form-control-alternative{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}" value="{{ $data->price }}" required>
                                                        @if ($errors->has('price'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('price') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                            </div>
                                        </div>
                                        

                                        

                                        <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-description">{{ __('Description') }}</label>
                                            <textarea name="description" id="input-description" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('description') }}"required>{{$data->description}}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-category_id">{{ __("Item's Category") }}</label>
                                                    <select name="category_id" id="input-category_id" class="form-control form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }}"required>
                                                        <option value="">Select Category</option>
                                                        @foreach ($category as $item)
                                                        <option value="{{$item->id}}" {{ $data->category_id==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>    
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('category_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('category_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group{{ $errors->has('shop_id') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-shop_id">{{ __("Item's Shop") }}</label>
                                                    <select name="shop_id" id="input-shop_id" class="form-control form-control-alternative{{ $errors->has('shop_id') ? ' is-invalid' : '' }}"required>
                                                        <option value="">Select Shop</option>
                                                        @foreach ($shop as $item)
                                                        <option value="{{$item->id}}"{{ $data->shop_id==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>    
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('shop_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('shop_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                                    <Select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}"  required>
                                                        <option value="">Select Status</option>
                                                        <option value="0" {{ $data->status=="0" ? 'Selected' : ''}}>Active</option>
                                                        <option value="1" {{ $data->status=="1" ? 'Selected' : ''}}>Deactive</option>
                                                    </select>
                
                                                    @if ($errors->has('status'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row{{ $errors->has('isVeg') ? ' has-danger' : '' }}">                                            
                                            
                                            <div class="col-4 row">
                                                <div class="col-6"> <label class="form-control-label">{{ __('Veg') }}</label></div>
                                                <div class="col-6">
                                                    <label class="custom-toggle">
                                                        <input type="radio" value="1" name="isVeg" {{ $data->isVeg==1 ? 'Checked' : '' }} class="{{ $errors->has('isVeg') ? ' is-invalid' : '' }}"> 
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-4 row">
                                                <div class="col-6"> <label class="form-control-label">{{ __('Non-veg') }}</label></div>
                                                <div class="col-6">
                                                    <label class="custom-toggle">
                                                        <input type="radio" value="0" name="isVeg" {{ $data->isVeg==0 ? 'Checked' : '' }} class="{{ $errors->has('isVeg') ? ' is-invalid' : '' }}">
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            {{-- <div class="col-4 row">
                                                <div class="col-6"> <label class="form-control-label">{{ __('Includes egg') }}</label></div>
                                                <div class="col-6">
                                                    <label class="custom-toggle">
                                                        <input type="radio" value="2" name="isVeg" {{ $data->isVeg==2 ? 'Checked' : '' }} class="{{ $errors->has('isVeg') ? ' is-invalid' : '' }}">
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div> --}}
                                            @if($errors->has('isVeg'))
                                                <div class="col-12">
                                                    <span class="invalid-feedback" style="display:block;" role="alert">
                                                        <strong>{{ $errors->first('isVeg') }}</strong>
                                                    </span>    
                                                </div>                                                                                                                                
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-10">
                                                <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-image">{{ __('Image') }}</label>
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
                                                <img class=" avatar-lg round-5 view-image" style="width: 100%;height: 90px;" src="{{url('images/upload/'.$data->image)}}">
                                            </div>
                                        </div>
                                       
                                        

                                        
                                        <div class="form-group{{ $errors->has('isNew') ? ' has-danger' : '' }}">                                            
                                            <div class="row">
                                                <div class="col-2"> <label class="form-control-label">{{ __('Is New?') }}</label></div>
                                                <div class="col-10">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" name="isNew" value="1" id="isNew" {{ $data->isNew=="1" ? 'Checked' : ''}}>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('isPopular') ? ' has-danger' : '' }}">                                            
                                            <div class="row">
                                                <div class="col-2"> <label class="form-control-label">{{ __('Is Popular?') }}</label></div>
                                                <div class="col-10">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" value="1" name="isPopular" id="isPopular" {{ $data->isPopular=="1" ? 'Checked' : ''}}>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group{{ $errors->has('isVeg') ? ' has-danger' : '' }}">                                            
                                            <div class="row">
                                                <div class="col-2"> <label class="form-control-label">{{ __('Is Pure Veg?') }}</label></div>
                                                <div class="col-10">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" value="1" name="isVeg" id="isVeg" {{ $data->isVeg=="1" ? 'Checked' : ''}}>
                                                        <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> --}}
                                   
        
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