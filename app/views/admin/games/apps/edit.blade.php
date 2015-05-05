@extends('admin._layouts.admin')

@section('content')
	@include('admin._scripts.scripts')
	<article>
		{{ Form::open(array('route' => array('admin.games.update.app', $game->id, $app_id), 'class' => 'large-form tab-container game_form', 'target'=>'_self', 'id' => 'tab-container')) }}
			<div class='panel-container'>
				<h3 class="center">{{ $game->main_title }} App</h3>

				@if(Session::has('message'))
				    <div class="flash-success">
				        <p>{{ Session::get('message') }}</p>
				    </div>
				@endif

				<li>
					{{ Form::label('title', 'Title:') }}	
					{{ Form::text('title', $values['title'], array('id' => 'title')) }}
					{{ $errors->first('title', '<p class="error">:message</p>') }}
				</li>
				<li>

					{{ Form::label('carrier_id', 'Carrier:') }}

					<select name="carrier_id" id="carrier">
						@foreach($carriers as $carrier)
							<?php $selected = ($carrier["id"] == $values['carrier_id']) ? 'selected' : ''; ?>
							<option value="{{ str_pad($carrier['id'], 2, '0', STR_PAD_LEFT) }}" {{ $selected }}>{{ $carrier['carrier'] }}</option>
						@endforeach
					</select>

					{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('language_id', 'Language:') }}
					<select name="language_id" id="language">
						@foreach($languages as $language)
							<?php $selected = ($language->id == $values['language_id']) ? 'selected' : ''; ?>
							<option value="{{ str_pad($language->id, 2, '0', STR_PAD_LEFT) }}" data-isocode="{{ strtolower($language->iso_code) }}" {{ $selected }}>{{ $language->language }}</option>
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
					{{ Form::textarea('excerpt', $values['excerpt'], array('id' => 'excerpt')) }}
					{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('currency_code', 'Currency:') }}
			  		{{ Form::select('currency_code', $currencies, $values['currency_code'], array('id' => 'currency_code')) }}				
					{{ $errors->first('currency_code', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('price', 'Price: ') }}
					{{ Form::text('price', $values['price'], array('id' => 'price')) }}
					{{ $errors->first('price', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('status', 'Status: ') }}
					<select name="status" c="{{ $values['status'] }}">
						<option value="1" {{ ($values['status'] == 1 ) ? 'selected' : '' }}>Published</option>
						<option value="2" {{ ($values['status'] != 1 ) ? 'selected' : '' }}>Draft</option>
					</select>
					{{ $errors->first('status', '<p class="error">:message</p>') }}
				</li>
				<br>
				{{ Form::submit('Save', array('id' => 'save')) }} <a href="{{ URL::route('admin.games.edit', $game->id) . '#apps' }}">Back</a>
				
				{{ Form::submit('Preview', array('id' => 'preview')) }}
				<!-- <a href="{{ URL::route('admin.games.preview', array($game->id, $values['app_id'])) }}" target='blank') id="preview">Preview</a> -->
			</div>
			
		{{ Form::close() }}	
		
	</article>
	{{ HTML::script('js/form-functions.js') }}
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
	<script>
	var gid = '{{ str_pad($game->id, 4, "0", STR_PAD_LEFT) }}',
		app_text = $('#app_id'),
		carrier = $('#carrier'),
		language = $('#language')
		title = $('#title');

	var app_id = gid + carrier.find('option:first').val() + language.find('option:first').val();

	carrier.on('change', function() {

		var cid= $(this).find('option:selected').val();

		app_id = gid + cid + language.find('option:selected').val();

		app_text.val(app_id);
		
	});

	language.on('change', function() {
		app_id = gid + carrier.find('option:selected').val() + language.find('option:selected').val();

		app_text.val(app_id);

	});

	</script>
	<script>
		$(document).ready(function(){
			var save_url = "{{ URL::route('admin.games.update.app', $game->id, $app_id) }}";
			var preview_url = "{{ URL::route('admin.games.preview', array($game->id, $values['app_id']))}}";
			var form = $('.game_form');	
				
			
			$('#preview').click(function(e){

				e.preventDefault();
				form.attr('action',preview_url);
				form.attr('target','_blank');
				form.submit();
				
			});


		});

	</script>
@stop