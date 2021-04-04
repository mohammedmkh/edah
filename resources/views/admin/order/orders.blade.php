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
                                <br>
                                <div class="pl-lg-4">


                                    <div id="search" class="row">
                                        <div class="col-4">
                                            <div class="form-group ">
                                                <label class="form-control-label" for="input-hour_work">رقم الطلب
                                                </label>
                                                <input type="number" name="order_no"
                                                       class="form-control form-control-alternative"
                                                       placeholder="رقم الطلب" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group ">
                                                <label class="form-control-label" for="input-hour_work">تاريخ الطلب
                                                </label>
                                                <input type="text" name="daterange"
                                                       class="form-control form-control-alternative"
                                                       placeholder="تاريخ الطلب" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-status">الحالة</label>
                                                <Select  name="technical" id="technical"
                                                        class="form-control select2 form-control-alternative" required>
                                                    <option  value="">التقني</option>
                                                    @foreach($technical as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group ">
                                            <button id="public_search" type="button" class="btn btn-success mt-4">بحث
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div style="padding:10px;" class="table-responsive">
                @if(count($orders)>0)
                    <table class="table data-table align-items-center table-flush yajra-datatable">
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
                                                    <span
                                                        class="status">{{$order->payment_status==1?'Completed': 'Pending'}}</span>
                                                </span>
                                </td>
                                <td>

                                    <a href="{{url(adminPath().'viewOrder/'.$order->id)}}" class="table-action"
                                       data-toggle="tooltip" data-original-title="View Order">
                                        <i class="fas fa-eye"></i></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$orders->render()}}
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


@section('java_script')


    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">

        $("#technical").select2()
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                autoUpdateInput: false,
                autoApply: true,
                locale: {
                    cancelLabel: 'Clear',

                    format: 'YYYY-MM-DD'
                }
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
        $(function () {


            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: false,
                type: "GET",

                "initComplete": function (settings, json) {
                    $(".dataTables_length").css('float', 'right')
                    $(".dataTables_filter").css('float', 'left')
                },
                ajax: {
                    url: "{{route('ordersList')}}",
                    data: function (d) {
                        d.order_no=$('input[name="order_no"]').val()
                        d.daterange=$('input[name="daterange"]').val()
                        d.technical=$('[name="technical"]').val()
                    }
                },
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
            $('#public_search').on('click', function (e) {
                table.draw();
                e.preventDefault();
            });

            $('.datatable-Order').each(function () {

                oTable = $(this)
                    .on('preXhr.dt', function (e, settings, data) {

                        data.scheduled = $('#scheduled').val();
                        data.day_type = $('#day_type').val();
                        data.usersname = $('#usersname').val();
                        data.usersname_cont = $('#usersname_cont').val();

                    })
                    .DataTable(dtOverrideGlobals);
                if (typeof window.route_mass_crud_entries_destroy != 'undefined') {
                    $(this).siblings('.actions').html('<a href="' + window.route_mass_crud_entries_destroy + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">' + window.deleteButtonTrans + '</a>');
                }
            });


            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });


        });


        function search() {
            $('.ajaxTable').show();
            oTable.ajax.reload();
        }
    </script>



@endsection
