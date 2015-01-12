@foreach($news as $item)
	@foreach($item->contents as $content)

		<div class="item">
			<div class="date">
				<div class="vhparent">
					<p class="vhcenter">{{ Carbon::parse($item->release_date)->format('M j') }}</p>
				</div>
			</div>

			<div class="details">
				<div class="vparent">
					<div class="vcenter">
						<h3>{{ $item->main_title }}</h3>
						<p>{{ $content->pivot->excerpt }}</p>
					</div>
				</div>
			</div>

			<div class="readmore">
				<a href="news/{{ $item->id }}">
					<div class="vhcenter"><i class="fa fa-angle-right"></i></div>
				</a>
			</div>
		</div>

	@endforeach
@endforeach
