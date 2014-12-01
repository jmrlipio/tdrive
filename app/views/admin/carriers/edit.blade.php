@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	{{ Form::model($carrier, array('route' => array('admin.carriers.update', $carrier->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Edit Carrier</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<ul>
			<li>
				{{ Form::label('carrier', 'Carrier: ') }}
				{{ Form::text('carrier') }}
				{{ $errors->first('carrier', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('country_id', 'Countries: ') }}
				{{ Form::select('country_id[]', $countries, $selected_countries, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose country(s)...'))  }}
				{{ $errors->first('country_id', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save') }}
			</li>
		</ul>
		

	{{ Form::close() }}
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	$(document).ready(function(){
		$(".chosen-select").chosen();
	});
	</script>

@stop