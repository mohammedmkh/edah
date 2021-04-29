@extends('admin.master', ['title' => __('User Management')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Users') ,
        'class' => 'col-lg-7'
    ])
    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card form-card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Users') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{url(adminPath().'Customer/create')}}"
                                   class="btn btn-sm btn-primary">{{ __('Add New Customer') }}</a>
                            </div>
                        </div>
                    </div>
                    <div style=" padding: 10px; " id="search" class="pl-lg-4">


                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-status"> الحالة</label>
                                    <Select name="status" id="status"
                                            class="form-control select2 form-control-alternative" required>
                                        <option value="">الحالة</option>
                                        <option value="0">Active</option>
                                        <option value="1">DeActive</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group ">
                                    <label class="form-control-label" for="input-hour_work">الإسم
                                    </label>
                                    <input type="text" name="name"
                                           class="form-control form-control-alternative"
                                           placeholder="الإسم" value="" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group ">
                                    <label class="form-control-label" for="input-hour_work">رقم الجوال
                                    </label>
                                    <input type="text" name="phone"
                                           class="form-control form-control-alternative"
                                           placeholder="رقم الجوال" value="" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group ">
                                    <label class="form-control-label" for="input-hour_work">الإيميل
                                    </label>
                                    <input type="email" name="email"
                                           class="form-control form-control-alternative"
                                           placeholder="الإيميل" value="" required>
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
                                    <button onclick="resetFilter()" type="button" class="btn btn-danger mt-4">إعادة
                                        تعيين
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style=" padding: 10px; " class="table-responsive">
                        <table class="table align-items-center yajra-datatable table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
                                <th scope="col">{{ __('Image') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Phone') }}</th>
                                {{-- <th scope="col">{{ __('Date of Birth') }}</th> --}}
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Registered at') }}</th>
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
                    url: "{{route('customerList')}}",
                    data: function (d) {
                        d.status = $('[name="status"]').val()
                        d.name = $('[name="name"]').val()
                        d.email = $('[name="email"]').val()
                        d.phone = $('[name="phone"]').val()


                    }
                },
                columns: [
                    {data: 'id', name: 'id', searchable: true},
                    {data: 'image', name: 'image', searchable: false},
                    {data: 'name', name: 'name', searchable: false},
                    {data: 'email', name: 'email', searchable: false},
                    {data: 'phone', name: 'phone', searchable: false},
                    {data: 'status', name: 'status', searchable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false},
                ]
            });
            $('#public_search').on('click', function (e) {
                table.draw();
                e.preventDefault();
            });


            function setUserStatus(user_id, status) {
                event.preventDefault()
                $.ajax({
                    url: '{{url('')}}/panel/setUserStatus'  ,
                    data: {_token: $('meta[name="csrf-token"]').attr('content'),user_id:user_id,status:status},
                    type: "POST",
                    success: function (result) {

                        table.ajax.reload( null, false ); // user paging is not reset on reload
                        toastr.success('{{__('Successfully completed')}}');

                    },
                    error: function (err) {
                        toastr.fail('{{__('The operation has failed')}}');

                    }
                });


            }






        $(document).ready(function () {
            /*
                        $('input[name="daterange"]').val(null)
            */
        });
    </script>
@endsection
