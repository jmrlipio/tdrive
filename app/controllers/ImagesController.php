<?php

class ImagesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /images
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /images/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.gallery.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /images
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /images/{id}
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
	 * GET /images/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /images/{id}
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
	 * DELETE /images/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function postUpload() {
		$path = public_path().'/images';
		$filename = str_random(12).'.jpg';

		$upload_success = Input::file('file')->move($path, $filename);

		if($upload_success) {
		   return Response::json('success', 200);
		} else {
		   return Response::json('error', 400);
		}
	}

}