<?php

class InquiriesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /inquiries
	 *
	 * @return Response
	 */
	public function index()
	{
		$inquiries = Inquiry::orderBy('created_at', 'DESC')->paginate(30);

		return View::make('admin.reports.inquiries.index')
					->with('inquiries', $inquiries);
	
	}

	public function linkTo() 
	{
		if(Input::has('show')) 
		{
			$inquiry = Inquiry::find($id);

			return View::make('admin.reports.inquiries.show')
					->with('inquiry', $inquiry);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /inquiries
	 *
	 * @return Response
	 */
	public function storeInquiry()
	{
		
		/*$messages = [
		    'captcha.required' => 'Incorrect',
		];*/
		$os_version = Input::get('os-type'). ' - ' . Input::get('os-version');
		$data = array(
		    'name' => Input::get('name'),
		    'email' => Input::get('email'),
		    'app_store' => Input::get('app_store'),
		    'country' => Input::get('country'),
		    'os' => $os_version,
		    'game_title' => Input::get('game_title'),
		    'message' => Input::get('message'),
		    'captcha' => Input::get('captcha')
		);

		$validator = Validator::make($data, Inquiry::$rules);

		if($validator->passes()) {

			Inquiry::create($data);

			$message = Input::get('message');
			$subject = 'Welcome!';
			$_data = array(
			    'name' => Input::get('name'),
			    'email' => Input::get('email'),
			    'country' => Input::get('country'),
			    'os' => Input::get('os-type'). ' - ' . Input::get('os-version'),
			    'game_title' => Input::get('game_title'),
			    'messages' => $message,
			);

			Mail::send('emails.inquiries.inquire', $_data , function ($message) use ($_data) {
				$message->to(Input::get('email'), Input::get('name'))->subject('Welcome!');
			});

			return Redirect::to(URL::previous() . '#contact')
                    ->with('message', 'Your inquiry has been sent.');
		}

		//validator fails
		return Redirect::to(URL::previous() . '#contact')
                    ->with('message', 'Something went wrong.')
                    ->withErrors($validator);
	}

	/**
	 * Display the specified resource.
	 * GET /inquiries/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$inquiry = Inquiry::find($id);

		return View::make('admin.reports.inquiries.show')
					->with('inquiry', $inquiry);
	}


	/**
	 * Remove the specified resource from storage.
	 * DELETE /inquiries/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Inquiry::destroy($id);

		return Redirect::back()
						->with('message', 'deleted!');
	}

	public function reply($id) 
	{
		$validator = Validator::make(Input::all(), Inquiry::$reply_rules);

		if($validator->passes())
		{ 
			$inquiry = Inquiry::find($id);
			$subject = 'Welcome!';
			$data = array(
			    'name' => $inquiry->name,
			    'email' => $inquiry->email,
			    'game' => $inquiry->game_title,
			    'messages' => Input::get('message'),
			);

			$mail = Mail::send('emails.inquiries.replyto', $data , function ($message) use ($inquiry) {
					$message->to($inquiry->email, $inquiry->name)->subject('Welcome!');
				});


			if(!$mail) 
			{
				//return Redirect::back()->with('message', 'Mail sent!');
				return Redirect::to('admin/reports/inquiries')->with('success', 'Mail sent!');
			}

			return Redirect::back()->with('message', 'Mail not sent');
		}
		//validator fails
		return Redirect::back()->withErrors($validator)->withInput();
		
	}

	public function settings() 
	{	
		$data = array(
				'email_subject' => Option::get(Constant::INQUIRY_EMAIL_SUBJECT),
				'email_message' => Option::get(Constant::INQUIRY_EMAIL_MESSAGE)
			);

		return View::make('admin.reports.inquiries.settings')
					->with('data', $data);
	}

	public function saveSettings() 
	{
		//add validations
		$data_subject = array(
				'option_name' => Constant::INQUIRY_EMAIL_SUBJECT,
				'option_value' => Input::get('email_subject'),
			);
		$data_message = array(
				'option_name' => Constant::INQUIRY_EMAIL_MESSAGE,
				'option_value' => Input::get('email_message'),	
			);
		$email_subject = Option::saveOption($data_subject);
		$email_message = Option::saveOption($data_message);

		return Redirect::back();
	}

	public function userContact() 
	{
		$games = Game::all();
		$countries = Country::all();
		$carriers = Carrier::all();

		$user_location = GeoIP::getLocation();
		$_default_location = Country::where('iso_3166_2','=', $user_location['isoCode'])->get();
		$default_location = array();
		
		foreach($_default_location as $df)
		{
			$default_location = array(
				'id' => $df->id,
				'name' => $df->full_name
			);
		}

		$page_title = 'Contact Us';
		$page_id = 'form';

		return View::make('contact-us')
					->with('page_title', $page_title)
					->with('page_id', $page_id)
					->with('games', $games)
					->with('countries', $countries)
					->with('carriers', $carriers)
					->with('default_location', $default_location);
	}

	public function userInquiry()
	{
		$os_version = Input::get('os-type'). ' - ' . Input::get('os-version');
		$data = array(
		    'name' => Input::get('name'),
		    'email' => Input::get('email'),
		    'app_store' => Input::get('app_store'),
		    'country' => Input::get('country'),
		    'os' => $os_version,
		    'game_title' => Input::get('game_title'),
		    'message' => Input::get('message'),
		    'captcha' => Input::get('captcha')
		);

		$validator = Validator::make($data, Inquiry::$rules);

		if($validator->passes()) {

			$message = Input::get('message');
			$subject = 'Welcome!';
			$_data = array(
			    'name' => Input::get('name'),
			    'email' => Input::get('email'),
			    'country' => Input::get('country'),
			    'os' => Input::get('os-type'). ' - ' . Input::get('os-version'),
			    'game_title' => Input::get('game_title'),
			    'messages' => $message,
			);
			Inquiry::create($data);

			Mail::send('emails.inquiries.inquire', $_data , function ($message) use ($_data) {
				$message->to(Input::get('email'), Input::get('name'))->subject('Welcome!');
			});

			return Redirect::to(URL::previous())
                    ->with('message', 'Your inquiry has been sent.');
		}

		//validator fails
		return Redirect::to('contact-us' )
				->withInput()
				->withErrors($validator);
	}



}
