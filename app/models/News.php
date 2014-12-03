<?php

class News extends \Eloquent {
	protected $fillable = [];

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