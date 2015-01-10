<?php

class Faq extends \Eloquent {
	protected $fillable = ['main_question','order'];

	public static $rules = [
        'main_question' => 'required|min:3|max:255',
        'order'	=> 'integer'
    ];

    public function languages() {
    	return $this->belongsToMany('Language', 'faq_languages')->withPivot('question', 'answer');
    }
}