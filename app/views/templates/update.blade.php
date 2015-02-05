@extends('layouts.main')
@section('content')

@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif

{{ Form::open(array('url' => 'templates/update')) }}
{{ Form::hidden('id', $template->id) }}
{{ Form::text('title', $template->title, array('class' => 'form-control', 'placeholder' => 'Title')) }}
{{ Form::textarea('description', $template->description, array('class' => 'form-control', 'placeholder' => 'description')) }}
{{ Form::text('version', $template->version, array('class' => 'form-control', 'placeholder' => 'version')) }}
<div class="form-group">
	<label for="visibility" class="col-xs-2 control-label">Visibility:</label>
	<div class="col-xs-10">
		{{ Form::select('visibility', array('public' => 'public', 'private' => 'private'), $template->visibility, array('class' => 'form-control', 'id' => 'visibility')) }}
	</div>
</div>
<div class="form-group">
	<label for="subcategory" class="col-xs-2 control-label">Sub-Category:</label>
	<div class="col-xs-10">
		{{ Form::select('subcategory', $subcategories, $template->subcategoryid, array('class' => 'form-control', 'id' => 'subcategory')) }}
	</div>
</div>
{{ Form::submit('Done', array('id' => 'done', 'class' => 'btn btn-default')) }}
{{ Form::close() }}

@stop