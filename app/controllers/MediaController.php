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
		//
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
		$path = public_path().'/images';
		$filename = $file->getClientOriginalName().'.jpg';
		$upload_success = $file->move($path, $filename);

		if($upload_success) {
			$media = new Media;
		   	$media->media_url = time() . '_' . $file->getClientOriginalName();
		   	$media->save();
		   	return Response::json('success', 200);
		} else {
		   	return Response::json('error', 400);
		}
		
	}

}