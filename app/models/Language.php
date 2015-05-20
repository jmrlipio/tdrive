<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Language extends \Eloquent {
	protected $fillable = ['language','iso_code'];
    public static $rules = [
        'language' => 'required|min:3|unique:languages|max:255',
        'iso_code' => 'required|min:2',
    ];

	public function games()
    {
        return $this->morphedByMany('Game', 'languagable');
    }

    public function news()
    {
        return $this->belongsToMany('News', 'news_content');
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

    public static function getLangID($locale) 
    {
        $id = Language::where('iso_code', '=', $locale)
                        ->first();
        return $id->id;
    }

}