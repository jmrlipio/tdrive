<nav class="sub-nav">
	<ul>
		<li><a href="{{ URL::route('admin.games.index') }}">Games</a></li>
		<li><a href="{{ URL::route('admin.categories.index') }}">Categories</a></li>
		<li><a href="{{ URL::route('admin.languages.index') }}">Languages</a></li>
		<li><a href="{{ URL::route('admin.carriers.index')}}">Carriers</a></li>
	</ul>
</nav>
<script>
$(document).ready(function($){
    var url = String(window.location).split('/');
    url.splice(5);

    var newurl = url.join('/');

    $('a[href^="' + newurl + '"]').addClass('active');
});
</script>