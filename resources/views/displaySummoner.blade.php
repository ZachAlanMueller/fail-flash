@extends('layouts.master')

@section('title', 'Fail Flash')

@section('content')
	<div class="row">
		<div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
					<div class="col-xs-2" style="border-right: solid;border-color: black">
						<img src="{{$summonerInfo->profile_img_link}}" class="img-circle" width="80px" height="80px">
					</div>
					<div class="col-xs-3" style="border-right: solid;border-color: black">
						<h2 class="text-center" style="margin-top:0px;font-family: Georgia, serif">
							{{$summonerInfo->name}}
						</h2>
						<!-- <div class="row">
							<h4 class="text-center"> 
								{{ucwords(strtolower($summonerInfo->tier))}} {{$summonerInfo->division}} 
							</h4>
						</div> -->
					</div>
					<div class="col-xs-2" style="border-right: solid;border-color: black">
						b<!-- <img src="{{$summonerInfo->badge_img_link}}" class="img-circle" height="100px" width="auto"> -->
					</div>
					<div class="col-xs-2"  style="border-right: solid;border-color: black">
c
					</div>
					<div class="col-xs-3" style="border-right: solid;border-color: black">
d
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
                        <h4>Home Tab</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="tab-pane fade" id="champions-pills">
                        <h4>Profile Tab</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="tab-pane fade" id="messages-pills">
                        <h4>Messages Tab</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="tab-pane fade" id="settings-pills">
                        <h4>Settings Tab</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
	</div>
@stop