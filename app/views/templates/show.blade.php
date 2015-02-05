@extends('layouts.main')
@section('content')

	<strong>Title: </strong>{{ $template->title }}<br>
	<strong>Description: </strong>{{ $template->description }}<br>
	<strong>Version: </strong>{{ $template->version }}<br>
	<strong>Visibility: </strong>{{ $template->visibility }}<br>
	<strong>Date Created: </strong>{{ $template->created_at }}<br>
	<strong>Date Updated: </strong>{{ $template->updated_at }}<br>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Task ID</th>
					<th>Title</th>
					<th>Duration</th>
					<th>Predecessor IDs</th>
					<th>Note</th>
					<th>Summary task IDs</th>
				</tr>
			</thead>
			<tbody>
				@if($tasks->isEmpty())
					<tr style="text-align:center;"><td colspan=6><h4>There are no tasks</h4></td></tr>
				@else
					<?php $i = 0; ?>
					@foreach ($tasks as $task)
						<tr>
							<td>{{ $task->taskid }}</td>
							@if(in_array($task->taskid, $summaries))
								<td style="text-indent:{{ $indentations[$i] }}em;"><strong>{{ $task->title }}</strong></td>
							@else
								<td style="text-indent:{{ $indentations[$i] }}em;">{{ $task->title }}</td>
							@endif
							<td>{{ $task->duration }}</td>
							<td>{{ $task->predecessorids }}</td>
							<td>{{ $task->note }}</td>
							<td>{{ $task->summarytaskid }}</td>
						</tr>
						<?php $i++; ?>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
	<br><br>
	@if(Auth::check() && $template->ownerid == Auth::user()->id)
		<a class="btn btn-danger" data-toggle="modal" data-target=".modal-sm">Delete</a>
		<a href="/templates/update/{{ $template->id }}" class="btn btn-info">Edit Template</a>
		@if($tasks->isEmpty())
			<a href="/tasks/create/{{ $template->id }}" class="btn btn-primary">Add Tasks</a>
		@else
			<a href="/tasks/update/{{ $template->id }}" class="btn btn-primary">Update Tasks</a>
		@endif
	@endif

	<a href="/templates/download/{{ $template->id }}" class="btn btn-primary">Download</a>
	<a href="/templates/copy/{{ $template->id }}" class="btn btn-primary">Copy</a>

	<div class="modal fade modal-sm">
		<div class="modal-dialog modal-danger">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Danger</h4>
				</div>
				<div class="modal-body">
					All template information will be <strong class="text-danger">deleted</strong>.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<a href="/templates/delete/{{ $template->id }}" class="btn btn-danger">Delete</a>
				</div>
			</div>
		</div>
	</div>
	
@stop