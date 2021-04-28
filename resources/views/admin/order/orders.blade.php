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
                                <div id="search" class="pl-lg-4">


                                    <div class="row">
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
                                                <label class="form-control-label" for="input-status">حالة الطلب</label>
                                                <Select name="status" id="status"
                                                        class="form-control select2 form-control-alternative" required>
                                                    <option value="">حالة الطلب</option>
                                                    @foreach($status as $value)
                                                        <option value="{{$value->id}}">{{$value->status_name}}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-status">الفنيين</label>
                                                <Select name="technical_id" id="technical_id"
                                                        class="form-control select2 form-control-alternative" required>
                                                    <option value="">الفنيين</option>
                                                    @foreach($technical as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-status">الزبائن</label>
                                                <Select name="user_id" id="user_id"
                                                        class="form-control select2 form-control-alternative" required>
                                                    <option value="">الزبائن</option>
                                                    @foreach($customer as $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group ">
                                                <button id="public_search" type="button" class="btn btn-success mt-4">
                                                    بحث
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group ">
                                                <button onclick="resetFilter()" type="button"
                                                        class="btn btn-danger mt-4">إعادة تعيين
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                    <div style="padding:10px;" class="table-responsive">
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
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

    </div>

@endsection


@section('java_script')


    <script type="text/javascript">

        $("#technical_id").select2()
        $("#user_id").select2()

        $(function () {
            $('input[name="daterange"]').daterangepicker({
                startDate: '03/05/2005',
                endDate: moment,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },

                showDropdowns: true,
                showCustomRangeLabel: true,
                opens: 'left',
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
                searching: false,
                "initComplete": function (settings, json) {
                    $(".dataTables_length").css('float', 'right')
                    $(".dataTables_filter").css('float', 'left')
                },
                ajax: {
                    url: "{{route('ordersList')}}",
                    data: function (d) {
                        d.order_no = $('input[name="order_no"]').val()
                        d.daterange = $('input[name="daterange"]').val()
                        d.technical_id = $('[name="technical_id"]').val();
                        d.user_id = $('[name="user_id"]').val()
                        d.status = $('[name="status"]').val()
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

        $(document).ready(function () {
            /*
                        $('input[name="daterange"]').val(null)
            */
        });
    </script>



@endsection
