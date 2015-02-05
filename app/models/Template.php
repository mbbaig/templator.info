<?php

class Template extends Eloquent {
	protected $fillable = array('title', 'description', 'version', 'visibility');
	public static $rules = array(
		'title' => 'required|min:2|max:50', 
		'description' => 'required|min:3|max:500', 
		'version' => 'required|max:30'
	);
	public function tasks()
	{
		return $this->hasMany('Task');
	}
	public function category() {
		return $this->belongsTo('Category');
	}
}