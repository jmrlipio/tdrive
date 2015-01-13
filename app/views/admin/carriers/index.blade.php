@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="carriers-list">
		<h2>Carriers</h2>
		
		@if(Auth::user()->role != 'admin')
			<a href="{{ URL::route('admin.carriers.create') }}" class="mgmt-link">New Carrier</a>
		@endif
		
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th>Carrier Name</th>
			</tr>
			@if(!$carriers->isEmpty())
				@foreach($carriers as $carrier)
					<tr>
						<td>
							<a href="#">{{ $carrier->carrier }}</a>
							@if(Auth::user()->role != 'admin')
								<ul class="actions">
									<li><a href="{{ URL::route('admin.carriers.edit', $carrier->id) }}">Edit</a></li>
									<li>
										{{ Form::open(array('route' => array('admin.carriers.destroy', $carrier->id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}
									</li>
								</ul>
							@endif
						</td>
					</tr>
				@endforeach
			@else
				<td><center>You haven't created any carriers yet.</center></td>
			@endif
		</table>
		<br>
		
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop