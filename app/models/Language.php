<?php

class Language extends \Eloquent {
	protected $fillable = [];

	public function games()
    {
        return $this->morphedByMany('Game', 'languagable');
    }

    public function news()
    {
        return $this->morphedByMany('News', 'languagable');
    }
}