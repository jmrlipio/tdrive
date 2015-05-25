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

    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'password', 'code', 'mobile_no', 'role', 'gender', 'birthday'];

    public static $rules = [
        'username'              => 'required|unique:users|min:6|max:10',
        'password'              => 'required|alpha_num|min:8|confirmed|max:64',
        'password_confirmation' => 'required|alpha_num|min:8|max:64',
        'first_name'            => 'required|min:2|alpha_spaces|max:255',
        'last_name'             => 'required|min:2|alpha_spaces|max:255',
        'email'                 => 'required|email|unique:users|max:255',
        'mobile_no'             => 'required|max:12',
        'gender'                => 'required',
        'birthday'              => 'required'
    ];

    public static $update_rules = [
        'first_name'            => 'required|alpha|min:2|max:255',
        'last_name'             => 'required|alpha|min:2|max:255',
        'email'                 => 'required|email|unique:users',
        'mobile_no'             => 'required'
    ];

    public static $update_details_rules = [
        'first_name'            => 'required|min:2|alpha_spaces|max:255',
        'last_name'             => 'required|min:2|alpha_spaces|max:255',
        'mobile_no'             => 'required',
        'gender'                => 'required',
        'birthday'              => 'required'
    ];

    public static $auth_rules = [
        'username' => 'required',
        'password' => 'required'
    ];

    public function authorization() {
        return $this->hasOne('Authorization');
    }

    public function news(){
        return $this->hasMany('News');
    }

    public function transactions(){
        return $this->hasMany('TRansaction');
    }

    public function games() {
        return $this->hasMany('Game');
    }

    public function game_prices() {
        return $this->belongsToMany('GamePrices', 'game_sales');
    }

    public static function is_member($user_id) 
    {
        $user = User::find($user_id);
        if($user && $user->role == 'member') 
        {
            return true;
        } 

        return false;
    }

    public function review() 
    {
        return $this->belongsToMany('Game', 'game_reviews');
    }

    public function sales() {

        return $this->belongsToMany('GamePrice', 'game_sales');
    }

    public static function updateLastLogin($id) 
    {
        $user = User::find($id);
        $user->last_login = Carbon::now();

        $user->save();

        return $user;
    }

}

