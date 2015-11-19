@extends('admin._layouts.admin')

@section('content')

		{{ Form::open(array('route' => array('admin.games.store.app', $game->id), 'class' => 'item-listing tab-container', 'id' => 'tab-container')) }}
			<div class='panel-container no-border'>
				<h2>{{ $game->main_title }} App</h2>

				<li>
					{{ Form::label('title', 'Title') }}	
					{{ Form::text('title', $game->main_title) }}
					{{ $errors->first('title', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('carrier_id', 'Carrier') }}
					
					<select name="carrier_id" id="carrier">
						@foreach($carriers as $carrier)
							<option value="{{ str_pad($carrier['id'], 2, '0', STR_PAD_LEFT) }}" >{{ $carrier['carrier'] }}</option>
						@endforeach
					</select>

					{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('language_id', 'Language') }}
					<select name="language_id" id="language">
						@foreach($languages as $language)
							<option value="{{ str_pad($language->id, 2, '0', STR_PAD_LEFT) }}" data-isocode="{{ strtolower($language->iso_code) }}">{{ $language->language }}</option>
						@endforeach
					</select>
				</li>
				<li>
					{{ Form::label('app_id', 'App ID') }}	
					{{ Form::text('app_id', null, array('id' => 'app_id')) }}
					{{ $errors->first('app_id', '<p class="error">:message</p>') }}
				</li>
				
				<li>
					{{ Form::label('content', 'Content') }}	
					{{ Form::textarea('content', null, array('id' => 'content')) }}
					{{ $errors->first('content', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('excerpt', 'Excerpt') }}	
					{{ Form::textarea('excerpt') }}
					{{ $errors->first('excerpt', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('currency_code', 'Currency') }}
			  		{{ Form::select('currency_code', $currencies) }}				
					{{ $errors->first('currency_code', '<p class="error">:message</p>') }}
				</li>
				<li>
					{{ Form::label('price', 'Price') }}
					{{ Form::text('price', $default_price) }}
					{{ $errors->first('price', '<p class="error">:message</p>') }}
				</li>
				<br>
				<a class="pull-left mgmt-link c-button" href="{{ URL::route('admin.games.edit', $game->id) . '#apps' }}">Cancel</a>
				{{ Form::submit('Save') }}
			</div>
			
		{{ Form::close() }}

@stop

@section('scripts')
	
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

	$(document).ready(function() {
		app_text.val(app_id);
	});

	carrier.on('change', function() {
		app_id = gid + $(this).find('option:selected').val() + language.find('option:selected').val();

		app_text.val(app_id);
	});

	language.on('change', function() {
		app_id = gid + carrier.find('option:selected').val() + language.find('option:selected').val();

		app_text.val(app_id);

	});

	</script>

@stop