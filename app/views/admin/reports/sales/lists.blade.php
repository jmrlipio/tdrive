@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing game-sales-div">
		<h2>Game Sales</h2>
		<br>
		<div class="clear"></div>
		<table id="table">
			<thead>
			<tr>
				<th style="width: 300px;">Game</th>
				<th>Carrier</th>
				<th>Language</th>
				<th>User</th>
				<th>Price</th>
				<th>Date</th>
			</tr>
			<thead>
			<tbody>
				@foreach($transactions as $transaction)
					<tr>
						<td style="width: 300px;">{{ $transaction->app->title }}</td>
						<td style="width: 80px;" >{{ $transaction->app->carrier->carrier }}</td>
						<td style="width: 280px;">{{ $transaction->app->language->language  }}</td>
						<td style="width: 180px;">
							@if($transaction->user != null)
								<a href="{{ URL::route('admin.users.show', $transaction->user->id) }}">
									{{ $transaction->user->username }}
								</a>
							@else								
									<i>User deleted.</i>								
							@endif
						</td>
						<td style="width: 180px;">{{ $transaction->app->price}}</td>
						<td style="width: 180px;">{{ $transaction->created_at}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clear"></div>
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

    	$('#table').DataTable({
	        "order": [[ 5, "desc" ]]
	    });
		var link = '<a href="{{ URL::route('admin.reports.sales.chart') }}"  class="pull-right graph-link">View Graphs</a>'
		$("#table_length label").append(link);

	});
	</script>
@stop