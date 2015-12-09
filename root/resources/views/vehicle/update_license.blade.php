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
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ trans('vehicle.update_license_page') }}</h1>
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
				<h3 class="box-title">{{ trans('vehicle.update_license_page') }}</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			{!! Form::open(array('url' => 'vehicle/store_license', 'id' => 'update_license_form')) !!}
			<input type="hidden" name="redirect_to" value="/vehicles">
			<div class="box-body">
				<input type="hidden" name="vehicle_id" value="{{ $vehicle_id }}">
				@foreach($license_types as $license_type)
				{{--*/ $start = 'license_type_start_'.$license_type->license_type_id /*--}}
				{{--*/ $end = 'license_type_end_'.$license_type->license_type_id /*--}}
				{{--*/ $status = 'status_'.$license_type->license_type_id /*--}}
				{{--*/ $color = '' /*--}}
				@if(isset($request[$license_type->license_type_id]) && ($request[$license_type->license_type_id] == 'pending' || $request[$license_type->license_type_id] == 'in-progress'))
					{{--*/ $color = 'red' /*--}}
				@endif
				<div class="panel panel-default" style="border-color: {{$color}}">
					<div class="panel-body">
					@if(isset($request[$license_type->license_type_id]) && ($request[$license_type->license_type_id] == 'pending' || $request[$license_type->license_type_id] == 'in-progress'))
						<div class="alert alert-info alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="glyphicon glyphicon-remove"></span></button>
							Request has recieved for renewal
						</div>
					@endif
						<div class="form-group">
							{!! Form::label('plate_number', $license_type->type) !!}
							<div class="col-lg-12" style="padding-left: 0px">
								<div class="col-lg-6 col-sm-6" style="padding-left: 0px">
									<?php ($license_type->license_start_on != "0000-00-00 00:00:00") ? $start_on = date("m-d-Y", strtotime($license_type->license_start_on)): $start_on = ''; ?>
									{!! Form::label('start_on', trans('vehicle.field_license_start')) !!}
									{!! Form::text($start, $start_on, ['class' => 'form-control license_start_date', 'placeholder' => 'Start Date', 'id' => $start, 'data-provide'=>'datepicker',' data-date-format'=>'mm/dd/yyyy', 'required' => 'required' ]) !!}
								</div>
								<div class="col-lg-6 col-sm-6" style="padding-left: 0px">
									<?php ($license_type->license_end_on != "0000-00-00 00:00:00") ? $end_on = date("m-d-Y", strtotime($license_type->license_end_on)): $end_on = ''; ?>
									{!! Form::label('end_on', trans('vehicle.field_license_end')) !!}
									{!! Form::text($end, $end_on, ['class' => 'form-control', 'placeholder' => 'Expiry Date', 'id' => $end, 'disabled' => 'disabled', 'required' => 'required' ]) !!}
								</div>
							</div>
						</div>
						@if(isset($request[$license_type->license_type_id]) && ($request[$license_type->license_type_id] == 'pending' || $request[$license_type->license_type_id] == 'in-progress'))
						<?php $status_options = array('pending' => 'Pending', 'in-progress' => 'In Progress', 'completed' => 'Completed'); ?>
						<div class="form-group">
						{!! Form::label('status', trans('vehicle.field_status')) !!}
                		{!! Form::select($status,$status_options ,$request[$license_type->license_type_id], ['class' => 'form-control', 'placeholder' => trans('vehicle.field_client')]) !!}                 
						</div>
						@endif
					</div>
				</div>
				@endforeach
			</div>
			<!-- /.box-body -->
			<div class="box-footer pull-right">
				<a href="{{ url('vehicles') }}"><button type="button" class="btn btn-default">{{ trans('vehicle.form_cancel_button') }}</button></a>
				<button type="submit" class="btn btn-info">{{ trans('vehicle.form_save_button') }}</button>
			</div>
			{!! Form::close() !!}
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