@extends('layouts.main')
@section('content')

@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif

{{ Form::open(array('url' => '/users/update')) }}
	<div class="row">
		<div class="col-xs-6">
			<p>
				{{ Form::text('firstname', Auth::user()->firstname, array('class'=>'form-control', 'placeholder'=>'First Name')) }}
			</p>
		</div>
		<div class="col-xs-6">
			<p>
				{{ Form::text('lastname', Auth::user()->lastname, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<p>
				{{ Form::text('email', Auth::user()->email, array('class'=>'form-control', 'placeholder'=>'Email')) }}
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<p>
				{{ Form::password('password_previous', array('class'=>'form-control', 'placeholder'=>'Previous Password')) }}
			</p>
		</div>
		<div class="col-xs-4">
			<p>
				{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
			</p>
		</div>
		<div class="col-xs-4">
			<p>
				{{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
			</p>
		</div>
	</div>
	<p>
		{{ Form::submit('Done', array('id' => 'done', 'class'=>'btn btn-default')) }}
	</p>
{{ Form::close() }}

@stop