<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Eazypapers APP for Nigerian Brewries">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Eazypapers APP for Nigerian Brewries</title>

    <!-- Bootstrap CSS -->    
    <link href="{{ asset("/themes/nbc/css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{ asset("/themes/nbc/css/bootstrap-theme.css") }}" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="{{ asset("/themes/nbc/css/elegant-icons-style.css") }}" rel="stylesheet" />
    <link href="{{ asset("/themes/nbc/assets/font-awesome/css/font-awesome.css") }}" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="{{ asset("/themes/nbc/css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("/themes/nbc/css/style-responsive.css") }}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="{{ asset("/themes/nbc/js/html5shiv.js") }}"></script>
    <script src="{{ asset("/themes/nbc/js/respond.min.js") }}"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">
 
     <form class="login-form" role="form" method="POST" action="{{ url('client/login') }}">
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
          @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
          @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">   
        <div class="login-wrap">
            <span>
              <img src="{{ asset("/themes/nbc/img/eazypapers_logo.png") }}" alt="Eazypapers.com" title="Eazypapers.com">
            </span>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" class="form-control" placeholder="Email" autofocus name="email" value="{{ old('email') }}">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <label class="checkbox">
                <input type="checkbox" value="1" name="remember"> Remember me
                <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
            </label>
            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            <!-- <button class="btn btn-info btn-lg btn-block" type="submit">Signup</button> -->
        </div>
      </form>

    </div>


  </body>
</html>
