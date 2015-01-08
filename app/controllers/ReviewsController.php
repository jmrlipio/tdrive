<?php

class ReviewsController extends \BaseController {

	public function index($id)
	{
		$languages = Language::all();

		$game = Game::find($id);

		return View::make('reviews')
			->with('page_title', 'Reviews | ' . $game->main_title)
			->with('page_id', 'reviews')
			->with(compact('game'))
			->with(compact('languages'));
	}

	public function admin_index()
	{
		// $reviews = Game::all();

		// return View::make('admin.reviews.index')
		// 	->with('page_title', 'Reviews - Admin')
		// 	->with('page_id', 'reviews')
		// 	->with(compact('reviews'));

		/*$grid = DataGrid::source(Review::with('user', 'game'));

		$grid->add('{{ $game->main_title }}','Game Title', 'game_id')->style('width:200px');
        $grid->add('{{ $user->first_name }}','First Name', 'user_id');
        $grid->add('{{ $user->last_name }}','Last Name', 'user_id');
        $grid->add('review', 'Review')->style('width:500px');
        $grid->add('status', 'Status');
        $grid->edit('/rapyd-demo/edit', 'Edit','modify|delete');
        // $grid->edit('/rapyd-demo/edit', 'Edit','show|modify');
        // $grid->link('/rapyd-demo/edit',"New Article", "TR");
        $grid->orderBy('id','desc');
        $grid->paginate(10);

        return  View::make('admin.reviews.index', compact('grid'));*/

        $filter = DataFilter::source(Review::with('user', 'game'));
        $filter->add('main_title','Game Title', 'text');
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->attributes(array("class"=>"table table-striped"));
        $grid->add('{{ $game->main_title }}','Game Title', 'game_id')->style('width:200px');
        $grid->add('{{ $user->first_name }}','First Name', 'user_id');
        $grid->add('{{ $user->last_name }}','Last Name', 'user_id');
        $grid->add('review', 'Review')->style('width:500px');
        $grid->add('status', 'Status');
        $grid->add('rating', 'Rating');
        $grid->edit('/rapyd-demo/edit', 'Edit','modify|delete');
        $grid->paginate(10);

        return  View::make('admin.reviews.index', compact('filter', 'grid'));

	}

}
