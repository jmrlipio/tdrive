@extends('admin._layouts.admin')

@section('content')
	{{ Form::model($settings, array('route' => array('admin.game-settings.update', $settings->id), 'method' => 'put', 'class' => 'small-form')) }}
		<h2>Game Settings</h2>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		<li>
			{{ Form::label('game_thumbnails', 'Displayed Number of Game Thumbnails:') }}
			{{ Form::text('game_thumbnails') }}
			{{ $errors->first('game_thumbnails', '<p class="error">:message</p>') }}
		</li>
		<li>
			{{ Form::label('game_rows', 'Displayed Number of Game Rows:') }}
			{{ Form::text('game_rows') }}
			{{ $errors->first('game_rows', '<p class="error">:message</p>') }}
		</li>
		<li>
			{{ Form::label('game_reviews', 'Displayed Number of Reviews:') }}
			{{ Form::text('game_reviews') }}
			{{ $errors->first('game_reviews', '<p class="error">:message</p>') }}
		</li>
		<li>
			{{ Form::label('review_rows', 'Displayed Number of Reviews:') }}
			{{ Form::text('review_rows') }}
			{{ $errors->first('game_reviews', '<p class="error">:message</p>') }}
		</li>
		<li>
			<div class="media-box" id="ribbon">
				{{ HTML::image(Request::root() . '/assets/site/' . $settings->ribbon_url, null) }}
			</div>

			{{ Form::label('ribbon_url', 'Ribbon:') }}
			{{ Form::file('ribbon_url') }}
		</li>
		{{ Form::submit('Update Settings') }}
	{{ Form::close() }}
@stop