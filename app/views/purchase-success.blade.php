@extends('_layouts.single')
@section('content')

	<br>
    <h2 class="center">{{ trans('global.Purchase successful...') }}</h2><br>

	<div id="token">{{ Form::token() }}</div>

    <p class="center">{{ trans('global.You are now going to be redirected back to the game page so that you can download the game.') }}

    </p>  

    <p class="center">{{ trans('global.You are being redirected in 10 seconds.') }}</p>

    <p class="center"><a href="#">back to game page</a></p>

@stop

@section('javascripts')
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	
	@include('_partials/scripts')

	<script>

		$( document ).ready(function() {

			window.setTimeout(function(){

		        //window.location.href = "";

		    }, 10000);

		});

		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		        sURLVariables = sPageURL.split('&'),
		        sParameterName,
		        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');
	        sPageURL = sParameterName[1];
	    }
	    //console.log(sPageURL);

	</script>

@stop
