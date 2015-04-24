<?php

class ProfileController extends \BaseController {

	public function index($id)
	{
		$user = User::find($id);
		$languages = Language::all();
		$page = 3;
		$count = 6;
		$country = Country::find(Session::get('country_id'));

		$cid = Session::get('carrier');
	
		$games = Game::paginate($count);

		$count = count($games);

		return View::make('profile')
			->with('page_title', $user->username)
			->with('page_id', 'profile')
			->with('user', $user)
			->with(compact('games'))
			->with(compact('languages','count', 'page'));
	}

	public function changeProfile($id)
	{
		$file = Input::file('image');

		$languages = Language::all();		
		$user = User::find($id);
		$games = Game::all();

		$filename = time() . '_' . $file->getClientOriginalName();
		$destinationPath = public_path() . '/images/avatars';		
		$upload_success = Input::file('image')->move($destinationPath, $filename);

		
		if($upload_success){	
			
			try{
				File::delete('images/avatars/'. $user->prof_pic);
			} catch (Exception $e) { }

			
			$user->prof_pic = $filename;
			$user->save();			
			
		}	

		return View::make('profile')
			->with('page_title', $user->username)
			->with('page_id', 'profile')
			->with('user', $user)
			->with(compact('games'))
			->with(compact('languages'));
	}

}
