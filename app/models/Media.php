<?php

class Media extends \Eloquent {
	protected $table = 'media';

	protected $fillable = ['media_url'];

	public static $rules = [
		'media_url' => 'required|image|mimes:jpeg,jpg,bmp,png,gif'
	];

	public function games()
    {
        return $this->morphedByMany('Game', 'mediable');
    }

    public function news()
    {
        return $this->hasMany('News');
    }
}