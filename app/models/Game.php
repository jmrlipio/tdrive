<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Game extends \Eloquent {

	use TriplePivotTrait;

	protected $fillable = ['user_id','title','slug','status','featured','content','release_date'];

	public static $rules = array(
		'user_id' => 'required|integer',
		'title' => 'required|min:2',
		'slug' => 'required|min:2',
		'status' => 'required|boolean',
		'featured' => 'required|boolean',
		'content' => 'required|min:20',
		'release_date' => 'required|date',
		'default_price' => 'required|numeric'
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
		return $this->morphToMany('Media', 'mediable');
	}

	public function keywords()
    {
        return $this->morphToMany('Keyword', 'keywordable');
    }

    public function languages()
    {
        return $this->morphToMany('Language', 'languagable');
    }

    public function sales() {
		return $this->belongsToMany('Carrier', 'sale_games');
	}

	public function prices() {
        return $this->tripleBelongsToMany('Carrier', 'Country', 'game_prices' );
    }
}