<nav class="sub-nav" id="reports-nav">
	<ul>
		<li><a href="{{ URL::route('admin.reports.sales.list') }}">Games</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.sales.list') }}">Sales Report</a></li>
				<li><a href="{{ URL::route('admin.reports.downloads') }}">Download Report</a></li>
				<li><a href="{{ URL::route('admin.reports.visitors.ratings') }}">Game Ratings</a></li>
				<li><a href="{{ URL::route('admin.reports.visitors.statistics') }}">Game Page Views</a></li>
			</ul>
		</li>
		<li></li>
		<!-- <li><a href="{{ URL::route('admin.reports.adminlogs') }}">Logs</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.adminlogs') }}">Admin Logs</a></li>
				<li><a href="{{ URL::route('admin.reports.visitors.activity') }}">User Activity Logs</a></li>
			</ul>
		</li> -->
		<li><a href="{{ URL::route('admin.reports.visitors.statistics') }}">Website</a>
			<ul class="dropdown">
				<!-- <li><a href="{{ URL::route('admin.reports.visitors.statistics') }}">Game Page Analytics</a></li> -->
				<li><a href="{{ URL::route('admin.reports.visitors.analytics') }}">Google Analytics</a></li>
				<li><a href="{{ URL::route('admin.reports.adminlogs') }}">Admin Login Activity</a></li>
				<li><a href="{{ URL::route('admin.reports.visitors.activity') }}">User Login Activity</a></li>
				
			</ul>
		</li>
	</ul>
</nav>
<script>
// $(document).ready(function($){
//     var url = String(window.location).split('/');
//     url.splice(5);

//     var newurl = url.join('/');

//     $('a[href^="' + newurl + '"]').addClass('active');
// });
</script>