@extends('admin.master', ['title' => __('Edit Item')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Edit Grocery Item') ,
        'headerData' => __('Grocery Items') ,
        'url' => 'GroceryItem' ,
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
                                        <a href="{{ url('GroceryItem') }}" class="btn btn-sm btn-primary">{{   __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('GroceryItem/'.$data->id)}}" class="grocery-item" autocomplete="off" enctype="multipart/form-data" >
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
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('fake_price') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-fake_price">{{ __('Price') }}</label>
                                                    <input type="number" min="0" name="fake_price" id="input-fake_price" class="form-control form-control-alternative{{ $errors->has('fake_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Price') }}"  value="{{ $data->fake_price }}" required>
                                                    @if ($errors->has('fake_price'))
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('fake_price') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('sell_price') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-sell_price">{{ __('Sell Price') }}</label>
                                                        <input type="number" min="0" name="sell_price" id="input-sell_price" class="form-control form-control-alternative{{ $errors->has('sell_price') ? ' is-invalid' : '' }}" placeholder="{{ __('Sell Price') }}"  value="{{ $data->sell_price }}"required>
                                                        @if ($errors->has('sell_price'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('sell_price') }}</strong>
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
                                            <div class="col-6">
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
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('subcategory_id') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-subcategory_id">{{ __("Sub Category") }}</label>
                                                    <select name="subcategory_id" id="input-subcategory_id" class="form-control form-control-alternative{{ $errors->has('subcategory_id') ? ' is-invalid' : '' }}"required>
                                                        <option value="">Select Sub Category</option>
                                                        @foreach ($subcategory as $item)
                                                        <option value="{{$item->id}}" {{ $data->subcategory_id==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>    
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('subcategory_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('subcategory_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('brand') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-brand">{{ __('Brand') }}</label>
                                                        <input type="text" name="brand" id="input-brand" class="form-control form-control-alternative{{ $errors->has('brand') ? ' is-invalid' : '' }}" placeholder="{{ __('Brand') }}" value="{{ $data->brand}}" required >
                                                        @if ($errors->has('brand'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('brand') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                 <div class="form-group{{ $errors->has('weight') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-weight">{{ __('Weight') }}</label>
                                                    <input type="text" name="weight" id="input-weight" class="form-control form-control-alternative{{ $errors->has('weight') ? ' is-invalid' : '' }}" placeholder="{{ __('Weight') }}" value="{{ $data->weight }}" required >
                                                    @if ($errors->has('weight'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('weight') }}</strong>
                                                        </span>
                                                   @endif
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('stoke') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-stoke">{{ __('Stoke') }}</label>
                                                    <input type="number" name="stoke" id="input-stoke" class="form-control form-control-alternative{{ $errors->has('stoke') ? ' is-invalid' : '' }}" placeholder="{{ __('Stoke') }}" value="{{ $data->stoke }}" required >
                                                    @if ($errors->has('stoke'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('stoke') }}</strong>
                                                        </span>
                                                   @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                                    <Select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}"  required>
                                                        <option value="">Select Status</option>
                                                        <option value="0" {{ $data->status=="0" ? 'Selected' : ''}}>Available</option>
                                                        <option value="1" {{ $data->status=="1" ? 'Selected' : ''}}>Not Available</option>
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