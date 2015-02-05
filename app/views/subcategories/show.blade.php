@extends('layouts.main')
@section('content')
<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/categories/show/{{ $category->id }}">{{ $category->title }}</a></li>
	<li class="active">{{ $subcategory->title }}</li>
</ol>
<div class="secondary-content">
	<div class="row">
		<div class="col-xs-2">
			<h3>Sort By</h3>
			<a class="btn btn-primary btn-block" href="/subcategories/sort/latest/{{ $subcategory->id }}">Latest</a>
			<a class="btn btn-primary btn-block" href="/subcategories/sort/name/{{ $subcategory->id }}">Name</a>
		</div>

		<!--<div class="col-xs-1 col-md-1 vline"></div>-->

			<div class="col-xs-10">
			<h3>Templates</h3>
			<div class= "scrollable">
				@foreach($templates as $template)
					<a href="/templates/show/{{$template->id}}" class="btn btn-primary btn-block">
						{{$template->title}} - {{$template->version}} - {{$template->updated_at}}
					</a>
				@endforeach
			</div>
		</div>
	</div>
</div>
@stop