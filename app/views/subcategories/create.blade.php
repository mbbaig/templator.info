@extends('layouts.main')
@section('content')

@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif

{{ Form::open(array('url' => 'templates/create')) }}
<p>{{ Form::label('titleLabel', 'title') }}</p>
<p>{{ Form::text('title') }}</p>
<p>{{ Form::label('visibilityLabel', 'visibility') }}</p>
<p>{{ Form::select('visibility', array('public' => 'public', 'private' => 'private')) }}</p>
<p>{{ Form::submit('Done', array('id' => 'done')) }}</p>
{{ Form::close() }}

@stop