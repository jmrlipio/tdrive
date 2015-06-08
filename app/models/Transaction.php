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

    public static function checkPurchased($id) 
    {
    	if(Auth::check()) 
    	{
    		$has_purchased = Transaction::where('user_id', '=', Auth::user()->id )
    									->where('status', '=', '1')
    									->where('app_id', '=', $id)
    									->first();
    		if(!$has_purchased) 
    		{
    			return false;
    		}

    		return $has_purchased;
    	}
    	return false;
    }

    public static function saveTransaction($data) 
    {
    	$transaction = Transaction::where('transaction_id', '=', $data['transaction_id'])
    								->first();
    	if(!$transaction) 
    	{
    		$_transaction = new Transaction;
    		$_transaction->transaction_id = $data['transaction_id'];
    		$_transaction->user_id = $data['user_id'];
    		$_transaction->app_id = $data['app_id'];
    		$_transaction->receipt_id = $data['receipt_id'];
    		$_transaction->status = $data['status'];
    		$_transaction->save();
    		return $_transaction;
    	}

    	return $transaction;
    }


}