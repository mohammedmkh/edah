@extends('admin.master', ['title' => __('User Management')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Grocery SubCategory') ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('SubCategory') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url(adminPath().'SubCategory/create')}}" class="btn btn-sm btn-primary">{{ __('Add SubCategory') }}</a>
                                </div>
                            </div>
                        </div>
                        <div id="search" class="pl-lg-4">


                            <div  class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status"> الحالة</label>
                                        <Select  name="status" id="status"
                                                 class="form-control select2 form-control-alternative" required>
                                            <option  value="">الحالة</option>
                                            <option  value="0">{{__('Active')}}</option>
                                            <option  value="1">{{__('DeActive')}}</option>

                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group ">
                                        <button id="public_search" type="button" class="btn btn-success mt-4">بحث
                                        </button>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group ">
                                        <button onclick="resetFilter()"  type="button" class="btn btn-danger mt-4">إعادة تعيين
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style=" padding: 10px; " class="table-responsive">
                                <table class="table yajra-datatable align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('#') }}</th>
                                            <th scope="col">{{ __('Image') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>
                                            <th scope="col">{{ __('Category') }}</th>
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
                    url: "{{route('subCategoryList')}}",
                    data: function (d) {
                        d.status=$('[name="status"]').val()


                    }
                },
                columns: [
                    {data: 'id', name: 'id',searchable:true},
                    {data: 'image', name: 'image',searchable:false},
                    {data: 'name', name: 'name',searchable:false},
                    {data: 'status', name: 'status',searchable:true},
                    {data: 'categoryName', name: 'categoryName',searchable:true},
                    {data: 'actions', name: 'actions',searchable:false},
                ]
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
