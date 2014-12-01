<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Country extends \Eloquent {

	use TriplePivotTrait;

	public function carriers(){
        return $this->belongsToMany('Carrier', 'country_carriers');
    }

    public function prices() {
        return $this->tripleBelongsToMany('Game', 'Carrier', 'game_prices' );
    }
}