@extends('admin.master', ['title' => __('DashBoard')])

@section('content')
{{-- @include('admin.layout.topHeader', [
        'title' => __('DashBoard') ,
        'class' => 'col-lg-7'
    ])  --}}

@if(Session::has('success'))
@include('toast',Session::get('success'))
@endif

<div class="header pb-8 pt-5 d-flex pt-lg-8"
    style="background-image: url({{url('admin/images/bg.jpg')}}); background-size: cover; background-position: center center;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid">

        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted">{{ __('Shops')}}</h5>
                                    <span class="h2 font-weight-bold">{{ $store_users_count }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                        <i class="fas fa-store"> </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted">{{ __('New Customers')}}</h5>
                                    <span class="h2 font-weight-bold">{{$master['users']}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted">{{ __('Sales')}}</h5>
                                    <span class="h2 font-weight-bold"></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted">{{ __('Technician Users')}}</h5>
                                    <span class="h2 font-weight-bold">{{$tech_users_count}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                        <i class="ni ni-delivery-fast"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--7">
    <?php 
        $sell_product =  \App\Setting::find(1)->sell_product;       
    ?>
    
    @if($sell_product == 2 || $sell_product == 0)

    @if(\App\Setting::find(1)->default_grocery_order_status == "Pending")
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Grocery Order Requests') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{url(adminPath().'Order')}}" class="btn btn-sm btn-primary">{{ __('See all') }}</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="grocery-pending-order">
                    @if(count($orders)>0)
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Order ID') }}</th>
                                <th scope="col">{{ __('Customer') }}</th>
                                <th scope="col">{{ __('payment') }}</th>
                                <th scope="col">{{ __('date') }}</th>
                                <th scope="col">{{ __('Payment GateWay') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td><span class="badge label label-light-warning">{{ $order->id }}</span></td>
                                <td>{{ $order->userOrder->name }}</td>
                                <td>{{ $order->price.'.00'}}</td>
                                <td>{{ $order->date ." | ".$order->time}}</td>
                                <td>{{ $order->price}}</td>
                                <td>
                                    {{-- "{{url('accept-gocery-order/'.$order->id)}}" --}}

                                    {{-- {{url('reject-grocery-order/'.$order->id)}} --}}
                                    <a href="{{url(adminPath().'viewOrder/'.$order->id)}}" class="table-action"
                                        data-toggle="tooltip" data-original-title="View Order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state text-center pb-3">
                        <img src="{{url('images/empty3.png')}}" style="width:30%;height:200px;">
                        <p style="font-weight:600;">لا يوجد طلبات بعد</p>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @endif
    @endif


</div>

@endsection