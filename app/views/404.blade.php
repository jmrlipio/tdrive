@extends('_layouts.single')
@section('content')

	<br>
    <h2 class="center">Page Not Found!</h2><br>

    <p class="center">This page could not be found on the server. <br> 404 error! <br><br>
    	{{ HTML::link('/','Return to homepage', array('class' => 'center')) }}
    </p>  

@stop