@extends('admin.master', ['title' => __('Add Item')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add City') ,
        'headerData' => __('Cities') ,
        'url' => 'cities' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Add New City') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('cities') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('cities')}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    
                                    <h6 class="heading-small text-muted mb-4">{{ __('Item Detail') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                        <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                                                        @if ($errors->has('name'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('shop_id') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-shop_id">اختر الدولة</label>
                                                    <select name="country_id" id="input-shop_id" class="form-control form-control-alternative{{ $errors->has('country_id') ? ' is-invalid' : '' }}"required>
                                                        <option value="">الدولة</option>
                                                        @foreach ($countries as $item)
                                                            <option value="{{$item->id}}" {{ old('country_id')==$item->id ? 'Selected' : ''}}>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('country_id'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('country_id') }}</strong>
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