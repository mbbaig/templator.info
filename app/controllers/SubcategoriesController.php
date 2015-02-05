<?php

class SubcategoriesController extends BaseController {

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
		return View::make('subcategories.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return View::make('subcategories.create');
	}

	public function postCreate()
	{
		$validator = Validator::make(Input::all(), Subcategory::$rules);
		//return Input::get('title');
		if($validator->passes()){
			$subcategory = new Subcategory;
			$subcategory->title = Input::get('title');
			$subcategory->categoryid = Input::get('catid');
			$subcategory->save();
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
		$subcategory = Subcategory::find($id);
		return View::make('subcategories.show')
		->with('templates', Template::where('subcategoryid', '=', $id)->where('visibility', '=', 'public')->orderBy('updated_at', 'desc')->get())
		->with('subcategory', $subcategory)
		->with('category', Category::where('id', '=', $subcategory->categoryid)->firstOrFail());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		return View::make('subcategories.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$tmeplates = Template::where('subcategoryid', '=', $id)->get();
		//dd($subcategories);
		if ($tmeplates->isEmpty()) {
			$category = Subcategory::find($id);
			$category->delete();
			return Redirect::to('/categories/create');
		}
		return View::make('categories.create')
		->with('categories', Category::all())
		->with('subcategories', Subcategory::all())
		->with('templates', Template::all())
		->with('message', 'Sub-Categories with Templates cannot be deleted');
	}

	public function getSort($value, $id)
	{
		$subcategory = Subcategory::find($id);
		switch ($value) {
			case 'latest':
				return View::make('subcategories.show')
				->with('templates', Template::where('subcategoryid', '=', $id)->where('visibility', '=', 'public')->orderBy('updated_at', 'desc')->get())
				->with('subcategory', $subcategory)
				->with('category', Category::where('id', '=', $subcategory->categoryid)->firstOrFail());
				break;
			default:
				return View::make('subcategories.show')
				->with('templates', Template::where('subcategoryid', '=', $id)->where('visibility', '=', 'public')->orderBy('title')->get())
				->with('subcategory', $subcategory)
				->with('category', Category::where('id', '=', $subcategory->categoryid)->firstOrFail());
				break;
		}
	}

}
