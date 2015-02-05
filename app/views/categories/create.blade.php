@extends('layouts.main')
@section('content')
@if($errors->has())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif
@if(!empty($message))
	<p>{{ $message }}</p>
@endif
<h2>Categories</h2><hr>

{{ Form::open(array('url' => '/categories/create', 'class' => 'form-inline spacing', 'role' => 'form')) }}
<div class="form-group col-xs-10">{{ Form::text('title', '', array('class'=>'form-control', 'placeholder'=>'Title of the Category')) }}</div>
{{ Form::submit('Add Category', array('id' => 'done', 'class'=>'btn btn-default')) }}
{{ Form::close() }}

<div class="panel-group" id="accordian">
	@foreach($categories as $category)
		<div class="panel panel-default">
			<a href="/categories/delete/{{ $category->id }}" class="btn btn-danger pull-right">Delete</a>
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#{{ str_replace(' ', '-', $category->title) }}{{ $category->id }}">{{ $category->title }} <small>Click to expand</small></a>
				</h4>
			</div>
			<div id="{{ str_replace(' ', '-', $category->title) }}{{ $category->id }}" class="panel-collapse collapse">
				<h4 class="spacing">Sub-Categories</h4>
				@foreach($subcategories as $subcategory)
					@if($category->id == $subcategory->categoryid)
						<div class="panel panel-info spacing">
							<a href="/subcategories/delete/{{ $subcategory->id }}" class="btn btn-danger pull-right">Delete</a>
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#{{ str_replace(' ', '-', $category->title) }}{{ $category->id }}" href="#{{ str_replace(' ', '-', $subcategory->title) }}{{ $subcategory->id }}">{{ $subcategory->title }} <small>Click to expand</small></a>
								</h4>
							</div>
							<div id="{{ str_replace(' ', '-', $subcategory->title) }}{{ $subcategory->id }}" class="panel-collapse collapse spacing">
								@foreach($templates as $template)
									@if($template->subcategoryid == $subcategory->id)
										<span class="btn btn-primary">
											Title: {{$template->title}}
										</span>
									@endif
								@endforeach
							</div>
						</div>
					@endif
				@endforeach
				{{ Form::open(array('url' => '/subcategories/create', 'class' => 'form-inline spacing', 'role' => 'form')) }}
				<div class="form-group">{{ Form::text('title', '', array('class'=>'form-control', 'placeholder'=>'Title of the Sub-Category')) }}</div>
				{{ Form::hidden('catid', $category->id) }}
				{{ Form::submit('Add Sub-Category', array('id' => 'done', 'class'=>'btn btn-default')) }}
				{{ Form::close() }}
			</div>
		</div>
	@endforeach
</div>

@stop