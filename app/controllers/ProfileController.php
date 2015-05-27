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
		$downloaded = Transaction::where('user_id', '=', $id )
									->where('status', '=', '1')
									->get();
		$downloaded_games = array();
		foreach($downloaded as $d) 
		{
			$downloaded_games[] = $d->app;
		}

		return View::make('profile')
			->with('page_title', $user->username)
			->with('page_id', 'profile')
			->with('user', $user)
			->with(compact('games', 'downloaded_games'))
			->with(compact('languages','count', 'page'));
	}

	public function changeProfile($id)
	{
		$user = User::find($id);
		/*$file = Input::file('image');
		$languages = Language::all();*/
		
		//$games = Game::all();
		//$count = count($games);
		//$page = 3;

	/*	$filename = time() . '_' . $file->getClientOriginalName();
		$destinationPath = public_path() . '/images/avatars';		
		$upload_success = Input::file('image')->move($destinationPath, $filename);*/

		if(Input::file('profile_image')) 
		{
			$profile_image = Input::file('profile_image');
			$filename = time() . "_" . $profile_image->getClientOriginalName();
			$path = public_path('images/avatars/' . $filename);
			$media = Image::make($profile_image->getRealPath())->save($path);

			if($media)
			{
				try{
					File::delete('images/avatars/'. $user->prof_pic);
				} catch (Exception $e) { }
			}	

			$user->prof_pic = $filename;
			$user->save();		

			return Response::json(array('message'=>"update successful"));
		}
	}

	public function getTransactions($id) {
		$transactions = Transaction::with("app")
			->where("user_id", "=", $id)
			->get();
	
		$user = User::find($id);

		return View::make('transactions')
			->with('page_title', $user->username)
			->with('page_id', 'transactions')
			->with('user', $user)
			->with('transactions', $transactions);
	}

}
