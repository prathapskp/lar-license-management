@extends('admin_template')

@section('content')
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray">You are here: </div>
			<li><a href="#">Home</a></li>
			<li class="active"><a href="#">Dashboard</a></li>
		</ul>
		<div class="page-header">
			
			<div class="row">
				<!-- Page header, center on small screens -->
				<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>

				<div class="col-xs-12 col-sm-8">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<!-- "Create project" button, width=auto on desktops -->
						<div class="pull-right col-xs-12 col-sm-auto"><a href="#" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>Renew Papers</a></div>

						<!-- Margin -->
						<div class="visible-xs clearfix form-group-margin"></div>

						<!-- Search field -->
						<form action="#" class="pull-right col-xs-12 col-sm-6">
							<div class="input-group no-margin">
								<span class="input-group-addon" style="border:none;background: #fff;background: rgba(0,0,0,.05);"><i class="fa fa-search"></i></span>
								<input type="text" placeholder="Search..." class="form-control no-padding-hr" style="border:none;background: #fff;background: rgba(0,0,0,.05);">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div> <!-- / .page-header -->

		
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"></span>
					</div>
					<div class="panel-body">
							 <div class="box-header with-border">
              <h3 class="box-title">{{ trans('profile.profile_heading') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
            {!! Form::model($user, array('route' => array('user.update', $user->id))) !!}
              <div class="box-body">
                <div class="form-group">
                {!! Form::label('first_name', trans('profile.first_name')) !!}
                {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => trans('profile.first_name') ]) !!}                 
                </div>
                <div class="form-group">
                {!! Form::label('last_name', trans('profile.last_name')) !!}
                {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => trans('profile.last_name') ]) !!}                 
                 </div>
                <div class="form-group">
                {!! Form::label('email', trans('profile.email')) !!}
                {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => trans('profile.email') ]) !!}                 
                </div>
                <div class="form-group">
                 {!! Form::label('password', trans('profile.password')) !!}
                 {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('profile.password') ]) !!}                 
                </div>
                <div class="form-group">
                 {!! Form::label('confirm_password', trans('profile.confirm_password')) !!}
                 {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => trans('profile.confirm_password') ]) !!}                 
                </div>
               <div class="form-group">
               	{!! Form::label('mobile_no', trans('profile.mobile_no')) !!}
                {!! Form::text('mobile_no', $user->mobile_no, ['class' => 'form-control', 'placeholder' => trans('profile.mobile_no') ]) !!}                 
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer pull-right">
                <a href=""><button type="button" class="btn btn-default">{{ trans('profile.cancel_button') }}</button></a>
                <button type="submit" class="btn btn-info">{{ trans('profile.save_button') }}</button>
              </div>
            {!! Form::close() !!}
						<div>
					</div>
				</div>
<!-- /11. $JQUERY_DATA_TABLES -->

			</div>
		</div>

@endsection