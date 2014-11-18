<?php

class News extends \Eloquent {
	protected $fillable = [];

	public function keywords() {
		return $this->morphToMany('Keyword', 'keywordable');
	}

	public function languages() {
		return $this->morphToMany('Keyword', 'languagable');
	}

	public function media() {
		return $this->morphToMany('Keyword', 'mediable');
	}

	public function comments() {
		return $this->belongsToMany('Comment', 'news_comments');
	}
}