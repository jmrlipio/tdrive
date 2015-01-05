@extends('_layouts/listing')

@section('stylesheets')
@stop

@section('content')

	<div class="container">
		<h1 class="title">Latest news</h1>

		<div id="token">{{ Form::token() }}</div>

		@foreach ($news as $item)
			@foreach ($item->contents as $content)

				<div class="item">
					<div class="date">
						<div class="vhparent">
							<p class="vhcenter">{{ Carbon::parse($item->release_date)->format('M j') }}</p>
						</div>	
					</div>	

					<div class="details">
						<div class="vparent">
							<div class="vcenter">
								<h3>{{{ $item->main_title }}}</h3>
								<p>{{{ $content->pivot->excerpt }}}</p>
							</div>	
						</div>
					</div>	

					<div class="readmore">
						<div>
							<a href="{{ 'news/'. $item->id }}" class="vhcenter"><i class="fa fa-angle-right"></i></a>
						</div>
					</div>
				</div>

			@endforeach
		@endforeach

		<div class="center">
			{{ $news->links() }}
		</div>

	</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}

	<script>
		FastClick.attach(document.body);
	</script>
@stop
