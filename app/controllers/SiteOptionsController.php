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

		if(Input::hasFile('ribbon_url')) {
			$ribbon = Input::file('ribbon_url');
			$ribbon_name = time() . "_" . $ribbon->getClientOriginalName();
			$ribbon_path = public_path('assets/site/' . $ribbon_name);
			Image::make($ribbon->getRealPath())->save($ribbon_path);
			
			$data['ribbon_url'] = $ribbon_name;
		} else {
			$data['ribbon_url'] = $game_settings->ribbon_url;
		}
		
		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}		

		$game_settings->update($data);

		return Redirect::back()->with('message', 'You have successfully updated this news details.');

	}

	public function showFormMessages() {

		$messages = Message::all();

		return View::make('admin.messages')->with('messages', $messages);

	}

	public function updateFormMessages() {

		$messages = Message::all();

		foreach(Input::get('messages') as $message) {

			foreach($messages as $ms) {

				if($message['id'] == $ms->id) {

					$data = [
						'success' => $message['success'],
						'error' => $message['error']
					];

					$validator = Validator::make($data, Message::$rules);

					if ($validator->fails())
					{
						return Redirect::back()->withErrors($validator)->withInput();
					}

					$ms->update($data);

				}
			}

		}

		return Redirect::back()->with('message', 'You have successfully updated these settings.');

	}

	public function showGames() {

		$games = Game::all();

		return View::make('admin.game-slideshow')->with('games', $games);

	}

	public function editFeaturedGame() {

	}

}