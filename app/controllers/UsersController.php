<?php

class UsersController extends BaseController {

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth', array('only'=>array('getSignout', 'getShow', 'getEdit', 'getDelete')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        return View::make('users.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreatefb()
	{
        $facebook = new Facebook(Config::get('facebook'));
    	$params = array(
        	'redirect_uri' => url('users/callbackfb'),
        	'scope' => 'email',
    	);
    	return Redirect::to($facebook->getLoginUrl($params));
	}

	public function getCallbackfb(){
		$code = Input::get('code');
	    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'An error occured when attempting to communicate with Facebook');
	 
	    $facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();
	 
	    if ($uid == 0) return Redirect::to('/')->with('message', 'An error occured');
	 
	    $me = $facebook->api('/me');
	    
	    $data = User::where("email", "=", $me["email"])->first();

	    if($data !== null && $me["email"] == $data->email){
	    	Auth::login($data);
	    	return Redirect::intended('/users/show/' . Auth::user()->id);
	    }
		else{
			$user = new User;
			$user->firstname = $me["first_name"];
			$user->lastname = $me["last_name"];	
			$user->email = $me["email"];
			$user->password = Hash::make($me["id"]);
			$user->save();
			Auth::login($user);
			return Redirect::intended('/users/show/' . Auth::user()->id);
		}
	}	

	public function getCreate()
	{
        return View::make('users.create');
	}

	public function postCreate()
	{
		$validator = Validator::make(Input::all(), User::$rules);

		if($validator->passes()) {
			$user = new User;
			$user->firstname = Input::get('firstname');
			$user->lastname = Input::get('lastname');	
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();
			Auth::login($user);
			return Redirect::intended('/users/show/' . Auth::user()->id);
		}
		return Redirect::to('/users/create')
		->withErrors($validator)
		->withInput();
	}

	public function postSignin() {
		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
			return Redirect::intended('/users/show/' . Auth::user()->id);
		}

		return Redirect::to('/users/index')
		->withErrors(array('Incorrect credentials'))
		->withInput();
	}

	public function getSignout()
	{
		Auth::logout();
		return Redirect::to('/');
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
        return View::make('users.show')
        ->with('templates', Template::where('ownerid', '=', $id)->get());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit()
	{
        return View::make('users.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postUpdate()
	{
		$merge = array_merge(
			User::$rules, 
			array(
				'password_previous' => 'required|alpha_num|between:6,12',
				'email' => 'required|email'
			)
		);
		$validator = Validator::make(Input::all(), $merge);

		if($validator->passes()) {
			if(Hash::check(Input::get('password_previous'), Auth::user()->password)) {
				$user = User::find(Auth::user()->id);
				$user->firstname = Input::get('firstname');
				$user->lastname = Input::get('lastname');	
				$user->email = Input::get('email');
				$user->password = Hash::make(Input::get('password'));
				$user->save();
				return Redirect::to('/users/show/' . Auth::user()->id);
			} else {
				return Redirect::to('/users/edit')
				->withErrors(array('Previous password must match'))
				->withInput();
			}
		}
		return Redirect::to('/users/edit')
		->withErrors($validator)
		->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete()
	{
		$user = User::find(Auth::user()->id);
		$user->delete();
		return Redirect::to('/');
	}

	public function getSort($value)
	{
		switch ($value) {
			case 'latest':
				return View::make('users.show')
				->with('templates', Template::where('ownerid', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->get());
				break;
			default:
				return View::make('users.show')
				->with('templates', Template::where('ownerid', '=', Auth::user()->id)->orderBy('title')->get());
				break;
		}
	}

}
