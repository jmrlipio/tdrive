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
		<br>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Title</th>
				<th>Date</th>
			</tr>
			@if(!$news->isEmpty())
				@foreach($news as $news_item)
					<tr>
						<td><input type="checkbox"></td>
						<td>
							<a href="#">{{ $news_item->main_title }}</a>
							<ul class="actions">
								<li><a href="{{ URL::route('admin.news.edit', $news_item->id) }}">Edit</a></li>
								<li><a href="">View</a></li>
								<li>
								{{ Form::open(array('route' => array('admin.news.destroy', $news_item->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}

								</li>
							</ul>
						</td>
						<td>{{ $news_item->created_at }}</td>
					</tr>
				@endforeach
			@else
				<tr class="tall-tr">
					<td colspan="6"><p>You haven't created any news yet.</p></td>
				</tr>
			@endif
		</table>
		{{ $news->links() }}
		<br>
		
	</div>
	{{ HTML::script('js/jquery-1.11.1.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	$(document).ready(function(){
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
	});
	</script>

@stop