@extends('admin.master', ['title' => __('Role & Permission')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Role & Permission') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card bg-secondary shadow">
                        <div class="card-header border-0">
                            <div class="nav-wrapper">
                                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">   
                                        <a class="nav-link mb-sm-3 mb-md-0 active" id="pemission-list-tab" data-toggle="tab" href="#pemission-list" role="tab" aria-controls="tabs-icons-text-1" aria-selected="false"><i class="fas fa-tasks mr-2"></i>Permissions List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="add-permission-tab" data-toggle="tab" href="#add-permission" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-plus mr-2"></i>Create Permission</a>
                                    </li>   
                                    <li class="nav-item">   
                                        <a class="nav-link mb-sm-3 mb-md-0 " id="role-list-tab" data-toggle="tab" href="#role-list" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-list mr-2"></i>Role List</a>
                                    </li>
                                    <li class="nav-item">   
                                        <a class="nav-link mb-sm-3 mb-md-0 " id="add-role-tab" data-toggle="tab" href="#add-role" role="tab" aria-controls="tabs-icons-text-1" aria-selected="false"><i class="fas fa-plus mr-2"></i>Create Role</a>
                                    </li>
                                                                     
                                </ul>
                            </div>
                        </div>  

                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pemission-list" role="tabpanel" aria-labelledby="pemission-list-tab">
                                    
                                    <div class="table-responsive"> 
                                        <form method="post" action="{{url('savePermission')}}" autocomplete="off" >                                     
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('#') }}</th>                                                     
                                                    <th scope="col">{{ __('Name') }}</th>
                                                   @foreach ($roles as $item)
                                                    <th scope="col">{{$item->name}}</th>
                                                   @endforeach                                                       
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                             
                                                @csrf
                                                @foreach ($permissions as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>                                                         
                                                        <td>{{ $item->name }}</td>                                                          
                                                        @foreach ($roles as $data) 
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="check_{{$item->id}}_{{$data->id}}" name="permission[]">
                                                                <label class="custom-control-label" for="check_{{$item->id}}_{{$data->id}}"></label>
                                                            </div>
                                                        </td> 
                                                       @endforeach                                                     
                                                        <td>                            
                                                            <div class="dropdown">
                                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                                    <a class="dropdown-item" href="{{url('Permission/'.$item->id.'/edit')}}">{{ __('Edit') }}</a>
                                                                    <a class="dropdown-item" onclick="deleteData('Permission','{{$item->id}}');" href="#">{{ __('Delete') }}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        
                                    </form>
                                      
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="add-permission" role="tabpanel" aria-labelledby="add-permission-tab">
                                    <form method="post" action="{{url('Permission')}}" autocomplete="off" >
                                        @csrf                                        
                                        <h6 class="heading-small text-muted mb-4">{{ __('permission Detail') }}</h6>
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
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                                <div class="tab-pane fade" id="role-list" role="tabpanel" aria-labelledby="role-list-tab">
                                  

                                    <div class="table-responsive">                                      
                                            <table class="table align-items-center table-flush">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">{{ __('#') }}</th>                                                     
                                                        <th scope="col">{{ __('Name') }}</th>
                                                        <th scope="col">{{ __('Status') }}</th>                                                         
                                                        <th scope="col">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $role)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>                                                         
                                                            <td>{{ $role->name }}</td>                                                          
                                                            <td>
                                                                <span class="badge badge-dot mr-4">
                                                                    <i class="{{$role->status==0?'bg-success': 'bg-danger'}}"></i>
                                                                    <span class="status">{{$role->status==0?'Active': 'Deactive'}}</span>
                                                                </span>
                                                            </td>                                                          
                                                            <td >                            
                                                                <div class="dropdown">
                                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                                        <a class="dropdown-item" href="{{url('Role/'.$role->id.'/edit')}}">{{ __('Edit') }}</a>
                                                                        <a class="dropdown-item" onclick="deleteData('Role','{{$role->id}}');" href="#">{{ __('Delete') }}</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                          
                                        </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="add-role" role="tabpanel" aria-labelledby="add-role-tab">
                                    <form method="post" action="{{url('Role')}}" autocomplete="off" >
                                        @csrf                                        
                                        <h6 class="heading-small text-muted mb-4">{{ __('Role Detail') }}</h6>
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
        </div>
       
    </div>

@endsection