@extends('admin.master', ['title' => __('Delivery Boys')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Technician') ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card form-card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Account Statment') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" onclick="posting('{{$technical_id}}')"
                                   class="btn btn-sm btn-primary">{{ __('Posting') }}</a>

                                <a target="_blank" href="{{url(adminPath().'technicalAccountStatmentExcel/'.$posting_id.'/'.$technical_id)}}"
                                   class="btn btn-sm btn-primary">{{ __('Excel') }}</a>
                                <a target="_blank" href="{{url(adminPath().'technicalAccountStatmentExcel/'.$posting_id.'/'.$technical_id)}}"
                                   class="btn btn-sm btn-primary">{{ __('PDF') }}</a>
                            </div>
                        </div>
                    </div>


                    <div style=" overflow-x: hidden ; padding: 10px; " class="table-responsive">
                        <table class="table yajra-datatable align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Category') }}</th>
                                <th scope="col">{{ __('Owner Profit') }}</th>
                                <th scope="col">{{ __('Technical Profit') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="text-align:right">{{__("Total")}}:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
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

        $(function () {


            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: false,
                scrollX: false,
                scrollY: false,
                searching: false,
                bPaginate: false,
                info: false,

                type: "GET",
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                buttons: [
                    {
                        text: 'تحديث',
                        className: 'btn green reload productTable',
                        action: function (e, dt, node, config) {
                            dt.ajax.reload();
                        }
                    },


                ],
                "initComplete": function (settings, json) {
                    $(".dataTables_length").css('float', 'right')
                    $(".dataTables_filter").css('float', 'left')
                },
                ajax: {
                    url: "{{route('technicalAccountStatment')}}",
                    data: function (d) {
                        d.id = '{{$technical_id}}'
                        d.posting_id ='{{$posting_id}}'


                    }
                },
                columns: [
                    {data: 'DT_RowIndex', "searchable": false, "orderable": false, "targets": 0},
                    {data: 'id', name: 'id', className: 'idd', searchable: false},
                    {data: 'category', name: 'category', searchable: false},
                    {data: 'owner_profit', name: 'owner_profit', searchable: false},
                    {data: 'technical_profit', name: 'technical_profit', searchable: false},
                    {data: 'time', name: 'time', searchable: false},
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    totalOwner = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotalOwner = api
                        .column(3, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                    $(api.column(3).footer()).html(
                        ' ( {{__("Total")}} ' + totalOwner + ' {{__("SAR")}} )'
                    );


                    // Total over all pages
                    totalTechnical = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotalTeachnical = api
                        .column(4, {page: 'all'})
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);


                    $(api.column(4).footer()).html(
                        ' ( {{__("Total")}} ' + totalTechnical + ' {{__("SAR")}} )'
                    );
                    $(api.column(4).footer()).attr('totalTechnical', totalTechnical);


                }

            });
            $('#public_search').on('click', function (e) {
                table.draw();
                e.preventDefault();
            });


        });


        function posting(id) {
            event.preventDefault();
            var first_order_id = $("tbody tr:last td:eq(1)").text();
            var last_order_id = $("tbody tr:first td:eq(1)").text();
            var total_technical = $('tfoot tr th:eq(4)').attr('totalTechnical');
            var technical_id = '{{$technical_id}}';

            $.ajax({
                url: '{{url('')}}/panel/tech_posting',
                data: {
                    _token: '{{csrf_token()}}',
                    technical_id: technical_id,
                    first_order_id: first_order_id,
                    last_order_id: last_order_id,
                    total_technical: total_technical
                },
                type: "POST",
                success: function (data, textStatus, jqXHR) {

                    if (data.success == true) {
                        location.reload();
                    } else {
                        alert("لا توجد بيانات متوفرة في الجدول لترحيلها")

                    }

                },
                error: function (data, textStatus, jqXHR) {

                    alert(data.message)
                },
            });

        }


        $(document).ready(function () {
            /*
                        $('input[name="daterange"]').val(null)
            */
        });
    </script>
@endsection
