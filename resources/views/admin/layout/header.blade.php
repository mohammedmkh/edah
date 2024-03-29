<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">

        <!-- User -->
        @if(Auth::check())
         <?php $image = Auth::user()->image; ?>
        @elseif(Auth::guard('mainAdmin')->check()) 
            <?php $image = Auth::guard('mainAdmin')->user()->image;  ?>
        @endif
        <?php 
            $sell_product =  \App\Setting::find(1)->sell_product;
            if($sell_product == 1){ $product = 'Grocery'; }
            if($sell_product == 2){ $product = 'Food'; }
        ?>
        <ul class="navbar-nav align-items-center d-none d-md-flex"> 

            <?php $lang = \App\Language::where('status',1)->get(); ?>     
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">


                        @foreach ($lang as $item)

                            @if(session()->get('locale') == $item->name)
                                <img alt="Image placeholder"  src="{{url('images/upload/'.$item->icon)}}" class="flag-icon" >
                            @endif
                        @endforeach

                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right py-0 overflow-hidden">
                    @foreach ($lang as $item)
                    <a href="{{url(adminPath().'changeLanguage/'.$item->name)}}" class="dropdown-item"><img src="{{url('images/upload/'.$item->icon)}}" class="flag-icon" ><span>{{ __($item->name) }}</span> </a>
                    @endforeach

                    {{-- <a href="{{url('changeLanguage/ar')}}" class="dropdown-item"><img src="{{url('images/flag-ae.png')}}" class="flag-icon"> <span>{{ __('Arebic') }}</span> </a> --}}
                </div>
            </li>




            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="rounded-circle">
                            <img alt="Image placeholder" class="avatar" src="{{url('images/upload/'.$image)}}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">
                                @if(Auth::check())
                                {{Auth::user()->name}}
                                @elseif(Auth::guard('mainAdmin')->check()) 
                                {{Auth::guard('mainAdmin')->user()->name}}
                                @endif
                            </span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right  py-0 overflow-hidden">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome') }}</h6>
                    </div>
                    @if(Auth::check())
                        <a href="{{url(adminPath().'ownerProfile')}}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>{{ __('My profile') }}</span>
                        </a>
                        <a href="{{url(adminPath().'OwnerSetting')}}" class="dropdown-item">
                            <i class="ni ni-settings-gear-65"></i>
                            <span>{{ __('Settings') }}</span>
                        </a>

                    @endif
                   
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>