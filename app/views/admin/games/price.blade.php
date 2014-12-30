@extends('admin._layouts.admin')

@section('content')
	
	{{ Form::open(array('route' => array('admin.games.edit.prices', $game->id, $carrier->id), 'method' => 'post', 'id' => 'prices-form')) }}
		<h3>{{ $game->main_title }}</h3>
		<h4>Prices for Globe {{ $carrier->carrier }}</h4>
		@if(Session::has('message'))
		    <div class="flash-success">
		        <p>{{ Session::get('message') }}</p>
		    </div>
		@endif
		<br>
		@foreach($countries as $country)
			@foreach($selected_countries as $scid => $sc)
				@if($scid == $country->id)
					<?php $cprice = null; ?>
					@foreach($prices as $country_id => $price)
						@if($country_id == $scid)
							<?php $cprice = $price; ?>
						@endif
					@endforeach
					<li>
						<p>{{ $country->full_name }}</p>
						<p>
							{{ Form::label($scid, $sc.': ') }}
							{{ Form::text('prices['.$scid.']', $cprice, array('id' => $scid, 'class' => 'small-text')) }}
						</p>
						<br>
					</li>
				@endif
			@endforeach
		@endforeach
		{{ Form::submit('Update Prices') }} <a href="{{ URL::route('admin.games.edit', $game->id) . '#prices' }}">Back</a>
	{{ Form::close() }}
	
	<script type="text/javascript">
		CKEDITOR.replace('content');
	</script>
@stop
