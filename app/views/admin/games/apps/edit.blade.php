@extends('admin._layouts.admin')

@section('content')
	<article>
		{{ Form::open(array('route' => array('admin.games.update.app', $game->id, $app_id), 'class' => 'large-form tab-container', 'id' => 'tab-container')) }}
			<div class='panel-container'>
				<h3 class="center">{{ $game->main_title }} App</h3>

				@if(Session::has('message'))
				    <div class="flash-success">
				        <p>{{ Session::get('message') }}</p>
				    </div>
				@endif

				<li>
					{{ Form::label('title', 'Title:') }}	
					{{ Form::text('title', $values['title']) }}
					{{ $errors->first('title', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('carrier_id', 'Carrier:') }}
			  		{{ Form::select('carrier_id', $carriers, $values['carrier_id'], array('id' => 'carrier')) }}				
					{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('language_id', 'Language:') }}
					<select name="language_id" id="language">
						@foreach($languages as $language)
							<?php $selected = ($language->id == $values['language_id']) ? 'selected' : ''; ?>
							<option value="{{ $language->id }}" data-isocode="{{ strtolower($language->iso_code) }}" {{ $selected }}>{{ $language->language }}</option>
						@endforeach
					</select>
				</li>
				<li>
					{{ Form::label('app_id', 'App ID:') }}	
					{{ Form::text('app_id', $values['app_id'], array('id' => 'app_id')) }}
					{{ $errors->first('app_id', '<p class="error">:message</p>') }}
				</li>
				
				<li>
					{{ Form::label('content', 'Content:') }}	
					{{ Form::textarea('content', $values['content'], array('id' => 'content')) }}
					{{ $errors->first('content', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('excerpt', 'Excerpt:') }}	
					{{ Form::textarea('excerpt', $values['excerpt']) }}
					{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('currency_code', 'Currency:') }}
			  		{{ Form::select('currency_code', $currencies, $values['currency_code']) }}				
					{{ $errors->first('currency_code', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('price', 'Price: ') }}
					{{ Form::text('price', $values['price']) }}
					{{ $errors->first('price', '<p class="error">:message</p>') }}
				</li>
				<br>
				{{ Form::submit('Save') }} <a href="{{ URL::route('admin.games.edit', $game->id) . '#apps' }}">Back</a>
			</div>
			
		{{ Form::close() }}
	</article>
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
	<script>
	var slug = '{{ $game->slug }}',
		app_text = $('#app_id'),
		carrier = $('#carrier'),
		language = $('#language');

	var app_id = slug + '-' + carrier.find('option:first').text().toLowerCase() + '-' + language.find('option:first').data('isocode');

	$(document).ready(function() {
		app_text.val();
	});

	carrier.on('change', function() {
		app_id = slug + '-' + $(this).find('option:selected').text().toLowerCase() + '-' + language.find('option:selected').data('isocode');

		app_text.val(app_id);
	});

	language.on('change', function() {
		
		app_id = slug + '-' + carrier.find('option:selected').text().toLowerCase() + '-' + language.find('option:selected').data('isocode');

		app_text.val(app_id);

	});

	</script>
@stop