@extends('layouts.main')
@section('content')

@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif

{{ Form::open(array('url' => 'users/signin')) }}
	<div class="row">
		<div class="col-xs-12">
			<p>
				{{ Form::text('email', '', array('class'=>'form-control', 'placeholder'=>'Email')) }}
			</p>
		</div>
		<div class="col-xs-12">
			<p>
				{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
			</p>
		</div>
	</div>
	<div class="row">
		<p class="col-xs-6">
			{{ Form::submit('Log In', array('id' => 'login', 'class'=>'btn btn-default')) }}
		</p>
	</div>
	<div class="row">
		<p class="col-xs-6">
			<a href="/users/create" class="btn btn-default">Sign Up</a>
		</p>
	</div>
{{ Form::close() }}

<a href="/users/createfb" class="btn btn-default">Login with Facebook</a>

@stop