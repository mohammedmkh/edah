@extends('admin.master', ['title' => __('Manage Coupon')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __(' Coupon') ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card form-card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Grocery Coupon') }}</h3><br>

                            </div>
                            <div class="col-4 text-right">
                                <a href="{{url(adminPath().'Coupon/create')}}" class="btn btn-sm btn-primary">{{ __('Add New Coupon') }}</a>
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
                                            <option  value="0">Active</option>
                                            <option  value="1">DeActive</option>

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

                    </div>

                    <div style="padding: 10px;  "  class="table-responsive">
                            <table class="table align-items-center yajra-datatable table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('#') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Code') }}</th>
                                    <th scope="col">{{ __('Discount') }}</th>
                                    <th scope="col">{{ __('Maximum Usage') }}</th>
                                    <th scope="col">{{ __('already Use') }}</th>
                                    <th scope="col">{{ __('Duration') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
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
                url: "{{route('couponsList')}}",
                data: function (d) {
                    d.status=$('[name="status"]').val()


                }
            },
            columns: [
                {data: 'id', name: 'id',searchable:true},
                {data: 'name', name: 'name',searchable:true},
                {data: 'code', name: 'code',searchable:true},
                {data: 'discount', name: 'discount',searchable:true},
                {data: 'max_use', name: 'max_use',searchable:true},
                {data: 'use_count', name: 'use_count' ,searchable:true},
                {data: 'duration', name: 'duration' ,searchable:false},
                {data: 'status', name: 'status',searchable:true},
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
