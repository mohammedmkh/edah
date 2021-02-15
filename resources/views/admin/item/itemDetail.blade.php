@extends('admin.master', ['title' => __($data->name)])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __($data->name) ,
        'headerData' => __('Items') ,
        'url' => 'Item' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow" style="border:none;" >                       
                        {{-- <div class="card-top-header"  style="background-image: url({{url('images/upload/'.$data->image)}});">
                        </div>  --}}
                        <div class="card-body shop-detail">
                            <div class="row">
                                <div class="col-6">
                                    <img src="{{url('images/upload/'.$data->image)}}">
                                   
                                    
                                </div>
                                <div class="col-6 text-right">
                                    <h3>{{$currency.$data->price}}</h3>
                                    <div class="rating">
                                        @for ($i =1 ; $i <= 5; $i++)
                                            <i class="fas fa-star {{$i<=$data->rate ? 'active' : ''}}"></i>
                                        @endfor
                                    </div>  
                                    <span class="badge rate-label mt-1">{{$data->rate}}({{$data->totalReview}})</span>                                 
                                </div>
                                <div class="col-6">
                                    <h2 class="mt-4">{{$data->name}}</h2>                                                                     
                                    <p class="m-0">Category: {{$data->category->name}}</p>
                                    <p class="m-0"> Shop: {{$data->shop->name}}</p>
                                    @if ($data->isVeg==1)
                                    <p class="b-1"><i class="fas fa-seedling mr-2 text-success"></i> Pure Veg</p>
                                    @else 
                                    <p><i class="fas fa-utensils text-danger mr-2"></i>Non-veg</p>
                                    @endif                                    
                                </div>
                            </div>                           
                        </div>
                    </div>
            </div>
        </div>
       
    </div>

@endsection