<?php

class Game extends \Eloquent {
	protected $fillable = ['user_id','name','description','price','release_date','type_id'];

	public static $rules = array(
		'user_id' => 'required|integer',
		'name' => 'required|min:2',
		'description' => 'required|min:20',
		'price' => 'required|numeric',
		'release_date' => 'required|date',
		'type_id' => 'required|integer'
	);

	public function user() {
		return $this->belongsTo('User');
	}

	public function type() {
		return $this->belongsTo('GameType');
	}

	public function image() {
		return $this->morphMany('Image', 'imageable');
	}
}