@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Download Reports</h2>
		<br>
		<table>
			<tr>
				<th style="width: 300px;">Game</th>
				<th style="width: 120px !important;" >Real Downloads</th>
				<th>Modified Downloads</th>
				<th>Success Downloads</th>
				<th>Failed Downloads</th>
			</tr>
			@foreach($games as $game)
				<tr>
					<td>{{ $game->main_title }}</td>
					<td style="width: 120px !important;">{{ $game->actual_downloads }}</td>
					<td>{{ $game->downloads }}</td>
					<td></td>
					<td></td>
				</tr>
			@endforeach
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop