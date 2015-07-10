@extends('admin._layouts.admin')

@section('content')

	<div class="item-listing" id="news-list">
		<h2>News</h2>
		<a href="{{ URL::route('admin.news.create') }}" class="mgmt-link">Create News</a>

		{{ Form::open(array('route' => 'admin.news.category','class' => 'simple-form', 'id' => 'submit-cat', 'method' => 'get')) }}
			{{ Form::select('cat', $categories, $selected, array('class' => 'select-filter', 'id' => 'select-cat')) }}
		{{ Form::close() }}
		<br><br><br><br>

		<table class="table table-striped table-bordered table-hover"  id="news_table">
			<thead>
				<tr>
					<th>Title</th>
					<th>Languages</th>
					<th>Category</th>
					<th>Date</th>
				</tr>
			</thead>

			<tbody>
				@foreach($news as $data)					
					<tr>
						<td>
							<a href="{{ URL::route('admin.news.edit', $data->id) }}">{{ $data->main_title }}</a>
							<ul class="actions">
								<li><a href="{{ URL::route('admin.news.edit', $data->id) }}">Edit</a></li>
								<li><a href="{{ URL::route('admin.news.variant.create', $data->id) }}">Add Variant</a></li>
								<li>
									{{ Form::open(array('route' => array('admin.news.destroy', $data->id), 'method' => 'delete', 'class' => 'delete-form')) }}
										{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
									{{ Form::close() }}
								</li>
							</ul>
						</td>
						<td>
							@foreach($data->languages as $row)
								<a class="{{strtolower($row->iso_code)}} flag-link" data-toggle="tooltip" data-placement="top" title="{{$row->language}}" href="{{ URL::route('admin.news.variant.edit', array('news_id' => $data->id, 'variant_id' => $row->id)) }}"></a>
							@endforeach
						</td>
						<td>{{ $data->NewsCategory->category }}</td>
						<td >{{ $data->created_at }}</td>
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
	{{ HTML::script('js/toastr.js') }}
	{{ HTML::script('css/polyglot-language-switcher.css') }}
	{{ HTML::script('js/bootstrap.min.js') }}

	<script>

	$(document).ready(function(){

		$('[data-toggle="tooltip"]').tooltip()

		$('#news_table').DataTable({
		        "order": [[ 3, "desc" ]]
		    });

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

		<?php if( Session::has('message') ) : ?>
			var message = "{{ Session::get('message')}}";
			var success = '1';
			getFlashMessage(success, message);
		<?php endif; ?>
	});

	</script>
@stop