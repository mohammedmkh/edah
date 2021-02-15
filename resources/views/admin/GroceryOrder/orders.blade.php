@extends('admin.master', ['title' => __('Orders')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Grocery Orders') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Grocery Orders') }}</h3>
                                </div>                                             
                            </div>
                        </div>
                    </div>                       

                    <div class="table-responsive">
                        @if(count($orders)>0)
                            <table class="table data-table align-items-center table-flush" >
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">{{ __('#') }}</th>
                                        <th scope="col">{{ __('Order ID') }}</th>
                                        <th scope="col">{{ __('Shop') }}</th>
                                        <th scope="col">{{ __('Customer') }}</th>                                                   
                                        <th scope="col">{{ __('payment') }}</th>    
                                        <th scope="col">{{ __('date') }}</th>  
                                        <th scope="col">{{ __('Delivery Type') }}</th>                
                                        <th scope="col">{{ __('Payment GateWay') }}</th>    
                                        <th scope="col">{{ __('Order Status') }}</th>    
                                        <th scope="col">{{ __('Payment Status') }}</th>    
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>                                            
                                            <td>{{ $order->order_no }}</td>
                                            <td>{{ $order->shop->name }}</td>
                                            <td>{{ $order->customer->name }}</td>                                              
                                            <td>{{ $currency.$order->payment.'.00' }}</td>
                                            <td>{{ $order->date.' | '.$order->time }}</td>
                                            <td>{{ $order->delivery_type }}</td>
                                            <td>{{ $order->payment_type }}</td>
                                            <td class="changeGroceryOrderStatus">
                                                <select id="order-{{$order->id}}" name="order_status" class=" form-control table-dropdown" {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                    <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                    <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Shop Approved</option>
                                                    @if($order->delivery_type=="delivery")
                                                    <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Driver Approved</option>
                                                    @endif
                                                    <option value="OrderReady"{{$order->order_status == 'OrderReady'?'Selected' : ''}}>Order is Ready at Store</option>
                                                    @if($order->delivery_type=="delivery")                                                    
                                                    <option value="PickUpGrocery"{{$order->order_status == 'PickUpGrocery'?'Selected' : ''}} disabled>Driver Pickup Grocery at Store</option>                                                  
                                                    <option value="OutOfDelivery"{{$order->order_status == 'OutOfDelivery'?'Selected' : ''}} disabled>Order is Out Of Delivery</option>                                                  
                                                    <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Order is near to Customer</option>                                                  
                                                    @endif
                                                    <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} {{$order->delivery_type=="delivery"? 'disabled': ''}}>Delivered</option>                                                            
                                                    <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                </select>
                                            </td>
                                            
                                            <td>
                                                <span class="badge badge-dot mr-4">
                                                    <i class="{{$order->payment_status==1?'bg-success': 'bg-warning'}}"></i>
                                                    <span class="status">{{$order->payment_status==1?'Completed': 'Pending'}}</span>
                                                </span>
                                            </td>
                                            <td>  
                                             <a href="#" class="table-action" data-toggle="tooltip" data-original-title="{{$order->order_otp}}">
                                                                <i class="fas fa-mobile-alt"></i></a>                                                                                                             
                                                <a href="{{url('viewGroceryOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                <i class="fas fa-eye"></i></a>
                                                <a href="{{url('groceryOrderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                <i class="fas fa-file-invoice-dollar"></i> </a>    
                                            </td>                                                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <?php echo $orders->render(); ?>
                            @else 
                                <div class="empty-state text-center pb-3" style="background: #fff;">
                                    <img src="{{url('images/empty3.png')}}" style="width:35%;height:220px;">
                                    <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                    <p style="font-weight:600;">Your Collection list is empty....</p>
                                </div> 
                            @endif
                        </div>
                      
            </div>
        </div>
       
    </div>

@endsection