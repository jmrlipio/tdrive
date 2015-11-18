@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="faq-list">
		<h2>Discounts</h2>

		<a href="{{ URL::route('admin.discounts.create') }}" class="mgmt-link">Create Discount</a>
		<table class="table table-striped table-bordered table-hover"  id="game_table">
			<thead>
				<tr>
					<th>Discount Name</th>
					<th>Carrier</th>
					<th>Games</th>
					<th>Discount</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
			</thead>

			<tbody>
				@if(!$discounts->isEmpty())
					@foreach($discounts as $discount)	
						<tr>
							<td>
								<a href="{{ URL::route('admin.discounts.edit', $discount->id) }}">{{ $discount->title }}</a>
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
							<td>{{ $discount->carrier->carrier }}</td>
							<td>
								@foreach($discount->games as $game)
									{{ $game->main_title }},
								@endforeach
							</td>
							<td>{{ $discount->discount_percentage . '%' }}</td>
							<td>{{ Carbon::createFromFormat('Y-m-d', $discount->start_date)->toFormattedDateString() }}</td>
							<td>{{ Carbon::createFromFormat('Y-m-d', $discount->end_date)->toFormattedDateString() }}</td>
						</tr>
					
					@endforeach
				@else
					<td><center>You haven't created any discounts yet.</center></td>
				@endif
			</tbody>
		</table>
	</div>

@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}

<script type="text/javascript">
$(document).ready(function(){
	
	$('#game_table').DataTable();
	
	<?php if( Session::has('message') ) : ?>
		var message = "{{ Session::get('message')}}";
		var status = "{{ Session::get('sof') }}"
		var success= "";
		
		switch(status)
		{
			case 'success':
				success	= '1';
			break;

			case 'failed':
				success	= '0';
			break;

			default:
				success = '1';
		}
	
		getFlashMessage(success, message);
	<?php endif; ?>

});	
</script>
@stop
