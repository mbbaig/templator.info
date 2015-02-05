@extends('layouts.main')
@section('content')

@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif

{{ Form::open(array('url' => 'templates/create')) }}
{{ Form::text('title', '', array('class' => 'form-control', 'placeholder' => 'Title')) }}
{{ Form::textarea('description', '', array('class' => 'form-control', 'placeholder' => 'description')) }}
{{ Form::text('version', '', array('class' => 'form-control', 'placeholder' => 'version')) }}
<div class="form-group">
	<label for="visibility" class="col-xs-2 control-label">Visibility:</label>
	<div class="col-xs-10">
		{{ Form::select('visibility', array('public' => 'public', 'private' => 'private'), '', array('class' => 'form-control', 'id' => 'visibility')) }}
	</div>
</div>
<div class="form-group">
	<label for="subcategory" class="col-xs-2 control-label">Sub-Category:</label>
	<div class="col-xs-10">
		{{ Form::select('subcategory', $subcategories, '', array('class' => 'form-control', 'id' => 'subcategory')) }}
	</div>
</div>
<br><br><br>
{{ Form::submit('Done', array('id' => 'done', 'class' => 'btn btn-success')) }}
{{ Form::close() }}

@stop