<?php

class FaqsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /faqs
	 *
	 * @return Response
	 */
	public function index()
	{
		$faqs = Faq::orderBy('order')->paginate(10);

		return View::make('admin.faqs.index')->with('faqs', $faqs);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /faqs/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.faqs.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /faqs
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Faq::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Faq::create($data);
		Event::fire('audit.faqs.create', Auth::user());

		return Redirect::route('admin.faqs.create')->with('message', 'You have successfully added a question and answer.');
	}

	/**
	 * Display the specified resource.
	 * GET /faqs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /faqs/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$faq = Faq::findOrFail($id);

		return View::make('admin.faqs.edit')->with('faq', $faq);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /faqs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$faq = Faq::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Faq::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Event::fire('audit.faqs.edit', Auth::user());
		$faq->update($data);

		return Redirect::route('admin.faqs.edit', $id)->with('message', 'You have successfully updated this question.');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /faqs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$faq = Faq::find($id);

		if($faq) {
			$faq->delete();

			Event::fire('audit.faqs.delete', Auth::user());
			
			return Redirect::route('admin.faqs.index')
				->with('message', 'Faq deleted')
				->with('sof', 'success');
		}

		return Redirect::route('admin.faqs.index')
			->with('message', 'Something went wrong. Try again.')
			->with('sof', 'success');
	}

}