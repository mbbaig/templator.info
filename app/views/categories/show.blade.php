@extends('layouts.main')
@section('content')
<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li class="active">{{ $category->title }}</li>
</ol>
<div class="row">
	@if(!empty($subcategories))
		@foreach ($subcategories as $subcategory)
			<div class="col-xs-4">
				<a href="/subcategories/show/{{ $subcategory->id }}" class="thumbnail cat">
					{{ $subcategory->title }}
				</a>
			</div>
		@endforeach
	@endif
</div>
<hr>
<div class="secondary-content">
	<div class="row">
		<div class="col-xs-2">
			<h3>Sort By</h3>
			<a class="btn btn-primary btn-block" href="/categories/sort/latest/{{ $category->id }}">Latest</a>
			<a class="btn btn-primary btn-block" href="/categories/sort/name/{{ $category->id }}">Name</a>
		</div>

		<!--<div class="col-xs-1 col-md-1 vline"></div>-->

		<div class="col-xs-10">
			<h3>Templates</h3>
			<div class= "scrollable">
				@if(!empty($templates))
					@foreach($templates as $template)
						<a href="/templates/show/{{$template->id}}" class="btn btn-primary btn-block">
						  Title: {{$template->title}} - Version: {{$template->version}} - Updated: {{$template->updated_at}}
						</a>
					@endforeach
				@endif
			</div>
		</div>
	</div>
</div>
@stop