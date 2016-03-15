<?php

use Jarektkaczyk\TriplePivot\TriplePivotTrait;

class Language extends \Eloquent {
    /*protected $fillable = ['language','iso_code'];*/  
   /* public static $rules = [
        'language' => 'required|min:3|unique:languages|max:255',
        'iso_code' => 'required|min:2',
    ];*/
    protected $fillable = ['language'];
    public static $rules = [
        'language' => 'required|min:3|unique:languages|max:255',
    ];


    public function games()
    {
        return $this->morphedByMany('Game', 'languagable');
    }

    public function news()
    {
        return $this->belongsToMany('News', 'news_content');
    }

    public function gamecontent()
    {
        return $this->morphedByMany('Game', 'contentable');
    }

    public function newscontent()
    {
        return $this->morphedByMany('News', 'contentable');
    }

    public function faqs() {
        return $this->belongsToMany('Faq', 'faq_languages');
    }

    public function carriers() {
        return $this->hasMany('Carrier');
    }

    public function apps() {
        return $this->tripleBelongsToMany('Game', 'Carrier', 'apps')->withPivot('price', 'title', 'content', 'excerpt');
    }

    public static function getLangID($locale) 
    {
        try
        {
            $id = Language::where('iso_code', '=', $locale)->first();
            return $id->id;
        }
        catch(Exception $e) { }
        
    }

    public static function getVariant($cat_id, $lang_id) 
    {
        $variant = DB::table('category_languages')
                        ->where('category_id', $cat_id)
                        ->where('language_id', Language::getLangID($lang_id))
                        ->first();
        if($variant) 
        {
            return $variant->variant;
        }
        else 
        {
            $variant = DB::table('category_languages')
                        ->where('category_id', $cat_id)
                        ->where('language_id', Language::getLangID('en'))
                        ->first();
            return $variant->variant;
        }
        return false;
    }

    public static function getLanguage($cid) 
    {

        // $games = Game::whereHas('apps', function($q) use ($cid)
        // {
        //     $q->where('carrier_id', '=', $cid);

        // })->get();

        $carrier = Carrier::find($cid);
        $apps = GameApp::where('carrier_id',$cid)->get();
        $arr_id = [];

        // foreach($games as $game){                               
            foreach($apps as $app) {
                if($app->status == Constant::PUBLISH && $app->game->status == 'live') 
                {
                    $arr_id[] = $app->language_id;
                }
            }
        // }

        $lang_id = array_unique($arr_id);
        $output = Language::whereIn('id', $lang_id)->get();
        
        if(count($output)==0 && $carrier)
        {
            $output[] = Language::find($carrier->language_id);
        }

        return $output;
    }
}