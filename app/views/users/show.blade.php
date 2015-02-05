@extends('layouts.main')
@section('content')
	<div class="row">
		<a href="/users/edit" class="btn btn-info col-xs-4">Edit Account Details</a>
		<span class="col-xs-1"></span>
		<a href="/users/signout" class="btn btn-warning col-xs-4">Log out</a>
		<span class="col-xs-1"></span>
		<a class="btn btn-danger col-xs-2" data-toggle="modal" data-target=".modal-sm">Delete Account</a>
		<div class="modal fade modal-sm">
			<div class="modal-dialog modal-danger">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Danger</h4>
					</div>
					<div class="modal-body">
						All of your information will be <strong class="text-danger">Destroyed</strong>.  
						Including all your templates.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<a href="/users/delete/{{ Auth::user()->id }}" class="btn btn-danger">Delete</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-2">
			<h3>Sort By</h3>			
			<a class="btn btn-primary btn-block" href="/users/sort/latest">Latest</a>
			<a class="btn btn-primary btn-block" href="/users/sort/name">Name</a>
		</div>

		<!--<div class="col-xs-1 col-md-1 vline"></div>-->

		<div class="col-xs-8">
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

		<div class="col-xs-2">
			<h3>Actions</h3>
			<a href="/templates/create" class="btn btn-primary btn-block">Create Template</a>
			@if(Auth::user()->admin == 'y')
				<a href="/categories/create" class="btn btn-primary btn-block">Manage Categories</a>
			@endif
		</div>
	</div>

@stop