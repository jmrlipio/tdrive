<?php

class Slider extends Eloquent {
	protected $table = 'slideables';

	protected $fillable = ['order'];

	public function slideable() {
		return $this->morphTo();
	}
}