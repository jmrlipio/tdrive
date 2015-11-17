@extends('admin._layouts.admin')
@section('content')

	<div class="item-listing table" >
		<h2>Inquiries</h2>
		<br>
		<table id="table" class="inquiries-table">
			<thead>
			<tr>
				<th class="no-sort"><input type="checkbox"></th>
				<th>Email</th>
				<th>Name</th>
				<th>Country</th>
				<th>App Store</th>
				<th>Os</th>
				<th>Os Version</th>
				<th>Date</th>
			</tr>
			<thead>
			<tbody>

			@foreach($inquiries as $inquiry)
				<tr>

					<td><input name="inquiry" type="checkbox" inquiry-id="{{$inquiry->id}}"></td>
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
						$os = "";
						$os_version = "";
					?>		
					@if($str != null ) 
						
						@if(strpos($str,'-') !== false) 
							<?php 
								$temp = explode(" - ",$str);		
								$os = $temp[0];
								$os_version = $temp[1];
						 	?>					
								<td>{{ $os }}</td>
								<td>{{ $os_version }}</td>
					 	@else
							<td>{{ $str }}</td>
							<td></td>
						@endif <!-- END of inner condition --> 
					
					@else 

						<td></td>
						<td></td>

					@endif <!-- //END of first condition -->
					
					<td>{{ $inquiry->created_at }}</td>
				</tr>
			@endforeach
			
		</tbody>
		</table>

	</div>
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}	
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	
	<script>
	
	$(document).ready(function(){
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
		$('.inquiries-table input[type="checkbox"]').click(function(){
			var checked = $('.inquiries-table input[type="checkbox"]:checked');
			if(checked.length > 0){
				$("a.del").removeClass("disabled");
			}else {
				$("a.del").addClass("disabled");
			}
		});

	    $('#table').DataTable({
	    	"columnDefs": [
			    { "width": "80px", "targets": 6 }
			  ],
			  "order": [[ 7, "desc" ]]
	    });

	    <?php if( Session::has('message') ) : ?>
			var message = "{{ Session::get('message')}}";
			var success = '1';
			getFlashMessage(success, message);
		<?php endif; ?>

	    $(document).on('click', 'a.del', function() {
	    	
        	if(confirm("Are you sure you want to remove this inquiry?")) {
				var ids = new Array();

			    $('input[name="inquiry"]:checked').each(function() {
			        ids.push($(this).attr("inquiry-id"));
			    });

				$.ajax({
					url: "{{ URL::route('admin.inquiry.multiple-delete') }}",
					type: "POST", 
					data: { ids: ids },
					success: function(response) {
						location.reload();
					},
					error: function(response) {
						console.log(response);
					}
				});
			}
			return false;
	    });

		var link = '<a href="#"  class="pull-right graph-link mgmt-link del disabled">Delete Selected</a>'
		$("#table_length label").html(link);
	});
	
	</script>
	
@stop