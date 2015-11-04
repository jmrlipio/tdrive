@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing table" id="faq-list">
		<h2>FAQs</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<a href="{{ URL::route('admin.faqs.create') }}" class="mgmt-link">New FAQ</a>
		<table>
			<tr>
				<th>Question</th>
				<th>Variants</th>
			</tr>
			@foreach($faqs as $faq)
				
					<tr>
						<td>
							<a href="{{ URL::route('admin.faqs.variant.create', $faq->id) }}">{{ $faq->main_question }}</a>
							<ul class="actions">
								
								<li><a href="{{ URL::route('admin.faqs.variant.create', $faq->id) }}">Add Variant</a></li>
								<li>
									{{ Form::open(array('route' => array('admin.faqs.destroy', $faq->id), 'method' => 'delete', 'class' => 'delete-form')) }}
										{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
									{{ Form::close() }}
								</li>
							</ul>
						</td>
						<td>
							@foreach($faq->languages as $fq)
								<a href="{{ URL::route('admin.faqs.variant.edit', array('faq_id' => $faq->id, 'language_id' => $fq->id)) }}">{{ $fq->language }}</a>
								
							@endforeach
						</td>
					</tr>
			@endforeach
		</table>
		<br>
		
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/form-functions.js') }}
@stop
