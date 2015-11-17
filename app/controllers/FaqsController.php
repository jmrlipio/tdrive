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

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.faqs.create')->with(compact('languages'));
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
		$faq->languages()->attach(Input::get('language_id'), array('question' => Input::get('question'), 'answer' => Input::get('answer'), 'default' => 1));

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

	public function multipleDestroy()
	{
		$ids = Input::get('ids');
		//dd($ids);
		foreach($ids as $id) {
			$faq = Faq::find($id);
			$faq->delete();

			Event::fire('audit.faqs.delete', Auth::user());
		}

		return Redirect::route('admin.faqs.index')
			->with('message', 'Faq deleted')
			->with('sof', 'success');
	}


	public function addVariant($id) {
		$faq = Faq::findOrFail($id);
		$languages = [];

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.faqs.variant')
			->with(compact('faq', 'languages'));
	}

	public function storeVariant($id) {
		$faq = Faq::findOrFail($id);
		$language_id = Input::get('language_id');

		$question = Input::get('question');
		$answer = Input::get('answer');
		// $default = (!empty(Input::get('default'))) ? 1 : 0;
		$default = Input::get('default', 0);

		$faq->languages()->attach($language_id, array('question' => $question, 'answer' => $answer, 'default' => $default));

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		return View::make('admin.faqs.edit')
			->with(compact('faq', 'languages'))
			->with('question', $question)
			->with('answer', $answer)
			->with('default', $default)
			->with('language_id', $language_id)
			->with('message', 'You have successfully added a variant.');

	}

	public function editVariant($id, $language_id) {
		$faq = Faq::findOrFail($id);
		$languages = [];
		$question = '';
		$answer = '';
		$default = 0;

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		foreach($faq->languages as $fq) {
			if($fq->id == $language_id) {
				$question = $fq->pivot->question;
				$answer = $fq->pivot->answer;
				$default = $fq->pivot->default;
			}
		}

		return View::make('admin.faqs.edit')
			->with(compact('faq', 'languages'))
			->with('question', $question)
			->with('answer', $answer)
			->with('default', $default)
			->with('language_id', $language_id);
	}

	public function updateVariant($id, $language_id) {
		$faq = Faq::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Faq::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$faq->update($data);

		$new_language_id = Input::get('language_id');
		$question = Input::get('question');
		$answer = Input::get('answer');
		$default = Input::get('default', 0);

		if($default) {
			foreach($faq->languages as $fq) {
				$faq->languages()->updateExistingPivot($fq->pivot->language_id, array('default' => 0));
			}
		}

		foreach(Language::all() as $language) {
			$languages[$language->id] = $language->language;
		}

		$attributes = [
			'language_id' => $new_language_id,
			'question' => $question,
			'answer' => $answer,
			'default' => $default
		];

		$faq->languages()->updateExistingPivot($language_id, $attributes);

		return Redirect::route('admin.faqs.variant.edit', array('id' => $id, 'language_id' => $new_language_id))
			->with(compact('faq', 'languages'))
			->with('question', $question)
			->with('answer', $answer)
			->with('default', $default)
			->with('language_id', $new_language_id)
			->with('message', 'You have successfully updated this variant.');
	}

	public function deleteVariant($id, $language_id) {
		$faq = Faq::findOrFail($id);

		$count = 0;

		foreach($faq->languages as $fq) {
			$count++;
		}

		if($count > 1) {
			$faq->languages()->detach($language_id);
			$message = 'Successfully deleted variant.';
		} else {
			$faq->delete();
			$message = 'Successfully deleted FAQ.';
		}

		return Redirect::route('admin.faqs.index')
			->with('message', $message);
	}

}