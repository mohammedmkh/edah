<header role="banner">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container">
        <?php $logo = \App\CompanySetting::find(1)->logo; ?>
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{ url('images/upload/'.$logo)}}" style="width: 200px;" alt="{{\App\CompanySetting::find(1)->name}}">           
            {{-- <img src="{{ url('frontend/images/logo.png')}}" style="width: 200px;" alt="{{\App\CompanySetting::find(1)->name}}">            --}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample05">
          {{-- <ul class="navbar-nav ml-auto pl-lg-5 pl-0">
            <li class="nav-item">
              <a class="nav-link active" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="recipes.html">Recipes</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="services.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Services</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
                <a class="dropdown-item" href="services.html">Food Catering</a>
                <a class="dropdown-item" href="services.html">Drink &amp; Beverages</a>
                <a class="dropdown-item" href="services.html">Wedding &amp; Birthday</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="news.html">News</a>
            </li>
          </ul> --}}

          <ul class="navbar-nav ml-auto">
            <li class="nav-item cta-btn">
              <a class="nav-link" href="{{url('/')}}">Contact Us</a>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>
  </header>
  <!-- END header -->