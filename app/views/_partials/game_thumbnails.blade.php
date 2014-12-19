<div class="column-three mobile">	
	 <div class="row clearfix">
		
	
		<div>
			<a href="#"><img src="images/thumbnails/blazing-dribble.jpg" class="border-radius" alt="Blazing Dribble"></a>
			<p class="description">Blazing Dribble <span class="price">(P 10.00)</span></p>
		</div>
	
		<div>
			<a href="#"><img src="images/thumbnails/blazing-kickoff.jpg" class="border-radius" alt="Blazing Kickoff"></a>
			<p class="description">Blazing Kickoff <span class="price">(P 10.00)</span></p>
		</div>
	</div>
	
	
	<div class="row clearfix">
		<div>
			<a href="#"><img src="images/thumbnails/doraemon.jpg" class="border-radius" alt="Doraemon"></a>
			<p class="description">Doraemon <span class="price">(P 5.00)</span></p>
		</div>
	
		<div>
			<a href="#"><img src="images/thumbnails/mew-mew-tower.jpg" class="border-radius" alt="Mew Mew Tower"></a>
			<p class="description">Mew Mew Tower <span class="price">(Free)</span></p>
		</div>
	
		<div>
			<a href="#"><img src="images/thumbnails/pop-up-pirates.jpg" class="border-radius" alt="Pop Up Pirates"></a>
			<p class="description">Pop Up Pirates <span class="price">(P 5.00)</span></p>
		</div>
	</div> 
</div>

<div class="column-four tablet">
				
	<div class="row clearfix">
		<?php 
			/*echo '<pre>';
			print_r($games->media);
			echo '</pre>';	*/
		?>	
		@foreach($games as $game)

			<div>
				<a href="#"><img src="#" class="border-radius" alt="{{ $game->title }}"></a>
				<p class="description">{{ $game->title }} <span class="price"> (P {{ $game->default_price }}) </span></p>
			</div>

		@endforeach
	</div>
	
	
	<div class="row clearfix">
		<div>
			<a href="#"><img src="images/thumbnails/doraemon.jpg" class="border-radius" alt="Doraemon"></a>
			<p class="description">Doraemon <span class="price">(P 5.00)</span></p>
		</div>
	
		<div>
			<a href="#"><img src="images/thumbnails/mew-mew-tower.jpg" class="border-radius" alt="Mew Mew Tower"></a>
			<p class="description">Mew Mew Tower <span class="price">(Free)</span></p>
		</div>
	
		<div>
			<a href="#"><img src="images/thumbnails/pop-up-pirates.jpg" class="border-radius" alt="Pop Up Pirates"></a>
			<p class="description">Pop Up Pirates <span class="price">(P 5.00)</span></p>
		</div>
	
		<div>
			<a href="#"><img src="images/thumbnails/mew-mew-tower.jpg" class="border-radius" alt="Mew Mew Tower"></a>
			<p class="description">Mew Mew Tower <span class="price">(Free)</span></p>
		</div>
	</div>
</div>
