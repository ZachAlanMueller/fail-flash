@extends('layouts.master')

@section('title', 'Fail Flash')

@section('content')
	<div class="row">

    <div class="row" style="border-bottom: solid;border-bottom-width: 1px; border-color: #eee; padding-bottom: 10px;">
			<div class="col-xs-2 text-center">
				<img src="{{$summonerInfo->profile_img_link}}" class="img-circle" width="80px" height="80px">
			</div>
			<div class="col-xs-3">
				<h2 class="text-center" style="font-family: Georgia, serif;">
					{{$summonerInfo->name}}
				</h2>
			</div>
			<div class="col-xs-2">
				<script>
				
				</script>
				<button id="refresh-button" type="button" class="btn btn-info btn-sm btn-block">Refresh Info</button>
				<button type="button" class="btn btn-warning btn-sm btn-block">Look for Live Game</button>
			</div>
			<div class="col-xs-2">
				<p style="visibility:hidden;"> Blarg</p>
			</div>
			<div class="col-xs-1">
				<img src="{{$summonerInfo->badge_img_link}}" width="80px" height="80px">
			</div>
			<div class="col-xs-2 text-center" style="font-family: Georgia, serif;">
				<p><b>{{ucwords(strtolower($summonerInfo->tier))}} {{$summonerInfo->division}}</b></p>
				<p><b>{{$summonerInfo->league_points}} LP </b></p>
			</div>
		</div>
</div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-pills">
            <li class="active"><a href="#overview-pills" data-toggle="tab">Overview</a>
            </li>
            <li><a href="#games-pills" data-toggle="tab">Recent Games</a>
            </li>
            <li><a href="#champions-pills" data-toggle="tab">Champions</a>
            </li>
            <li><a href="#settings-pills" data-toggle="tab">Settings</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="overview-pills">
							<div class="row">
								<div class="col-xs-6">
									@if(true)
										<canvas id="lastGame" width="auto" height="auto"></canvas>
										<script>
											$(document).ready(function() {
												var ctx = document.getElementById('lastGame');
												var lastGame = new Chart(ctx, {
													type: 'bar',
													data: {
														labels: [
															"2", "stuff", "three"
														],
														datasets: [{
															label: 'KDA of Last 10 Games',
															data: [
																"4.5", "4", "5"
															]
														}]
													},
													options: {
														scales: {
															yAxes: [{
																ticks: {
																	beginAtZero:true
																}
															}]
														}
													}
												});
											});
										</script>
									@endif
								</div>
								<div class="col-xs-3">

								</div>
								<div class="col-xs-3">

								</div>
							</div>
            </div>
            <div class="tab-pane fade" id="games-pills">
                <h4>Profile Tab</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="tab-pane fade" id="champions-pills">
							<div class="row">
								<div class="col-xs-6">
									@if(true)
										<canvas id="topPlayedChamps" width="auto" height="auto"></canvas>
										<div id="chartjs-tooltip"></div>
										<script>
											$(document).ready(function() {
												//
												function Label(short, long) {
						              this.short = short;
						              this.long = long
						             }
						             Label.prototype.toString = function() {
						              return this.short;
						             }
												//
												var ctx = document.getElementById('topPlayedChamps');
												var topChamps = new Chart(ctx, {
													type: 'horizontalBar',
													data: {
												    labels: [
											        @for($i = 0; $i < 10; $i++)
															new Label("{{$champions->topPlayed[$i]->name}}", "{{round($champions->topPlayed[$i]->win_percent, 1)}}")
															@if($i != 9), @endif
															@endfor
												    ],
												    datasets: [
											        {
										            data: [
																	@for($j = 0; $j < 10; $j++)
																	"{{$champions->topPlayed[$j]->number_games}}"
																	@if($j != 9), @endif
																	@endfor
																],
										            backgroundColor: [
										                "#191E58",
										                "#2C3065",
										                "#3F4373",
																		"#525681",
										                "#65698F",
																		"#787B9D",
										                "#8C8EAB",
										                "#9FA1B9",
																		"#B2B4C7",
																		"#C5C6D5"
										            ],
										            hoverBackgroundColor: [
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de"
										            ]
											        }
														]
													},
													options: {
														cutoutPercentage: 50,
														title: {
															display: true,
															text: 'Most Played Champions'
														},
														legend: {
															display: false
														},
														tooltips: {
															enabled: true,
															callbacks: {
													      // tooltipItem is an object containing some information about the item that this label is for (item that will show in tooltip).
													      // data : the chart data item containing all of the datasets
																title: function(tooltipItem, data) {
													        // Return string from this function. You know the datasetIndex and the data index from the tooltip item. You could compute the percentage here and attach it to the string.

																	return tooltipItem[0].yLabel;
													      },
																beforeLabel: function(tooltipItem, data) {
													        // Return string from this function. You know the datasetIndex and the data index from the tooltip item. You could compute the percentage here and attach it to the string.
																	return "Ranked Games Played: " + tooltipItem.xLabel;
													      },
																label: function(tooltipItem, data) {
													        // Return string from this function. You know the datasetIndex and the data index from the tooltip item. You could compute the percentage here and attach it to the string.

																	return "Win Rate: " + data.labels[tooltipItem.index].long + "%";

													      }
															}
														}
													},
												});
											});
										</script>
									@endif
								</div>
								<div class="col-xs-6">
									@if(true)
										<canvas id="topWinningChamps" width="auto" height="auto"></canvas>
										<div id="chartjs-tooltip"></div>
										<script>
											$(document).ready(function() {
												//

												//
												var ctx = document.getElementById('topWinningChamps');
												var topChamps = new Chart(ctx, {
													type: 'pie',
													data: {
												    labels: [
											        @foreach($champions->topWinners as $j => $winner)
															"{{$winner->name}}"
															@if($j != count($champions->topWinners)), @endif
															@endforeach
												    ],
												    datasets: [
											        {
										            data: [
																	@foreach($champions->topWinners as $j => $winner)
																	"{{round($winner->win_percent, 1)}}"
																	@if($j != count($champions->topWinners)), @endif
																	@endforeach
																],
										            backgroundColor: [
										                @foreach($champions->topWinners as $j => $winner)
																		"#{{$colors[abs(round($winner->win_percent / 10, 0) - 10)]}}"
																		@if($j != count($champions->topWinners)), @endif
																		@endforeach
										            ],
										            hoverBackgroundColor: [
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de",
																		"#5bc0de"
										            ]
											        }
														]
													},
													options: {
														cutoutPercentage: 50,
														title: {
															display: true,
															text: 'Top Win Percent Champions'
														},
														legend: {
															display: true
														},
														tooltips: {
															enabled: true,
														}
													},
												});
											});
										</script>
									@endif
								</div>
							</div>
						</div>
            <div class="tab-pane fade" id="settings-pills">
                <h4>Settings Tab</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
	</div>
@stop
