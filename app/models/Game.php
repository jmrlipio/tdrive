<?php

class Game extends \Eloquent {
	protected $fillable = ['user_id','name','description','price','release_date','type_id'];

	public static $rules = array(
		'user_id' => 'required|integer',
		'name' => 'required|min:2',
		'description' => 'required|min:20',
		'price' => 'required|numeric',
		'release_date' => 'required|date',
		'type_id' => 'required|integer'
	);

	public function user() {
		return $this->belongsTo('User');
	}

	public function categories() {
		return $this->belongsToMany('Category', 'game_categories');
	}

	public function platforms() {
		return $this->belongsToMany('Platform', 'game_platforms');
	}

	public function currencies() {
		return $this->belongsToMany('Currency', 'game_currencies');
	}

	public function media() {
		return $this->morphToMany('Media', 'imageable');
	}

	public function keywords()
    {
        return $this->morphToMany('Keyword', 'keywordable');
    }

    public function languages()
    {
        return $this->morphToMany('Language', 'languagable');
    }
}