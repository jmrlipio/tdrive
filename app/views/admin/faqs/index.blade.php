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
				<th class="no-sort"><input type="checkbox"></th>
				<th>Question</th>
				<th>Variants</th>
			</tr>
			@foreach($faqs as $faq)
				
					<tr>
						<td><input type="checkbox"></td>
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
								<a class="{{strtolower($fq->iso_code)}} flag-link" data-toggle="tooltip" data-placement="top" title="{{$fq->id}}" href="{{ URL::route('admin.faqs.variant.edit', array('faq_id' => $faq->id, 'language_id' => $fq->id)) }}"></a>
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
	
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});
@stop
