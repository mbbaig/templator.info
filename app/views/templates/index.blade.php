@extends('layouts.main')
@section('content')
<div class="row">
	@if(isset($categories))
		@foreach ($categories as $category)
			<div class="col-xs-4">
				<a href="/categories/show/{{ $category->id }}" class="thumbnail cat">
					{{ $category->title }}
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
			<a class="btn btn-primary btn-block" href="/templates/sort/latest">Latest</a>
			<a class="btn btn-primary btn-block" href="/templates/sort/name">Name</a>
		</div>

		<!-- <div class="col-xs-1 vline"></div> -->

		<div class="col-xs-10">
			<h3>Templates</h3>
			<div class= "scrollable">
				@foreach($templates as $template)
				<a href="/templates/show/{{$template->id}}" class="btn btn-primary btn-block">
				  Title: {{$template->title}} - Version: {{$template->version}} - Updated: {{$template->updated_at}}
				</a>
				@endforeach
			</div>
		</div>

		<!--<div class="col-xs-1 col-md-1 vline"></div>-->
	</div>
</div>
@stop