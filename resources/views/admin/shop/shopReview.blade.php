@extends('admin.master', ['title' => __('Shop Review')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Shop Review') ,
        'headerData' => __('Shops') ,
        'url' => 'Shop' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Shop Review') }}</h3>
                                </div>                             
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="list-group list-group-flush">  
                                @if(count($data)>0)     
                                @foreach ($data as $item)                                    
                                        <div class="row align-items-center mb-2 pb-2" style = "border-bottom:1px solid #eee;">                                            
                                            <div class="col-2">                                                                                                        
                                                <img alt="Image placeholder" src="{{url('images/upload/'.$item->customer->image)}}" class="avatar-lg ml-4" style="border-radius:50%">                                                                        
                                            </div>
                                            <div class="col ml--2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h4 class="mb-2">{{$item->customer->name}}</h4>
                                                        <div class="rating">
                                                            @for ($i =1 ; $i <= 5; $i++)                                        
                                                                <i class="fas fa-star {{$i<=$item->rate ? 'active' : ''}}"></i>
                                                            @endfor
                                                        </div> 
                                                    </div>
                                                    <div class="text-right text-muted">
                                                        <small>{{$item->created_at->diffForHumans()}}</small>
                                                    </div>
                                                </div>
                                                <p class="text-sm mb-0">{{$item->message}}</p>
                                            </div>
                                        </div>                                                                                 
                                @endforeach
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
       
    </div>

@endsection