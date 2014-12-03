@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="carriers-list">
		<h2>Carriers</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Carrier Name</th>
			</tr>
			@foreach($carriers as $carrier)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $carrier->carrier }}</a>
						<ul class="actions">
							<li><a href="{{ URL::route('admin.carriers.edit', $carrier->id) }}">Edit</a></li>
							<li><a href="">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.carriers.destroy', $carrier->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
				</tr>
			@endforeach
		</table>
		<br>
		<a href="{{ URL::route('admin.carriers.create') }}" class="mgmt-link">New Carrier</a>
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop