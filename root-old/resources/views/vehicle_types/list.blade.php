@extends('admin_template')

@section('content')
   <ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray">You are here: </div>
			<li><a href="#">Home</a></li>
			<li><a href="#">Dashboard</a></li>
			<li class="active"><a href="#">Vehicle Type</a></li>
		</ul>
		<div class="page-header">
			
			<div class="row">
				<!-- Page header, center on small screens -->
				<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;{{ trans('vehicle_type.listing_page_heading') }}</h1>

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



<!-- 11. $JQUERY_DATA_TABLES ===========================================================================

				jQuery Data Tables
-->
				<!-- Javascript -->
				<script>
					/*init.push(function () {
						$('#jq-datatables-example').dataTable();
						$('#jq-datatables-example_wrapper .table-caption').text('VEHICLE DATABASE');
						$('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Search...');
					});*/
	$(document).ready(function() {
	//	var token = "{{ csrf_token() }}";
	  $('#fileData').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ url('vehicle-types/ajaxData') }}",
        "columns": [
            {data: 'type', name: 'type'},		  
            {data: 'created_at', name: 'created_at'},            
            {data: 'action', name: 'action', orderable: false, searchable: false, bSearchable: false},
        ]      
    });
	   });
</script>
				<!-- / Javascript -->

				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"></span>
					</div>
					<div class="panel-body">
						<div class="table-primary">
							<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="fileData">
								<thead>
									<tr>
										<th>Type</th>										
										<th>Created At</th>										
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
																	
								</tbody>
							</table>
						</div>
					</div>
				</div>
<!-- /11. $JQUERY_DATA_TABLES -->

			</div>
		</div>

@endsection