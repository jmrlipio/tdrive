<?php

class News extends \Eloquent {
	protected $fillable = ['user_id','main_title','slug','status','news_category_id', 'featured_image'];

	public static $rules = [
		'user_id' => 'required|integer',
		'main_title' => 'required|min:2',
		'slug' => 'required|min:2',
		'status' => 'required',
		// 'release_date' => 'required|date',
		'news_category_id' => 'required|integer',
		'featured_image' => 'required'
	];

	public static $fieldRules = [
		'language_id' 	=> 'required'
	];

	public function keywords() {
		return $this->morphToMany('Keyword', 'keywordable');
	}

	public function languages() {
		return $this->morphToMany('Language', 'languagable');
	}

	public function comments() {
		return $this->belongsToMany('Comment', 'news_comments');
	}

	public function newsCategory() {
		return $this->belongsTo('NewsCategory');
	}

    public function contents() {
    	return $this->morphToMany('Language', 'contentable')->withPivot('title', 'content', 'excerpt');
    }

    public function sliders() {
    	return $this->morphMany('Slider', 'slideable');
    }
}
