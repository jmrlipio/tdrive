<?php

class Observer {

 

  public function __construct($type) 
  { 
     // $this->type = $type;
  }


   public function saved($model)
    {
    // dd($model);
    }


    public function updated($model)
    {
      echo '<pre>';
      dd($model);
      $log = new UserLog;
      $log->user_id = Auth::user()->id;
      $log->activity = Auth::user() . 'Updated ' . $type ;
      $log->save();
    }

    public function deleted($model)
    {
      dd('logged deleted');
    }

    public function created($model) 
    {
      $log = new UserLog;
      $log->user_id = Auth::user()->id;
      $log->activity = 'Created new ' . $type;
      $log->save();
    }
  
  
}