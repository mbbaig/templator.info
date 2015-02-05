<?php

class TemplatesController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('getCreate', 'getUpdate', 'getDelete', 'getCopy')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Responses
	 */
	public function getIndex()
	{
		/*$user = User::find(5);
		$user->password = Hash::make($user->password);
		$user->save();
		return $user;*/
		return View::make('templates.index')
		->with('templates', Template::where('visibility', '=', 'public')->orderBy('updated_at', 'desc')->get())
		->with('categories', Category::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$subcategories = array();

		foreach (Subcategory::all() as $subcategory) {
			$subcategories[$subcategory->id] = $subcategory->title;
		}

		return View::make('templates.create')
		->with('subcategories', $subcategories);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		$validator = Validator::make(Input::all(), Template::$rules);
		if($validator->passes()){
			$template= new Template;
			$template->ownerid = Auth::user()->id;
			$template->subcategoryid = Input::get('subcategory');
			$template->title = Input::get('title');
			$template->description = Input::get('description');
			$template->version= Input::get('version');
			$template->visibility= Input::get('visibility');

			$template->save();
			return Redirect::to('/templates/show/' . $template->id);
		}

		return Redirect::to('/templates/create')->withErrors($validator)->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		$template = Template::find($id);
		if ($template == null) {
			App::abort(404);
		} elseif ($template->visibility == 'private') {
			if (Auth::check() && Auth::user()->id == $template->ownerid) {
				//nothing to do here
			} else {
				return Redirect::to('/');
			}
		}

		$tasks = Task::where('templateid', '=', $id)->get();
		$summaries = array();
		$i = 0;
		foreach ($tasks as $task) {
			if (!in_array($task->summarytaskid, $summaries) && $task->summarytaskid !== null) {
				$summaries[$i] = $task->summarytaskid;
			}
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
			} else {
				$indentations[$i] = --$indents;
			}
		}

		return View::make('templates.show')
		->with('template', $template)
		->with('tasks', $tasks)
		->with('summaries', $summaries)
		->with('indentations', $indentations);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getUpdate($id)
	{
		$subcategories = array();

		foreach (Subcategory::all() as $subcategory) {
			$subcategories[$subcategory->id] = $subcategory->title;
		}

		return View::make('templates.update')
		->with('template', Template::find($id))
		->with('subcategories', $subcategories);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate()
	{
		$validator = Validator::make(Input::all(), Template::$rules);
		if($validator->passes()){
			$template = Template::find(Input::get('id'));
			$template->update(Input::all());
			return Redirect::to('/templates/show/' . Input::get('id'));
		}

		return Redirect::to('/templates/update/' . Input::get('id'))
		->withErrors($validator)
		->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$template = Template::find($id);
		$template->delete();
		return Redirect::to('/users/show/' . Auth::user()->id);
	}

	public function getCopy($id)
	{
		$template = Template::find($id);
		$templateCopy = new Template;
		$templateCopy->subcategoryid = $template->subcategoryid;
		$templateCopy->title = $template->title;
		$templateCopy->description = $template->description; 
		$templateCopy->version= $template->version;
		$templateCopy->visibility= $template->visibility;

		//Set ownerid and sourcetemplateid
		$templateCopy->ownerid = Auth::user()->id;
		$templateCopy->sourcetemplateid = $id;
		$templateCopy->save();

		$tasks = Task::where("templateid", '=', $id)->get();
		foreach ($tasks as $task) {
			$newTask = new Task;
			$newTask->taskid = $task->taskid;
			$newTask->title = $task->title;
			$newTask->note = $task->note;
			$newTask->duration = $task->duration;
			$newTask->summarytaskid = $task->summarytaskid;
			$newTask->templateid = $templateCopy->id;
			$newTask->predecessorids = $task->predecessorids;

			$newTask->save();
		}

		return Redirect::to('/users/show/' . Auth::user()->id);
	}

	public function postSearch()
	{
		if (null == Input::get('search')) {
			return Redirect::to('/');
		}
		$search_term = htmlspecialchars(Input::get('search'), ENT_QUOTES);
		return Redirect::to('/templates/search/' . $search_term);
		/*return View::make('templates.search')
		->with('search', $search_term)
		->with('categories', Category::all());*/
	}

	public function getSearch($search)
	{
		return View::make('templates.index')
		->with('templates', Template::where('title', 'LIKE', '%'. $search .'%')->get())
		->with('search', $search);
	}

	public function getDownload($id)
	{
		$template = Template::find($id);
		$tasks = Task::where('templateid', '=', $id)->get();

		$summaries = array();
		$i = 0;
		foreach ($tasks as $task) {
			if (!in_array($task->summarytaskid, $summaries) && $task->summarytaskid !== null) {
				$summaries[$i] = $task->summarytaskid;
			}
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
			} elseif ($sums[$i] !== null && $sums[$i] > $sums[$i-1]) {
				$indentations[$i] = ++$indents;
			} elseif ($sums[$i] == $sums[$i-1]) {
				$indentations[$i] = $indents;
			} else {
				$indentations[$i] = --$indents;
			}
		}

		$sheetTasks = array(array('ID', 'Task Mode', 'Name', 'Duration', 'Predecessors', 'Notes', 'Outline Level'));
		/*@if(in_array($task->taskid, $summaries))
			<td style="text-indent:{{ $task->summarytaskid }}em;"><strong>{{ $task->title }}</strong></td>
		@else
			<td style="text-indent:{{ $task->summarytaskid }}em;">{{ $task->title }}</td>
		@endif*/
		$i=0;
		foreach ($tasks as $task) {
			array_push($sheetTasks, array($task->taskid, 'Auto Scheduled', $task->title, $task->duration, $task->predecessorids, $task->note, $indentations[$i]+1));
			$i++;
		}
		$xls = Excel::create($template->title)
		->sheet('tasks')
		->with($sheetTasks);
		/*$excel = $xls->excel->getActiveSheet();
		$i = 2;
		$j = 0;
		foreach ($tasks as $task) {
			if (in_array($task->taskid, $summaries)) {
				$excel->getStyle('B'.$i)->getFont()->setBold(true);
				$excel->getStyle('B'.$i)->getAlignment()->setIndent($indentations[$j]);
			} else {
				$excel->getStyle('B'.$i)->getAlignment()->setIndent($indentations[$j]);
			}
			$i++;
			$j++;
		}*/
		
		$xls->export('xlsx');
	}

	public function getSort($value)
	{
		switch ($value) {
			case 'latest':
				return View::make('templates.index')
				->with('templates', Template::where('visibility', '=', 'public')->orderBy('updated_at', 'desc')->get())
				->with('categories', Category::all());
				break;
			default:
				return View::make('templates.index')
				->with('templates', Template::where('visibility', '=', 'public')->orderBy('title')->get())
				->with('categories', Category::all());
				break;
		}
	}
}
