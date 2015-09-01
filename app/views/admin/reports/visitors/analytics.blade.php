@extends('admin._layouts.admin')
@section('content')
	@include('admin._partials.reports-nav')
	<div class="item-listing">
		<h2>Google Analytics</h2>
	<script>
	(function(w,d,s,g,js,fs){
	  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
	  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
	  js.src='https://apis.google.com/js/platform.js';
	  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
	}(window,document,'script'));
</script>
<style>
  .chart-1 {
    width: 40%;
    float: left;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-left: 45px;
    margin-bottom: 20px;
  }
</style>
<div id="embed-api-auth-container"></div>
<div id="view-selector-container"></div>
<div id="chart-container"></div>
<div class="chart-1">
  <h3>Top Countries by Sessions</h3>
  <p>Last 30 days</p>
  <div id="chart-1-container"></div>
</div>

<div class="chart-1">
  <h3>Top Countries by Sessions</h3>
  <p>Last 60 days</p>
  <div id="chart-2-container"></div>
</div>
<div class="clear"></div>

<div class="chart-1">
  <h3>Pageviews</h3>
  <p>This Week</p>
  <div id="chart-3-container"></div>
</div>
<div class="chart-1">
  <h3>Pageviews</h3>
  <p>Last Week</p>
  <div id="chart-4-container"></div>
</div>

<div class="clear"></div>
<div id="view-selector-1-container" style="display: none;"></div>
<div id="view-selector-2-container" style="display: none;"></div>
<div id="view-selector-3-container" style="display: none;"></div>
<script>

gapi.analytics.ready(function() {

  var user = gapi.analytics.auth.authorize({
    container: 'embed-api-auth-container',
    clientid: '79947328033-j280admh73fp86qogjjgf5esagussqnf.apps.googleusercontent.com'
  });

console.log(user);

var viewSelector = new gapi.analytics.ViewSelector({
    container: 'view-selector-container'
  });

  // Render the view selector to the page.
  viewSelector.execute();

  var dataChart = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date',
      'start-date': '30daysAgo',
      'end-date': 'yesterday'
    },
    chart: {
      container: 'chart-container',
      type: 'LINE',
      options: {
        width: '100%'
      }
    }
  });


  /**
   * Render the dataChart on the page whenever a new view is selected.
   */
  viewSelector.on('change', function(ids) {
    dataChart.set({query: {ids: ids}}).execute();
  });

  var mainChartRowClickListener;


  var viewSelector1 = new gapi.analytics.ViewSelector({
    container: 'view-selector-1-container'
  });

  /**
   * Create a ViewSelector for the second view to be rendered inside of an
   * element with the id "view-selector-2-container".
   */
  var viewSelector2 = new gapi.analytics.ViewSelector({
    container: 'view-selector-2-container'
  });

  var viewSelector3 = new gapi.analytics.ViewSelector({
    container: 'view-selector-3-container'
  });

  // Render the view selector to the page.
  
  // Render both view selectors to the page.
  viewSelector1.execute();
  viewSelector2.execute();
  viewSelector3.execute();


  /**
   * Create the first DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'chart-1-container',
      type: 'PIE',
      options: {
        width: '300px'
      }
    }
  });

  var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': '60daysAgo',
      'end-date': 'yesterday',
      'max-results': 6,
      sort: '-ga:sessions'
    },
    chart: {
      container: 'chart-2-container',
      type: 'PIE',
      options: {
        width: '100%'
      }
    }
  });

  var dataChart3 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviews',
      dimensions: 'ga:date',
      'start-date': '7daysAgo',
      'end-date': 'yesterday'
    },
    chart: {
      container: 'chart-3-container',
      type: 'LINE',
      options: {
        width: '100%'
      }
    }
  });

  var dataChart4 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviews',
      dimensions: 'ga:date',
      'start-date': '15daysAgo',
      'end-date': '8daysAgo'
    },
    chart: {
      container: 'chart-4-container',
      type: 'LINE',
      options: {
        width: '100%'
      }
    }
  });

  viewSelector.on('change', function(ids) {
    var options = {query: {ids: ids}};

    if (mainChartRowClickListener) {
      google.visualization.events.removeListener(mainChartRowClickListener);
    }

    mainChart.set(options).execute();
    breakdownChart.set(options);

    // Only render the breakdown chart if a browser filter has been set.
    if (breakdownChart.get().query.filters) breakdownChart.execute();
  });

  viewSelector1.on('change', function(ids) {
    dataChart1.set({query: {ids: ids}}).execute();
  });

  viewSelector2.on('change', function(ids) {
    dataChart2.set({query: {ids: ids}}).execute();
  });

   viewSelector3.on('change', function(ids) {
    dataChart3.set({query: {ids: ids}}).execute();
    dataChart4.set({query: {ids: ids}}).execute();
  });





  /**
   * Each time the main chart is rendered, add an event listener to it so
   * that when the user clicks on a row, the line chart is updated with
   * the data from the browser in the clicked row.
   */
  mainChart.on('success', function(response) {

    var chart = response.chart;
    var dataTable = response.dataTable;

    // Store a reference to this listener so it can be cleaned up later.
    mainChartRowClickListener = google.visualization.events
        .addListener(chart, 'select', function(event) {

      // When you unselect a row, the "select" event still fires
      // but the selection is empty. Ignore that case.
      if (!chart.getSelection().length) return;

      var row =  chart.getSelection()[0].row;
      var browser =  dataTable.getValue(row, 0);
      var options = {
        query: {
          filters: 'ga:browser==' + browser
        },
        chart: {
          options: {
            title: browser
          }
        }
      };

      breakdownChart.set(options).execute();
    });
  });

});
</script>
@stop