<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		<div>

			<h2>Welcome to Tdrive</h2>

			<p>Hello {{ $username }},</p>

			<p>
				Please keep this e-mail for your records. Your account information is as follows:
			</p>

			<p>
				---------------------------- <br>
				Username: {{$username}} <br>
				----------------------------
			</p>

			<p>
				Your password has been securely stored in our database and cannot be

				retrieved. In the event that it is forgotten, you will be able to reset it

				using the email address associated with your account.
			</p>

			<p>
				Please visit the following link in order to activate your account:
				
				<a href="{{ $link }}">{{ $link }}</a>
			</p>

			<p>
				Thank you for registering.
			</p>

			

		</div>
	</body>
</html>
