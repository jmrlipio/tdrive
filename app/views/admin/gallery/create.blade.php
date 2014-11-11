@extends('admin._layouts.admin')

@section('content')

{{ Form::open(array('route' => 'gallery.upload', 'action' => 'ImagesController@postUpload', 'class' => 'dropzone')) }}
	
{{ Form::close() }}

{{ HTML::script('js/jquery-1.11.1.js') }}
{{ HTML::script('js/dropzone.js') }}
@stop

