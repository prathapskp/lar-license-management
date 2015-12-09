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
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ trans('vehicle.create_page_heading') }}</h1>
		<div class="col-xs-12 col-sm-8">
			<div class="row">
				<hr class="visible-xs no-grid-gutter-h">
				<!-- "Create project" button, width=auto on desktops -->
				<!-- <div class="pull-right col-xs-12 col-sm-auto"><a href="#" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>Renew Papers</a></div> -->
				<!-- Margin -->
				<div class="visible-xs clearfix form-group-margin"></div>
				<!-- Search field -->
				<!-- <form action="#" class="pull-right col-xs-12 col-sm-6">
						<div class="input-group no-margin">
								<span class="input-group-addon" style="border:none;background: #fff;background: rgba(0,0,0,.05);"><i class="fa fa-search"></i></span>
								<input type="text" placeholder="Search..." class="form-control no-padding-hr" style="border:none;background: #fff;background: rgba(0,0,0,.05);">
						</div>
				</form> -->
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
				<h3 class="box-title">{{ trans('vehicle.form_request_renewal') }}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			
			<div class="box-body form-horizontal">
				
				<div class="form-group">
					{!! Form::label('field_plate_number', trans('vehicle.field_plate_number')) !!}: {{$vehicle->plate_number}}
				</div>
				<div class="form-group">
					{!! Form::label('field_vehicle_type', trans('vehicle.field_vehicle_type')) !!}: {{$vehicle->type}}
				</div>
				<div class="form-group">
					{!! Form::label('field_registration_number', trans('vehicle.field_registration_number')) !!}: {{$vehicle->registration_number}}
				</div>
				<div class="form-group">
					{!! Form::label('field_owner_name', trans('vehicle.field_owner_name')) !!}: {{$vehicle->owner_name}}
				</div>
				<div class="form-group">
					{!! Form::label('field_owner_email', trans('vehicle.field_owner_email')) !!}: {{$vehicle->owner_email}}
				</div>
				<div class="form-group">
					{!! Form::label('field_owner_phone', trans('vehicle.field_owner_phone')) !!}: {{$vehicle->owner_phone}}
				</div>
				<div class="form-group">
					{!! Form::label('field_location', trans('vehicle.field_location')) !!}: {{$vehicle->location}}
				</div>
				<div class="form-group">
					{!! Form::label('field_chassis_number', trans('vehicle.field_chassis_number')) !!}: {{$vehicle->chassis_number}}
				</div>
				
			</div>
			<div class="box-body">
				@foreach($license_types as $license_type)
				{!! Form::open(array('url' => 'vehicle/renewal_request')) !!}
				<input type="hidden" name="license_type_id" value="{{$license_type->license_type_id}}">
				<input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">
				
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group">
							{!! Form::label('plate_number', $license_type->type) !!}
							<div class="col-lg-12" style="padding-left: 0px">
								<div class="col-lg-6 col-sm-6" style="padding-left: 0px">
								<?php ($license_type->license_start_on != "0000-00-00 00:00:00") ? $start_on = date("m-d-Y", strtotime($license_type->license_start_on)): $start_on = ''; ?>
									{!! Form::label('plate_number', trans('vehicle.field_license_start')) !!}
									{!! Form::text('start_on', $start_on, ['class' => 'form-control license_start_date', 'placeholder' => 'Start Date','disabled' => 'disabled' ]) !!}
								</div>
								<div class="col-lg-6 col-sm-6" style="padding-left: 0px">
									<?php ($license_type->license_end_on != "0000-00-00 00:00:00") ? $end_on = date("m-d-Y", strtotime($license_type->license_end_on)): $end_on = ''; ?>
									{!! Form::label('plate_number', trans('vehicle.field_license_end')) !!}
									{!! Form::text('end_on', $end_on, ['class' => 'form-control', 'placeholder' => 'Expiry Date', 'disabled' => 'disabled' ]) !!}
								</div>
							</div>
						</div>
						<div class="box-footer pull-right">
						@if(!isset($request[$license_type->license_type_id]) || $request[$license_type->license_type_id] == 'completed')
							<button type="submit" class="btn btn-info">{{ trans('vehicle.form_request_renewal_button') }}</button>
						@endif
						@if(isset($request[$license_type->license_type_id]) && ($request[$license_type->license_type_id] == 'pending' || $request[$license_type->license_type_id] == 'in-progress'))
							<div class="alert alert-info" role="alert">Renewal request is <?php echo ucwords($request[$license_type->license_type_id]); ?></div>
						@endif

						</div>
					</div>
					
				</div>
				{!! Form::close() !!}
				@endforeach
			</div>
			<!-- /.box-body -->
			
			<div>
			</div>
		</div>
		<!-- /11. $JQUERY_DATA_TABLES -->
	</div>
</div>
<!-- multiselect box -->
<link href="{{ asset("/themes/nbc/assets/stylesheets/bootstrap-datepicker.min.css") }}" rel="stylesheet" type="text/css">
<script src="{{ asset("/themes/nbc/assets/javascripts/bootstrap-datepicker.min.js") }}"></script>
<script type="text/javascript">
$(document).ready(function() {
$(".license_start_date").on('changeDate', function(event){
	event.preventDefault();
	var id = this.id;
	var end_id = id.replace("start", "end");
	var data_request = "_token={{ csrf_token() }}&date="+$("#"+id).val();
	$.ajax({
	url: "{{ url('vehicle/get_expiry_date') }}",
	type: 'POST',
	data: data_request,
	success: function(data) {
		$("#"+end_id).val(data);
	}
	});
});
$("#update_license_form").validate();
});
</script>
@endsection