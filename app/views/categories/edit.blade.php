@extends('layouts.main')
@section('content')

@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif

{{ Form::open(array('url' => 'categories/update/')) }}
<p>{{ Form::hidden('id', $category->id) }}</p>
<p>{{ Form::label('titleLabel', 'title') }}</p>
<p>{{ Form::text('title', $category->title) }}</p>
<p>{{ Form::submit('Done', array('id' => 'done')) }}</p>
{{ Form::close() }}

@stop