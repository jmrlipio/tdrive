@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	{{ HTML::script('https://www.google.com/jsapi')}}
		<script type="text/javascript">
		   google.load("visualization", "1", {packages:["corechart"]});

	      $(document).ready(function() {
	      	var filter = 'all';
	      	var game_id = '1';
	      	var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	      	var options = {
	          title: 'Games Sales',
	          vAxis: {title: 'Games',  titleTextStyle: {color: 'blue'}}
	        };
      		    jQuery.ajax({
                  type: "POST",
                  url: 'sales/chart/overall',
                  success : function(data) {
                  		var dt = new google.visualization.DataTable(data, 0.6);
        				chart.draw(dt, options);
        				//console.log(data);
                  }
                }, "json");

      		 $('.game_selection').change(function() {
      		 	game_id = $(this).val();
      		 	var ajax_url = 'chart/' + game_id + '/' + filter;
      		 	if(game_id == '0') 
      		 	{
      		 		ajax_url = 'sales/chart/overall';
      		 	}

      		 	jQuery.ajax({
                  type: "POST",
                  url: ajax_url,
                  success : function(data) {
                  		var dt = new google.visualization.DataTable(data, 0.6);
        				chart.draw(dt, options);
                  }
                }, "json");
      		 }); 

      		 $('.filter_selection').change(function() {
      		 	filter = $(this).val();
      		 	var ajax_url = 'chart/' + game_id + '/' + filter;
      		 	jQuery.ajax({
                  type: "POST",
                  url: ajax_url,
                  success : function(data) {
                  		var dt = new google.visualization.DataTable(data, 0.6);
        				chart.draw(dt, options);
                  }
                }, "json");
      		 }); 
	      });
		</script>
		<div class="clear"></div>
		<div class="filter">
			<label>Games: </label> 
			<select class="game_selection">
				<option value="0">All</option>
				@foreach($games as $game)
					<option value="{{ $game->id }}">{{ $game->main_title }}</option>
				@endforeach
			</select>
		</div>
		<div class="filter">
			<label>Filter: </label> 
			<select class="filter_selection">
				<option value="all">All</option>
				<option value="country">Country</option>
				<option value="carrier">Carrier</option>
			</select>
		</div>
		<div class="clear"></div>
		<br/>
		<div id="chart_div" style="width: 100%; height: 500px;"></div>
		
@stop