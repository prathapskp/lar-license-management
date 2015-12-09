<div id="main-menu" role="navigation">
    <div id="main-menu-inner">
      <div class="menu-content top" id="menu-content-demo">
        <!-- Menu custom content demo
           Javascript: html/assets/demo/demo.js
         -->
        <div>
          <div class="text-bg"><span class="text-slim">Welcome,</span> <span class="text-semibold">NBC</span></div>

          <img src="{{ asset("/themes/nbc/assets/demo/avatars/nbc.jpg") }}" alt="" class="">
          <div class="btn-group">
            <!-- <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a> -->
            <a href="{{ url('profile') }}" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
           <!--  <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a> -->
           @if(Session::get('role') == 1)
            <a href="{{ url('logout') }}" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
             @endif
            @if(Session::get('role') == 2)
             <a href="{{ url('client/logout') }}" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
          @endif
          </div>
          <a href="#" class="close">&times;</a>
        </div>
      </div>
      @if(Session::get('role') == 1)
      <ul class="navigation">
        <li><!-- class="active" -->
          <a href="{{ url('/') }}"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Dashboard</span></a>
        </li>
        <li>
          <a href="{{ url('clients') }}"><i class="menu-icon fa fa-th"></i><span class="mm-text">Clients</span></a>          
        </li>
         <li>
          <a href="{{ url('license-types') }}"><i class="menu-icon fa fa-th"></i><span class="mm-text">License Types</span></a>          
        </li>
        <li>
          <a href="{{ url('vehicle-types') }}"><i class="menu-icon fa fa-th"></i><span class="mm-text">Vehicle Category</span></a>          
        </li>
        <li>
          <a href="{{ url('vehicles') }}"><i class="menu-icon fa fa-th"></i><span class="mm-text">Vehicles</span></a>          
        </li>    
      </ul> <!-- / .navigation -->
      @endif
      @if(Session::get('role') == 2)
      <ul class="navigation">
        <li><!-- class="active" -->
          <a href="{{ url('client/dashboard') }}"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text">Dashboard</span></a>
        </li>
        <li>
          <a href="{{ url('client/vehicles') }}"><i class="menu-icon fa fa-th"></i><span class="mm-text">Vehicles</span></a>          
        </li>        
      </ul> <!-- / .navigation -->
      @endif
       @if(Session::get('role') == 1)
      <div class="menu-content">
        <a href="{{ url('vehicle/renewal-listing') }}" class="btn btn-primary btn-block btn-outline dark">Make a Renewal</a>
      </div>
      @endif
    </div> <!-- / #main-menu-inner -->
  </div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->