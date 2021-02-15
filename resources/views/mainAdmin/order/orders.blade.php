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
                                {{-- <div class="col-4 text-right">
                                    <a href="{{url('Shop/create')}}" class="btn btn-sm btn-primary">{{ __('Add New Shop') }}</a>
                                </div> --}}
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($orders)>0) 
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Order ID') }}</th>
                                            <th scope="col">{{ __('Customer') }}</th>
                                            <th scope="col">{{ __('Delivery Guy') }}</th>    
                                            {{-- <th scope="col">{{ __('Location') }}</th>   --}}
                                            <th scope="col">{{ __('payment') }}</th> 
                                            <th scope="col">{{ __('date') }}</th>   
                                            <th scope="col">{{ __('Payment GateWay') }}</th>    
                                            <th scope="col">{{ __('Order Status') }}</th>    
                                            <th scope="col">{{ __('Payment Status') }}</th>    
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                        
                                            <tr>
                                                <td><span class="badge label label-light-warning">{{ $order->order_no }}</span></td>
                                                <td>{{ $order->customer->name }}</td>
                                                {{-- <td>{{ $order->deliveryGuy->name }}</td> --}}
                                                {{-- <td>{{ $order->location->name}}</td> --}}
                                                <td>{{ $currency.$order->payment.'.00'}}</td>
                                                <td>{{ $order->created_at->format('Y-m-d')}}</td>
                                                <td>{{ $order->payment_type}}</td>
                                                <td>
                                                    {{-- {{ $order->order_status}} --}}
                                                    <select name="order_status" id="order_status" class="form-control table-dropdown">
                                                        <option value="Pending">Pending</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="OnTheWay">On the way</option>
                                                        <option value="Complete">Complete</option>
                                                        <option value="Cancle">Cancle</option>
                                                    </select>
                                                </td>
                                               
                                                <td>
                                                    {{-- <span class="badge badge-dot mr-4">
                                                        <i class="{{$order->payment_status==1?'bg-success': 'bg-warning'}}"></i>
                                                        <span class="status">{{$order->payment_status==1?'Complete': 'Pending'}}</span>
                                                    </span> --}}
                                                    <select name="payment_status" id="payment_status" class="form-control table-dropdown">
                                                        <option value="0">Waiting</option>
                                                        <option value="1">Complete</option>
                                                        <option value="2">Return</option>
                                                    </select>
                                                </td>
                                                <td>                            
                                            
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{url('Order/'.$order->id.$order->order_no)}}">{{ __('View Order') }}</a>
                                                            <a class="dropdown-item" href="#">{{ __('View Invoice') }}</a>
                                                            <a class="dropdown-item" onclick="deleteData('Order','{{$order->id}}');" href="#">{{ __('Delete') }}</a>
                                                        </div>
                                                    </div>
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
                    </div>
            </div>
        </div>
       
    </div>

@endsection