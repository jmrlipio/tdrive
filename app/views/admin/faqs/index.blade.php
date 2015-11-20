@extends('admin._layouts.admin')

@section('content')
	<div class="item-listing table" id="faq-list">
		<h2>FAQs</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<a href="#" class="mgmt-link del disabled">Delete Selected</a>
		<a href="{{ URL::route('admin.faqs.create') }}" class="mgmt-link">New FAQ</a>
		<table>
			<tr>
				<th class="no-sort"><input type="checkbox"></th>
				<th>Question</th>
				<th>Variants</th>
			</tr>
			@foreach($faqs as $faq)
				
					<tr>
						<td><input type="checkbox" name="faq" fq-id="{{$faq->id}}"></td>
						<td>
							<a href="{{ URL::route('admin.faqs.variant.create', $faq->id) }}">{{ $faq->main_question }}</a>
							<ul class="actions">
								
								<li><a href="{{ URL::route('admin.faqs.variant.create', $faq->id) }}">Add Variant</a> |</li>
								<li>
									{{ Form::open(array('route' => array('admin.faqs.destroy', $faq->id), 'method' => 'delete', 'class' => 'delete-form')) }}
										{{ Form::submit('Delete', array('class' => 'delete-btn')) }}
									{{ Form::close() }}
								</li>
							</ul>
						</td>
						<td>
							@foreach($faq->languages as $fq)
								<a class="{{strtolower($fq->iso_code)}} flag-link" data-toggle="tooltip" data-placement="top" title="{{$fq->language}}" href="{{ URL::route('admin.faqs.variant.edit', array('faq_id' => $faq->id, 'language_id' => $fq->id)) }}"></a>
							@endforeach
						</td>
					</tr>
			@endforeach
		</table>
		<br>
		
	</div>
@stop


@section('scripts')
{{ HTML::script('js/bootstrap.min.js') }}
{{ HTML::script('js/form-functions.js') }}

<script>
$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();
	$('th input[type=checkbox]').click(function(){
		if($(this).is(':checked')) {
			$('td input[type=checkbox').prop('checked', true);
		} else {
			$('td input[type=checkbox').prop('checked', false);
		}
	});

	$('#faq-list input[type="checkbox"]').click(function(){
		var checked = $('#faq-list input[type="checkbox"]:checked');
		if(checked.length > 0){
			$("a.del").removeClass("disabled");
		}else {
			$("a.del").addClass("disabled");
		}
	});

    $('a.del').on('click', function() {

    	if(confirm("Are you sure you want to remove this assignment?")) {
			var ids = new Array();

		    $('input[name="faq"]:checked').each(function() {
		        ids.push($(this).attr("fq-id"));
		    });

			$.ajax({
				url: "{{ URL::route('admin.faqs.multiple-delete') }}",
				type: "POST", 
				data: { ids: ids },
				success: function(response) {
					location.reload();
				}
			});
		}
		return false;
    });

});
</script>
@stop
