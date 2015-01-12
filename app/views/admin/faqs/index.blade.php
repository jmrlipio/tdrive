@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing" id="faq-list">
		<h2>FAQs</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Question</th>
			</tr>
			@foreach($faqs as $faq)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $faq->question }}</a>
						<ul class="actions">
							<li><a href="{{ URL::route('admin.faqs.edit', $faq->id) }}">Edit</a></li>
							<li><a href="">View</a></li>
							<li>
								{{ Form::open(array('route' => array('admin.faqs.destroy', $faq->id), 'method' => 'delete', 'class' => 'delete-form')) }}
									{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
								{{ Form::close() }}
							</li>
						</ul>
					</td>
				</tr>
			@endforeach
		</table>
		<br>
		<a href="{{ URL::route('admin.faqs.create') }}" class="mgmt-link">New FAQ</a>
	</div>
@stop