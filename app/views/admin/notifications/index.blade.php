@extends('admin._layouts.admin')

@section('stylesheets')

	<style>
		.fl { float: left; }
		.clear { clear:both; }
		form.login { width: 15%; }
		input:disabled:hover, button:disabled:hover { background: #5cb85c; cursor: not-allowed;}
		input:disabled, button:disabled { background: #5cb85c; color: #fff; }
  		h3.flash-success { color: green !important; line-height: 40px; }
  		button { background: #FFC0CB; color: #333; width: 86%; height: 32px;}
  		button:hover {background: #333; color: #fff;}
  		button .fa { padding-right: 5px; }
  		button.disapprove { background: #333; color: #fff;}
  		button.disapprove:hover { background: #FFC0CB; color: #333;}
  		button.disapprove:disabled:hover { background: #333; color: #fff;}
  		button.delete-button { background: #CC0001; color: #fff;}
  		button.delete-button:hover { background: #333; color: #fff;}
	</style>
@stop

@section('content')

	<div class="item-listing">
		
		<h2>Notifications</h2>		
		<br>

		<p><strong>Game Title:</strong> {{ $review->game->main_title }}</p>	<br>	
		
 		<p><strong>Review by:</strong> {{ $review->user->first_name  }}</p> <br>

 		<p><strong>Review:</strong> {{ $review->review }}</p> <br>


 		{{ Form::open(array('route' => 'review.approve', 'class' => 'login fl' )) }}

			@if($review->status == '1')			

				<div class="control-item submit-btn">							
					<input type="hidden" name="id" value="{{$review->id}}" />
					{{-- Form::submit('Approved', array('disabled')) --}}
					<button type="submit" disabled><i class="fa fa-check"></i>Approve</button>						
				</div>

			@else

				<div class="control-item submit-btn">							
					<input type="hidden" name="id" value="{{$review->id}}" />
					<button type="submit"><i class="fa fa-check"></i>Approve</button>
				</div>	

			@endif			


		{{ Form::close() }}

		{{ Form::open(array('route' => 'review.disapprove', 'class' => 'fl login')) }}
			<input type="hidden" name="id" value="{{$review->id}}" />	
			
			{{-- Form::submit('Disapprove') --}}
			@if($review->status == '0')	
				<div class="control-item submit-btn">	
					<button type="submit" class="disapprove" disabled><i class="fa fa-times"></i></i>Disapprove</button>
				</div>
			@else
				<div class="control-item submit-btn">	
					<button type="submit" class="disapprove colorized"><i class="fa fa-times"></i></i>Disapprove</button>
				</div>
			
			@endif


		{{ Form::close() }}

		{{ Form::open(array('route' => array('review.destroy', $review->id), 'method' => 'delete', 'class' => 'fl login')) }}
				
			{{-- Form::submit('Delete', array('class' => 'delete-button')) --}}
			<div class="control-item submit-btn">
				<button type="submit" class="delete-button"><i class="fa fa-trash-o"></i>Delete</button>
			</div>					

		{{ Form::close() }}

		<div class="clear"></div>
		
	</div>

	
@stop

@section('scripts')
{{ HTML::script('js/toastr.js') }}
{{ HTML::script('js/form-functions.js') }}

<script type="text/javascript">
$(document).ready(function(){
	<?php if( Session::has('success') ) : ?>
		var message = "{{ Session::get('success')}}";
		var success = '1';
		getFlashMessage(success, message);
	<?php endif; ?>

});

$('.delete-button').on('click', function(e) {
	if(!confirm("Are you sure you want to delete this item?")) e.preventDefault();
});


</script>

@stop