@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="languages-list">
		<h2>Languages</h2>
		<a href="{{ URL::route('admin.languages.create') }}" class="mgmt-link">New Language</a>
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Language</th>
			</tr>
			@foreach($languages as $language)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $language->language }}</a>
						<ul class="actions">
							<li><a href="{{ URL::route('admin.languages.edit', $language->id) }}">Edit</a></li>
							<li><a href="">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.languages.destroy', $language->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
				</tr>
			@endforeach
		</table>
		<br>
		
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop