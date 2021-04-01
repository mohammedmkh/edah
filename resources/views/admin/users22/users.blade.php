@extends('admin.master', ['title' => __('User Management')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Users') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Users') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    {{-- <a href="{{url('admin/Customer/create')}}" class="btn btn-sm btn-primary">{{ __('Add user') }}</a> --}}
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
                                            <th scope="col">{{ __('Date of Birth') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                           
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
                                                <td>{{ $user->dateOfBirth }}</td>
                                                <td>
                                                    <span class="badge badge-dot mr-4">
                                                        <i class="{{$user->status==0?'bg-success': 'bg-danger'}}"></i>
                                                        <span class="status">{{$user->status==0?'Active': 'Block'}}</span>
                                                    </span>
                                                </td>
                                              
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else 
                                <div class="empty-state text-center pb-3">
                                    <img src="{{url('images/empty3.png')}}" style="width:35%;height:220px;">
                                    <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                    <p style="font-weight:600;">Your Collection list in empty....</p>
                                </div> 
                            @endif
                            </div>
                    </div>
            </div>
        </div>
       
    </div>

@endsection