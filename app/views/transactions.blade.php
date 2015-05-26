@extends('_layouts/single')
@section('content')

	<div class="container">
		<h1 class="title">Transactions for {{{ $user->username }}}:</h1>
	
		@if(!$transactions->isEmpty())
			<table id="user_transactions">

				<thead>
					<tr>
						<td>Game</td>
						<td>Date</td>
						<td>Status</td>
					</tr>
				</thead>

				<tbody>
					@foreach($transactions as $transaction)	
					<tr>
						<td>{{ $transaction->app->title }}</td>
						<td>{{ $transaction->created_at->format(' M d, Y - H:i:s') }}</td>
						<td>{{ $transaction->status }}</td>
					</tr>	
					@endforeach
				</tbody>

			</table>
		@else
			no transactions
		@endif


	</div>

@stop
@stop