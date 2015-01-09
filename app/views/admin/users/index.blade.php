@extends('admin._layouts.admin')

@section('content')

	<div class="item-listing">
		<h2>Users</h2>
		<!-- <div id="search-box" class="pull-right">			
			{{-- Form::open(array('route' => 'admin.users.search', 'id' => 'search')) --}}
				{{-- Form::text('keyword', Input::old('keyword'), array('placeholder' => 'Search user..')) --}}
			{{-- Form::close() --}}
		</div> -->

		<br>
		<a href="{{ URL::route('admin.users.create') }}" class="mgmt-link">Create User</a>
		<br><br><br><br>
	<div id="user_tbl_container">
		{{-- Form::open(array('route' => 'admin.users.roles','class' => 'simple-form', 'id' => 'submit-role', 'method' => 'get')) --}}
			{{-- Form::select('role', $roles, $selected, array('class' => 'select-filter', 'id' => 'select-role')) --}}
		{{-- Form::close() --}}
		<table class="table table-striped table-bordered table-hover"  id="user_table">
			<thead>
				<tr>
					<th><input type="checkbox"></th>
					<th>Name</th>
					<th>Username</th>
					<th>Email</th>
					<th>Role</th>
					<th>Last Login</th>
					<th>Last Activity</th>
				</tr>
			</thead>

			<tbody>
				@forelse($users as $user)
					<tr class="result">
						<td><input type="checkbox"></td>
						<td>
							<a href="{{ URL::route('admin.users.show', $user->id) }}">{{ $user->first_name . ' ' . $user->last_name }}</a>
							<ul class="actions">
								<li><a href="">Edit</a></li>
								<li><a href="{{ URL::route('admin.users.show', $user->id) }}">View</a></li>
								<li><a href="">Delete</a></li>
							</ul>
						</td>
						<td>{{ $user->username }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->role }}</td>
						<td>{{ $user->last_login }}</td>
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
		{{-- $users->links() --}}
		<br>
		
	</div>

@stop

@section('scripts')

	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}

	<script>
	$(document).ready(function(){
		$('#user_table').DataTable();
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
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
	   
	    });

		$('#select-role').on('change', function() {
			$('#submit-role').trigger('submit');
		});*/
	</script>

@stop