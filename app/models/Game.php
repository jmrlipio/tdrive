<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Game extends \Eloquent {

	use TriplePivotTrait;

	protected $fillable = ['user_id','main_title','slug','status','featured','release_date','default_price','downloads','default_price','category_id'];

	public static $rules = [
		'user_id' => 'required|integer',
		'main_title' => 'required|min:2|unique:games',
		'slug' => 'required|min:2',
		'status' => 'required|boolean',
		'featured' => 'required|boolean',
		'release_date' => 'required|date',
		'downloads' => 'required|numeric',
		'default_price' => 'required|numeric'
	];

	public static $fieldRules = [
		'language_id' 	=> 'required',
		'carrier_id'	=> 'required',
		'category_id' => 'required'
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function categories() {
		return $this->belongsToMany('Category', 'game_categories');
	}

	public function carriers() {
		return $this->belongsToMany('Carrier', 'game_carriers');
	}

	public function media() {
		return $this->morphToMany('Media', 'mediable')->withPivot('type', 'id');
	}

    public function languages()
    {
        return $this->morphToMany('Language', 'languagable');
    }

    public function sales() {
		return $this->belongsToMany('Carrier', 'sale_games');
	}

	public function prices() {
        return $this->tripleBelongsToMany('Carrier', 'Country', 'game_prices' )->withPivot('price');
    }

    public function contents() {
    	return $this->morphToMany('Language', 'contentable')->withPivot('title', 'content', 'excerpt');
    }

}