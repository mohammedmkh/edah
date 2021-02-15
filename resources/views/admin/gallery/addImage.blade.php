@extends('admin.master', ['title' => __('Add Image')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Image') ,
        'headerData' => __('Gallery') ,
        'url' => 'Gallery' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Add Image') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('Gallery') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('Gallery')}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    
                                    <h6 class="heading-small text-muted mb-4">{{ __('Image Detail') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                            
                                            <label class="form-control-label" for="input-title">{{ __('Title') }}</label>
                                            <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title') }}" required autofocus>
                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
        
                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                                <label class="form-control-label" for="input-image">{{ __('Image') }}</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image" id="image" required>
                                                    <label class="custom-file-label" for="image">Select file</label>
                                                </div>
                                                @if ($errors->has('image'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('image') }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('shop_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-shop_id">{{ __('Shop') }}</label>
                                            <Select name="shop_id" id="input-shop_id" class="form-control form-control-alternative{{ $errors->has('shop_id') ? ' is-invalid' : '' }}"  required>
                                                <option value="">Select Shop</option>
                                                @foreach ($shops as $item)
                                                    <option value="{{$item->id}}" {{ old('shop_id')==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                               
                                            </select>
        
                                            @if ($errors->has('shop_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('shop_id') }}</strong>
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