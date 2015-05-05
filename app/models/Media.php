<?php

class Media extends \Eloquent {
	protected $table = 'media';

	protected $fillable = ['url', 'type'];

	public static $rules = [
		'media_url' => 'required|image|mimes:jpeg,jpg,bmp,png,gif'
	];

	public function games()
    {
        return $this->belongsToMany('Game', 'game_media');
    }


    public static function getGameIcon($game_id) 
	{
		$game = Game::find($game_id);

		foreach($game->media as $icon) 
		{
			if($icon->type == 'icons') 
			{
				return $icon->url;
			}
		}

		return null;
	}

	public static function getGameImages($game_id, $type) 
	{
		$game = Game::find($game_id);

		foreach($game->media as $icon) 
		{
			if($icon->type == $type) 
			{
				return $icon;
			}
		}

		return null;
	}

	public static function saveGameMedia($data) 
	{

	}

	public static function deleteGameMedia($data) 
	{
		
	}

}
