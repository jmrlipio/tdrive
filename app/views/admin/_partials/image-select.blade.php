<div id="cover">
	<div id="img-select" class="tab-container">
		<a href="#" id="img-close"></a>
		<ul class='etabs'>
			<li class='tab'><a href="#select" id="select-tab">Select Image</a></li>
			<li class='tab'><a href="#upload" id="upload-tab">Upload Image</a></li>
		</ul>
		<div class='panel-container'>
			<div id="select">
				<h3>Please select an image:</h3>
				<br>
				<div id="img-gallery" class="panel-div">
					<ul>
						
					</ul>
				</div>
				<div id="img-select-buttons">
					{{ Form::button('Select', array('id' => 'choose-img')) }}
					{{ Form::button('Cancel', array('id' => 'close-img-select')) }}
				</div>
			</div>
			<div id="upload">
				<div id="img-gallery" class="panel-div">
					{{ Form::open(array('route' => 'media.upload', 'class' => 'dropzone')) }}

					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
{{ HTML::script('js/dropzone.min.js') }}