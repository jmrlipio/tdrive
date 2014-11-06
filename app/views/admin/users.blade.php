@extends('../layouts/default')

@section('content')
	
	<ul>
		@foreach($users as $user)
			<li>{{ $user->username }}</li>
		@endforeach
	</ul>

@stop