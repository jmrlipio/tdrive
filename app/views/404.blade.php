@extends('_layouts.default')
@section('content')

<div id="sb-site">
    <div class="content-main">       

        <div class="container" id="error-container">
            <h2>Page Not Found!</h2>

            <p>This page could not be found on the server. <br/> 404 error!</p>

            {{ HTML::link('/','Return to homepage') }}
        </div>

    </div>
</div>
@stop