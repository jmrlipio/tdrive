@include('_partials.header')
    <div id="login">
        @if(Session::has('message'))
            <div class="flash-success">
                <p>{{ Session::get('message') }}</p>
            </div>
        @endif

        {{ Form::open(array('route' => 'login.post', 'class' => 'login', 'id' => 'login-form')) }}
            <p class="signin">sign in</p>
            <ul>
                <li>
                    {{ Form::text('username', null, array('placeholder'=>'username')) }}
                    {{ $errors->first('username', '<p class="error">:message</p>') }}
                </li>
                <li>
                    {{ Form::password('password', array('placeholder'=>'password')) }}
                    {{ $errors->first('password', '<p class="error">:message</p>') }}
                </li>
                <li>
                    {{ Form::checkbox('remember', 1 , null, ['class' => 'pull-left', 'id'=>'remember']); }}
                    <span class="pull-left">keep me signed in</span>

                    {{ Form::submit('login >',  ['class' => 'pull-right']) }}

                    <div class="clear"></div>
                </li>
            </ul>   
             <p class="pink">forgot your password?</p>  
             
                <p class="not-member">not yet a member?</p>
                <div id="register-button">
                    <a href="{{ route('users.signup') }}">register</a>   
                </div> 
        {{ Form::close() }}
        
    </div>
</body>
</html>