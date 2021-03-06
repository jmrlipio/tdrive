@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="faq-list">
		<h2>Discounts</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<a href="{{ URL::route('admin.discounts.create') }}" class="mgmt-link">Create Discount</a>
		<table class="table table-striped table-bordered table-hover"  id="game_table">
			<thead>
				<tr>
					<th>Discount Name</th>
				</tr>
			</thead>

			<tbody>
				@if(!$discounts->isEmpty())
					@foreach($discounts as $discount)	
						<tr>
							<td>
								<a href="#">{{ $discount->title }}</a>
								@if(Auth::user()->role != 'admin')
									<ul class="actions">							
										<li><a href="{{ URL::route('admin.discounts.edit', $discount->id) }}">Edit</a></li>		
										<li>
											{{ Form::open(array('route' => array('admin.discounts.destroy', $discount->id), 'method' => 'delete', 'class' => 'delete-form')) }}
												{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
											{{ Form::close() }}
										</li>
									</ul>
								@endif
							</td>
						</tr>
					
					@endforeach
				@else
					<td><center>You haven't created any discounts yet.</center></td>
				@endif
			</tbody>
		</table>
	</div>

	{{ HTML::script('js/form-functions.js') }}
@stop
