<?php

class MediaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /media
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /media/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.media.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /media
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /media/{id}
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
	 * GET /media/{id}/edit
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
	 * PUT /media/{id}
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
	 * DELETE /media/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function postUpload() {
		$file = Input::file('file');
		$destinationPath = public_path() . '/images/uploads';
		$filename = time() . '_' . $file->getClientOriginalName();
		$upload_success = Input::file('file')->move($destinationPath, $filename);

		if($upload_success) {
			$img = new Media;
			$img->url = $filename;
			$img->save();

			return Response::json('success', 200);
		} else {
			return Response::json('error', 400);
		}
	}

	public function showAllMedia() {
		$images = [];

		foreach(Media::all() as $media) {
			$images[$media->id] = "http://tdrive.dev/images/uploads/" . $media->url;
		}

		return $images;
	}





}