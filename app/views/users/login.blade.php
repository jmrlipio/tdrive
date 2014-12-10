@extends('_layouts.login')
@section('content')

    <div id="login">
        @if(Session::has('message'))
            <div class="flash-success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif

       <h3 class="center">Sign In</h3>

        <div class="center">
           {{ Form::open(array('route' => 'login.post', 'class' => 'login', 'id' => 'login-form')) }}

                <div class="control">
                    {{ Form::text('username', null, array('placeholder'=>'username')) }}
                    {{ $errors->first('username', '<p class="error">:message</p>') }}
                </div>

                <div class="control">
                    {{ Form::password('password', array('placeholder'=>'password')) }}
                    {{ $errors->first('password', '<p class="error">:message</p>') }}
                </div>

                <div class="control-group clearfix">
                    <div class="control-item">
                        {{ Form::checkbox('remember', 1 , null, ['class' => 'pull-left', 'id'=>'remember']); }}
                       <label for="remember">Remember me</label>
                    </div>

                    <div class="control-item">
                         {{ Form::submit('Login &raquo;',  ['class' => 'button button-pink']) }}
                    </div>
                </div>

            {{ Form::close() }}
        </div>

        <div class="center">
            <a href="{{ route('password.remind') }}" class="button button-pink">Forgot your password?</a>
        </div>

        <div class="center">
            <h3>Not yet a member? <a href="{{ route('users.signup') }}" class="link link-pink">Register</a></h3>
        </div>
        
    </div>
@stop
