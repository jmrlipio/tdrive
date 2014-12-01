<?php

class Language extends \Eloquent {
	protected $fillable = ['language'];

    public static $rules = [
        'language' => 'required|min:3|unique:languages',
    ];

	public function games()
    {
        return $this->morphedByMany('Game', 'languagable');
    }

    public function news()
    {
        return $this->morphedByMany('News', 'languagable');
    }

}