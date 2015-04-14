@extends('_layouts.form')

@section('stylesheets')
	{{ HTML::style("css/form.css"); }}
@stop

<style>
	
	#logo-container {
		margin-top: -30px;
		margin-bottom: 10px;
	}
	.container {
		display: none;
	}
	
</style>

@section('content')
    {{ Form::open(array('route' => 'authorize.login.post', 'class' => 'login')) }}
        <h2>Please login</h2>
        @if (Session::has('message') ) 
            <center><p class="error">{{ Session::get('message') }}</p></center>       
        @endif 
        <ul>
            <li>
                {{ Form::label('username', 'Username') }}
                {{ Form::text('username') }}
                {{ $errors->first('username', '<p class="error">:message</p>') }}
            </li>
            <li>
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password') }}
                {{ $errors->first('password', '<p class="error">:message</p>') }}
                {{ Form::hidden('app_id', $app_id) }}
            </li>
            <li>
                {{ Form::submit('Log in') }}
            </li>
        </ul>
    {{ Form::close() }}

@stop

@section('javascripts')

@stop
