@extends('_layouts.single')
@section('content')

	<br>
    <h2 class="center">{{ trans('global.Page Not Found!') }}</h2><br>

	<div id="token">{{ Form::token() }}</div>

    <p class="center">{{ trans('global.This page could not be found on the server.') }} <br> {{ trans('global.404 error!') }} <br><br>
    	{{ HTML::link('/',trans('global.Return to homepage'), array('class' => 'center')) }}
    </p>  

@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

@stop
