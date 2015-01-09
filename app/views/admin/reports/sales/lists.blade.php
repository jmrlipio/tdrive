@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Game Sales</h2>
		<br>
		<table id="table">
			<thead>
			<tr>
				<th>Game</th>
				<th>Carrier</th>
				<th>Country</th>
				<th>User</th>
				<th>Price</th>
			</tr>
			<thead>
			<tbody>
			@foreach($sales as $sale)
				<tr>
					<td>{{ $sale->prices->game->main_title }}</td>
					<td>{{ $sale->prices->carrier->carrier }}</td>
					<td>{{ $sale->prices->country->capital }}</td>
					<td>{{ $sale->user->username }}</td>
					<td>{{ $sale->prices->price }}</td>
				</tr>
			@endforeach
		</tbody>
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
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

    	 $('#table').DataTable();

	});
	</script>
@stop