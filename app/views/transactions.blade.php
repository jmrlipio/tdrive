@extends('_layouts/single')
@section('content')

	<div class="container">
		<h1 class="title">{{ trans('global.Purchase History') }}</h1>
	
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
						<td>{{ $transaction->created_at->format(' M d, Y') }}</td>
						<td><span class="<?php echo ($transaction->status == 1) ? 'green' : '';  ?>">{{ Constant::status($transaction->status) }}</span></td>
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
@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script('js/image-uploader.js') }}
	
	@include('_partials/scripts')

	<script>
		FastClick.attach(document.body);
		var token = $('input[name="_token"]').val();
		
	</script>



@stop