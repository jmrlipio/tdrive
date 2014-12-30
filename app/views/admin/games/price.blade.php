@extends('admin._layouts.admin')

@section('content')
	
	{{ Form::open(array('route' => array('admin.games.edit.prices', $game->id, $carrier->id), 'method' => 'post', 'id' => 'game-content-form')) }}
		<h3>{{ $game->main_title }}</h3>
		<p>Prices for Globe {{ $carrier->carrier }}</p>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		@foreach($countries as $country)
			@foreach($selected_countries as $scid => $sc)
				@if($scid == $country->id)
					<li>
						{{ Form::label($scid, $sc) }}	
						{{ Form::text('prices[]', null, array('id' => $scid)) }}
					</li>
				@endif
			@endforeach
		@endforeach
		{{ Form::submit('Update Prices') }} <a href="{{ URL::route('admin.games.edit', $game->id) . '#game-content' }}">Back</a>
	{{ Form::close() }}
	
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
@stop
