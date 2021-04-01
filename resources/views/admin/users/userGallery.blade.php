@extends('admin.master', ['title' => __('User Management')])

@section('content')  
     @include('admin.layout.topHeader', [
        'title' => __('User Gallery') ,
        'headerData' => __('Users') ,
        'url' => 'Customer' ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('User Gallery') }}</h3>
                                </div>
                                <div class="col-4 text-right">                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body user-gallery">
                            @if(count($data)>0)                                                                              
                                <section id="gallery">
                                    <div class="container">
                                      <div id="image-gallery">
                                        <div class="row">                                         
                                            @foreach ($data as $item)
                                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
                                                <div class="img-wrapper">
                                                    <a href="{{url('images/upload/'.$item->image)}}"><img src="{{url('images/upload/'.$item->image)}}" class="img-responsive"></a>
                                                  <div class="img-overlay">
                                                    {{-- <i class="fa fa-plus-circle" aria-hidden="true"></i> --}}
                                                  </div>
                                                </div>
                                              </div>
                                            @endforeach                                          
                                        </div>
                                      </div>
                                    </div>
                                </section>
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

@endsection