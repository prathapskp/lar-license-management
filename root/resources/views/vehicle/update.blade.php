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
				<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ trans('vehicle.update_page_heading') }}</h1>

				<div class="col-xs-12 col-sm-8">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<!-- "Create project" button, width=auto on desktops -->
						<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ url('vehicle/create') }}" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>{{ trans('vehicle.add_vehicle') }}</a></div>

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
              <h3 class="box-title">{{ trans('vehicle.update_page_heading') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
            {!! Form::model($vehicle, array('route' => array('vehicle.update', $vehicle->id))) !!}
              <div class="box-body">
                <div class="form-group">
                {!! Form::label('plate_number', trans('vehicle.field_plate_number')) !!}
                {!! Form::text('plate_number', $vehicle->plate_number, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_plate_number') ]) !!}                 
                </div>   
                <div class="form-group">
                {!! Form::label('vehicle_type_id', trans('vehicle.field_vehicle_type')) !!}
                {!! Form::select('vehicle_type_id',$vehicle_type_options, $vehicle->vehicle_type_id, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_vehicle_type')]) !!}                 
                </div>   
                <div class="form-group">
                    <select multiple="multiple" class="form-control" name="license_type_id[]" id="license_type_id">
                    @foreach($license_type_options as $key => $option)
                        
                            <option value="{{$key}}" @if(in_array($key,$license_type_arr))selected="selected"@endif>{{$option}}</option>
                        
                    @endforeach
                    </select>
                </div>  
                 <div class="form-group">
                {!! Form::label('client_id', trans('vehicle.field_client')) !!}
                {!! Form::select('client_id',$client_options ,$vehicle->client_id, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_client')]) !!}                 
                </div> 
                <div class="form-group">
                {!! Form::label('registration_number', trans('vehicle.field_registration_number')) !!}
                {!! Form::text('registration_number', $vehicle->registartion_number, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_registration_number') ]) !!}                 
                </div>   
                <div class="form-group">
                {!! Form::label('owner_name', trans('vehicle.field_owner_name')) !!}
                {!! Form::text('owner_name', $vehicle->owner_name, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_owner_name') ]) !!}                 
                </div>   
                <div class="form-group">
                {!! Form::label('owner_email', trans('vehicle.field_owner_email')) !!}
                {!! Form::text('owner_email', $vehicle->owner_email, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_owner_email') ]) !!}                 
                </div>
                <div class="form-group">
                {!! Form::label('owner_phone', trans('vehicle.field_owner_phone')) !!}
                {!! Form::text('owner_phone', $vehicle->phone, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_owner_phone') ]) !!}                 
                </div> 
                <div class="form-group">
                {!! Form::label('location', trans('vehicle.field_location')) !!}
                {!! Form::text('location', $vehicle->location, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_location') ]) !!}                 
                </div>
                <div class="form-group">
                {!! Form::label('chassis_number', trans('vehicle.field_chassis_number')) !!}
                {!! Form::text('chassis_number', $vehicle->chassis_number, ['class' => 'form-control', 'placeholder' => trans('vehicle.field_chassis_number') ]) !!}                 
                </div>              
              </div>
              <!-- /.box-body -->

              <div class="box-footer pull-right">
                <a href="{{ url('vehicles') }}"><button type="button" class="btn btn-default">{{ trans('vehicle.form_cancel_button') }}</button></a>
                <button type="submit" class="btn btn-info">{{ trans('vehicle.form_update_button') }}</button>
              </div>
            {!! Form::close() !!}
						<div>
					</div>
				</div>
<!-- /11. $JQUERY_DATA_TABLES -->

			</div>
		</div>
<script type="text/javascript">
$(document).ready(function() {
     $("#vehicle_type_id").on("change",function() {
      if($("#vehicle_type_id").val() == "") {
      var option = "<option value=''></option>";
      $("#license_type_id").html(option);
      return false;
      }
      $.ajax({
      url: "{{ url('vehicle/ajaxGetLicenseTypes') }}/"+$("#vehicle_type_id").val(),
      type: 'get',
      dataType: "json",
      success: function(data) {
        $("#license_type_id").select2('val', 'All');      
      var opt = "";
      for(var k in data.option) {
      opt = opt+"<option value='"+k+"'>"+data.option[k]+"</option>";
      }
      $("#license_type_id").html(opt);
      
      }
      });
  
  });
});
</script>
<!-- multiselect box --> 
<link href="{{ asset("/themes/nbc/assets/stylesheets/select2.min.css") }}" rel="stylesheet" type="text/css">
<script src="{{ asset("/themes/nbc/assets/javascripts/select2.min.js") }}"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#license_type_id").select2({
    placeholder: "{{trans('vehicle.field_license_type')}}"
});
});
</script>
@endsection