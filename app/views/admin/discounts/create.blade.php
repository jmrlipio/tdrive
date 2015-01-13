@extends('admin._layouts.admin')

@section('content')
	@include('admin._partials.game-nav')
	<article>
		{{ Form::open(array('route' => 'admin.discounts.store', 'class' => 'large-form tab-container', 'id' => 'tab-container', 'files' => true, 'enctype'=> 'multipart/form-data')) }}
			<h2>Create New Discount</h2>
			<br>
			@if(Session::has('message'))
			    <div class="flash-success">
			        <p>{{ Session::get('message') }}</p>
			    </div>
			@endif
			<div class='panel-container'>
				<ul>
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
						{{ Form::label('featured_image', 'Choose an image') }}
						{{ Form::file('featured_image') }}
						{{ $errors->first('featured_image', '<p class="error">:message</p>') }}
					</li>
					<li>
						{{ Form::label('game_id', 'Games: ') }}
						{{ Form::select('game_id[]', $games, null, array('multiple' => 'multiple', 'class' => 'chosen-select', 'id' => 'languages', 'data-placeholder'=>'Choose game(s)...'))  }}
						{{ $errors->first('game_id', '<p class="error">:message</p>') }}
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
	})();
	</script>

@stop
