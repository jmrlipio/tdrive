/*
	WIP: Share Plugin
	TODO: 
		1. dynamic adding of meta tags
		2. add multiple sharing sites
		3. add sharing url for facebook, twitter etc
		4. profit
*/

(function($) {
	"use strict";
	$.fn.fbshare = function(options)  
	{

		var Data = {
					'OG_name' : 'TDrive',
					'OG_url' : 'http://tdrive.com',
					'OG_title' : 'TDrive is the shizz',
					'OG_desc' : 'This is a dummy description',
					'OG_image' : 'http://dev.jigzen.com/tdrive/public/images/tose1.png',
			},
			selector = { 
						'site_name' : $('meta[property=og\\:site_name]'),
						'url' : $('meta[property=og\\:url]'),
						'title' : $('meta[property=og\\:title]'),
						'description' : $('meta[property=og\\:description]'),
						'image': $('meta[property=og\\:image]')
					   },
			methods = {
						init:function() 
						{	
							if (options){
                                $.extend(Data, options);
                            }
							selector['site_name'].attr('content', Data['OG_name']);	
							selector['url'].attr('content', Data['OG_url']);	
							selector['title'].attr('content', Data['OG_title']);	
							selector['description'].attr('content', Data['OG_desc']);
							selector['image'].attr('content', Data['OG_image']);	
						},
					  };

		 return methods.init.apply(this);
	}
})(jQuery);