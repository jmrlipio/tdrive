@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Admin Logs</h2>
		<br>
		<table>
			@foreach($logs as $log)
				<tr>
					<td>{{ $log->activity }}</td>
				</tr>
			@endforeach
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop