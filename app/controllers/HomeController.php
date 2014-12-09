<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$games = Game::with('media')->get();
		$root = Request::root();
		$thumbnails = array();

		foreach($games as $game) {
			foreach($game->media as $media) {
				if($media->pivot->type == 'featured') {
					$thumbnails[] = $root. '/images/uploads/' . $media->url;
				}
			}
		}
		// echo '<pre>';
		// print_r($thumbnails);
		// echo '</pre>';
	return View::make('index')
		->with('thumbnails', $thumbnails)
		->with('games', $games);
	}
}
