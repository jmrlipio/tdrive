<nav class="sub-nav" id="options-nav">
	<ul>
		<li><a href="{{ URL::route('admin.general-settings') }}">General Settings</a></li>
		<li><a href="{{ URL::route('admin.form-messages') }}">Success/Error Messages</a></li>
		<li><a href="{{ URL::route('admin.slideshow') }}">Homepage Slideshow</a></li>
		<li><a href="{{ URL::route('admin.game-settings') }}">Game Page</a></li>
		<li><a href="{{ URL::route('admin.variables') }}">Site Variables</a></li>
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