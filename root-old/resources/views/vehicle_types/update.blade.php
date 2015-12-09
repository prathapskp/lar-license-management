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
				<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ trans('vehicle_type.update_page_heading') }}</h1>

				<div class="col-xs-12 col-sm-8">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<!-- "Create project" button, width=auto on desktops -->
						<div class="pull-right col-xs-12 col-sm-auto"><a href="{{ url('vehicle-type/create') }}" class="btn btn-primary btn-labeled" style="width: 100%;"><span class="btn-label icon fa fa-plus"></span>{{ trans('vehicle_type.add_vehicle') }}</a></div>

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
              <h3 class="box-title">{{ trans('vehicle_type.update_page_heading') }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
            {!! Form::model($type, array('route' => array('vehicle-type.update', $type->id))) !!}
              <div class="box-body">
                <div class="form-group">
                {!! Form::label('type', trans('vehicle_type.field_type')) !!}
                {!! Form::text('type', $type->type, ['class' => 'form-control', 'placeholder' => trans('vehicle_type.field_type') ]) !!}                 
                </div>        
                <div class="form-group">
					<select multiple="multiple" class="form-control" name="license_type_id[]" id="license_type_id">
					@foreach($options as $key => $option)
					    
					        <option value="{{$key}}" @if(in_array($key,$license_type_arr))selected="selected"@endif>{{$option}}</option>
					    
					@endforeach
					</select>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer pull-right">
                <a href="{{ url('vehicle-types') }}"><button type="button" class="btn btn-default">{{ trans('vehicle_type.form_cancel_button') }}</button></a>
                <button type="submit" class="btn btn-info">{{ trans('vehicle_type.form_update_button') }}</button>
              </div>
            {!! Form::close() !!}
						<div>
					</div>
				</div>
<!-- /11. $JQUERY_DATA_TABLES -->

			</div>
		</div>

@endsection