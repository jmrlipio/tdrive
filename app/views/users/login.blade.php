@extends('_layouts.login')
@section('content')

    <div id="login">

        @if($errors->has() )                         
           
            @foreach($errors->all() as $error)                        
                <h3 class="center">{{ $error }}</h3>                     
            @endforeach 

        @elseif (Session::has('message') ) 
            
                <h3 class="center">{{ Session::get('message') }}</h3>              

        @else

            <h3 class="center">Sign In</h3>

        @endif     

        <div class="center">
           {{ Form::open(array('route' => 'login.post', 'class' => 'login', 'id' => 'login-form')) }}

                <div class="control">
                    {{ Form::text('username', null, array('placeholder'=>'username')) }}                   
                </div>

                <div class="control">
                    {{ Form::password('password', array('placeholder'=>'password')) }}                    
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
