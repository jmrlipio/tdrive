@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.options-nav')
	{{ Form::model($settings, array('route' => array('admin.game-settings.update', $settings->id), 'method' => 'put', 'class' => 'small-form', 'files' => true, 'enctype'=> 'multipart/form-data')) }}
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
		<!--<li>
			{{-- Form::label('review_rows', 'Displayed Number of Reviews:') --}}
			{{-- Form::text('review_rows') --}}
			{{-- $errors->first('game_reviews', '<p class="error">:message</p>') --}}
		</li>-->
		<li>
			<div class="media-box" id="ribbon">
				{{ HTML::image(Request::root() . '/images/' . $settings->ribbon_url, null) }}
			</div>

			{{ Form::label('ribbon_url', 'Free Ribbon:') }}
			{{ Form::file('ribbon_url') }}
		</li>
		<li>
			<div class="media-box" id="sale">
				{{ HTML::image(Request::root() . '/images/' . $settings->sale_url, null) }}
			</div>

			{{ Form::label('sale_url', 'On Sale Ribbon:') }}
			{{ Form::file('sale_url') }}
		</li>
		{{ Form::submit('Update Settings') }}
	{{ Form::close() }}
@stop