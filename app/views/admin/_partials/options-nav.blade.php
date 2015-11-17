<nav class="sub-nav options">
	<ul>
		<!-- <li><a href="{{ URL::route('admin.general-settings') }}">General Settings</a></li> -->
		<li><a href="{{ URL::route('admin.featured') }}">Homepage</a></li>
		<li><a href="{{ URL::route('admin.game-settings') }}">Game Page</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.carriers.index')}}">Carriers</a></li>
				<li><a href="{{URL::route('admin.game-settings')}}">Game Variables</a></li>
			</ul>
		</li>
		<li><a href="{{ URL::route('admin.ip-filters') }}">IP Filters</a></li>
		<li><a href="{{ URL::route('admin.languages.index') }}">Languages</a></li>
		<li><a href="#">Variables</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.general-settings') }}">Website</a></li>
				<li><a href="{{ URL::route('admin.variables') }}">Social Media</a></li>
			</ul>
		</li>
		<li><a href="#">Mail</a>
			<ul class="dropdown">
				<li><a href="{{ URL::route('admin.mail-settings') }}">Mail Server Settings</a></li>
				<li><a href="{{ URL::route('admin.reports.inquiries.settings') }}">Auto Responder</a></li>
			</ul>
		<li><a href="">Debug Mode</a></li>
	</ul>
</nav>
<script>
$(document).ready(function($){
    var url = String(window.location).split('/');
    url.splice(6);

    var newurl = url[4];

    $('a[href*="' + newurl + '"]').addClass('active');
});
</script>