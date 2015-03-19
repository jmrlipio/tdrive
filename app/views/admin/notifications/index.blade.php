@extends('admin._layouts.admin')

@section('content')

	<div class="item-listing" id="news-list">
		
		<h2>Notifications</h2>
		

		<p>Game Title: {{ $review->game->main_title }}</p>
		
		
 		<p>Review by: {{ $review->user->first_name  }}</p>

 		<p>Review: {{ $review->review }}</p>

 		{{ Form::open(array('route' => 'admin.approve.review', 'class' => 'login fl' )) }}

	 		@if(Session::has('success'))

		 		<p>{{ Session::get('success') }}</p>	 	
			
			@else

				<div class="control-item submit-btn">
							
					<input type="hidden" name="id" value="{{$review->id}}" />	
						
						{{ Form::submit('Approve') }}					

				</div>	

			@endif				


		{{ Form::close() }}
		
	</div>

@stop

@section('scripts')


@stop