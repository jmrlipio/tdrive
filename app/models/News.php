<?php

class News extends \Eloquent {
	protected $fillable = ['user_id','title','excerpt','status','content','news_category_id'];

	public static $rules = array(
		'user_id' => 'required|integer',
		'title' => 'required|min:2',
		'excerpt' => 'required|min:20',
		'status' => 'required|boolean',
		'content' => 'required|min:20',
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
		return $this->morphToMany('Media', 'mediable');
	}

	public function comments() {
		return $this->belongsToMany('Comment', 'news_comments');
	}

	public function newsCategory() {
		return $this->belongsTo('NewsCategory');
	}
}