@extends('admin.master', ['title' => __('Edit Category')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Edit SubCategory') ,
        'headerData' => __('SubCategory') ,
        'url' => 'GrocerySubCategory' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

            <div class="row">
                    <div class="col-xl-12 order-xl-1">
                        <div class="card form-card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">{{ __('Edit SubCategory') }}</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="{{ url('GrocerySubCategory') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{url('GrocerySubCategory/'.$data->id)}}" class="grocery_subcategory" autocomplete="off" enctype="multipart/form-data" >
                                    @csrf
                                    @method('put')
                                    <h6 class="heading-small text-muted mb-4">{{ __('Category Detail') }}</h6>
                                    <div class="pl-lg-4">


                                        <div class="row">
                                            <div class="col-3" style="border-right: 1px solid #ddd;">
                                                <ul class="nav nav-tabs tabs-left sideways border-0">
                                                    @foreach($languages as $lang)

                                                        <li><a href="#language-{{$lang->id}}" class="{{ $loop->index == 0 ? 'active show' : '' }} " data-toggle="tab"> <i class="ni ni-settings-gear-65 mr-2"></i> {{$lang->name}} </a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-9">
                                                <div class="tab-content">

                                                    @foreach($languages as $lang)
                                                        <div class="tab-pane {{ $loop->index == 0 ? 'active show' : '' }}" id="language-{{$lang->id}}">



                                                            <div class="form-group{{ $errors->has('name.*') ? ' has-danger' : '' }}">

                                                                <label class="form-control-label" for="input-name">{{ __('Name') }}</label>

                                                                <input type="text" name="name[{{$lang->id}}]" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}"  required autofocus
                                                                       value="{{ old('name.'.$lang->id ,$data->translation($lang->id)->name??'' )  }}">
                                                                @if ($errors->has('name.'.$lang->id))
                                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name.'.$lang->id) }}</strong>
                                                             </span>
                                                                @endif
                                                            </div>


                                                            <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">

                                                                <label class="form-control-label" for="input-name">{{ __('description') }}</label>
                                                                <input type="text" name="description[{{$lang->id}}]" id="input-name" class="form-control form-control-alternative{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('description') }}" value="{{ old('description.'.$lang->id ,$data->translation($lang->id)->description??'' ) }}"  autofocus>
                                                                @if ($errors->has('description.'.$lang->id))
                                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description.'.$lang->id) }}</strong>
                                                             </span>
                                                                @endif
                                                            </div>


                                                        </div>

                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>






                                        <div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-category_id">{{ __('Category') }}</label>
                                            <Select name="category_id" id="input-category_id" class="form-control form-control-alternative{{ $errors->has('category_id') ? ' is-invalid' : '' }}"  required>
                                                <option value="">Select Category</option>
                                                @foreach ($category as $item)

                                                <option value="{{$item->id}}" {{ $data->parent==$item->id ? 'Selected' : ''}}>{{$item->translation()->name ?? ''}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('category_id'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category_id') }}</strong>
                                                </span>
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
                                        
                                        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                                            <Select name="status" id="input-status" class="form-control form-control-alternative{{ $errors->has('status') ? ' is-invalid' : '' }}"  required>
                                                <option value="">Select Status</option>
                                                <option value="0" {{ $data->status=="0" ? 'Selected' : ''}}>Avaliable</option>
                                                <option value="1" {{ $data->status=="1" ? 'Selected' : ''}}>Not Avaliable</option>
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
                                                <input type="text" class="form-control form-control-alternative "name="sort" id="sort" value="{{$data->sort}}" >
                                            </div>
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4" id="editbutton">{{ __('Save') }}</button>
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



        $('#editbutton').click(function(){
            var error = 0;
            var msg = 'An Error Has Occured.\n\nRequired Fields missed are :\n';
            $(':input[required]').each(function(){
                $(this).css('border','1px solid rgb(202, 209, 215)');
                if($(this).attr('type') == 'file'){
                    $(this).attr('placeholder', 'Placeholder text');
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

            console.log('the error is' + error);
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
