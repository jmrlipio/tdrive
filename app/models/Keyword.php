<?php

class Keyword extends \Eloquent {
	protected $fillable = [];

	public function games()
    {
        return $this->morphedByMany('Game', 'keywordable');
    }

    public function news()
    {
        return $this->morphedByMany('News', 'keywordable');
    }


}