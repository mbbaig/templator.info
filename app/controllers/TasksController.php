<?php

class TasksController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('getCreate', 'getUpdate', 'getDelete')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return View::make('tasks.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate($id)
	{
		$template = Template::find($id);

		if(Auth::user()->id == $template->ownerid){
			return View::make('tasks.create')
			->with('template', Template::find($id));
		}
		return Redirect::to('/');
	}

	public function postCreate($id)
	{
		$template = Template::find($id);
		$durationType = Input::get('durationType');
		$allInput = Input::get('data');
		$taskid = 1;
		foreach ($allInput as $task) {
			if ($task[0] !== "") {
				$newTask = new Task;
				$newTask->taskid = $taskid;
				$newTask->title = $task[0];
				if ($durationType) {
					$newTask->duration = $task[1] . " h";
				} else {
					$newTask->duration = $task[1] . " d";
				}
				$newTask->predecessorids = $task[2];
				$newTask->note = $task[3];
				$newTask->summarytaskid = (intval($task[4]) == 0) ? null : intval($task[4]) ;
				$newTask->templateid = $id;
				$newTask->save();
			}
			$taskid++;
		}
		$template->touch();
		return Response::json($allInput);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return View::make('tasks.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getUpdate($id)
	{
		$tasks = Task::where('templateid', '=', $id)->get();

		$summaries = array();
		$i = 0;	
		$isChecked = false;
		if (strpos($tasks[0]->duration, " h") !== false) {
			$isChecked = true;
		} else {
			$isChecked = false;
		}
		foreach ($tasks as $task) {
			if (!in_array($task->summarytaskid, $summaries) && $task->summarytaskid !== null) {
				$summaries[$i] = $task->summarytaskid;
			}
			$task->duration = str_replace([" d", " h"], "", $task->duration);
			$task->duration = intval($task->duration);
			$i++;
		}

		$indentations = array();
		$sums = $tasks->fetch('summarytaskid');
		$its = count($sums);
		$indents = 0;
		for ($i=0; $i < $its; $i++) { 
			if($sums[$i] == null) {
				$indents = 0;
				$indentations[$i] = $indents;
			} elseif ($sums[$i] > $sums[$i-1]) {
				$indentations[$i] = ++$indents;
			} elseif ($sums[$i] == $sums[$i-1]) {
				$indentations[$i] = $indents;
			} elseif ($sums[$i] < $sums[$i-1]) {
				$indentations[$i] = --$indents;
			}

			if(in_array($tasks[$i]->taskid, $summaries)) {
				$tasks[$i]->title = "<b>" . $tasks[$i]->title . "</b>";
			}
		}

		for ($i=0; $i < $its; $i++) { 
			$tasks[$i]->title = str_repeat("<indent>", $indentations[$i]) . $tasks[$i]->title . str_repeat("</indent>", $indentations[$i]);
		}
		return View::make('tasks.edit')
		->with('template', Template::find($id))
		->with('tasks', $tasks)
		->with('isChecked', $isChecked);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate($id)
	{
		Task::where('templateid', '=', $id)->delete();
		$template = Template::find($id);

		$allInput = Input::get('data');
		$durationType = Input::get('durationType');
		$taskid = 1;
		foreach ($allInput as $task) {
			if ($task[0] !== "") {
				$newTask = new Task;
				$newTask->taskid = $taskid;
				$newTask->title = $task[0];
				if ($durationType) {
					$newTask->duration = $task[1] . " h";
				} else {
					$newTask->duration = $task[1] . " d";
				}
				$newTask->predecessorids = $task[2];
				$newTask->note = $task[3];
				$newTask->summarytaskid = (intval($task[4]) == 0) ? null : intval($task[4]) ;
				$newTask->templateid = $id;
				$newTask->save();
			}
			$taskid++;
		}
		$template->touch();
		return Response::json($allInput);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		//
	}

}
