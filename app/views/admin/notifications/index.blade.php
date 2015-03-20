@extends('admin._layouts.admin')

@section('stylesheets')

	<style>
		.fl { float: left; }
		.clear { clear:both; }
		form.login { width: 15%; }
		input:disabled:hover { background: #5cb85c; cursor: not-allowed;}
		input:disabled { background: #5cb85c; }
  		h3.flash-success { color: green !important; line-height: 40px; }
	</style>
@stop

@section('content')

	<div class="item-listing" id="news-list">
		
		<h2>Notifications</h2>

		@if (Session::has('success') ) 
            
        	<h3 class="center flash-success">{{ Session::get('success') }}</h3>

        @endif
		
		<br>

		<p><strong>Game Title:</strong> {{ $review->game->main_title }}</p>	<br>	
		
 		<p><strong>Review by:</strong> {{ $review->user->first_name  }}</p> <br>

 		<p><strong>Review:</strong> {{ $review->review }}</p> <br>

 		{{ Form::open(array('route' => 'review.approve', 'class' => 'login fl' )) }}

			@if($review->status == '1')			

				<div class="control-item submit-btn">
							
					<input type="hidden" name="id" value="{{$review->id}}" />	
						
						{{ Form::submit('Approved', array('disabled')) }}		

				</div>	

			@else

				<div class="control-item submit-btn">
							
					<input type="hidden" name="id" value="{{$review->id}}" />	
						
						{{ Form::submit('Approve') }}		

				</div>	


			@endif			


		{{ Form::close() }}

		{{ Form::open(array('route' => array('review.destroy', $review->id), 'method' => 'delete', 'class' => 'fl login')) }}
				
			{{ Form::submit('Delete') }}					

		{{ Form::close() }}

		<div class="clear"></div>
		
	</div>

@stop

@section('scripts')


@stop