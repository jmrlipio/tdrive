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
		$inquiries = Inquiry::orderBy('created_at')->paginate(10);

		return View::make('admin.reports.inquiries.index')
					->with('inquiries', $inquiries);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /inquiries/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /inquiries
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	 * Show the form for editing the specified resource.
	 * GET /inquiries/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}


	/**
	 * Update the specified resource in storage.
	 * PUT /inquiries/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
		//
	}

	public function reply($id) 
	{

	return View::make('admin.reports.inquiries.show');

		$inquiry = Inquiry::find($id);
		dd($inquiry);
		$message = Input::get('message');
		$subject = 'Welcome!';
		$data = array(
		    'name' => 'adasd',
		    'email' => $inquiry->email,
		    'message' => 'asdsad',
		);

		 Mail::send('emails.inquiries.replyto', $data , function ($message) use ($inquiry) {
				$message->to($inquiry->email, $inquiry->name)->subject('Welcome!');
			});

		//if(!$mail) 
		//{
			//return Redirect::back()->with('message', 'error sending!');
		//}

		return Redirect::back()->with('message', 'Mail sent!');
	}

}