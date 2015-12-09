<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> 
<html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

  <!-- Open Sans font from Google CDN -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&amp;subset=latin" rel="stylesheet" type="text/css">

  <!-- LanderApp's stylesheets -->
  <link href="{{ asset("/themes/nbc/assets/stylesheets/bootstrap.min.css") }}" rel="stylesheet" type="text/css">
  <link href="{{ asset("/themes/nbc/assets/stylesheets/landerapp.min.css") }}" rel="stylesheet" type="text/css">
  <link href="{{ asset("/themes/nbc/assets/stylesheets/widgets.min.css") }}" rel="stylesheet" type="text/css">
  <link href="{{ asset("/themes/nbc/assets/stylesheets/rtl.min.css") }}" rel="stylesheet" type="text/css">
  <link href="{{ asset("/themes/nbc/assets/stylesheets/themes.min.css") }}" rel="stylesheet" type="text/css">
  <script src="{{ asset("/themes/nbc/assets/javascripts/jquery.min.js") }}"></script>

  <!--[if lt IE 9]>
    <script src="assets/javascripts/ie.min.js"></script>
  <![endif]-->
</head>


<!-- 1. $BODY ======================================================================================
  
  Body

  Classes:
  * 'theme-{THEME NAME}'
  * 'right-to-left'      - Sets text direction to right-to-left
  * 'main-menu-right'    - Places the main menu on the right side
  * 'no-main-menu'       - Hides the main menu
  * 'main-navbar-fixed'  - Fixes the main navigation
  * 'main-menu-fixed'    - Fixes the main menu
  * 'main-menu-animated' - Animate main menu
-->
<body class="theme-default main-menu-animated">

<script>var init = [];</script>
<!-- Demo script --> <script src="{{ asset("/themes/nbc/assets/demo/demo.js") }}"></script> <!-- / Demo script -->

<div id="main-wrapper">


<!-- 2. $MAIN_NAVIGATION ===========================================================================

  Main navigation
-->
  <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
    <!-- Main menu toggle -->
    <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>
    
    <div class="navbar-inner">
      <!-- Main navbar header -->
      <div class="navbar-header">

        <!-- Logo -->
        <a href="index.html" class="navbar-brand">
          <strong>EAZYPAPERS.COM</strong>  App
        </a>

        <!-- Main navbar toggle -->
 @include('header')
<!-- /2. $END_MAIN_NAVIGATION -->


<!-- 4. $MAIN_MENU =================================================================================

    Main menu
    
    Notes:
    * to make the menu item active, add a class 'active' to the <li>
      example: <li class="active">...</li>
    * multilevel submenu example:
      <li class="mm-dropdown">
        <a href="#"><span class="mm-text">Submenu item text 1</span></a>
        <ul>
        <li>...</li>
        <li class="mm-dropdown">
          <a href="#"><span class="mm-text">Submenu item text 2</span></a>
          <ul>
          <li>...</li>
          ...
          </ul>
        </li>
        ...
        </ul>
      </li>
-->
   @include('sidebar')
<!-- /4. $MAIN_MENU -->

  <div id="content-wrapper">
    @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if (session('error'))
           <div class="alert alert-danger">
             {{ session('error') }}
           </div>
          @endif
          @if (Session::has('flash_message'))
           <div class="alert alert-success">
             {{ Session::get('flash_message') }}
           </div>
          @endif
     @yield('content')   
   
  </div> <!-- / #content-wrapper -->
<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

<!-- Get jQuery from Google CDN -->


<!-- LanderApp's javascripts -->
<script src="{{ asset("/themes/nbc/assets/javascripts/bootstrap.min.js") }}"></script>
<script src="{{ asset("/themes/nbc/assets/javascripts/jquery.dataTabless.js") }}"></script>
<script src="{{ asset("/themes/nbc/assets/javascripts/jquery.dataTables.columnFilters.js") }}"></script>
<script src="{{ asset("/themes/nbc/assets/javascripts/landerapp.min.js") }}"></script>

<script type="text/javascript">
  init.push(function () {
    // Javascript code here
  })
  window.LanderApp.start(init);
</script>

</body>
</html>