<div id="polyglotLanguageSwitcher" class="polyglotLanguageSwitcher">
	<form action="{{ URL::route('choose_language') }}" id="locale" class="language" method="post">

		{{ Form::token() }}

		<select name="locale" id="polyglot-language-options">
			<option value="" selected>Select Language</option>
			<option id="en" value="en" {{ (strtolower($user_location['isoCode']) == 'us' || Lang::locale() == 'us') ? ' selected' : '' }}>English</option>
			<option id="th" value="th" {{ (strtolower($user_location['isoCode']) == 'th' || Lang::locale() == 'th') ? ' selected' : '' }}>Thai</option>
			<option id="id" value="id" {{ (strtolower($user_location['isoCode']) == 'id' || Lang::locale() == 'id') ? ' selected' : '' }}>Bahasa Indonesia</option>
			<option id="my" value="my" {{ (strtolower($user_location['isoCode']) == 'my' || Lang::locale() == 'my') ? ' selected' : '' }}>Bahasa Malaysia</option>
			<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || Lang::locale() == 'cn') ? ' selected' : '' }}>Traditional Chinese</option>
			<option id="cn" value="cn" {{ (strtolower($user_location['isoCode']) == 'cn' || Lang::locale() == 'cn') ? ' selected' : '' }}>Simplified Chinese</option>
			<option id="vn" value="vn" {{ (strtolower($user_location['isoCode']) == 'vn' || Lang::locale() == 'vn') ? ' selected' : '' }}>Vietnamese</option>
			<option id="jp" value="jp" {{ (strtolower($user_location['isoCode']) == 'jp' || Lang::locale() == 'jp') ? ' selected' : '' }}>Japanese</option>
			<option id="hi" value="hi" {{ (strtolower($user_location['isoCode']) == 'hi' || Lang::locale() == 'hi') ? ' selected' : '' }}>Hindi</option>
		</select>

		<input type="submit" value="select">
	</form>
</div>
