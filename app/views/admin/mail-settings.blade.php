@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	{{ Form::model($settings, array('route' => array('admin.game-settings.update', $settings->id), 'method' => 'put', 'class' => 'small-form', 'files' => true, 'enctype'=> 'multipart/form-data')) }}
		<h2>Mail Settings</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>

	{{ Form::close() }}
@stop