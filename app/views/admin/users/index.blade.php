@extends('admin._layouts.admin')

@section('content')

	<div class="item-listing">
		<h2>Users</h2>
		<div id="search-box" class="pull-right">			
			{{ Form::open(array('route' => 'admin.users.search', 'id' => 'search')) }}
				{{ Form::text('keyword', Input::old('keyword'), array('placeholder' => 'Search user..')) }}
			{{ Form::close() }}
		</div>

		<br>
		<table id="user-lists">
			<tr>
				<th><input type="checkbox"></th>
				<th>Name</th>
				<th>Username</th>
				<th>Last Login</th>
			</tr>
			@foreach($users as $user)
			<tr class="result">
				<td><input type="checkbox"></td>
				<td>
					<a href="#">{{ $user->first_name . ' ' . $user->last_name }}</a>
					<ul class="actions">
						<li><a href="">Edit</a></li>
						<li><a href="">View</a></li>
						<li><a href="">Delete</a></li>
					</ul>
				</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->last_login }}</td>
			</tr>
			@endforeach

		</table>
		{{ $users->links() }}
		<br>
		<a href="{{ URL::route('admin.users.create') }}" class="mgmt-link">Create User</a>
	</div>

	<script>

	var user_list = $('tr#list');
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


	</script>
@stop