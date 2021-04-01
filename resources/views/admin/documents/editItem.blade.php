@extends('admin.master', ['title' => __('Edit Item')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Edit Document') ,
        'headerData' => __('Documents') ,
        'url' => 'documents' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Edit Document') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url(adminPath().'documents') }}" class="btn btn-sm btn-primary">{{   __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url(adminPath().'documents/'.$data->id)}}" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    @method('put')

                                    <div class="pl-lg-4">
                                        <div class="row">



                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('document_description') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-name">{{ __('Document Description') }}</label>
                                                    <input type="text" name="document_description" id="input-name" class="form-control form-control-alternative{{ $errors->has('document_description') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ $data->document_description }}" required autofocus>
                                                    @if ($errors->has('document_description'))
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('document_description') }}</strong>
                                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-shop_id">اختر نوع المستخدم</label>
                                                    <select name="type" id="input-shop_id" class="form-control form-control-alternative{{ $errors->has('country_id') ? ' is-invalid' : '' }}"required>
                                                        <option value="1" {{ $data->type == 1 ? 'selected' : '' }}>فني</option>
                                                        <option value="2" {{ $data->type == 2 ? 'selected' : '' }}>صاحب محل </option>
                                                    </select>

                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="col-4"> <label class="form-control-label">{{ __('is required') }} :</label></div>
                                                <div class="col-8">
                                                    <label class="custom-toggle">
                                                        <input type="checkbox" value="1" name="is_required" id="user_verify" {{ $data->is_required ==1 ? 'checked' : '' }}>
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