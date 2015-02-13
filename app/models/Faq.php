<?php

class Faq extends \Eloquent {
	protected $fillable = ['main_question','order'];

	public static $rules = [
        'main_question' => 'required|min:3|max:255',
        'order'	=> 'integer'
    ];

    public function languages() {
    	return $this->BelongsToMany('Language', 'faq_languages')->withPivot('language_id','answer','question','default');
    }

}