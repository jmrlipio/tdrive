<nav class="sub-nav" id="options-nav">
	<ul>
		<li><a href="{{ URL::route('admin.general-settings') }}">General Settings</a></li>
		<li><a href="{{ URL::route('admin.featured') }}">Homepage</a></li>
		<li><a href="{{ URL::route('admin.game-settings') }}">Game Page</a></li>
		<li><a href="{{ URL::route('admin.variables') }}">Site Variables</a></li>
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