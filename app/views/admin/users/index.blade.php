@extends('admin._layouts.admin')

@section('stylesheets')

	<style>

		div#btn-export {
			 /*background: #e9548e; 
			width: 50%;
			text-align: center;
			 margin: 0 auto; 
			padding: 8px;
			margin-top:10px;*/
			margin-bottom: 5px;
		}
		div#btn-export >form {
			width: auto;
			display: initial;
			margin-right: 5px;
		}
		.fl { float: left; }
		.clear {clear: both;}

		tr > th:first-of-type { width: 25px !important; }
	</style>

@stop

@section('content')

	<div class="item-listing">
		<h2>Users</h2>
		<br>
	
		<a href="{{ URL::route('admin.users.create') }}" class="mgmt-link">Create User</a>
		<div class="pull-left">

			<div id="btn-export">
			
				{{ Form::open(array('route' => 'admin.users.roles','class' => 'simple-form', 'id' => 'submit-role', 'method' => 'get')) }}
					{{ Form::select('role', $roles, $selected, array('class' => 'select-filter', 'id' => 'select-role')) }}
				{{ Form::close() }}
				<!-- Export as xls or excel -->	

				{{ Form::open(array('route' => 'admin.export.selectedDB', 'class' => 'login fl' )) }}
			
					<div class="control-item submit-btn">
						<input type="hidden" name="file_type" value="xls" />
						<input type="hidden" name="data_type" value="user" />
						<button type="submit">
						  <i class="fa fa-file-excel-o"></i> Export as Excel
						</button>
					</div>

				{{ Form::close() }}

				<!-- End -->

				<!-- Export as csv -->	
			
				{{ Form::open(array('route' => 'admin.export.selectedDB', 'class' => 'login fl' )) }}
			
					<div class="control-item submit-btn">
						<input type="hidden" name="file_type" value="csv" />
						<input type="hidden" name="data_type" value="user" />
						<button type="submit">
						  <i class="fa fa-file-text-o"></i> Export as Csv
						</button>
					</div>
			
				{{ Form::close() }}

				<!-- End -->

				<!-- Export as pdf -->	
			
				{{ Form::open(array('route' => 'admin.export.selectedDB', 'class' => 'login fl' )) }}
			
					<div class="control-item submit-btn">
						<input type="hidden" name="file_type" value="pdf" />
						<input type="hidden" name="data_type" value="user" />
						<button type="submit">
						  <i class="fa fa-file-pdf-o"></i> Export as Pdf
						</button>
					</div>
			
				{{ Form::close() }}

				<!-- End -->
			
				<div class="clear"></div>

			</div>
		</div>
		<div class="clear"></div>

	<div id="user_tbl_container">
		
		<table class="table table-striped table-bordered table-hover"  id="user_table">
			<thead>
				<tr>
					<th class="no-sort"><input type="checkbox"></th>
					<th>Id</th>					
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Mobile No.</th>
					<th>Role</th>
					<th>Last Login</th>
				</tr>
			</thead>

			<tbody>
				@forelse($users as $user)
					<tr class="result">
						<td><input type="checkbox"></td>
						<td>{{ $user->id }}</td>
						<td>
							<a href="{{ URL::route('admin.users.show', $user->id) }}">{{ $user->first_name . ' ' . $user->last_name }}</a>
							<ul class="actions">
								<li><a href="{{ URL::route('admin.users.edit', $user->id) }}">Edit</a></li>
								<li><a href="{{ URL::route('admin.users.show', $user->id) }}">View</a></li>
								<li>
									{{ Form::open(array('route' => array('admin.users.destroy', $user->id), 'method' => 'delete', 'class' => 'delete-form')) }}
											{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
										{{ Form::close() }}	
								</li>
							</ul>
						</td>						
						<td>{{ $user->username }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->mobile_no }}</td>
						<td>{{ $user->role }}</td>
						<td>{{ $user->last_login }}</td>
					</tr>

					@empty
						<tr class="tall-tr">
							<td colspan="6"><p>You haven't created any cat yet.</p></td>
						</tr>

				@endforelse
		</tbody>
	</table>
		
	</div>

		<br>
		
	</div>

@stop

@section('scripts')
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}

	<script>
	$(document).ready(function(){
		$('#user_table').DataTable( {
	      "aoColumnDefs": [
	          { 'bSortable': false, 'aTargets': [ 0 ] },
	          { 'aaSorting': [ "desc"], 'aTargets': [ 6 ] }
	       ],
	       "order": [[ 7, "desc" ]]
		});

		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});

		<?php if( Session::has('message') ) : ?>
			var message = "{{ Session::get('message')}}";
			var success = '1';
			getFlashMessage(success, message);
		<?php endif; ?>
	});

		/*var user_list = $('tr#list');
		var table = $('#user-lists');
		$('#search').on('input', function(e) {
			$('.result').remove();

	        e.preventDefault();
	        var form = $(this);

		    $.post(form.attr('action'), form.serialize(), function(data) {	       
		        for(var id in data){

		         	console.log(data[id]['first_name'] + ' ' + data[id]['last_name']);
		         	//console.log(data[id]['last_login'] + ' ' + data[id]['last_name']);
		         		var search_result = $('<tr class="result"><td><input type="checkbox"></td> \
												<td> \
													<a href="#">'+ data[id]['first_name'] + ' ' + data[id]['last_name'] +'</a> \
													<ul class="actions"> \
														<li><a href="">Edit</a></li> \
														<li><a href="">View</a></li> \
														<li><a href="">Delete</a></li> \
													</ul> \
												</td> \
												<td>'+ data[id]['username'] +'</td> \
												<td>'+ data[id]['last_login'] +'</td></tr>').hide();
		         	
		         
		         	  $('#user-lists').append(search_result);
		         	  search_result.show('slow');
		        }
		        // user_list.html(search_result);      
		    });
	   
	    });*/

		$('#select-role').on('change', function() {
			$('#submit-role').trigger('submit');
		});
	</script>

@stop