<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>

		<div>
			<p>Hello, {{ $name }}</p>

			<p>
				Your request "{{ $game_title }}" has been received and is being reviewed by our customer service. <br> 

				To ensure a fast and accurate response, please refrain from sending more than one email/ticket regarding your inquiry. <br>				 

				We will respond to your request as soon as possible. <br>				 

				Customer service is open Monday - Friday from 2:00AM - 10:00 AM GMT.

			</p>
			
			<p>{{ $messages }}</p>
		</div>
	</body>
</html>
