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

                            </div>
                        </div>


                        <div style=" padding: 10px; " class="table-responsive">
                            <table class="table yajra-datatable align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('#') }}</th>
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
                serverSide: true,
                scrollX: false,
                searching: false,

                type: "GET",

                "initComplete": function (settings, json) {
                    $(".dataTables_length").css('float', 'right')
                    $(".dataTables_filter").css('float', 'left')
                },
                ajax: {
                    url: "{{route('technicalAccountStatment')}}",
                    data: function (d) {
                        d.id={{$id}}


                    }
                },
                columns: [
                    {data:'DT_RowIndex',"searchable": false,"orderable": false,"targets": 0},
                    {data: 'category', name: 'category',searchable:false},
                    {data: 'owner_profit', name: 'owner_profit',searchable:false},
                    {data: 'technical_profit', name: 'technical_profit',searchable:false},
                    {data: 'time', name: 'time',searchable:false},
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    totalOwner = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotalOwner = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );


                    // Update footer
                    $( api.column( 2 ).footer() ).html(
                        ' SAR '+pageTotalOwner +' ( SAR'+ totalOwner +' {{__("Total")}})'
                    );






                    // Total over all pages
                    totalTeachnical = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Total over this page
                    pageTotalTeachnical = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );


                    // Update footer
                    $( api.column( 3 ).footer() ).html(
                        ' SAR '+pageTotalTeachnical +' ( SAR'+ totalTeachnical +' {{__("Total")}})'
                    );

                }

            });
            $('#public_search').on('click', function (e) {
                table.draw();
                e.preventDefault();
            });


        });




        $( document ).ready(function() {
            /*
                        $('input[name="daterange"]').val(null)
            */
        });
    </script>
@endsection
