<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Carrier extends \Eloquent {

	use TriplePivotTrait;
	
	protected $fillable = ['id','carrier','language_id'];

	public static $rules = [
		'id' => 'required|integer|unique:carriers',
        'carrier' => 'required|min:3|unique:carriers|max:255',
        'language_id' => 'required'
    ];

	public function countries() {
		return $this->belongsToMany('Country', 'country_carriers')->withPivot('id');
	}

	public function games() {
		return $this->hasMany('Game');
	}

	/**
     * @return \Jarektkaczyk\TriplePivot\TripleBelongsToMany
     */
    public function prices() {
        return $this->tripleBelongsToMany('Game', 'Country', 'game_prices' )->withPivot('price');
    }

    public function apps() {
        return $this->tripleBelongsToMany('Game', 'Language', 'apps')->withPivot('price', 'title', 'content', 'excerpt');
    }

    public function discounts() {
    	return $this->hasMany('Discounts');
    }

    public function language() {
    	return $this->belongsTo('Language');
    }

    public static function getCarriers($game_id){
        $game = Game::find($game_id);
        $carriers = array();

        foreach ($game->apps as $app) {
            if($app->pivot->status == Constant::PUBLISH )
            {
                $carriers[] = array(
                    'carrier_name' => $app->pivot->carrier,
                    'id' => $app->pivot->carrier_id,
                    'language' => $app->pivot->language_id
                    );
            }
        }
        return $carriers;

    }

	// public function sales() {
	// 	return $this->belongsToMany('Game', 'sale_games');
	// }
}
