@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="platforms-list">
		<h2>Platforms</h2>
		@if(Session::has('message'))
		    <div class="flash-{{ Session::get('sof') }}">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Platform</th>
				<th>Slug</th>
			</tr>
			@foreach($platforms as $platform)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $platform->platform }}</a>
						<ul class="actions">
							<li><a href="{{ URL::route('admin.platforms.edit', $platform->id) }}">Edit</a></li>
							<li><a href="">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.platforms.destroy', $platform->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
					<td>{{ $platform->slug }}</td>
				</tr>
			@endforeach
		</table>
		<br>
		<a href="{{ URL::route('admin.platforms.create') }}" class="mgmt-link">New Platform</a>
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop