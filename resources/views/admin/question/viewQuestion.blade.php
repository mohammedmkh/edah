@extends('admin.master', ['title' => __('Manage Question')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Question') ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card form-card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Question') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{url(adminPath().'Question/create')}}"
                                   class="btn btn-sm btn-primary">{{ __('Add New Question') }}</a>
                            </div>
                        </div>
                    </div>
                    <div style=" padding: 10px;" class="table-responsive">
                        <table class="table align-items-center yajra-datatable table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Question') }}</th>
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

@endsection
@section('java_script')

    <script type="text/javascript">

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
                    url: "{{route('questionList')}}",
                    data: function (d) {
                        d.status = $('[name="status"]').val()


                    }
                },
                columns: [
                    {data: 'id', name: 'id', searchable: true},
                    {data: 'name', name: 'name', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false},
                ]
            });
            $('#public_search').on('click', function (e) {
                table.draw();
                e.preventDefault();
            });


        });


        $(document).ready(function () {
            /*
                        $('input[name="daterange"]').val(null)
            */
        });
    </script>
@endsection
