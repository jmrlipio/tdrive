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

    public function gamecontent()
    {
        return $this->morphedByMany('Game', 'contentable');
    }

    public function newscontent()
    {
        return $this->morphedByMany('News', 'contentable');
    }

}