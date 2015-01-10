@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	{{ HTML::script('https://www.google.com/jsapi')}}
		<script type="text/javascript">
		   google.load("visualization", "1", {packages:["corechart"]});

	      $(document).ready(function() {

	      	var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
	      	var options = {
          	          title: 'Page View Reports',
          	          vAxis: {title: 'Pages',  titleTextStyle: {color: 'blue'}}
	                     };

            jQuery.ajax({
                type: "POST",
                url: 'chart/pageviews',
                success : function(data) {
                    var dt = new google.visualization.DataTable(data, 0.6);
                   chart.draw(dt, options);
                }
              }, "json");



	      });
		</script>
		<br/>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
		
@stop