<?php

	/*
	  List of option names

	  	-inquiry_email_subject
	  	-inquiry_email_automated_message

	 */

class Option extends \Eloquent {
	
	protected $table = 'options';
    protected $fillable = ['option_name', 'option_value'];

    /*temp*/
    public static save($data) 
    {
    	$option = Option::where('option_name', '=', $data['option_name']);
    	
    	if($option) 
    	{
    		$option->option_value = $data['option_value'];
    		$option->save();

    		return true;
    	}

    	$option->option_name = $data['option_name'];
    	$option->option_value = $data['option_value'];
    	$option->save();

    	return true;
    }

}