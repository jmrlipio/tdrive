@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing" >
		<h2>Inquiries</h2>
		<br>
		@if (Session::has('success') ) 
            
       		<p class="center flash-success">{{ Session::get('success') }}</p> 

	    @elseif(Session::has('fail') )   

	    	<p class="center flash-fail">{{ Session::get('fail') }}</p>    

	    @endif

		<table id="table">
			<thead>
			<tr>
				<th><input type="checkbox"></th>
				<th>Email</th>
				<th>Name</th>
				<th>Country</th>
				<th>App Store</th>
				<th>Os</th>
				<th>Os Version</th>
				<th>Message</th>
				<th>Date</th>
			</tr>
			<thead>
			<tbody>

			@foreach($inquiries as $inquiry)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="{{ URL::route('admin.reports.inquiries.show', $inquiry->id) }}">{{ $inquiry->email }}</a>
						<ul class="actions">
							<li><a href="{{ URL::route('admin.reports.inquiries.show', $inquiry->id) }}">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.reports.inquiries.destroy', $inquiry->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
					<td>{{ $inquiry->name }}</td>
					<td>{{ $inquiry->country }}</td>
					<td>{{ $inquiry->app_store }}</td>					
					<?php 
						$str = $inquiry->os;		
						if($str != null)
						{
							$temp = explode(" - ",$str);		
							$os = $temp[0];
							$os_version = $temp[1]; 
					?>
							<td>{{ $os }}</td>
							<td>{{ $os_version }}</td>
					
					<?php } else { ?>	

						<td></td>
						<td></td>

					<?php } ?>
					<td>{{ $inquiry->message }}</td>
					<td>{{ $inquiry->created_at }}</td>
				</tr>
			@endforeach
			
		</tbody>
		</table>

		<a href="{{ URL::route('admin.reports.inquiries.settings') }}" class="mgmt-link" id="asettings">Autoresponder Settings</a>
	</div>
	{{ HTML::script('js/form-functions.js') }}	
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	<script>
	$(document).ready(function(){
	    $('#table').DataTable();
		});
	</script>
@stop