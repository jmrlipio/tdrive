<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

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

    public function faqs() {
        return $this->belongsToMany('Faq', 'faq_languages');
    }

    public function carriers() {
        return $this->hasMany('Carrier');
    }

    public function apps() {
        return $this->tripleBelongsToMany('Game', 'Carrier', 'apps')->withPivot('price', 'title', 'content', 'excerpt');
    }

}