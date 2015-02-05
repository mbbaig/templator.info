<?php

class Subcategory extends Eloquent {
	protected $fillable = array('title');

	public static $rules = array('title' => 'required|min:2');

	public function templates() {
		return $this->hasMany('Template');
	}
}
