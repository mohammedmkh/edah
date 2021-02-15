@extends('admin.master', ['title' => __('Delivery Boys')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Technician') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Technician') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url('technicians/create')}}" class="btn btn-sm btn-primary">{{ __('Add Technician') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($users)>0)       
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('#') }}</th>
                                            <th scope="col">{{ __('Image') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Email') }}</th>
                                            <th scope="col">{{ __('Phone') }}</th>    
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Role') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img class="avatar avatar-lg" src="{{url('images/upload/'.$user->image)}}"></td>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                </td>
                                                <td>{{ $user->phone }}</td>                                               
                                                <td>
                                                    <span class="badge badge-dot mr-4">
                                                        <i class="{{$user->status==0?'bg-success': 'bg-danger'}}"></i>
                                                        <span class="status">{{$user->status==0?'Active': 'Block'}}</span>
                                                    </span>
                                                </td>

                                                <td><span class="badge border-1">{{ __('Technician')}}</span></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            @if($user->driver_radius==null)                                                        
                                                            <a class="dropdown-item open-assign-driver" data-id="{{$user->id}}" data-toggle="modal" data-target="#assignRadius">{{ __('Assign area') }}</a>
                                                            @endif
                                                            <a class="dropdown-item" href="{{url('Driver/edit/'.$user->id)}}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item" href="#" onclick="deleteData('Customer','{{$user->id}}');" >{{ __('Delete') }}</a>
                                                          
                                                        </div>
                                                    </div> 
                                                  
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else 
                                <div class="empty-state text-center pb-3">
                                    <img src="{{url('images/empty3.png')}}" style="width:35%;height:220px;">
                                    <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                    <p style="font-weight:600;">Your Collection list is empty....</p>
                                </div>
                            @endif                                
                            </div>
                    </div>
            </div>
        </div>
       
    </div>



    <div class="modal fade" id="assignRadius" tabindex="-1" role="dialog" aria-labelledby="assignRadiusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="assignRadiusLabel">{{ __('Assign Radius to Driver')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body bg-secondary">
                <form method="post" action="{{url('assignRadius')}}">
                        @csrf                        
                            <div class="form-group{{ $errors->has('driver_radius') ? ' has-danger' : '' }}">                                            
                                <label class="form-control-label" for="input-driver_radius">{{ __('Radius (KM)') }}</label>
                                <input type="number" name="driver_radius" id="input-driver_radius" class="form-control form-control-alternative{{ $errors->has('driver_radius') ? ' is-invalid' : '' }}" placeholder="{{ __('Radius') }}" value="" required autofocus>
                                @if ($errors->has('driver_radius'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_radius') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="driver_id" id="driver_id" class="form-control">
                                                     
                            <div class="form-group text-right"> 
                                {{-- <button type="button" class="btn" data-dismiss="modal">{{ __('Close') }}</button> --}}
                                <button  type="submit" class="btn btn-primary">{{ __('Save') }}</button>   
                            </div>                                              
                   </form>
                </div>
                {{-- <div class="modal-footer">    </div> --}}
            </div>
        </div>
    </div>


@endsection