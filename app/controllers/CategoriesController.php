<?php

class CategoriesController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('admin', array('only'=>array('getCreate', 'getEdit', 'getDelete')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('categories.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('categories.create')
		->with('categories', Category::all())
		->with('subcategories', Subcategory::all())
		->with('templates', Template::all());
	}

	public function postCreate()
	{
		$validator = Validator::make(Input::all(), Category::$rules);
		//return Input::get('title');
		if($validator->passes()){
			$category = new Category;
			$category->title = Input::get('title');

			$category->save();
			return Redirect::to('/categories/create');
		}

		return Redirect::to('/categories/create')
		->withErrors($validator)
		->withInput();
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
	public function getShow($id)
	{
		$subcategories = Subcategory::where('categoryid', '=', $id)->get();
		$subArray = $subcategories->toArray();
		if($subArray == null || empty($subArray) || !isset($subArray) || !$subArray) {
			return Redirect::to('/');
		}
		$subids = array();
		for ($i=0; $i < count($subcategories); $i++) {
			$subids[$i] = $subcategories[$i]->id;
		}
		$templates = Template::whereIn('subcategoryid', $subids)->where('visibility', '=', 'public')->orderBy('updated_at', 'desc')->get();
		return View::make('categories.show')
		->with('subcategories', $subcategories)
		->with('templates', $templates)
		->with('category', Category::find($id));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		return View::make('categories.edit')
		->with('category', Category::find($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate()
	{
		$validator = Validator::make(Input::all(), Category::$rules);
		if($validator->passes()){
			$category = Category::find(Input::get('id'));
			$category->update(Input::all());

			$category->save();
			return Redirect::to('/');
		}

		return Redirect::to('/categories/edit/' . Input::get('id'))->withErrors($validator)->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$subcategories = Subcategory::where('categoryid', '=', $id)->get();
		//dd($subcategories);
		if ($subcategories->isEmpty()) {
			$category = Category::find($id);
			$category->delete();
			return Redirect::to('/categories/create');
		}
		return View::make('categories.create')
		->with('categories', Category::all())
		->with('subcategories', Subcategory::all())
		->with('templates', Template::all())
		->with('message', 'Categories with Sub-Categories cannot be deleted');
	}

	public function getSort($value, $id)
	{
		$subcategories = Subcategory::where('categoryid', '=', $id)->get();
		$subArray = $subcategories->toArray();
		if($subArray == null || empty($subArray) || !isset($subArray) || !$subArray) {
			return Redirect::to('/');
		}
		$subids = array();
		for ($i=0; $i < count($subcategories); $i++) {
			$subids[$i] = $subcategories[$i]->id;
		}
		switch ($value) {
			case 'latest':
				$templates = Template::whereIn('subcategoryid', $subids)->where('visibility', '=', 'public')->orderBy('updated_at', 'desc')->get();
				return View::make('categories.show')
				->with('subcategories', $subcategories)
				->with('templates', $templates)
				->with('category', Category::find($id));
				break;
			default:
				$templates = Template::whereIn('subcategoryid', $subids)->where('visibility', '=', 'public')->orderBy('title')->get();
				return View::make('categories.show')
				->with('subcategories', $subcategories)
				->with('templates', $templates)
				->with('category', Category::find($id));
				break;
		}
	}
}
