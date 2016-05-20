@extends('layouts.master')

@section('title', 'Fail Flash')

@section('content')
    <script>
    	$( document ).ready(function() {
		    var data = {
			    labels: ["January", "February", "March", "April", "May", "June", "July"],
			    datasets: [
			        {
			            label: "My First dataset",
			            fill: true,
			            lineTension: 0.1,
			            backgroundColor: "rgba(75,192,192,0.4)",
			            borderColor: "rgba(75,192,192,1)",
			            borderCapStyle: 'butt',
			            borderDash: [],
			            borderDashOffset: 0.0,
			            borderJoinStyle: 'miter',
			            pointBorderColor: "rgba(75,192,192,1)",
			            pointBackgroundColor: "#fff",
			            pointBorderWidth: 1,
			            pointHoverRadius: 5,
			            pointHoverBackgroundColor: "rgba(75,192,192,1)",
			            pointHoverBorderColor: "rgba(220,220,220,1)",
			            pointHoverBorderWidth: 2,
			            pointRadius: 1,
			            pointHitRadius: 10,
			            data: [30, 10, , -33, -23, 10, -20],
			        }
			    ]
			};
			
			var ctx = document.getElementById("myChart");

		    var myLineChart = new Chart(ctx, {
			    type: 'line',
			    data: data,
			    options: {
			        xAxes: [{
			            display: false
			        }]
			    }
			});



		});
    </script>






    <div class="row">
    	<div class="col-xs-3">
    		<div class='panel panel-primary'>
    			<div class='panel-heading' style="text-align:center">
    				<b>Top Played Champions</b>
    			</div>
    			<div class='panel-body'>
    				
	    		</div>
    			<div class ='panel-footer'>
    				
    			</div>
    		</div>
    	</div>
    	<div class="col-xs-9">
    		<div class='panel panel-primary'>
    			<div class='panel-heading' style="text-align:center">
    				<b>Latest Game</b>
    			</div>
    			<div class='panel-body'>
    				<canvas id="myChart" width="400" height="400"></canvas>
	    		</div>
    			<div class ='panel-footer'>
    				
    			</div>
    		</div>
    	</div>
    </div>
@stop