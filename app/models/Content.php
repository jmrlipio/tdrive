<?php

class Content extends \Eloquent {
	protected $table = 'languages';

	protected $fillable = ['title', 'content', 'excerpt'];

	public function games()
    {
        return $this->morphedByMany('Game', 'contentable');
    }

    public function news()
    {
        return $this->morphedByMany('News', 'contentable');
    }
}