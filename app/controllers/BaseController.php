<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function __construct()
	{       
		$user_location = GeoIP::getLocation();   
		$site_variables = SiteVariable::all();
		$general_settings = GeneralSetting::all();
		$game_settings = GameSetting::all();

		View::share('user_location', $user_location);
		View::share('site_variables', $site_variables);
		View::share('general_settings', $general_settings);
	}

	/*public function test($telco){

		View::share('telco', $telco);

	}*/


}
