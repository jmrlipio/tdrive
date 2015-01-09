@extends('admin._layouts.admin')

@section('content')
	{{ Form::open(array('route' => array('admin.form-messages.update'), 'method' => 'post', 'class' => 'small-form', 'id' => 'form-messages')) }}
		<h2>Form Messages</h2>
		
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif

		<?php $count = 0; ?>
		@foreach($messages as $message)
			<div class="form-messages">
				<h3>{{ ucfirst($message->form) }} Form</h3>
				<li>
					{{ Form::label('success', 'Success Message:') }}
					{{ Form::text('messages[' . $count . '][success]', $message->success) }}

					{{ Form::label('error', 'Error Message:') }}
					{{ Form::text('messages[' . $count .'][error]', $message->error) }}
					{{ Form::hidden('messages[' . $count . '][id]', $message->id) }}
				</li>
				<?php $count++; ?>
			</div>
		@endforeach

		{{ Form::submit('Update Form Messages') }}
	{{ Form::close() }}
@stop