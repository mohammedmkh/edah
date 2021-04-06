@extends('admin.master', ['title' => __('View Order')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('View Order') ,
        'headerData' => __('Orders') ,
        'url' => 'Order' ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card form-card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('View Order') }}</h3>
                            </div>
                            {{-- <div class="col-4 text-right">
                                <a href="{{url('Shop/create')}}" class="btn btn-sm btn-primary">{{ __('Add New Shop') }}</a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 order-left">

                                <h3>Customer</h3>
                                <p class="mb-0">{{$data->userOrder->name}}</p>
                                <p>{{$data->userOrder->email}}</p>
                                {{-- <h3>Delivery Guy</h3>
                                <p class="mb-0">{{$data->deliveryGuy->name}}</p>
                                <p>{{$data->deliveryGuy->email}}</p> --}}
                                <h3>Technician Details </h3>
                                <p class="mb-0">Name: {{$data->technician->name ?? ''}}</p>
                                <p class="mb-0">{{$data->technician->email ?? ''}}</p>
                                {{-- <p>{{$data->location->name}}</p> --}}
                            </div>
                            <div class="col-6 text-right order-rigth">
                                <h3><span>Order Date : </span>{{$data->created_at->format('Y-m-d')}}</h3>
                                <h3><span>Order Status : </span>{{$data->status_name}}</h3>
                                <h3><span>Order Id : </span>{{$data->id}}</h3>


                            </div>


                            <div class="col-12 text-right order-rigth">

                                <h3><span>Payment Type : </span>{{$data->payment_type}}</h3>
                                <h3><span>Payment Status : </span>{{$data->status==0?'Pending' : 'Complete'}}</h3>
                                @if($data->payment_token!=null)
                                    <h3><span>Payment ID : </span>{{$data->payment_token}}</h3>
                                @endif

                            </div>

                        </div>

                        <div class="item-table table-responsive mt-5">


                        </div>
                        <div class="table-bottom mt-5">
                            <div class="row">
                                <div class="col-12 text-right">

                                    <h3><span>Delivery Charge : </span>{{$data->delivery_charge.'.00'}}</h3>
                                    <h3><span>Coupon Discount : </span>{{$data->coupon_price.'.00'}}</h3>

                                </div>
                            </div>
                        </div>
                        <div class="table-bottom mt-5">
                            <div class="row">
                                <div class="col-12 text-right">

                                    <h3><span>Delivery Charge : </span>{{$data->delivery_charge.'.00'}}</h3>
                                    <h3><span>Coupon Discount : </span>{{$data->coupon_price.'.00'}}</h3>

                                </div>
                            </div>


                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-8" style=" margin: 0px 70px; width:100%; height:400px " id="map"></div>

                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>

@endsection
@section('java_script')

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3wT8Q3pZDG5m61D7TtBAgP3Cjjf0H0gs&callback=initMap&libraries=&v=weekly"
        async
    ></script>

<script>

    var map;
    var service;
    var infowindow;

    function initMap() {
        var sydney = new google.maps.LatLng({{$data->lat}}, {{$data->lang}});

        infowindow = new google.maps.InfoWindow();

        map = new google.maps.Map(
            document.getElementById('map'), {center: sydney, zoom: 17});


    }

    function initMap() {
        const myLatLng = { lat: {{$data->lat}}, lng: {{$data->lang}} };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 17,
            center: myLatLng,
        });
        infowindow = new google.maps.InfoWindow();

        new google.maps.Marker({
            position: myLatLng,
            map,
        });
    }</script>
@endsection

