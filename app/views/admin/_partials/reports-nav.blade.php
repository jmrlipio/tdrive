<nav class="sub-nav" id="reports-nav">
	<ul>
		<li><a href="{{ URL::route('admin.reports.sales.list') }}">Sales</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.sales.chart') }}">Graphs</a></li>
			</ul>
		</li>
		<li><a href="{{ URL::route('admin.reports.downloads') }}">Downloads</a></li>
		<li><a href="{{ URL::route('admin.reports.adminlogs') }}">Admin Logs</a></li>
		<li><a href="{{ URL::route('admin.reports.visitorlogs') }}">Visitor Logs</a></li>
		<li><a href="{{ URL::route('admin.reports.inquiries') }}">Inquiries</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.reports.inquiries.settings') }}">settings</a></li>
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