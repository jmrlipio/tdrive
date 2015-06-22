<?php

class ReportsController extends \BaseController {

	public function index()
	{
		return View::make('admin.reports.index');
	}


	public function salesList()
	{
		$transactions = Transaction::all();
		return View::make('admin.reports.sales.lists')
					->with('transactions', $transactions);
	}

	public function salesChart()
	{
		$games = Game::all();

		return View::make('admin.reports.sales.index')
					->with('games', $games);
	}

	public function overallGamesSales() 
	{
	   $games = Game::all();			

	   $array = array();	
	   $array['cols'] = array(
	   						 array(
	   						 	'id' => "games", 
	   						 	'label' => 'Games', 
	   						 	'type' => 'string'
	   						 		),
	    					array(
	    						'id' => "downloads", 
	    						'label' => 'Downloads', 
	    						'type' => 'number'
	    						)
	    					);
	    $rows = array();
	    foreach($games as $game) 
	    {

	    	$prices = GameSales::where('game_id', '=', $game->id)
	    						->get();
	    		$total = 0;
	    		foreach($prices as $_prices) 
	    		{
	    			$sales 	= Sales::where('game_price_id', '=', $_prices->id)
	    							->get();
	    			$count = count($sales->toArray());
	    			$total = $total + $count;
	    		}	

	     	$temp = array();
		    $temp[] = array('v' => $game->main_title, 'f' =>NULL);
		    $temp[] = array('v' => $total, 'f' =>NULL);
		    $rows[] = array('c' => $temp);	
	    }

	    $array['rows'] = $rows;
	    $json_data = json_encode($array);
	    	

	    return $json_data;
	}

	public function salesFilter($game_id, $filter) 
	{
	   $game_data = '';
	   $array = array();
	   $rows = array();	
	   
	   $array['cols'] = array(
	   						 array(
	   						 	'id' => "games", 
	   						 	'label' => 'Games', 
	   						 	'type' => 'string'
	   						 		),
	    					array(
	    						'id' => "downloads", 
	    						'label' => 'Downloads', 
	    						'type' => 'number'
	    						)
	    					);
	    
	    if($filter == 'carrier') 
		{	
			$game_data = Game::find($game_id);
			foreach($game_data->carriers as $carrier) 
	    	{
		    	$prices = GameSales::where('game_id', '=', $game_id)
		    						->where('carrier_id', '=', $carrier->id)
		    						->get();
		    		$total = 0;
		    		foreach($prices as $_prices) 
		    		{
		    			$sales 	= Sales::where('game_price_id', '=', $_prices->id)
		    							->get();
		    			$count = count($sales->toArray());
		    			$total = $total + $count;
		    		}	

		     	$temp = array();
			    $temp[] = array('v' => $carrier->carrier, 'f' => NULL);
			    $temp[] = array('v' => $total, 'f' => NULL);
			    $rows[] = array('c' => $temp);	
	    	}
		}
		else if($filter == 'country')
		{
			$game_data = Game::find($game_id);
			foreach($game_data->carriers as $carrier) 
	    	{
				foreach($carrier->countries as $country) 
		    	{

			    	$prices = GameSales::where('game_id', '=', $game_id)
			    						->where('country_id', '=', $country->id)
			    						->get();
			    	$total = 0;
			    	if($prices) 
			    	{
			    		foreach($prices as $_prices) 
			    		{
			    			$sales 	= Sales::where('game_price_id', '=', $_prices->id)
			    							->get();
			    			$count = count($sales->toArray());
			    			$total = $total + $count;
			    		}	

				     	$temp = array();
					    $temp[] = array('v' => $country->capital . '(' . $carrier->carrier . ')', 'f' => NULL);
					    $temp[] = array('v' => $total, 'f' => NULL);
					    $rows[] = array('c' => $temp);	
			    	}

		    	}
	    	 }
		}

	    $array['rows'] = $rows;
	    $json_data = json_encode($array);
	    
	    return  $json_data;
	}


	public function downloads()
	{
		$games = Game::all();

		return View::make('admin.reports.downloads')
					->with('games', $games);
	}

	public function adminlogs()
	{
		$logs = AdminLog::orderBy('created_at', 'DESC')->get();
		$users = User::all();

		return View::make('admin.reports.adminLogs.index')
					->with('logs', $logs)
					->with('users', $users);
	}

	public function visitorlogs()
	{
		$sessions = Tracker::sessions(60 * 24);
		$pageViews = Tracker::pageViews(60 * 24 * 30);
		echo '<pre>';
		dd($pageViews);
		return View::make('admin.reports.visitorlogs');
	}

	/*public function inquiries()
	{
		return View::make('admin.reports.inquiries');
	}*/

/*	public function downloadCheck() 
	{
		$filename = "the name of my file";
		$filePath = "/path/to/download/$filename";
		//lets read this file to the user
		//open the file for binary reading
		$file = fopen($filePath,"rb");
		// we build some headers
		header("Content-type: application/octet-stream"); 
		header("Content-Disposition: inline; filename=\"$filename\"");
		header("Content-length: ".(string)(filesize($filePath)));
		while(!feof($file) )// if we haven't got to the End Of File
		{ 
			print(fread($file, 1024*8) );//read 8k from the file and send to the user
			flush();//force the previous line to send its info
			if (connection_status()!=0)//check the connection, if it has ended...
			{
				fclose($file);//close the file
				die();//kill the script
			}
		}
		fclose($file);//close the file
		//if we get this far, the file was completely downloaded
		//update the database
	}
*/

	public function visitorsPagesViews() 
	{
		return View::make('admin.reports.visitors.index');
	}

	public function visitorsPagesViewsChart() 
	{
	   $array = array();
	   $rows = array();	
	   
	   //show specific routes only
	   $routes	= ['game.show', 'news.show'];

	   $array['cols'] = array(
	   						 array(
	   						 	'id' => "pages", 
	   						 	'label' => 'Pages', 
	   						 	'type' => 'string'
	   						 		),
	    					array(
	    						'id' => "pageviews", 
	    						'label' => 'Page Views', 
	    						'type' => 'number'
	    						)
	    					);
	   	foreach($routes as $route) 
	   	{
	   		$page = DB::table('tracker_routes')
	   						->select('id')
	   						->where('name', '=', $route)
	   						->first();

	   		$views = DB::table('tracker_log')	
	   					->select('route_path_id')
	   					->where('route_path_id', '=', $page->id)
	   					->get();
	 	
			$temp = array();
		    $temp[] = array('v' => $route, 'f' => NULL);
		    $temp[] = array('v' => count($views) , 'f' => NULL);
		    $rows[] = array('c' => $temp);	

	   	}

		$array['rows'] = $rows;
	    $json_data = json_encode($array);
	    
	    return  $json_data;	
	}

	public function visitorsUsersViews() 
	{

		$users = DB::table('tracker_sessions')
					->join('users', 'tracker_sessions.user_id', '=' , 'users.id')
					->join('tracker_devices', 'tracker_sessions.device_id', '=' , 'tracker_devices.id')
					->select('users.username', 'tracker_sessions.client_ip', 'tracker_sessions.created_at', 'tracker_devices.kind', 'tracker_devices.platform', 'tracker_devices.model' )
					->get();

		return View::make('admin.reports.visitors.users-index')
					->with('users', $users);
	}

	public function visitorsRatingsViews() 
	{
		$games = Game::all();

		return View::make('admin.reports.visitors.ratings')
					->with('games', $games);
	}
        
     public function visitorsStatisticViews() 
     {
     	//$games = Sales::getTotalSales(1);
     	$games = Game::all();

     	return View::make('admin.reports.visitors.statistics-index')
     				->with('games', $games);
     }   

     public function visitorsBuyStatisticViews($id) 
     {
     	$games = Transaction::getTransaction($id) ;
     	$game = Game::find($id);
     	return View::make('admin.reports.visitors.buy-index')
     				->with('games', $games)
     				->with('game', $game);
     }   

     public function visitorsDownloadStatisticViews($id) 
     {
     	$games = Download::getTotalDownloads($id);

     	return View::make('admin.reports.visitors.download-index')
     				->with('games', $games);
     }

     public function visitorsGoolgeAnaylitcsViews() 
     {
     	return View::make('admin.reports.visitors.analytics');
     }     

     public function visitorActivityUsers() 
     {
     	$activities = ActivityLog::all();
     	//dd($activities);
     	return View::make('admin.reports.visitors.activity')
     				->with('activities', $activities);
     }                                                                                                 
}