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
				<button type="button" class="btn btn-info btn-sm btn-block">Refresh Info</button>
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
									    type: 'line',
									    data: {
									        labels: [
										        @foreach($lastGame->frameEvents as $a => $frameEvent)
										        	@if(($a % count($lastGame->players)) == 0)
										        		"{{round(($frameEvent->timestamp / 60000), 0) }}" @if( $a != count($lastGame->frameEvent)), @endif
										        	@endif
										        @endforeach
									        ],
									        datasets: [{
									            label: 'Gold',
									            data: [
									            @foreach($lastGame->frameEvents as $a => $frameEvent)
																@if($frameEvent->summoner_id == $userInfo->summoner_id && $frameEvent->event_type == "CHAMPION_KILL" and $frameEvent->victim_id == $userInfo->summoner_id)
																	"{{2 * $a}}" @if( $a != count($lastGame->frames)), @endif
																@endif
									        	@endforeach
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
                <h4>Messages Tab</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="tab-pane fade" id="settings-pills">
                <h4>Settings Tab</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
	</div>
@stop
