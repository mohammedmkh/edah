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
                                    <h3 class="mb-0">{{ __('Technician') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url(adminPath().'technicians/create')}}" class="btn btn-sm btn-primary">{{ __('Add Technician') }}</a>
                                </div>
                            </div>
                        </div>
                        <div style=" padding: 10px; " id="search" class="pl-lg-4">


                            <div  class="row">
                                <div class="col-3">
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
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Phone') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Role') }}</th>
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



    <div class="modal fade" id="assignRadius" tabindex="-1" role="dialog" aria-labelledby="assignRadiusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="assignRadiusLabel">{{ __('Assign Radius to Driver')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body bg-secondary">
                <form method="post" action="{{url('assignRadius')}}">
                        @csrf
                            <div class="form-group{{ $errors->has('driver_radius') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-driver_radius">{{ __('Radius (KM)') }}</label>
                                <input type="number" name="driver_radius" id="input-driver_radius" class="form-control form-control-alternative{{ $errors->has('driver_radius') ? ' is-invalid' : '' }}" placeholder="{{ __('Radius') }}" value="" required autofocus>
                                @if ($errors->has('driver_radius'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driver_radius') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="driver_id" id="driver_id" class="form-control">

                            <div class="form-group text-right">
                                {{-- <button type="button" class="btn" data-dismiss="modal">{{ __('Close') }}</button> --}}
                                <button  type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                   </form>
                </div>
                {{-- <div class="modal-footer">    </div> --}}
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
                    url: "{{route('techniciansList')}}",
                    data: function (d) {
                        d.status=$('[name="status"]').val()
                        d.name=$('[name="name"]').val()
                        d.email=$('[name="email"]').val()
                        d.phone=$('[name="phone"]').val()

                    }
                },
                columns: [
                    {data: 'id', name: 'id',searchable:true},
                    {data: 'image', name: 'image',searchable:false},
                    {data: 'name', name: 'name',searchable:false},
                    {data: 'email', name: 'email',searchable:false},
                    {data: 'phone', name: 'phone',searchable:false},
                    {data: 'status', name: 'status',searchable:false},
                    {data: 'created_at', name: 'created_at',searchable:false},
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
