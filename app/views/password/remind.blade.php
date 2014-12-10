@extends('_layouts.login')
@section('content')
	<div id="forgot-password">
		
		<h3 class="center">Remind password page</h3>
		
		<div class="center">
            @if (Session::has('error'))
              {{ trans(Session::get('reason')) }}
            @elseif (Session::has('success'))
              An email with the password reset has been sent.
            @endif
             
            {{ Form::open(array('route' => 'password.request', 'class' => 'forgot-password', 'id' => 'forgot-password-form')) }}   

                <div class="control">       
                    {{ Form::text('email', null, array('placeholder'=>'email','required')) }}
                </div>

                <div class="control-item">
                     {{ Form::submit('Submit',  ['class' => 'button button-pink']) }}
                </div>
             
            {{ Form::close() }}

        </div>
	</div>
@stop