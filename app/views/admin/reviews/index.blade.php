@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<div class="review-listing" id="games-list">
		<h2>Games</h2>
		<br>

		{{ $filter }}
		{{ $grid }}

		<br>
	</div>
	{{ HTML::script('js/jquery-1.11.1.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	$(document).ready(function(){
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
	});
	</script>

@stop