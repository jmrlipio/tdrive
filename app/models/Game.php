<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Game extends \Eloquent {

	use TriplePivotTrait;

	protected $fillable = ['user_id','main_title','slug','status','featured','release_date','default_price','downloads','image_orientation'];

	public static $rules = [
		'user_id' => 'required|integer',
		'main_title' => 'required|min:2|max:255',
		'slug' => 'required|min:2|max:255',
		'release_date' => 'required|date',
		'downloads' => 'required|numeric',
		'default_price' => 'required|numeric'
	];

	public static $content_rules = [
		'content' => 'max:10000'
	];

	public static $fieldRules = [
		'language_id' 	=> 'required',
		'category_id' => 'required'
	];

	public static $app_rules = [
		'title' => 'required|max:255',
		'content' => 'required|max:10000',
		'excerpt' => 'required',
		'price' => 'required|numeric'
	];

	public function user() {
		return $this->belongsTo('User');
	}

	public function categories() {
		return $this->belongsToMany('Category', 'game_categories');
	}

	public function media() {
		return $this->belongsToMany('Media', 'game_media')->withPivot('id');
	}

    public function sales() {
		return $this->belongsToMany('Carrier', 'sale_games');
	}

    public function apps() {
        return $this->tripleBelongsToMany('Carrier', 'Language', 'apps')->withPivot('carrier_id','language_id','app_id', 'price', 'title', 'content', 'excerpt', 'currency_code', 'status');
    }

    // public function prices() {
    //     return $this->tripleBelongsToMany('Carrier', 'Country', 'game_prices')->withPivot('price', 'carrier_id');
    // }

    public function contents() {
    	return $this->morphToMany('Language', 'contentable')->withPivot('language_id','title', 'content', 'excerpt', 'default');
    }

    public function review() {
    	return $this->belongsToMany('User', 'game_reviews')->withPivot('created_at', 'review', 'rating','status', 'user_id', 'id')->orderBy('pivot_created_at', 'desc');
    }

    public function discounts() {
    	return $this->belongsToMany('Discount', 'game_discounts');
    }

    public function sliders() {
    	return $this->morphMany('Slider', 'slideable');
    }

    public function app() {
        return $this->hasMany('GameApp');
    }

    public static function countPublishStatus($cat_id) 
    {
    	$games = Category::find($cat_id)->games;
    	$count = 0;
    	foreach($games as $game) 
    	{
    		foreach($game->apps as $app) 
    		{
    			if($app->pivot->status == Constant::PUBLISH) 
    			{
    				$count++;
    			}
    		}
    	}
    	return $count;
    }

    public static function getAppsPerCategory($cat_id, $limit = null) 
    {
        $category = Category::find($cat_id);
        $apps = array();
        foreach($category->games()->get() as $game) 
        {
            foreach($game->apps as $app) 
            {
                if(Language::getLangID(Session::get('locale')) == $app->pivot->language_id && $app->pivot->carrier_id == Session::get('carrier'))
                {
                    if($app->pivot->status == Constant::PUBLISH )
                        $apps[] = $app;
                }
            }
        }
        return $apps;
    }

    public static function getAllGames() 
    {
        $games_slide = [];
        $languages = Language::all();
        foreach(Game::all() as $game) { 
            foreach($game->apps as $app) {
                $iso_code = ''; 
                foreach($languages as $language){
                    if($language->id == $app->pivot->language_id){
                        $iso_code = strtolower($language->iso_code);
                    }
                }       

                /*THAI TEST*/
                //$iso_code = 'TH';

                foreach ($game->media as $media) {
                    if($media->type == 'homepage') {
                        if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier') && $app->pivot->status == Constant::PUBLISH) {                     
                            $games_slide[$game->id] = array(
                                'url' => $media->url, 
                                'title' => $game->main_title, 
                                'id' => $game->id,
                                'price' => $app->pivot->price,
                                'currency_code' => $app->pivot->currency_code,
                                'app_id' => $app->pivot->app_id);
                        }
                    }
                }
            }
        }
        return $games_slide;
    }
}
