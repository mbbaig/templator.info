<?php

class Task extends Eloquent {
	protected $fillable = array('title', 'note', 'duration', 'summarytaskid', 'predecessorids', 'ismilestone', 'issummarytask');

	public static $rules = array(
		'title' => 'required|min:2|max:50', 
		'note' => 'required|min:3|max:500', 
		'duration' => 'required|numeric'
	);

	public function template() {
		$this->belongsTo('Template');
	}
}
