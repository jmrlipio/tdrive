<?php

class Media extends \Eloquent {
	protected $table = 'media';

	protected $fillable = ['url', 'type'];

	public static $rules = [
		'media_url' => 'required|image|mimes:jpeg,jpg,bmp,png,gif'
	];

	public function games()
    {
        return $this->belongsToMany('Game', 'game_media');
    }

}
