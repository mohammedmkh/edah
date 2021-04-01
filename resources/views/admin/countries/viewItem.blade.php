@extends('admin.master', ['title' => __('Items')])

@section('content')
    @include('admin.layout.topHeader', [
        'title' => __('Countries') ,
        'class' => 'col-lg-7'
    ]) 
    <div class="container-fluid mt--7">
           
        <div class="row">
            <div class="col">
                    <div class="card form-card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('The Countries') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{url(adminPath().'countries/create')}}" class="btn btn-sm btn-primary">{{ __('Add New Country') }}</a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            @if(count($items)>0) 
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('#') }}</th>
                                            <th scope="col">{{ __('Name') }}</th>
                                            <th scope="col">{{ __('Status') }}</th>   
                                            <th scope="col">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->statusName }}</td>



                                                <td>                            
                                                    {{-- <a href="{{url('Item/'.$item->id.'/edit')}}" class="table-action" data-toggle="tooltip" data-original-title="Edit Item">
                                                        <i class="fas fa-user-edit"></i>
                                                    </a>
                                                    <a href="#!" onclick="deleteData('Item','{{$item->id}}');" class="table-action table-action-delete" data-toggle="tooltip" data-original-title="Delete Item">
                                                        <i class="fas fa-trash"></i>
                                                    </a> --}}

                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-men
                                                        u-right dropdown-menu-arrow">
                                                            <a class="dropdown-item" href="{{url(adminPath().'countries/'.$item->id.'/edit')}}">{{ __('Edit') }}</a>
                                                            <a class="dropdown-item" onclick="deleteData('countries','{{$item->id}}');" href="#">{{ __('Delete') }}</a>
                                                            {{-- onclick="deleteData('Item','{{$item->id}}');" --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                                <?php echo $items->render(); ?>
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