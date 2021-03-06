<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Game extends \Eloquent {

	use TriplePivotTrait;

	protected $fillable = ['id','user_id','carrier_id','main_title','slug','status','featured','release_date','default_price','downloads','default_price','category_id','image_orientation'];

	public static $rules = [
		'id' => 'required|integer|unique:games',
		'user_id' => 'required|integer',
		'carrier_id' => 'required|integer',
		'main_title' => 'required|min:2|unique:games',
		'slug' => 'required|min:2',
		'featured' => 'required|boolean',
		'release_date' => 'required|date',
		'downloads' => 'required|numeric',
		'default_price' => 'required|numeric'
	];

	public static $fieldRules = [
		'language_id' 	=> 'required',
		'category_id' => 'required'
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function categories() {
		return $this->belongsToMany('Category', 'game_categories');
	}

	public function carrier() {
		return $this->belongsTo('Carrier');
	}

	public function media() {
		return $this->belongsToMany('Media', 'game_media')->withPivot('id');
	}

    public function languages()
    {
        return $this->morphToMany('Language', 'languagable');
    }

    public function sales() {
		return $this->belongsToMany('Carrier', 'sale_games');
	}

	public function prices() {
        return $this->tripleBelongsToMany('Carrier', 'Country', 'game_prices')->withPivot('price', 'carrier_id');
    }

    public function contents() {
    	return $this->morphToMany('Language', 'contentable')->withPivot('title', 'content', 'excerpt');
    }

    public function review() {
    	return $this->belongsToMany('User', 'game_reviews')->withPivot('created_at', 'review', 'rating','status')->orderBy('pivot_created_at', 'desc');
    }

    public function discounts() {
    	return $this->belongsToMany('Discount', 'game_discounts');
    }

}
