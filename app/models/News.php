<?php

class News extends \Eloquent {
	protected $fillable = ['user_id','main_title','slug','status','news_category_id','release_date'];

	public static $rules = array(
		'user_id' => 'required|integer',
		'main_title' => 'required|min:2',
		'slug' => 'required|min:2',
		'status' => 'required|boolean',
		'release_date' => 'required|date',
		'news_category_id' => 'required|integer'
	);

	public function keywords() {
		return $this->morphToMany('Keyword', 'keywordable');
	}

	public function languages() {
		return $this->morphToMany('Language', 'languagable');
	}

	public function media() {
		return $this->morphToMany('Media', 'mediable')->withPivot('type');
	}

	public function comments() {
		return $this->belongsToMany('Comment', 'news_comments');
	}

	public function newsCategory() {
		return $this->belongsTo('NewsCategory');
	}
}