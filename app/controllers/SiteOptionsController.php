<?php

class SiteOptionsController extends \BaseController {

	public function showGeneralSettings() {

		$settings = GeneralSetting::all();

		return View::make('admin.settings')->with('settings', $settings);

	}

	public function updateGeneralSettings() {

		$gen_settings = GeneralSetting::all();

		foreach(Input::get('settings') as $setting) {

			foreach($gen_settings as $gs) {

				if($setting['id'] == $gs->id) {

					$values = ['value' => $setting['value']];

					$validator = Validator::make($data = $values, GeneralSetting::$rules);

					if ($validator->fails())
					{
						return Redirect::back()->withErrors($validator)->withInput();
					}

					$gs->update($data);

				}
			}

		}

		return Redirect::back()->with('message', 'You have successfully updated these settings.');

	}

	public function showVariables() {

		$variables = SiteVariable::all();

		return View::make('admin.variables')->with('variables', $variables);

	}

	public function updateVariables() {

		$site_variables = SiteVariable::all();

		foreach(Input::get('variables') as $variable) {

			foreach($site_variables as $sv) {

				if($variable['id'] == $sv->id) {

					$values = ['variable_value' => $variable['variable_value']];

					$validator = Validator::make($data = $values, SiteVariable::$rules);

					if ($validator->fails())
					{
						return Redirect::back()->withErrors($validator)->withInput();
					}

					$sv->update($data);

				}
			}

		}

		return Redirect::back()->with('message', 'You have successfully updated the variables.');

	}

	public function showGameSettings() {
		$game_settings = GameSetting::find(1);

		return View::make('admin.game-settings')->with('settings', $game_settings);
	}

	public function updateGameSettings($id) {
		$game_settings = GameSetting::find($id);

		$validator = Validator::make($data = Input::all(), GameSetting::$rules);
		//free
		if(Input::hasFile('ribbon_url')) {
			$ribbon = Input::file('ribbon_url');
			//$ribbon_name = time() . "_" . $ribbon->getClientOriginalName();
			$ribbon_name = "ribbon-front.png";
			$ribbon_path = public_path('images/' . $ribbon_name);
			Image::make($ribbon->getRealPath())->save($ribbon_path);
			
			$data['ribbon_url'] = $ribbon_name;
		} else {
			$data['ribbon_url'] = $game_settings->ribbon_url;
		}
		//discounted
		if(Input::hasFile('sale_url')) {
			$sale_ribbon = Input::file('sale_url');
			//$sale_ribbon_name = time() . "_" . $sale_ribbon->getClientOriginalName();
			$sale_ribbon_name = "ribbon-discounted-front.png";
			$sale_ribbon_path = public_path('images/' . $sale_ribbon_name);
			Image::make($sale_ribbon->getRealPath())->save($sale_ribbon_path);
			
			$data['sale_url'] = $sale_ribbon_name;
		} else {
			$data['sale_url'] = $game_settings->sale_url;
		}
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}		

		$game_settings->update($data);

		return Redirect::back()->with('message', 'You have successfully updated this news details.');

	}

	public function showNews() {

		$news = News::orderBy('created_at')->paginate(10);

		return View::make('admin.slideshow')->with('news', $news);

	}

	public function showFeatured() {

		$games = [];
		$news = [];
		$categories = [];
		$selected_games = [];
		$selected_news = [];
		$selected_categories = [];

		$sliders = Slider::all();

		foreach($sliders as $slider) {
			if($slider->slideable_type == 'Game') $selected_games[] = $slider->slideable_id;
			else if($slider->slideable_type == 'News') $selected_news[] = $slider->slideable_id;
		}

		foreach(Game::all() as $game) {
			$games[$game->id] = $game->main_title;
		}

		foreach(News::all() as $nw) {
			$news[$nw->id] = $nw->main_title;
		}

		foreach(Category::all() as $category) {
			$categories[$category->id] = $category->category;
			if($category->featured) $selected_categories[] = $category->id;
		}

		$featured_categories = Category::where('featured', '=', 1)->orderBy('order')->get();

		return View::make('admin.slideshow')
			->with(compact('games','news','sliders','selected_news','selected_games','categories','selected_categories','featured_categories'));

	}

	public function updateFeatured()
	{
		$data = Input::get('item');

		Slider::truncate();
        
        $count = 1;
        foreach($data as $item) {
        	foreach($item as $type => $id) {
        		if($type == 'game') $slider = Game::find($id);
        		else $slider = News::find($id);

        		$slider->sliders()->create(['order' => $count]);
        	}
        	
        	$count++;
        }

        return Redirect::back()->with('message', 'You have successfully update the homepage slider items.');
	}

	public function updateCategories() {
		$featured = Input::get('item');

		$count = 1;

		foreach($featured as $fc) {
			$ctg = Category::find($fc);

			$data = [
				'featured' => 1,
				'order' => $count
			];

			$ctg->update($data);

			$count++;
		}

		foreach(Category::all() as $category) {
			if(!in_array($category->id, $featured)) {
				$data = [
					'featured' => 0,
					'order' => 0
				];

				$category->update($data);
			}
		}

		return Redirect::back()->with('message', 'You have successfully updated the featured categories.');
	}

	public function getCreateIPfilters() {


		return View::make('admin.ip-filters.create');
	}

	public function getIPfilters() 
	{
		$filters = IPFilter::all();

		return View::make('admin.ip-filters')
				->with(compact('filters'));
	}

	public function addIPfilters() 
	{

		$validator = Validator::make($data = Input::all(), IPFilter::$rules);
		date_default_timezone_set('Asia/Manila');
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		$filter = new IPFilter();
		$filter->ip_address = Input::get('ip_address');
		$filter->added_by = Auth::user()->id;
		$filter->save();

		return Redirect::to('admin/ip-filters')->with('message', 'You have added an IP address.');
	}

	public function deleteIPFilter($id) {
		$filter = IPFilter::find($id);

		$filter->delete();
		
		return Redirect::back()->with('message', 'You have delete an IP address.');
	}

}