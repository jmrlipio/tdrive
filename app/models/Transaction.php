<?php

class Transaction extends \Eloquent {
    protected $table = 'transactions';
	protected $fillable = ["user_id", "app_id", "transaction_id", "receipt_id", "status"];

    public function user() {
        return $this->belongsTo('User');
    }

    public function app() {
        return $this->belongsTo('GameApp', 'app_id', 'app_id');
    }

}