<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Game extends \Eloquent {

	use TriplePivotTrait;

	protected $fillable = ['user_id','title','slug','status','featured','content','release_date','default_price','excerpt','downloads','default_price'];

	public static $rules = array(
		'user_id' => 'required|integer',
		'title' => 'required|min:2',
		'slug' => 'required|min:2',
		'status' => 'required|boolean',
		'featured' => 'required|boolean',
		'content' => 'required|min:20',
		'release_date' => 'required|date',
		'excerpt' => 'required',
		'downloads' => 'required|numeric',
		'default_price' => 'required|numeric',
	);

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
        return $this->tripleBelongsToMany('Carrier', 'Country', 'game_prices' )->withPivot('price');
    }

}