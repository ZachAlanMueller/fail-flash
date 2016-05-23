@extends('layouts.master')

@section('title', 'Fail Flash')

@section('content')
	<style>
		#poster{
			display: block;
			margin-left: auto;
			margin-right: auto;
			height: 85vh;
			width: auto;
		}
	</style>
    <img src="{{$img_link}}" id="poster">
@stop