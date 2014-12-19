<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		<div>
			<p>Hello {{ $username }},</p>

			<p>Please activate your account using the following link</p>
			<a href="{{ $link }}">Activate Now</a>

		</div>
	</body>
</html>
