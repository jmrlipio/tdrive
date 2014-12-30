@extends('layouts/single')

@section('content')

	<div id="featured" class="container">
		<img src="/images/news/{{ preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($news->main_title)) }}.jpg" alt="{{ $news->main_title }}">
	</div>

	<div class="container">
		<div class="details">
			<div class="date">
				<div class="vhparent">
					<p class="vhcenter">03 jul</p>
				</div>
			</div>

			<div class="title">
				<div class="vparent">
					<h2 class="vcenter">{{{ $news->main_title }}}</h2>
				</div>
			</div>
		</div>

		<div class="description">

			@foreach($news->contents as $item)
				{{ $item->pivot->content }}
			@endforeach

		</div>

		<div class="social clearfix">
			<div>
				<a href="#" class="share">Share</a>
				<a href="#" class="like">Like </a>
			</div>
		</div>
	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);
	</script>
@stop
