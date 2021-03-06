@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" id="categories-list">
		<h2>Inquiries</h2>
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Name</th>
				<th>Email</th>
				<th>Message</th>
			</tr>
			@foreach($inquiries as $inquiry)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $inquiry->email }}</a>
						<ul class="actions">
							<li><a href="">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.reports.inquiries.destroy', $inquiry->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
					<td>{{ $inquiry->name }}</td>
					<td>{{ $inquiry->message }}</td>
				</tr>
			@endforeach
		</table>
	</div>
	{{ HTML::script('js/form-functions.js') }}
@stop