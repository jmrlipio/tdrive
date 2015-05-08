@extends('admin._layouts.admin')
@section('stylesheets')
	<style>
		.media-box { float: none !important; padding-left: 0 !important; }
	</style>
@stop
@section('content')
	@include('admin._partials.game-nav')
	<article>
		
			<h2>Edit Discount</h2>
			<br>
			@if(Session::has('message'))
			    <div class="flash-success">
			        <p>{{ Session::get('message') }}</p>
			    </div>
			@endif
			<div class='panel-container'>
				<ul>
					<li>
						<?php $image = $discount->featured_image; ?>
						
						{{ Form::label('featured_image', 'Featured Image:') }}

						<div class="media-box" id="featured_imagec">
							
							{{ Form::open(array('route' => array('admin.games.postupdate-media', $discount->id), 'method' => 'post', 'files' => true, 'class' => 'post-media-form')) }}
							@if($image)
								<img src="{{ asset('assets/discounts') }}/{{ $image }}" class="image-preview" alt="image_preview"/>
			            	@else
			            		<img src="{{ asset('images/default-450x200.png') }}" class="image-preview" alt="image_preview"/>
			            	@endif
			            	 <div style="position:relative; width: 100px; top: -35px">
			              		<a class='btn btn-primary upload-trigger' href='javascript:;'>
			                    <span class="screenshot-loader" >change</span>
			                    <input type="file" name="featured_image" id="featured_image" class="media-file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' size="60"  onchange='$("#upload-file-info").html($(this).val());'>
			             		</a>
				        	</div>
				        	{{ Form::close() }}
			            </div>

						<div class="clear"></div>

					</li>
					{{ Form::model($discount, array('route' => array('admin.discounts.update', $discount->id), 'method' => 'put', 'enctype'=> 'multipart/form-data', 'files' => true, 'id' => 'tab-container', 'class' => 'large-form tab-container')) }}
					<li>
						{{ Form::label('title', 'Discount Name: ') }}
						{{ Form::text('title') }}
						{{ $errors->first('title', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('description', 'Description: ') }}
						{{ Form::textarea('description', null, array('id' => 'content')) }}
						{{ $errors->first('description', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('carrier_id', 'Carrier:') }}
				  		{{ Form::select('carrier_id', $carriers, null) }}				
						{{ $errors->first('carrier_id', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('game_id', 'Games: ') }}
						{{ Form::select('game_id[]', $games, $selected_games, array('multiple' => 'multiple', 'class' => 'chosen-select', 'data-placeholder'=>'Choose game(s)...'))  }}
						{{ $errors->first('game_id', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('discount_percentage', 'Discount Percentage: ') }}
						{{ Form::text('discount_percentage', null, array('id' => 'discount-percent')) }}
						{{ $errors->first('discount_percentage', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('active', 'Active: ') }}
						{{ Form::select('active', array('1' => 'Yes', '0' => 'No'))  }}
					</li>
					<li>
						{{ Form::label('user_limit', 'User Limit: ') }}
						{{ Form::text('user_limit') }}
						{{ $errors->first('user_limit', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('start_date', 'Start Date:') }}
						{{ Form::text('start_date', null, array('id' => 'start_date', 'class' => 'datepicker')) }}
						{{ $errors->first('start_date', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('end_date', 'End Date:') }}
						{{ Form::text('end_date', null, array('id' => 'end_date', 'class' => 'datepicker')) }}
						{{ $errors->first('end_date', '<p class="error">:message</p>') }}
					</li>
					

					<li>
						{{ Form::submit('Save') }}
					</li>			
					
				</ul>
			</div>

		{{ Form::close() }}
	</article>
	
	{{ HTML::script('js/chosen.jquery.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/image-uploader.js') }}
	<script>
	(function(){
		$(".chosen-select").chosen();

		$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' }).bind("change",function(){
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("yy-mm-dd", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#to").datepicker( "option", "minDate", minValue );
    	});

    	CKEDITOR.replace('content');

    	//promo, icons, homepage

		$("#featured_image").uploadBOOM({
			'url': '{{ URL::route("admin.discounts.postupdate-media", $discount->id) }}',
			'before_loading': '<span class="loader-icon"></span>Saving..',
			'after_loading' : 'Change'
		});

	})();
	</script>

@stop
