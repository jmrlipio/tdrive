<?php

class ReportsController extends \BaseController {

	public function index()
	{
		return View::make('admin.reports.index');
	}


	public function salesList()
	{
		$sales = Sales::all();	
		return View::make('admin.reports.sales.lists')
					->with('sales', $sales);
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