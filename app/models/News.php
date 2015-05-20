<?php

class News extends \Eloquent {
	protected $fillable = ['user_id','main_title','slug','status','news_category_id', 'featured_image', 'homepage_image'];

	public static $rules = [
		'user_id' => 'required|integer',
		'main_title' => 'required|min:2|max:255',
		'slug' => 'required|min:2|max:255',
		'status' => 'required',
		'news_category_id' => 'required|integer',
		'featured_image' => 'required',
		'homepage_image' => 'required'
	];

	public static $content_rules = [
		'title' => 'required|min:2|max:255',
		'content' => 'required|max:2000',
		'excerpt' => 'required|max:255'
	];

	public static $fieldRules = [
		'language_id' 	=> 'required'
	];

	public function keywords() {
		return $this->morphToMany('Keyword', 'keywordable');
	}

	public function languages() {
		return $this->BelongsToMany('Language', 'news_contents')->withPivot('language_id', 'title', 'content', 'excerpt');
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

     public static function getNewsByLang($id, $lang) {
    	$news = News::find($id);
    	foreach($news->languages as $content) :
			if($lang == $content->iso_code) :
				return $content;
			endif;
		endforeach;
			return false;
    }
}
