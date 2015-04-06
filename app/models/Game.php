<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Game extends \Eloquent {

	use TriplePivotTrait;

	protected $fillable = ['user_id','main_title','slug','status','featured','release_date','default_price','downloads','image_orientation'];

	public static $rules = [
		'user_id' => 'required|integer',
		'main_title' => 'required|min:2',
		'slug' => 'required|min:2',
		'release_date' => 'required|date',
		'downloads' => 'required|numeric',
		'default_price' => 'required|numeric'
	];

	public static $content_rules = [
		'content' => 'max:1000'
	];

	public static $fieldRules = [
		'language_id' 	=> 'required',
		'category_id' => 'required'
	];

	public static $app_rules = [
		'title' => 'required',
		'content' => 'required|max:1000',
		'excerpt' => 'required',
		'price' => 'required|numeric'
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

    public function apps() {
        return $this->tripleBelongsToMany('Carrier', 'Language', 'apps')->withPivot('carrier_id','language_id','app_id', 'price', 'title', 'content', 'excerpt', 'currency_code');
    }

    public function contents() {
    	return $this->morphToMany('Language', 'contentable')->withPivot('language_id','title', 'content', 'excerpt', 'default');
    }

    public function review() {
    	return $this->belongsToMany('User', 'game_reviews')->withPivot('created_at', 'review', 'rating','status')->orderBy('pivot_created_at', 'desc');
    }

    public function discounts() {
    	return $this->belongsToMany('Discount', 'game_discounts');
    }

    public function sliders() {
    	return $this->morphMany('Slider', 'slideable');
    }

}
