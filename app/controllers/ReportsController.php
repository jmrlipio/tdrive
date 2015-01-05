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
		$logs = AdminLog::orderBy('created_at', 'DESC')->get();
		return View::make('admin.reports.adminLogs.index')
					->with('logs', $logs);
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