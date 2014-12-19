<?php

class Faq extends \Eloquent {
	protected $fillable = ['question', 'answer','order'];

	public static $rules = [
        'question' => 'required|min:3|max:255',
        'answer' => 'required|min:3',
        'order'	=> 'integer'
    ];
}