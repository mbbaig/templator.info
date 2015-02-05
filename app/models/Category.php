<?php

class Category extends Eloquent {
	protected $fillable = array('title');

	public static $rules = array('title' => 'required|min:2|max:50');

	public function subcategories() {
		return $this->hasMany('Subcategory');
	}
}
