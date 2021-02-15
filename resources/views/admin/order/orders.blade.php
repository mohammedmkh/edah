@extends('admin.master', ['title' => __('Orders')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Orders') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Orders') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    {{-- <a href="{{url('orderCreateNoti')}}"><button class="btn btn-sm btn-primary">{{ __('Click') }}</button></a> --}}
                                </div>                 
                            </div>
                        </div>
                        <div class="card-header border-0">
                            <div class="nav-wrapper">
                                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item"><a class="nav-link mb-sm-3 mb-md-0 active" id="allOrder-tab" data-toggle="tab" href="#allOrder" role="tab" aria-controls="allOrder" aria-selected="true"><i class="fas fa-utensils mr-2"></i>{{ __('All')}}<span class="badge label label-light-primary ml-2">{{ $totalOrder }}</span></a></li>
                                    <li class="nav-item"><a class="nav-link mb-sm-3 mb-md-0" id="pendingOrder-tab" data-toggle="tab" href="#pendingOrder" role="tab" aria-controls="pendingOrder" aria-selected="false"><i class="fa fa-download mr-2"></i>{{ __('Pending')}}<span class="badge label label-light-primary ml-2">{{ count($pendingOrder) }}</span></a></li>
                                    <li class="nav-item"><a class="nav-link mb-sm-3 mb-md-0" id="approveOrder-tab" data-toggle="tab" href="#approveOrder" role="tab" aria-controls="approveOrder" aria-selected="false"><i class="fas fa-check-square mr-2"></i>{{ __('Approved')}}<span class="badge label label-light-primary ml-2">{{ count($approveOrder) }}</span></a></li>
                                    <li class="nav-item"><a class="nav-link mb-sm-3 mb-md-0" id="onWayOrder-tab" data-toggle="tab" href="#onWayOrder" role="tab" aria-controls="onWayOrder" aria-selected="false"><i class="fas fa-motorcycle mr-2"></i>{{ __('On the way')}}<span class="badge label label-light-primary ml-2">{{ count($onWayOrder) }}</span></a></li>
                                    <li class="nav-item"><a class="nav-link mb-sm-3 mb-md-0" id="completeOrder-tab" data-toggle="tab" href="#completeOrder" role="tab" aria-controls="completeOrder" aria-selected="false"><i class="fas fa-thumbs-up mr-2"></i>{{ __('Delivered')}}<span class="badge label label-light-primary ml-2">{{ count($completeOrder) }}</span></a></li>
                                    <li class="nav-item"><a class="nav-link mb-sm-3 mb-md-0" id="CancelOrder-tab" data-toggle="tab" href="#CancelOrder" role="tab" aria-controls="CancelOrder" aria-selected="false"><i class="fas fa-window-close mr-2"></i>{{ __('Cancel')}}<span class="badge label label-light-primary ml-2">{{ count($cancelOrder) }}</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="allOrder" role="tabpanel" aria-labelledby="allOrder-tab">
                                    @if(count($orders)>0) 
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('Order ID') }}</th>
                                                    <th scope="col">{{ __('Shop') }}</th>
                                                    <th scope="col">{{ __('Customer') }}</th>                                                                                                       
                                                    <th scope="col">{{ __('payment') }}</th>    
                                                    <th scope="col">{{ __('date') }}</th>                                                       
                                                    <th scope="col">{{ __('Payment GateWay') }}</th>    
                                                    <th scope="col">{{ __('Order Status') }}</th>    
                                                    <th scope="col">{{ __('Payment Status') }}</th>    
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($orders as $order)                                        
                                                    <tr>
                                                        <td><span class="badge label label-light-warning">{{ $order->order_no }}</span></td>
                                                        <td>{{ $order->shop->name }}</td>
                                                        <td>{{ $order->customer->name }}</td>
                                                        {{-- <td class="assignOrder">                                                            
                                                            <select name="employee_id" id="employee_id-{{$order->id}}" class="form-control table-dropdown" {{$order->deliveryBoy_id==null?'':'disabled'}}>
                                                                <option value="">Assign DeliveryBoy</option>
                                                                @foreach ($deliveryBoy as $item)
                                                                <option value="{{$item->id}}"{{$order->deliveryBoy_id == $item->id?'Selected' : ''}}>{{$item->name}}</option>    
                                                                @endforeach                                                                
                                                            </select>
                                                        </td> --}}

                                                       
                                                        <td>{{ $currency.$order->payment.'.00'}}</td>
                                                        <td>{{ $order->date ." | ".$order->time}}</td>
                                                        <td>{{ $order->payment_type}}</td>
                                                        <td class="changeOrderStatus">                                                    
                                                        {{-- <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown">
                                                            <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                            <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                            <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}}>On the way</option>
                                                            <option value="Complete"{{$order->order_status == 'Complete'?'Selected' : ''}}>Complete</option>
                                                            <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                        </select> --}}
                                                        <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown" {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                            <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                            <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                            <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Accept Driver</option>
                                                            <option value="Prepare"{{$order->order_status == 'Prepare'?'Selected' : ''}}>Prepare Food</option>
                                                            <option value="DriverAtShop"{{$order->order_status == 'DriverAtShop'?'Selected' : ''}} disabled>Driver Come at Shop</option>
                                                            <option value="PickUpFood"{{$order->order_status == 'PickUpFood'?'Selected' : ''}} disabled>PickUp Food From Shop</option>
                                                            <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}} disabled>Driver On the way</option>
                                                            <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Reach at Doad Step</option>
                                                            <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} disabled>Delivered</option>                                                            
                                                            <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                        </select>
                                                        </td>                                                
                                                        <td class="changePaymentStatus">                                                     
                                                            <select name="payment_status" id="paymentStatus-{{$order->id}}" class="form-control table-dropdown" disabled>
                                                                <option value="0"{{$order->payment_status == 0?'Selected' : ''}}>Waiting</option>
                                                                <option value="1"{{$order->payment_status == 1?'Selected' : ''}}>Complete</option>
                                                                <option value="2"{{$order->payment_status == 2?'Selected' : ''}}>Return</option>
                                                            </select>
                                                        </td>
                                                        <td>   
                                                           
                                                            <a href="#" class="table-action" data-toggle="tooltip" data-original-title="{{$order->driver_otp}}">
                                                                <i class="fas fa-mobile-alt"></i></a>                                                                                                                  
                                                            <a href="{{url('viewOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                            <i class="fas fa-eye"></i></a>
                                                            <a href="{{url('orderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                                <i class="fas fa-file-invoice-dollar"></i> </a>                                                                                                                         
                                                            {{-- <a href="#" class="table-action" onclick="deleteData('ShopOrder','{{$order->id}}');"  data-toggle="tooltip" data-original-title="Delete Order">                                                            
                                                                <i class="fas fa-trash-alt text-danger"></i>
                                                            </a>   --}}
                                                        </td>
                                                    </tr> 
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <?php echo $orders->render(); ?>
                                    @else 
                                        <div class="empty-state text-center pb-3">
                                            <img src="{{url('images/empty3.png')}}" style="width:35%;height:220px;">
                                            <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                            <p style="font-weight:600;">Your Collection list is empty....</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade " id="pendingOrder" role="tabpanel" aria-labelledby="pendingOrder-tab">
                                    @if(count($pendingOrder)>0) 
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('Order ID') }}</th>
                                                    <th scope="col">{{ __('Shop') }}</th>
                                                    <th scope="col">{{ __('Customer') }}</th>                                                   
                                                    <th scope="col">{{ __('payment') }}</th>    
                                                    <th scope="col">{{ __('date') }}</th>    
                                                    <th scope="col">{{ __('Payment GateWay') }}</th>    
                                                    <th scope="col">{{ __('Order Status') }}</th>    
                                                    <th scope="col">{{ __('Payment Status') }}</th>    
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendingOrder as $order)                                        
                                                    <tr>
                                                        <td><span class="badge label label-light-warning">{{ $order->order_no }}</span></td>
                                                        <td>{{ $order->shop->name }}</td>     
                                                        <td>{{ $order->customer->name }}</td>                                                                                                            
                                                        <td>{{ $currency.$order->payment.'.00'}}</td>
                                                        <td>{{ $order->date ." | ".$order->time}}</td>
                                                        <td>{{ $order->payment_type}}</td>
                                                        <td class="changeOrderStatus">                                                    
                                                            <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown"  {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                                <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                                <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                                <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Accept Driver</option>
                                                                <option value="Prepare"{{$order->order_status == 'Prepare'?'Selected' : ''}}>Prepare Food</option>
                                                                <option value="DriverAtShop"{{$order->order_status == 'DriverAtShop'?'Selected' : ''}} disabled>Driver Come at Shop</option>
                                                                <option value="PickUpFood"{{$order->order_status == 'PickUpFood'?'Selected' : ''}} disabled>PickUp Food From Shop</option>
                                                                <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}} disabled>Driver On the way</option>
                                                                <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Reach at Doad Step</option>
                                                                <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} disabled>Delivered</option>                                                            
                                                                <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                            </select>
                                                        </td>                                                
                                                        <td class="changePaymentStatus">                                                     
                                                            <select name="payment_status" id="paymentStatus-{{$order->id}}" class="form-control table-dropdown" disabled>
                                                                <option value="0"{{$order->payment_status == 0?'Selected' : ''}}>Waiting</option>
                                                                <option value="1"{{$order->payment_status == 1?'Selected' : ''}}>Complete</option>
                                                                <option value="2"{{$order->payment_status == 2?'Selected' : ''}}>Return</option>
                                                            </select>
                                                        </td>
                                                        <td>   
                                                        <a href="{{url('viewOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                            <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{url('orderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                                <i class="fas fa-file-invoice-dollar"></i>
                                                            </a>                                                                                                                         
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
                                <div class="tab-pane fade " id="approveOrder" role="tabpanel" aria-labelledby="approveOrder-tab">
                                    @if(count($approveOrder)>0) 
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('Order ID') }}</th>
                                                    <th scope="col">{{ __('Shop') }}</th>
                                                    <th scope="col">{{ __('Customer') }}</th>
                                                   
                                                    <th scope="col">{{ __('payment') }}</th>    
                                                    <th scope="col">{{ __('date') }}</th> 
                                                    <th scope="col">{{ __('Payment GateWay') }}</th>    
                                                    <th scope="col">{{ __('Order Status') }}</th>    
                                                    <th scope="col">{{ __('Payment Status') }}</th>    
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($approveOrder as $order)                                        
                                                    <tr>
                                                        <td><span class="badge label label-light-warning">{{ $order->order_no }}</span>                                                      
                                                        </td>
                                                        <td>{{ $order->shop->name }}</td>     
                                                        <td>{{ $order->customer->name }}</td>
                                                       
                                                        <td>{{ $currency.$order->payment.'.00'}}</td>
                                                        <td>{{ $order->date ." | ".$order->time}}</td>
                                                        <td>{{ $order->payment_type}}</td>
                                                        <td class="changeOrderStatus">                                                    
                                                            <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown"  {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                                <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                                <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                                <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Accept Driver</option>
                                                                <option value="Prepare"{{$order->order_status == 'Prepare'?'Selected' : ''}}>Prepare Food</option>
                                                                <option value="DriverAtShop"{{$order->order_status == 'DriverAtShop'?'Selected' : ''}} disabled>Driver Come at Shop</option>
                                                                <option value="PickUpFood"{{$order->order_status == 'PickUpFood'?'Selected' : ''}} disabled>PickUp Food From Shop</option>
                                                                <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}} disabled>Driver On the way</option>
                                                                <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Reach at Doad Step</option>
                                                                <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} disabled>Delivered</option>                                                            
                                                                <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                            </select>
                                                        </td>                                                
                                                        <td class="changePaymentStatus">                                                     
                                                            <select name="payment_status" id="paymentStatus-{{$order->id}}" class="form-control table-dropdown" disabled>
                                                                <option value="0"{{$order->payment_status == 0?'Selected' : ''}}>Waiting</option>
                                                                <option value="1"{{$order->payment_status == 1?'Selected' : ''}}>Complete</option>
                                                                <option value="2"{{$order->payment_status == 2?'Selected' : ''}}>Return</option>
                                                            </select>
                                                        </td>
                                                        <td>  
                                                            <a class="table-action" data-toggle="tooltip" data-original-title="{{$order->driver_otp}}">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </a>  
                                                        <a href="{{url('viewOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                            <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{url('orderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                                <i class="fas fa-file-invoice-dollar"></i>
                                                            </a>                                                                                                                         
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
                                <div class="tab-pane fade " id="onWayOrder" role="tabpanel" aria-labelledby="onWayOrder-tab">
                                    @if(count($onWayOrder)>0) 
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('Order ID') }}</th>
                                                    <th scope="col">{{ __('Shop') }}</th>
                                                    <th scope="col">{{ __('Customer') }}</th>
                                                   
                                                    <th scope="col">{{ __('payment') }}</th>    
                                                    <th scope="col">{{ __('date') }}</th>    
                                                    <th scope="col">{{ __('Payment GateWay') }}</th>    
                                                    <th scope="col">{{ __('Order Status') }}</th>    
                                                    <th scope="col">{{ __('Payment Status') }}</th>    
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($onWayOrder as $order)                                        
                                                    <tr>
                                                        <td><span class="badge label label-light-warning">{{ $order->order_no }}</span></td>
                                                        <td>{{ $order->shop->name }}</td>     
                                                        <td>{{ $order->customer->name }}</td>
                                                      
                                                        <td>{{ $currency.$order->payment.'.00'}}</td>
                                                        <td>{{ $order->date." | ".$order->time}}</td>
                                                        <td>{{ $order->payment_type}}</td>
                                                        <td class="changeOrderStatus">                                                    
                                                            <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown"  {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                                <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                                <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                                <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Accept Driver</option>
                                                                <option value="Prepare"{{$order->order_status == 'Prepare'?'Selected' : ''}}>Prepare Food</option>
                                                                <option value="DriverAtShop"{{$order->order_status == 'DriverAtShop'?'Selected' : ''}} disabled>Driver Come at Shop</option>
                                                                <option value="PickUpFood"{{$order->order_status == 'PickUpFood'?'Selected' : ''}} disabled>PickUp Food From Shop</option>
                                                                <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}} disabled>Driver On the way</option>
                                                                <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Reach at Doad Step</option>
                                                                <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} disabled>Delivered</option>                                                            
                                                                <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                            </select>
                                                        </td>                                                
                                                        <td class="changePaymentStatus">                                                     
                                                            <select name="payment_status" id="paymentStatus-{{$order->id}}" class="form-control table-dropdown" disabled>
                                                                <option value="0"{{$order->payment_status == 0?'Selected' : ''}}>Waiting</option>
                                                                <option value="1"{{$order->payment_status == 1?'Selected' : ''}}>Complete</option>
                                                                <option value="2"{{$order->payment_status == 2?'Selected' : ''}}>Return</option>
                                                            </select>
                                                        </td>
                                                        <td>  
                                                           
                                                            <a href="{{url('viewOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                            <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{url('orderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                                <i class="fas fa-file-invoice-dollar"></i>
                                                            </a>                                                                                                                         
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
                                <div class="tab-pane fade " id="completeOrder" role="tabpanel" aria-labelledby="completeOrder-tab">
                                    @if(count($completeOrder)>0) 
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('Order ID') }}</th>
                                                    <th scope="col">{{ __('Shop') }}</th>
                                                    <th scope="col">{{ __('Customer') }}</th>
                                                  
                                                    <th scope="col">{{ __('payment') }}</th>    
                                                    <th scope="col">{{ __('date') }}</th>    
                                                    <th scope="col">{{ __('Payment GateWay') }}</th>    
                                                    <th scope="col">{{ __('Order Status') }}</th>    
                                                    <th scope="col">{{ __('Payment Status') }}</th>    
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($completeOrder as $order)                                        
                                                    <tr>
                                                        <td><span class="badge label label-light-warning">{{ $order->order_no }}</span></td>
                                                        <td>{{ $order->shop->name }}</td>     
                                                        <td>{{ $order->customer->name }}</td>                                                       
                                                   
                                                        <td>{{ $currency.$order->payment.'.00'}}</td>
                                                        <td>{{ $order->date ." | ".$order->time}}</td>
                                                        <td>{{ $order->payment_type}}</td>
                                                        <td class="changeOrderStatus">                                                    
                                                            <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown"  {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                                <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                                <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                                <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Accept Driver</option>
                                                                <option value="Prepare"{{$order->order_status == 'Prepare'?'Selected' : ''}}>Prepare Food</option>
                                                                <option value="DriverAtShop"{{$order->order_status == 'DriverAtShop'?'Selected' : ''}} disabled>Driver Come at Shop</option>
                                                                <option value="PickUpFood"{{$order->order_status == 'PickUpFood'?'Selected' : ''}} disabled>PickUp Food From Shop</option>
                                                                <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}} disabled>Driver On the way</option>
                                                                <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Reach at Doad Step</option>
                                                                <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} disabled>Delivered</option>                                                            
                                                                <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                            </select>
                                                        </td>                                                
                                                        <td class="changePaymentStatus">                                                     
                                                            <select name="payment_status" id="paymentStatus-{{$order->id}}" class="form-control table-dropdown" disabled>
                                                                <option value="0"{{$order->payment_status == 0?'Selected' : ''}}>Waiting</option>
                                                                <option value="1"{{$order->payment_status == 1?'Selected' : ''}}>Complete</option>
                                                                <option value="2"{{$order->payment_status == 2?'Selected' : ''}}>Return</option>
                                                            </select>
                                                        </td>
                                                        <td>   
                                                        <a href="{{url('viewOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                            <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{url('orderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                                <i class="fas fa-file-invoice-dollar"></i>
                                                            </a>                                                                                                                         
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
                                <div class="tab-pane fade " id="CancelOrder" role="tabpanel" aria-labelledby="CancelOrder-tab">
                                    @if(count($cancelOrder)>0) 
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">{{ __('Order ID') }}</th>
                                                    <th scope="col">{{ __('Shop') }}</th>
                                                    <th scope="col">{{ __('Customer') }}</th>                                                   
                                                    <th scope="col">{{ __('payment') }}</th>    
                                                    <th scope="col">{{ __('date') }}</th>    
                                                    <th scope="col">{{ __('Payment GateWay') }}</th>    
                                                    <th scope="col">{{ __('Order Status') }}</th>    
                                                    <th scope="col">{{ __('Payment Status') }}</th>    
                                                    <th scope="col">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cancelOrder as $order)                                        
                                                    <tr>
                                                        <td><span class="badge label label-light-warning">{{ $order->order_no }}</span></td>
                                                        <td>{{ $order->shop->name }}</td>     
                                                        <td>{{ $order->customer->name }}</td>                                                       
                                                        <td>{{ $currency.$order->payment.'.00'}}</td>
                                                        <td>{{ $order->date ." | ".$order->time}}</td>
                                                        <td>{{ $order->payment_type}}</td>
                                                        <td class="changeOrderStatus">                                                    
                                                            <select name="order_status" id="orderStatus-{{$order->id}}" class="form-control table-dropdown"  {{$order->order_status=="Cancel" || $order->order_status=="Delivered" ? 'disabled':''}}>
                                                                <option value="Pending"{{$order->order_status == 'Pending'?'Selected' : ''}}>Pending</option>
                                                                <option value="Approved"{{$order->order_status == 'Approved'?'Selected' : ''}}>Approved</option>
                                                                <option value="DriverApproved"{{$order->order_status == 'DriverApproved'?'Selected' : ''}} disabled>Accept Driver</option>
                                                                <option value="Prepare"{{$order->order_status == 'Prepare'?'Selected' : ''}}>Prepare Food</option>
                                                                <option value="DriverAtShop"{{$order->order_status == 'DriverAtShop'?'Selected' : ''}} disabled>Driver Come at Shop</option>
                                                                <option value="PickUpFood"{{$order->order_status == 'PickUpFood'?'Selected' : ''}} disabled>PickUp Food From Shop</option>
                                                                <option value="OnTheWay"{{$order->order_status == 'OnTheWay'?'Selected' : ''}} disabled>Driver On the way</option>
                                                                <option value="DriverReach"{{$order->order_status == 'DriverReach'?'Selected' : ''}} disabled>Reach at Doad Step</option>
                                                                <option value="Delivered"{{$order->order_status == 'Delivered'?'Selected' : ''}} disabled>Delivered</option>                                                            
                                                                <option value="Cancel"{{$order->order_status == 'Cancel'?'Selected' : ''}}>Cancel</option>
                                                            </select>
                                                        </td>                                                
                                                        <td class="changePaymentStatus">                                                     
                                                            {{-- {{$order->payment_status==1 ? 'disabled':''}} --}}
                                                            <select name="payment_status" id="paymentStatus-{{$order->id}}" class="form-control table-dropdown" disabled>
                                                                <option value="0"{{$order->payment_status == 0?'Selected' : ''}}>Waiting</option>
                                                                <option value="1"{{$order->payment_status == 1?'Selected' : ''}}>Complete</option>
                                                                <option value="2"{{$order->payment_status == 2?'Selected' : ''}}>Return</option>
                                                            </select>
                                                        </td>
                                                        <td>   
                                                        <a href="{{url('viewOrder/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                            <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{url('orderInvoice/'.$order->id.$order->order_no)}}" class="table-action" data-toggle="tooltip" data-original-title="view Invoice">
                                                                <i class="fas fa-file-invoice-dollar"></i>
                                                            </a>                                                                                                                         
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
       
    </div>

@endsection