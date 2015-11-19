<?php

class ReviewsController extends \BaseController {

	public function index($id)
	{
		$languages = Language::all();

		$game = Game::find($id);
		
/*		$reviews = [];

		foreach($game->review as $review) {
			$reviews[] = $review;
		}*/

		return View::make('reviews')
			->with('page_title', 'Reviews | ' . $game->main_title)
			->with('page_id', 'reviews')
			->with(compact('game'))
			->with(compact('languages'));
	}

	public function admin_index()
	{
		$reviews = Review::orderBy('viewed')->paginate(10);
		$all_games = Game::orderBy('main_title')->get();
		$games = ['all' => 'All'];
		
		foreach ($all_games as $g) {
			$games[$g->id] = ucfirst($g->main_title);
		}
		sort($games);

		return View::make('admin.reviews.index')
			->with('selected', 'all')
			->with('page_title', 'Reviews - Admin')
			->with('page_id', 'reviews')
			->with('games', $games)
			->with(compact('reviews'));

	}

	public function update_status()
	{
		/*$data = Input::all();
        
        if(Request::ajax())
        {
            $id = $data['id'];
            $status = Review::where('id', $id)->first();
            $status->status = $data['status'];
            $status->update();
        }*/
	}

	public function postReview($id,$app_id)
	{
		$validator = Validator::make(Input::all(), Review::$rules);
		$url = URL::route('game.show', $id) . '/' . $app_id;
		$user_id = (Auth::check()) ? Auth::user()->id : 0;
		$exists = true;

		if(Review::where('user_id', '=', $user_id)->where('game_id', '=', $id)->exists()){
			$exists = true;	
		} else {
			$exists = false;
		}

		if ($validator->passes() && $exists == false) {
			Review::create(Input::all());

			/*$data = Review::whereViewed(0)->count();

			Event::fire('user.post.review',array($data));*/

			return Redirect::to($url."#review")->with('message', 'Your review has been submitted for approval.');
		
		} elseif ( $exists) {
			return Redirect::to($url."#review")->with('error', 'You are only allowed to create one review per game.');
		}

		//validator fails
		return Redirect::to($url)->withErrors($validator)->withInput();
	}

	public function show($id){

    	$review = Review::find($id);
    	$viewed = Review::whereId($id);
    	$viewed->update(array('viewed' => 1));

    	return View::make('admin.notifications.index')
    		->with('review', $review);
					
    }

    public function approveReview(){

    	$review = Review::whereId(Input::get('id'));
        $review->update(array('status' => 1));

    	return Redirect::back()->with('success','Review approved!');  
					
    }

    public function disapproveReview(){

    	$review = Review::whereId(Input::get('id'));
        $review->update(array('status' => 0));

    	return Redirect::back()->with('success','Review disapproved!');  
					
    }

    public function destroy($id)
	{
		$review = Review::find($id);

		$all_games = Game::orderBy('main_title')->get();
		$games = ['all' => 'All'];

		foreach ($all_games as $g) {
			$games[$g->id] = ucfirst($g->main_title);
		}   
		sort($games);   

		if($review) {

			$review->delete();
			
			$reviews = Review::orderBy('viewed')->paginate(10);
	
		} 

		return Redirect::route('admin.reviews.index')
			->with('message', 'Review Deleted');

	}

	public function delete($id) 
	{
		dd('df');
		$review = Review::find($id);
		$review->delete();

		return Redirect::back();
	}

	 public function handleDestroy() {
	    $checked = Input::only('checked')['checked'];  
	    $all_games = Game::orderBy('main_title')->get();
		$games = ['all' => 'All'];

		foreach ($all_games as $g) {
			$games[$g->id] = ucfirst($g->main_title);
		}   
		sort($games);   
		if($checked != null)
		{
			Review::whereIn('id', $checked)->delete();
			$reviews = Review::orderBy('viewed')->paginate(10);
			return Redirect::back()				
				->with('message', 'Review Deleted');
		} else {
			return Redirect::back()		
				->with('sof', 'failed');
		}
    }

     public function delete_front($game_id, $user_id)
	{
		

	}

	public function deleteReview($id, $app_id)
	{
		$url = URL::route('game.show', $id) . '/' . $app_id;
		$review_id = Input::get('id');
		$review = Review::find($review_id);

		try{
			
			if($review) {
				$review->delete();
				return Redirect::to($url)->with('message', 'Your review has been removed.');
			}

		} catch( Exception $e){
			return Redirect::to($url)->withErrors($validator)->withInput()->with('error', 'Deleting error.');
		}	
		
	}

	public function updateReview($id, $app_id)
	{
		$validator = Validator::make(Input::all(), Review::$rules);
		$url = URL::route('game.show', $id) . '/' . $app_id;
		$review_id = Input::get('id');
		$review = Review::find($review_id);

		try{
			
			if($validator->passes()) {
				$review->review = Input::get('review');
				$review->rating = Input::get('rating');
				$review->save();
				
				return Redirect::to($url)->with('message', 'Your review has been updated.');
			}
			return Redirect::to($url)->withErrors($validator)->withInput()->with('error', 'Wrong Captcha. Please Try again');
			
		} catch( Exception $e){
			return Redirect::to($url)->with('error', 'Update error.');
		}	
		
	}

	public function getReviewByGame() 
    {
		$selected_game = Input::get('selected_game');
		$all_games = Game::All();
		$games = ['all' => 'All'];
		
		foreach ($all_games as $g) {
			$games[$g->id] = ucfirst($g->main_title);
		}

		if($selected_game != 'all'){
			$reviews = Review::where('game_id', '=', $selected_game)
				->orderBy('viewed')->paginate(10);   		
    	} else {
			$reviews = Review::orderBy('viewed')->paginate(10);   
    	}

		return View::make('admin.reviews.index')
			->with('selected', $selected_game)
			->with('page_title', 'Reviews - Admin')
			->with('page_id', 'reviews')
			->with('games', $games)
			->with(compact('reviews'));
    }

    public function multipleDestroy()
	{
		$ids = Input::get('ids');

		foreach($ids as $id) 
		{
			$discount = Review::find($id);
			$discount->delete();
			
		}

		return Redirect::route('admin.reviews.index')
			->with('message', 'Review deleted.')
			->with('sof', 'success');	
	}


}
