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

		return View::make('admin.reviews.index')
			->with('page_title', 'Reviews - Admin')
			->with('page_id', 'reviews')
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

	public function postReview($id)
	{
		$validator = Validator::make(Input::all(), Review::$rules);
		$url = URL::route('game.show', $id) . '#review';

		if ($validator->passes()) {
			Review::create(Input::all());

			/*$data = Review::whereViewed(0)->count();

			Event::fire('user.post.review',array($data));*/

			return Redirect::to($url)->with('message', 'Your review has been added.');
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

    public function apprroveReview(){

    	$review = Review::whereId(Input::get('id'));
        $review->update(array('status' => 1));

    	return Redirect::back()->with('success','Review approved!');  
					
    }

    public function destroy($id)
	{
		$review = Review::find($id);
		
		if($review) {

			$review->delete();
			
			$reviews = Review::orderBy('id')->paginate(10);
	
		}

		return View::make('admin.reviews.index')
			->with('page_title', 'Reviews - Admin')
			->with('page_id', 'reviews')
			->with(compact('reviews'));

	}

}
