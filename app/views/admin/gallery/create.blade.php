@extends('admin._layouts.admin')

@section('content')

{{ Form::open(array('route' => 'gallery.upload', 'class' => 'dropzone')) }}

{{ Form::close() }}

{{ HTML::script('js/jquery-1.11.1.js') }}
{{ HTML::script('js/dropzone.min.js') }}

@stop