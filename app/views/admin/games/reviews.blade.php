@extends('admin._layouts.admin')
@section('stylesheets')
<style>
	div#pie_wrapper{
		width: 80%;
		min-height: 350px;
		margin-bottom: 20px;
	}

</style>
@stop
@section('content')
	@include('admin._partials.game-nav')
	<div class="item-listing" id="games-list">
		<h2>{{ $game->main_title}} Reviews</h2><br>

		<div id="pie_wrapper">
			<div id="chart_div"></div>
		</div>
	
		<table class="table table-striped table-bordered table-hover" id="game_table">
			<thead>
				<tr>
					<th>Username</th>
					<th>Review</th>
					<th>Rating</th>
				</tr>
			</thead>

			<tbody>
				@foreach($game->review as $review)	
					<tr>
						<td>{{ $review->username }}</td>
						<td>{{ $review->pivot->review }}</td>
						<td>
							{{-- $review->pivot->rating --}}
							@for($i = 1; $i <= 5; $i++)
								<i class="fa fa-star{{ ($i <= $review->pivot->rating) ? '' : '-empty' }}"></i>
							@endfor
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<br>
	</div>
	
@stop

@section('scripts')

	{{ HTML::script('js/jquery.dataTables.js') }}
	{{ HTML::script('js/jquery.dataTables.bootstrap.js') }}
	{{ HTML::script('js/form-functions.js') }}
	{{ HTML::script('js/google-api.js') }}

	<script type="text/javascript">
	google.load('visualization', '1', { 'packages': ['corechart'] });
	
	$(document).ready(function(){
		$('#game_table').DataTable();
		$('th input[type=checkbox]').click(function(){
			if($(this).is(':checked')) {
				$('td input[type=checkbox').prop('checked', true);
			} else {
				$('td input[type=checkbox').prop('checked', false);
			}
		});

		$('#select-cat').on('change', function() {
			$('#submit-cat').trigger('submit');
		});

		/* Pie chart*/

		var jsonData = {{ $output }};
		var data = new google.visualization.DataTable(jsonData);

		var options = {
			'title':'Ratings',
			 chartArea:{left:10,top:30,width:"100%",height:"85%"},			 
			'width':500,    
			'height':350
		};

		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data,options); 

		/* END */
	});

	</script>
@stop
