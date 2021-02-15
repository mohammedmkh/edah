@extends('admin.master', ['title' => __('Items')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Settings') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Settings') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url('additionalsettings/create')}}" class="btn btn-sm btn-primary">{{ __('Add New Setting') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($data)>0)
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('#') }}</th>

                                            <th scope="col">{{ __('code') }}</th>

                                            <th scope="col">{{ __('Key') }}</th>

                                            <th scope="col">{{ __('value') }}</th>
                                            <th scope="col">{{ __('status') }}</th>
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)


                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->the_key?? '' }}</td>
                                                <td>{{ $item->value?? '' }}</td>
                                                <td>{{ $item->status_name }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-men
                                                        u-right dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{url('additionalsettings/'.$item->id.'/edit')}}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item" onclick="deleteData('additionalsettings','{{$item->id}}');" href="#">{{ __('Delete') }}</a>
                                                            {{-- onclick="deleteData('Item','{{$item->id}}');" --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                                <?php echo $data ->render(); ?>
                            @else                             
                                <div class="empty-state text-center pb-3">
                                    <img src="{{url('images/empty3.png')}}" style="width:35%;height:220px;">
                                    <h2 class="pt-3 mb-0" style="font-size:25px;">Nothing!!</h2>
                                    <p style="font-weight:600;">Your Collection list in empty....</p>
                                </div>                        
                            @endif
                            </div>
                    </div>
            </div>
        </div>
       
    </div>

@endsection