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
                                    <h3 class="mb-0">{{ __('Grocery Orders') }}</h3>
                                </div>                                             
                            </div>
                        </div>
                    </div>                       

                    <div class="table-responsive">
                        @if(count($orders)>0)
                            <table class="table data-table align-items-center table-flush yajra-datatable" >
                                <thead class="thead-light">
                                    <tr>

                                        <th scope="col">{{ __('Order ID') }}</th>

                                        <th scope="col">{{ __('Customer') }}</th>                                                   
                                        <th scope="col">{{ __('payment') }}</th>    
                                        <th scope="col">{{ __('date') }}</th>  

                                        <th scope="col">{{ __('Payment GateWay') }}</th>    

                                        <th scope="col">{{ __('Payment Status') }}</th>    
                                        <th scope="col">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>

                                            <td>{{ $order->id }}</td>

                                            <td>{{ $order->userOrder->name }}</td>
                                            <td>{{ $order->price.'.00' }}</td>
                                            <td>{{ $order->date.' | '.$order->time }}</td>

                                            <td>{{ $order->payment_type }}</td>

                                            
                                            <td>
                                                <span class="badge badge-dot mr-4">
                                                    <i class="{{$order->payment_status==1?'bg-success': 'bg-warning'}}"></i>
                                                    <span class="status">{{$order->payment_status==1?'Completed': 'Pending'}}</span>
                                                </span>
                                            </td>
                                            <td>  

                                                <a href="{{url(adminPath().'viewOrder/'.$order->id)}}" class="table-action" data-toggle="tooltip" data-original-title="View Order">
                                                <i class="fas fa-eye"></i></a>

                                            </td>                                                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <?php echo $orders->render(); ?>
                            @else 
                                <div class="empty-state text-center pb-3" style="background: #fff;">
                                    <img src="{{url('images/empty3.png')}}" style="width:35%;height:220px;">
                                    <p style="font-weight:600;">لا يوجد طلبات بعد</p>
                                </div> 
                            @endif
                        </div>
                      
            </div>
        </div>
       
    </div>

@endsection


@section('javascript')

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>



    <script type="text/javascript">


        $(function () {


            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: false,
                type:"GET",
                ajax: "{{ route('ordersList') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'userOrder.name', name: 'userOrder.name'},
                    {data: 'price', name: 'price'},
                    {data: 'time', name: 'time'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions'},
                ]
            });


            $('.datatable-Order').each(function () {

                oTable =  $(this)
                    .on('preXhr.dt', function (e, settings, data) {

                        data.scheduled   =  $('#scheduled').val() ;
                        data.day_type    =  $('#day_type').val() ;
                        data.usersname   =  $('#usersname').val() ;
                        data.usersname_cont = $('#usersname_cont').val() ;

                    })
                    .DataTable(dtOverrideGlobals);
                if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
                    $(this).siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">'+window.deleteButtonTrans+'</a>');
                }
            });



            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });






        });





        function search(){
            $('.ajaxTable').show();
            oTable.ajax.reload();
        }
    </script>



@endsection