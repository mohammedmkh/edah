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
                                <h3 class="mb-0">{{ __('Technical Account Statement Historey') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" onclick="posting('{{$id}}')"
                                   class="btn btn-sm btn-primary">{{ __('Posting') }}</a>
                            </div>
                        </div>
                    </div>


                    <div style=" overflow-x: hidden ; padding: 10px; " class="table-responsive">
                        <table class="table yajra-datatable align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Date Posting') }}</th>
                                <th scope="col">{{ __('Total  Posting') }}</th>
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

        $(function () {


            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: false,

                searching: false,
                bPaginate: false,
                info: false,

                type: "GET",

                "initComplete": function (settings, json) {
                    $(".dataTables_length").css('float', 'right')
                    $(".dataTables_filter").css('float', 'left')
                },
                ajax: {
                    url: "{{route('getTechnicalAccountStatmentHistory')}}",
                    data: function (d) {
                        d.id ={{$id}}


                    }
                },
                columns: [
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'total_technical', name: 'total_technical', searchable: false},
                    {data: 'action', name: 'action', searchable: false},
                ],

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
            var technical_id = '{{$id}}';

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
                    }else {
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
