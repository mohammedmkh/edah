@extends('admin.master', ['title' => __('Add Category')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Add Category') ,
        'headerData' => __('Category') ,
        'url' => 'GroceryCategory' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card form-card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Add Grocery Category') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ url(adminPath().'Category') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <form method="post" action="{{url(adminPath().'Category')}}" autocomplete="off" enctype="multipart/form-data" id="thisForm">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Grocery Category Detail') }}</h6>


                            <div class="row">
                                <div class="col-3" >
                                    <ul class="nav nav-tabs tabs-left sideways border-0">
                                        @foreach($languages as $lang)

                                            <li><a href="#language-{{$lang->id}}" class="{{ $loop->index == 0 ? 'active show' : '' }} " data-toggle="tab"> <i class="fas fa-language"></i> {{$lang->name}} </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content">

                                        @foreach($languages as $lang)
                                            <div class="tab-pane {{ $loop->index == 0 ? 'active show' : '' }}" id="language-{{$lang->id}}">


                                                <div class="form-group{{ $errors->has('name.*') ? ' has-danger' : '' }}">

                                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                                    <input type="text" name="name[{{$lang->id}}]" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name.'.$lang->id) }}" required autofocus>
                                                    @if ($errors->has('name.'.$lang->id))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name.'.$lang->id) }}</strong>
                                                             </span>
                                                    @endif
                                                </div>


                                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">

                                                    <label class="form-control-label" for="input-name">{{ __('description') }}</label>
                                                    <input type="text" name="description[{{$lang->id}}]" id="input-name" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('description') }}" value="{{ old('description.'.$lang->id) }}"  autofocus>
                                                    @if ($errors->has('description.'.$lang->id))
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name.'.$lang->id) }}</strong>
                                                             </span>
                                                    @endif
                                                </div>


                                            </div>

                                        @endforeach





                                    </div>
                                </div>
                            </div>


                            <div class="pl-lg-4">



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





                                <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                    <Select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}"  required>
                                        <option value="">{{__('Select Status')}}</option>
                                        <option value="0" {{ old('status')=="0" ? 'Selected' : ''}}></option>
                                        <option value="1" {{ old('status')=="1" ? 'Selected' : ''}}>{{__('Not Avaliable')}}  </option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('status') }}</strong>
                                                </span>
                                    @endif
                                </div>


                                <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-image">{{ __('sort') }}</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control form-control-alternative "name="sort" id="sort" >
                                    </div>
                                </div>



                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4" id="addbutton">{{ __('Save') }}</button>
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



        $('#addbutton').click(function(){
            var error = 0;
            var msg = 'An Error Has Occured.\n\nRequired Fields missed are :\n';
            $(':input[required]').each(function(){
                $(this).css('border','1px solid rgb(202, 209, 215)');
                if($(this).attr('type') == 'file'){
                    $(this).attr('placeholder', 'Placeholder text');
                    $(this).close('label').attr('border','19px solid rgb(202, 209, 215)');
                    console.log('error file input');
                }


                if($(this).val() == ''){
                    msg += '\n' + $(this).attr('id') + ' Is A Required Field..';
                    $(this).css('border','1px solid red');
                    if(error == 0){
                        $(this).focus();
                    }
                    error = 1;
                }
            });


            if(error == 1){
                var id =  $('.tab-pane').find(':required:invalid').closest('.tab-pane').attr('id');

                // Find the link that corresponds to the pane and have it show
                console.log('the id is' + id);
                $('.nav a[href="#' + id + '"]').tab('show');

                // Only want to do it once
                return false;
            }
        });

    </script>

@endsection
