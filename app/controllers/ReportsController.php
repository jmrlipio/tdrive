<?php

class ReportsController extends \BaseController {

	public function index()
	{
		return View::make('admin.reports.index');
	}

	public function sales()
	{
		return View::make('admin.reports.sales');
	}

	public function downloads()
	{
		return View::make('admin.reports.downloads');
	}

	public function adminlogs()
	{
		return View::make('admin.reports.adminlogs');
	}

	public function visitorlogs()
	{
		return View::make('admin.reports.visitorlogs');
	}

	/*public function inquiries()
	{
		return View::make('admin.reports.inquiries');
	}*/
                                                                                                            
}