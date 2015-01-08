@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="filter">
		<label>Date from: </label> 
		{{ Form::label('release_date', 'Release Date:') }}
		{{ Form::text('release_date', null, array('id' => 'date_from')) }}
	</div>
	<div class="filter">
		<label>Date to: </label> 
		{{ Form::label('release_date', 'Release Date:') }}
		{{ Form::text('release_date', null, array('id' => 'date_to')) }}
	</div>
	<div class="filter"> 
		{{ Form::submit('Search', array('id' => 'save-game')) }}
	</div>
	<div class="clear"></div>
	<div class="item-listing" id="categories-list">
		<h2>Game Sales</h2>
		<br>
		<table>
			<tr>
				<th>Game ID</th>
				<th>Game</th>
				<th>Carrier</th>
				<th>Country</th>
				<th>User</th>
				<th>Price</th>
			</tr>
			@foreach($sales as $sale)
			<tr>
				<td>{{ $sale->prices->game_id }}</td>
				<td>{{ $sale->prices->game->main_title }}</td>
				<td>{{ $sale->prices->carrier->carrier }}</td>
				<td>{{ $sale->prices->country->capital }}</td>
				<td>{{ $sale->user->username }}</td>
				<td>{{ $sale->prices->price }}</td>
			</tr>	
			@endforeach
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
	<script>
	$(document).ready(function() {
		// Date picker for Release Date
        $("#date_from").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

    	$("#date_to").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

	});
	</script>
@stop