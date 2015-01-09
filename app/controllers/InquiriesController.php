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
		$inquiries = Inquiry::orderBy('created_at')->paginate(30);

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
	public function store()
	{

		$validator = Validator::make(Input::all(), Inquiry::$rules);
		if($validator->passes()) 
		{

			Inquiry::create(Input::all());

			$message = Input::get('message');
			$subject = 'Welcome!';
			$data = array(
			    'name' => Input::get('name'),
			    'email' => Input::get('email'),
			    'game' => Input::get('game'),
			    'messages' => $message,
			);

			Mail::send('emails.inquiries.inquire', $data , function ($message) use ($data) {
					$message->to(Input::get('email'), Input::get('name'))->subject('Welcome!');
				});


			return Redirect::back()
							->with('message', 'Inquiry Sent!');
		}
		//validator fails
		return Redirect::back()
						->withErrors($validator)
						->withInput();
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
				return Redirect::back()->with('message', 'Mail sent!');
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

}