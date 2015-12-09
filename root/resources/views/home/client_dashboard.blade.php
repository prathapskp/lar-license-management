@extends('admin_template')

@section('content')
<style type="text/css">
	.pie-chart-label {
		font-size: 14px;
		line-height: 25px;
	}
</style>
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
					
				</div>
			</div>
		</div> <!-- / .page-header -->

<?php /*$arr[] = array('day' => '2015-02', 'v' => 65);
$arr[] = array('day' => '2015-03', 'v' => 12);*/

 ?>
		<div class="row">
			<div class="col-md-8">

<!-- 5. $UPLOADS_CHART =============================================================================

				Uploads chart
-->
				<!-- Javascript -->
				<script>
					init.push(function () {
						Morris.Line({
							element: 'hero-graph',
							data: <?php echo json_encode($graph_plot_data); ?>,
							xkey: 'day',
							ykeys: ['v'],
							labels: ['Renewals'],
							lineColors: ['#fff'],
							lineWidth: 2,
							pointSize: 4,
							gridLineColor: 'rgba(255,255,255,.5)',
							resize: true,
							gridTextColor: '#fff',
							xLabels: "month",
						   // xLabelMargin: 20,
							//xLabelAngle: 10,
							xLabelFormat: function(d) {
								return ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov', 'Dec'][d.getMonth()] + ' ' + d.getDate(); 
							},
						});
					

					});
				</script>
				<!-- / Javascript -->

				<div class="stat-panel">
					<div class="stat-row">
						<!-- Small horizontal padding, bordered, without right border, top aligned text -->
						<div class="stat-cell col-sm-4 padding-sm-hr bordered no-border-r valign-top">
							<!-- Small padding, without top padding, extra small horizontal padding -->
							<h4 class="padding-sm no-padding-t padding-xs-hr"><i class="menu-icon fa fa-files-o"></i>&nbsp;&nbsp;Next Month Renewals</h4>
							<!-- Without margin -->
							<ul class="list-group no-margin">
							@if(!empty($next_month_license_type_expiry_data))
								@foreach($next_month_license_type_expiry_data as $value)
								<li class="list-group-item no-border-hr padding-xs-hr no-bg">
									{{$value->type}} <span class="label label-pa-purple pull-right">{{$value->count}}</span>
								</li> <!-- / .list-group-item -->
								@endforeach
							@endif
							</ul>
						</div> <!-- /.stat-cell -->
						<!-- Primary background, small padding, vertically centered text -->
						<div class="stat-cell col-sm-8 bg-primary padding-sm valign-middle">
							<div id="hero-graph" class="graph" style="height: 230px;"></div>
						</div>
					</div>
				</div> <!-- /.stat-panel -->
<!-- /5. $UPLOADS_CHART -->

<!-- 6. $EASY_PIE_CHARTS ===========================================================================

				Easy Pie charts
-->
				<!-- Javascript -->
				<script>
				license_types = '<?php echo count($current_month_license_type_expiry_data); ?>';
					init.push(function () { 
						license_types = license_types+1;
						// Easy Pie Charts
						var easyPieChartDefaults = {
							animate: 2000,
							scaleColor: false,
							lineWidth: 6,
							lineCap: 'square',
							size: 90,
							trackColor: '#e5e5e5'
						}
						for (i = 0; i <= license_types; i++) { 
						    $('#easy-pie-chart-'+i).easyPieChart($.extend({}, easyPieChartDefaults, {
								barColor: LanderApp.settings.consts.COLORS[1]
							}));
						}
						
						/*$('#easy-pie-chart-2').easyPieChart($.extend({}, easyPieChartDefaults, {
							barColor: LanderApp.settings.consts.COLORS[1]
						}));
						$('#easy-pie-chart-3').easyPieChart($.extend({}, easyPieChartDefaults, {
							barColor: LanderApp.settings.consts.COLORS[1]
						}));*/
					});
				</script>
				<!-- / Javascript -->

				<div class="row">
				<?php $i =1;
				if(!empty($current_month_license_type_expiry_data))
				foreach($current_month_license_type_expiry_data as $value) { ?>
					<div class="col-xs-4">
						<!-- Centered text -->
						<div class="stat-panel text-center">
							<div class="stat-row">
								<!-- Dark gray background, small padding, extra small text, semibold text -->
								<div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
									<i class="fa fa-globe"></i>&nbsp;&nbsp;Expiring This Month
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, without horizontal padding -->
								<div class="stat-cell bordered no-border-t no-padding-hr">
									<div class="pie-chart" data-percent="43" id="easy-pie-chart-{{$i}}">
										<div class="pie-chart-label">{{ $value->count}} 
										@if($value->count > 1)
										{{ $value->type }}s
										@elseif ($value->count <= 1)
										{{ $value->type }}
										@endif
										</div>
									</div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div>
					<?php $i++;
					} ?>
					
				</div>
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
								<span class="text-xlg"><strong>{{ $expired_vehicle_count }}</strong></span><span class="text-lg text-slim">&nbsp;Vehicle <?= ($expired_vehicle_count > 1) ? '' : 's'; ?></span><br>
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
								<span class="text-xlg"><span class="text-lg text-slim">Call </span><strong>08189064341</strong></span><br>
								<!-- Big text -->
								<span class="text-bg">For Support</span><br>
								<!-- Small text -->
								<span class="text-sm"><a href="#">www.eazypapers.com</a></span>
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
		<hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t">

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
		<hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t">

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