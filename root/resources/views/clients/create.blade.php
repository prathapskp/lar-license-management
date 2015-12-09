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
              <h3 class="box-title">{{ trans('client.create_heading') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
            {!! Form::open(array('url' => 'clients/create')) !!}
              <div class="box-body">
                <div class="form-group">
                {!! Form::label('first_name', trans('client.first_name')) !!}
                {!! Form::text('first_name', '', ['class' => 'form-control', 'placeholder' => trans('client.first_name') ]) !!}                 
                </div>
                <div class="form-group">
                {!! Form::label('last_name', trans('client.last_name')) !!}
                {!! Form::text('last_name', '', ['class' => 'form-control', 'placeholder' => trans('client.last_name') ]) !!}                 
                 </div>
                <div class="form-group">
                {!! Form::label('email', trans('client.email')) !!}
                {!! Form::text('email', '', ['class' => 'form-control', 'placeholder' => trans('client.email') ]) !!}                 
                </div>
                <div class="form-group">
                 {!! Form::label('subdomain', trans('client.subdomain')) !!}
                 {!! Form::text('subdomain', '', ['class' => 'form-control', 'placeholder' => trans('client.subdomain') ]) !!}                 
                </div>
                <div class="form-group">
                 {!! Form::label('password', trans('client.password')) !!}
                 {!! Form::password('password', ['class' => 'form-control', 'placeholder' => trans('client.password') ]) !!}                 
                </div>
                
               <div class="form-group">
               	{!! Form::label('mobile_no', trans('client.mobile_no')) !!}
                {!! Form::text('mobile_no', '', ['class' => 'form-control', 'placeholder' => trans('client.mobile_no') ]) !!}                 
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer pull-right">
                <a href="{{ url('clients') }}"><button type="button" class="btn btn-default">{{ trans('client.cancel_button') }}</button></a>
                <button type="submit" class="btn btn-info">{{ trans('client.save_button') }}</button>
              </div>
            {!! Form::close() !!}
						<div>
					</div>
				</div>
<!-- /11. $JQUERY_DATA_TABLES -->

			</div>
		</div>
@endsection