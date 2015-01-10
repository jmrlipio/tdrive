@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing" id="faq-list">
		<h2>Discounts</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<a href="{{ URL::route('admin.discounts.create') }}" class="mgmt-link">New Discount</a>
		<table>
			<tr>
				<th><input type="checkbox"></th>
				<th>Discount Name</th>
			</tr>
			@foreach($discounts as $discount)
				<tr>
					<td><input type="checkbox"></td>
					<td>
						<a href="#">{{ $faq->main_question }}</a>
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
		
	</div>
@stop