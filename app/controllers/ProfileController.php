<?php

class ProfileController extends \BaseController {

	public function index($id)
	{
		$languages = Language::all();

		$user = User::find($id);
		$games = Game::all();

		return View::make('profile')
			->with('page_title', $user->username)
			->with('page_id', 'profile')
			->with('user', $user)
			->with(compact('games'))
			->with(compact('languages'));
	}

}
