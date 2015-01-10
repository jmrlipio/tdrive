@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($faq, array('route' => array('admin.faqs.update', $faq->id), 'method' => 'put', 'class' => 'small-form')) }}
		<ul id="details" class="screens">
			<h2>Edit FAQ</h2>
			@if(Session::has('message'))
			    <div class="flash-success">
			        <p>{{ Session::get('message') }}</p>
			    </div>
			@endif
			<li>
				{{ Form::label('main_question', 'Question: ') }}
				{{ Form::text('main_question') }}
				{{ $errors->first('main_question', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('language_id', 'Languages: ') }}
				{{ Form::select('language_id[]', $languages, $selected_languages, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose language(s)...'))  }}
				{{ $errors->first('language_id', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::label('order', 'Order: ') }}
				{{ Form::text('order', null, array('id' => 'faq-order')) }}
				{{ $errors->first('order', '<p class="error">:message</p>') }}
			</li>
			<li>
				{{ Form::submit('Save and Continue') }}
				<a href="#screens" id="next">Next</a>
			</li>
			
		</ul>
		<ul id="faq-content" class="screens">
			<h3>The faq has content for the following languages:</h3>
			<p><em>Please add content for the following languages</em></p>
			<br>
			@if($selected_languages)
			<ul>
				@foreach($languages as $language_id => $language)
					@if(in_array($language_id, $selected_languages))
						<li><a href="{{ URL::route('admin.faq.edit.content', array('faq_id' => $faq->id, 'language_id' => $language_id)) }}">{{ $language }}</a></li>
					@endif
				@endforeach
			</ul>
			@else
				<p>Please select one or more languages to add content to this faq.
			@endif
			
			<br>
			<a href="#" id="back">Back</a>
		</ul>
	{{ Form::close() }}

	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}
	<script>
	(function(){
		var hash = window.location.hash.slice(1);

		if(hash != "") {
			$('#details').hide();
			$('#faq-content').show();
		}

		$(".chosen-select").chosen();

		$('#next').click(function(){
			$('#details').hide();
			$('#faq-content').show();
		});

		$('#back').click(function(){
			$('#faq-content').hide();
			$('#details').show();
		});
	})();
	</script>
@stop