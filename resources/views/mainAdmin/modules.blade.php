@extends('admin.master', ['title' => __('Modules')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Modules') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Modules') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    {{-- <a href="#" class="btn btn-sm btn-primary">{{ __('Add New Category') }}</a> --}}
                                    {{-- <input type="file" name="add_module" > --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush list my--3">
                                @if(Session::has('success'))
                                @include('toast',Session::get('success'))
                                @endif
                                @if(Session::has('error'))
                                @include('toast',Session::get('error'))
                                @endif
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#">
                                                <img alt="Image placeholder" class="avatar-lg round-5" src="{{url('images/coupon.png')}}">
                                            </a>
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">Coupons</a>
                                            </h4>                                          
                                            <small>Looking for coupons? FoodLans Freecharge Coupon. A comprehensive database of Restaurants coupons, discount & Promo codes.</small>
                                        </div>
                                        <div class="col-auto">
                                            @if(View::exists('admin.coupon.viewCoupon'))
                                            <a href="#"><button type="button" class="btn btn-sm btn-primary">Added</button></a>
                                            @else                                             
                                            <a href="{{url('addCoupons')}}"><button type="button" class="btn btn-sm btn-primary">Add Now</button></a>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#">                                                
                                                <img alt="Image placeholder" class="avatar-lg round-5" src="{{url('images/mail.png')}}">
                                            </a>
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">Mail Notification Template</a>
                                            </h4>                                          
                                            <small>Send e-mail & SMS notifications both to customers and Drivers - when an order is booked, verification and other.</small>
                                        </div>
                                        <div class="col-auto">                                            
                                            @if(View::exists('mainAdmin.notification.viewNotification'))
                                                <a href="{{url('add_notification')}}"><button type="button" class="btn btn-sm btn-primary">Added</button></a>
                                            @else                                             
                                                <a href="{{url('add_notification')}}"><button type="button" class="btn btn-sm btn-primary">Add Now</button></a>
                                            @endif                                            
                                        </div>
                                    </div>
                                </li>
                                {{-- <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            
                                            <a href="#">
                                                <img alt="Image placeholder" class="avatar-lg round-5" src="{{url('images/paypal.png')}}">
                                            </a>
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">Payment with Paypal</a>
                                            </h4>                                          
                                            <small>Looking for coupons? FoodLans Freecharge Coupon. A comprehensive database of Restaurants coupons, discount & Promo codes.</small>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-sm btn-primary">Add Now</button>
                                        </div>
                                    </div>
                                </li>
                                 --}}
                        
                          
                            </ul>                         
                        </div>
                    </div>
            </div>
        </div>
       
    </div>

@endsection