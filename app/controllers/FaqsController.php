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
		$languages = [];

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.faqs.create')->with('languages', $languages);
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

		$faq = Faq::create($data);

		$faq->languages()->sync(Input::get('language_id'));

		Event::fire('audit.faqs.create', Auth::user());

		return Redirect::route('admin.faqs.create')->with('message', 'You have successfully added a question.');
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

		$languages = [];
		$selected_languages = [];

		foreach($faq->languages as $language) {
			$selected_languages[] = $language->id;
		}

		foreach(Language::orderBy('language')->get() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.faqs.edit')
			->with('faq', $faq)
			->with('languages', $languages)
			->with('selected_languages', $selected_languages);
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

	public function getLanguageContent($id, $language_id) {
		$faq = Faq::find($id);
		$language = Language::find($language_id);

		$question = '';
		$answer = '';

		foreach($faq->languages as $faq_content) {
			if($faq_content->pivot->language_id == $language_id) {
				$question = $faq_content->pivot->question;
				$answer = $faq_content->pivot->answer;
			}
	    }

		return View::make('admin.faqs.content')
			->with('faq', $faq)
			->with('language_id', $language_id)
			->with('language', $language)
			->with('question', $question)
			->with('answer', $answer);
	}

}