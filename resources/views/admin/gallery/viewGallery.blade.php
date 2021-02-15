@extends('admin.master', ['title' => __('Gallery')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Gallery') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Gallery') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url('Gallery/create')}}" class="btn btn-sm btn-primary">{{ __('Add Image') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($gallery)>0) 
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('#') }}</th>
                                            <th scope="col">{{ __('Image') }}</th>
                                            <th scope="col">{{ __('Title') }}</th>
                                            <th scope="col">{{ __('Shop') }}</th>                                             
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gallery as $item)
                                           
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img class=" avatar-lg round-5" src="{{url('images/upload/'.$item->image)}}"></td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->shopName }}</td>                                                
                                                <td>                            
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">                                                          
                                                            <a class="dropdown-item" href="{{url('Gallery/'.$item->id.'/edit')}}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item" onclick="deleteData('Gallery','{{$item->id}}');" href="#">{{ __('Delete') }}</a>
                                                            {{-- onclick="deleteData('Gallery','{{$item->id}}');" --}}
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
                                    <p style="font-weight:600;">Your Collection list in empty....</p>
                                </div>                        
                            @endif
                            </div>
                    </div>
            </div>
        </div>
       
    </div>

@endsection