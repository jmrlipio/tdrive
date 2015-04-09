<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>		

		<h2>Hello {{$user->first_name}}</h2>

		<div>

			<p>
				You are receiving this notification because you have (or someone pretending

				to be you has) requested a new password be sent for your account on "Tdrive".

				If you did not request this notification then please ignore it.
			</p>

			<p>
				To reset your password, click the link provided below.
			</p>

				<a href="{{ URL::to('password/reset', array($token)) }}">{{ URL::to('password/reset', array($token)) }}</a>

			<!-- <p>
				
				If successful you will be able to login using the following password:
			
				Password: <em>"Temporary password here"</em>
			
			</p> -->

			<p>
				This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
			</p>
		

		</div>
	</body>
</html>
