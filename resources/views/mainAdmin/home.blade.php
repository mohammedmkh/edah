@extends('admin.master', ['title' => __('Home')])

@section('content')
    {{-- @include('admin.layout.topHeader', [
        'title' => __('DashBoard') ,

        'class' => 'col-lg-7'
    ])  --}}
    <div class="header pb-8 pt-5 d-flex pt-lg-8" style="background-image: url({{url('admin/images/bg.jpg')}}); background-size: cover; background-position: center center;">
        <span class="mask bg-gradient-default opacity-8"></span>
            <div class="container-fluid">


                <div class="header-body">
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted">{{ __('Shops')}}</h5>
                                            <span class="h2 font-weight-bold">{{$master['shops']}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="fas fa-store"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted">{{ __('New users')}}</h5>
                                            <span class="h2 font-weight-bold">{{$master['users']}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                    <i class="fas fa-users"></i>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted">{{ __('Sales')}}</h5>
                                            <span class="h2 font-weight-bold">{{$currency.$master['sales']}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="fas fa-chart-pie"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted">{{ __('Delivery Guys')}}</h5>
                                            <span class="h2 font-weight-bold">{{$master['delivery']}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                 <i class="ni ni-delivery-fast"></i>
                                                 {{-- <i class="fas fa-user-friends"></i> --}}


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>



        <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-8">

                {{-- location map --}}
                <div class="card shadow mb-5">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                            <h3 class="mb-0">{{ __('Our Locations') }}</h3>
                                <input type="hidden" id="locations" name="locations" value="{{$locations}}">
                                <input type="hidden" id="shops" name="shops" value="{{$shops}}">
                            </div>

                            <div class="col-4 text-right">
                                {{-- <a href="#" class="btn btn-sm btn-primary">{{ __('See all') }}</a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div  class="vector-map" id="locationMap" style="width: 100%; height: 400px" ></div>
                    </div>
                </div>
                {{-- users --}}
                    {{-- <div class="card shadow mb-5">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Happy Customers') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url('Customer')}}" class="btn btn-sm btn-primary">{{ __('See all') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($users)>0)
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ __('Name')}}</th>
                                            <th scope="col">{{ __('Email')}}</th>
                                            <th scope="col">{{ __('Total Orders')}}</th>
                                            <th scope="col">{{ __('Phone')}}</th>
                                            <th scope="col">{{ __('Status')}}</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                        <tr>
                                                <th scope="row"> {{$loop->iteration}} </th>
                                                <td><img class="avatar avatar-sm mr-3" src="{{url('images/upload/'.$item->image)}}">{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->orders}}</td>
                                                <td>{{$item->phone}}</td>
                                                <td>
                                                    <span class="badge badge-dot mr-4">
                                                        <i class="{{$item->status==0?'bg-success': 'bg-danger'}}"></i>
                                                        <span class="status">{{$item->status==0?'Active': 'Block'}}</span>
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                       <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                           <i class="fas fa-ellipsis-v"></i>
                                                       </a>
                                                       <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{url('Customer/'.$item->id.'/edit')}}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item" href="#" onclick="deleteData('Customer','{{$item->id}}');"  >{{ __('Delete') }}</a>
                                                       </div>
                                                   </div>

                                                   </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-state text-center pb-3">
                                    <img src="{{url('images/empty3.png')}}" style="width:40%;height:200px;">
                                    <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                    <p style="font-weight:600;">Your Collection list is empty....</p>
                                </div>
                            @endif
                            </div>
                    </div> --}}
                {{-- shop owners --}}

                <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Shop Owners') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url('shopOwners')}}" class="btn btn-sm btn-primary">{{ __('See all') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($owners)>0)
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ __('Name')}}</th>
                                            <th scope="col">{{ __('Email')}}</th>
                                            <th scope="col">{{ __('Phone')}}</th>
                                            <th scope="col">{{ __('Shops')}}</th>
                                            <th scope="col">{{ __('Status')}}</th>
                                            <th scope="col">{{ __('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($owners as $item)
                                        <tr>
                                                <th scope="row"> {{$loop->iteration}} </th>
                                                <td><img class="avatar avatar-sm mr-3" src="{{url('images/upload/'.$item->image)}}">{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->phone}}</td>
                                                <td>
                                                    <div class="avatar-group">
                                                        @foreach ($item->shops as $shop)
                                                        <a href="#" class="avatar avatar-sm rounded-circle" data-toggle="tooltip" data-original-title="{{$shop->name}}">
                                                            <img src="{{url('images/upload/'.$shop->image)}}">
                                                        </a>
                                                        @endforeach
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="badge badge-dot mr-4">
                                                        <i class="{{$item->status==0?'bg-success': 'bg-danger'}}"></i>
                                                        <span class="status">{{$item->status==0?'Active': 'Block'}}</span>
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{url('Customer/'.$item->id.'/edit')}}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item" href="#" onclick="deleteData('Customer','{{$item->id}}');"  >{{ __('Delete') }}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-state text-center pb-3">
                                    <img src="{{url('images/empty3.png')}}" style="width:40%;height:200px;">
                                    <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                    <p style="font-weight:600;">Your Collection list is empty....</p>
                                </div>
                            @endif
                            </div>
                    </div>
            </div>
            <div class="col-4">
                {{-- shops --}}
                <div class="card shadow mb-4">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Shops') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                {{-- <a href="#" class="btn btn-sm btn-primary">{{ __('See all') }}</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="chart-pie" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
                {{-- categories --}}
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Categories') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{url('AdminCategory')}}" class="btn btn-sm btn-primary">{{ __('See all') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($category)>0)
                            <ul class="list-group list-group-flush list my--3">
                                @foreach ($category as $item)
                                    @if($loop->iteration <= 4)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img class=" avatar-lg round-5" src="{{url('images/upload/'.$item->image)}}">
                                            </div>
                                            <div class="col ml--2">
                                                <h4 class="mb-0">
                                                    <a href="#!">{{$item->name}}</a>
                                                </h4>
                                                <span class="badge badge-dot mr-4">
                                                    <i class="{{$item->status==0?'bg-success': 'bg-danger'}}"></i>
                                                    <span class="status">{{$item->status==0?'Active': 'Block'}}</span>
                                                </span>
                                            </div>
                                            <div class="col-auto">
                                            <span class=" label label-light-primary">{{ $item->totalItems.' Items' }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                @endforeach

                            </ul>
                        @else
                            <div class="empty-state text-center pb-3">
                                <img src="{{url('images/empty3.png')}}" style="width:60%;height:200px;">
                                <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                <p style="font-weight:600;">Your Collection list is empty....</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
