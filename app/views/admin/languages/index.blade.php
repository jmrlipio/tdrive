@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="languages-list">
		<h2>Languages</h2>

		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.languages.create') }}" class="mgmt-link">New Language</a>
		@endif

		<br>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th>ID</th>
				<th>Language</th>
			</tr>
			@if(!$languages->isEmpty())
				@foreach($languages as $language)
					<tr>
						<td>{{ str_pad($language->id, 2, '0', STR_PAD_LEFT) }}</td>
						<td>
							<a href="{{ URL::route('admin.languages.edit', $language->id) }}">{{ $language->language }}</a>
							@if(Auth::user()->role != 'admin')
								<ul class="actions">
									<li><a href="{{ URL::route('admin.languages.edit', $language->id) }}">Edit</a></li>
									<li>
										{{ Form::open(array('route' => array('admin.languages.destroy', $language->id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</li>
								</ul>
							@endif
						</td>
					</tr>
				@endforeach
			@else
				<td><center>You haven't created any languages yet.</center></td>
			@endif
		</table>
		<br>
		
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop