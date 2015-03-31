@extends('admin._layouts.admin')

@section('content')

	<div class="item-listing" id="news-list">
		<h2>News</h2>
		<a href="{{ URL::route('admin.news.create') }}" class="mgmt-link">Create News</a>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif

		{{ Form::open(array('route' => 'admin.news.category','class' => 'simple-form', 'id' => 'submit-cat', 'method' => 'get')) }}
			{{ Form::select('cat', $categories, $selected, array('class' => 'select-filter', 'id' => 'select-cat')) }}
		{{ Form::close() }}
		<br><br><br><br>

		<table class="table table-striped table-bordered table-hover"  id="news_table">
			<thead>
				<tr>
					<th><input type="checkbox"></th>
					<th>Title</th>
					<th>Languages</th>
					<th>Category</th>
					<th>Date</th>
				</tr>
			</thead>

			<tbody>
				@foreach($news as $data)					
					<tr>
						<td><input type="checkbox"></td>
						<td>
							<a href="{{ URL::route('admin.news.edit', $data->id) }}">{{ $data->main_title }}</a>
							<ul class="actions">
								<li><a href="{{ URL::route('admin.news.edit', $data->id) }}">Edit</a></li>
								<li><a href="">View</a></li>
								<li>
								{{ Form::open(array('route' => array('admin.news.destroy', $data->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}

								</li>
							</ul>
						</td>
						<td>
							@foreach($data->languages as $row)
								{{ $row->language }}
							@endforeach
						</td>

						<td>								
							{{ $data->NewsCategory->category }}								
						</td>
						<td>{{ $data->created_at }}</td>
						
					</tr>		
				@endforeach
			</tbody>
		
		</table>
		<br>
	</div>

@stop

@section('scripts')

	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	{{ HTML::script('js/form-functions.js') }}

	<script>
	$(document).ready(function(){
		$('#news_table').DataTable();
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});

		$('#select-cat').on('change', function() {
			$('#submit-cat').trigger('submit');
		});
	});

	</script>
@stop