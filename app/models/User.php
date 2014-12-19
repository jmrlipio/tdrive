<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $fillable = ['username', 'first_name', 'last_name'];

	public static $rules = [
		'username'				=> 'required|unique:users|min:2',
		'password'              => 'required|alpha_num|between:8,12|confirmed',
        'password_confirmation' => 'required|alpha_num|between:8,12',
        'first_name' 			=> 'required|alpha|min:2',
        'last_name' 			=> 'required|alpha|min:2'
    ];

    public static $update_rules = [
        'first_name' 			=> 'required|alpha|min:2',
        'last_name' 			=> 'required|alpha|min:2'
    ];

    public static $auth_rules = [
        'username' => 'required',
        'password' => 'required'
    ];

    public function news(){
        return $this->hasMany('News');
    }

    public function games() {
    	return $this->hasMany('Game');
    }

    public function game_prices() {
        return $this->belongsToMany('GamePrices', 'game_sales');
    }
}
