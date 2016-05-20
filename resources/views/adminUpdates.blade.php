@extends('layouts.master')

@section('title', 'Fail Flash')

@section('content')
    <div class="row">
    	<div class="col-xs-4">
    		<div class='panel panel-info'>
    			<div class='panel-heading'>
    				Database Updates
    			</div>
    			<div class='panel-body'>
    				{{ Form::open(['route' => 'update-database']) }}
	    			<div class='row'>
	    				<div class='col-xs-12'>
	    					{{ Form::checkbox('champions', 'value', 'class' => 'checkbox-tv') }}
	    					Update Champions Table
	    				</div>
	    			</div>
	    		</div>
    			<div class ='panel-footer'>
    				{{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
    				{{ Form::close() }}
    			</div>

    	</div>
    	<div class="col-xs-4">

    	</div>
    	<div class="col-xs-4">

    	</div>
    </div>
@stop