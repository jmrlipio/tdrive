@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	{{ Form::open(array('route' => array('admin.variables.update'), 'method' => 'post', 'class' => 'small-form', 'id' => 'variables')) }}
	<h2>Site Variables</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<?php $count = 0; ?>
		@foreach($variables as $variable)
			<li>
				{{ Form::label($variable->variable_name, $variable->variable_name) }}
				{{ Form::text('variables[' . $count .'][variable_value]', $variable->variable_value) }}
				{{ Form::hidden('variables[' . $count . '][id]', $variable->id) }}
			</li>
			<?php $count++; ?>
		@endforeach
		{{ Form::submit('Update Variables') }}
	{{ Form::close() }}
@stop