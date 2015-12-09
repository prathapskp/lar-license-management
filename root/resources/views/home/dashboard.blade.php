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

<?php $arr[] = array('day' => 'Jan', 'v' => 20);
 ?>
		<div class="row">
			<div class="col-md-8">
				<div class="stat-panel">
					<div class="stat-row">

						<!-- Small horizontal padding, bordered, without right border, top aligned text -->
						<div class="stat-cell col-sm-8 padding-sm-hr bordered no-border-r valign-top">
							<!-- Small padding, without top padding, extra small horizontal padding -->
							<h4 class="padding-sm no-padding-t padding-xs-hr"><i class="menu-icon fa fa-files-o"></i>&nbsp;&nbsp;Clients with expiring licenses this month</h4>
							<!-- Without margin -->
							<ul class="list-group no-margin">
								@foreach($client_list as $value)
								<li class="list-group-item no-border-hr padding-xs-hr no-bg">
									{{$value->client_name}} <span class="label label-pa-purple pull-right">{{$value->count}}</span>
								</li> <!-- / .list-group-item -->
								@endforeach
							</ul>
						</div> <!-- /.stat-cell -->
						
					</div>
				</div> <!-- /.stat-panel -->				
			</div>
<!-- /6. $EASY_PIE_CHARTS -->

			<div class="col-md-4">
				<div class="row">

<!-- 7. $EARNED_TODAY_STAT_PANEL ===================================================================

					Earned today stat panel
-->
					<div class="col-sm-4 col-md-12">
						<div class="stat-panel">
							<!-- Danger background, vertically centered text -->
							<div class="stat-cell bg-danger valign-middle">
								<!-- Stat panel bg icon -->
								<i class="fa fa-flash bg-icon"></i>
								<!-- Extra large text -->
								<span class="text-xlg"><strong>{{ $expired_vehicle_count }}</strong></span><span class="text-lg text-slim">&nbsp;Vehicle</span><br>
								<!-- Big text -->
								<span class="text-bg">Have not been renewed</span><br>
								<!-- Small text -->
								<span class="text-sm"><a href="#"></a></span>
							</div> <!-- /.stat-cell -->
						</div> <!-- /.stat-panel -->
					</div>
<!-- /7. $EARNED_TODAY_STAT_PANEL -->


<!-- 8. $RETWEETS_GRAPH_STAT_PANEL =================================================================

					Retweets graph stat panel
-->
					<div class="col-sm-4 col-md-12">
						<!-- Javascript -->
						<script>
							init.push(function () {
								$("#stats-sparklines-3").pixelSparkline([275,490,397,487,339,403,402,312,300], {
									type: 'line',
									width: '100%',
									height: '45px',
									fillColor: '',
									lineColor: '#fff',
									lineWidth: 2,
									spotColor: '#ffffff',
									minSpotColor: '#ffffff',
									maxSpotColor: '#ffffff',
									highlightSpotColor: '#ffffff',
									highlightLineColor: '#ffffff',
									spotRadius: 4,
									highlightLineColor: '#ffffff'
								});
							});
						</script>
						<!-- / Javascript -->

						<div class="stat-panel">
							<div class="stat-row">
								<!-- Purple background, small padding -->
								<div class="stat-cell bg-pa-purple valign-middle">
								<i class="fa fa-trophy bg-icon"></i>
								<span class="text-xlg"><strong>1400</strong></span><span class="text-lg text-slim">&nbsp;Vehicles</span><br>
								<!-- Big text -->
								<span class="text-bg">Have complete papers</span><br>
								<!-- Small text -->
								<span class="text-sm"><a href="#"></a></span>
									<!-- Extra small text -->
																	</div>
							</div> <!-- /.stat-row -->
							
						</div> <!-- /.stat-panel -->
					</div>
<!-- /8. $RETWEETS_GRAPH_STAT_PANEL -->

<!-- 9. $UNIQUE_VISITORS_STAT_PANEL ================================================================

					Unique visitors stat panel
-->
					<div class="col-sm-4 col-md-12">
					

						<div class="stat-panel">
							<div class="stat-row">
								<!-- Warning background -->
								<div class="stat-cell bg-warning">
									<!-- Big text -->
									<i class="fa fa-flash bg-icon"></i>
								<!-- Extra large text -->
								<span class="text-xlg"><strong>{{ $expired_papers_count }}</strong></span><span class="text-lg text-slim">&nbsp;License</span><br>
								<!-- Big text -->
								<span class="text-bg">Have not been renewed</span><br>
								<!-- Small text -->
								<span class="text-sm"><a href="#"></a></span>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Warning background, small padding, without top padding, horizontally centered text -->
								<div class="stat-cell bg-warning padding-sm no-padding-t text-center">								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div>
				</div>
			</div>
		</div>
<!-- /9. $UNIQUE_VISITORS_STAT_PANEL -->

		<!-- Page wide horizontal line -->
		

		<div class="row">

<!-- 10. $SUPPORT_TICKETS ==========================================================================

			Support tickets
-->
			<!-- Javascript -->
			<script>
				init.push(function () {
					$('#dashboard-support-tickets .panel-body > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: true });
				})
			</script>
			<!-- / Javascript -->

		
<!-- /10. $SUPPORT_TICKETS -->

<!-- 11. $RECENT_ACTIVITY ==========================================================================

			Recent activity
-->
			<!-- Javascript -->
			<script>
				init.push(function () {
					$('#dashboard-recent .panel-body > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: true });
				})
			</script>
			<!-- / Javascript -->

			
<!-- /11. $RECENT_ACTIVITY -->
		</div>

		<!-- Page wide horizontal line -->
	

		<div class="row">

<!-- 12. $NEW_USERS_TABLE ==========================================================================

			New users table
-->
		
<!-- /12. $NEW_USERS_TABLE -->

<!-- 13. $RECENT_TASKS =============================================================================

			Recent tasks
-->
			
<!-- /13. $RECENT_TASKS -->

		</div>
@endsection