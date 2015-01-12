<nav class="sub-nav" id="reports-nav">
	<ul>
		<li><a href="{{ URL::route('admin.reports.sales.list') }}">Game</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.sales.list') }}">Sales</a></li>
				<li><a href="{{ URL::route('admin.reports.downloads') }}">Downloads</a></li>
				<li><a href="{{ URL::route('admin.reports.visitors.ratings') }}">Total Game Ratings</a></li>
				<li><a href="{{ URL::route('admin.reports.sales.chart') }}">Graphs</a></li>
			</ul>
		</li>
		<li></li>
		<li><a href="{{ URL::route('admin.reports.adminlogs') }}">Logs</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.adminlogs') }}">Admin Logs</a></li>
				<li><a href="{{ URL::route('admin.reports.visitors.activity') }}">User Activity Logs</a></li>
			</ul>
		</li>
		<li><a href="{{ URL::route('admin.reports.inquiries') }}">Website</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.inquiries') }}">Inquiries</a></li>
				<!--<li><a href="{{-- URL::route('admin.reports.visitors.statistics') --}}">Game Statistics</a></li>-->
				<!--<li><a href="{{-- URL::route('admin.reports.visitors.analytics') --}}">Google Analytics</a></li>-->
				
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