/*IMAGE UPLOADER FOR GAMES MEDIA BOOM!!*/
/*TODO: improve reusability*/

(function($) {
	"use strict";
	$.fn.uploadBOOM = function(options, callback)  
	{
		var file = this;
		var _URL = window.URL || window.webkitURL;
		var Data = {
					'url' : '',
					'before_loading' : '',
					'after_loading' : '',
			},
			selector = { 
						'media_box' : this.closest('.media-box'),
						'image_preview': this.closest('.media-box').find('.image-preview'),
						'form': this.closest('.media-box').find('.post-media-form'),
						'loader': this.closest('.media-box').find('.screenshot-loader'),
						'orientation' : $('#orientation')
					   },		   
			methods = {
						init: function() 
						{	
							if (options){
                                $.extend(Data, options);
                            }
							//onchange event
							file.change(function() {
								var _file = this;
								if(methods.checkExtension()) 
								{
									methods.validate(_file, function(e){
										if(methods.checkDimensions(e.width, e.height)) 
										{
											methods.show(_file);									
											methods.submit();
										}
										else 
										{
											alert('Wrong dimensions!');
										}
									});	
								}
								else 
								{
									alert('Not a correct file format!');
								}
							})
						},
						validate: function(_file, _callback) 
						{
							var temp, img;
						    if ((temp = _file.files[0])) {
						        img = new Image();
					              img.onload = function() {
										_callback(this);	
					              }
						        img.src = _URL.createObjectURL(temp);
						    }

							return true;
						},
						checkExtension: function() 
						{
							var val = file.val().toLowerCase();
							var regex = new RegExp("(.*?)\.(jpg|png|jpeg)$");
							if(!(regex.test(val))) 
							{
								file.val('');
								return false;
							}

							return true;
						},
						submit: function() 
						{
							selector['loader'].html(Data['before_loading']);
							selector['form'].submit(function(e) {
								var _form = new FormData(this);

								methods.send(_form, function(data){
									//CALLBACK: TODO: change
									if(callback) 
									{
										callback(data);
									}
								})

								 e.preventDefault();
				       			 $(this).unbind('submit');
							});
							selector['form'].submit();
						},
						show: function(_file) 
						{
							var reader = new FileReader();
							reader.onload = function(e) {								
								selector['image_preview'].attr('src', e.target.result);

							}
							reader.readAsDataURL(_file.files[0]);
						},
						send: function(_data, _callback) 
						{
							$.ajax({
				            	type: 'POST',
				            	url: Data['url'],
				            	data: _data,
				            	mimeType:"multipart/form-data",
						    	contentType: false,
						    	cache: false,
						    	processData:false,
				            	success: function (data) {
				            		 selector['loader'].html(Data['after_loading']);
				            		_callback(jQuery.parseJSON(data));
				            	}
					       	});
						},
						checkDimensions: function(_width, _height) 
						{
							var type = file.attr('name');
							var __width, __height

							if(type == 'promos') 
							{
					    		__width = 1024;
					    		__height = 500;
					    		/*__width = 450;
					    		__height = 549;*/
						    } 
						    else if(type == 'icons')
						    {
						    	__width = 512;
						    	__height = 512;
						    } 
						    else if(type == 'homepage') 
						    {
						    	__width = 1024;
						    	__height = 768;
						    } 
						    else if(type == 'screenshot')
						    {

						    	if(selector['orientation'] == 'landscape') 
						    	{
						    		__width = 800;
						    		__height = 480;
						    	} 
						    	else 
						    	{
						    		__width = 480;
						    		__height = 500;
						    	}
						    }

						    console.log(_width + "-" + __width + "; " + _height + "-" + __height );
						    
						    if(_width != __width && _height != __height) 
						    {
						    	return false;
						    }

						    return true;
						}
					  };

		 return methods.init.apply(this);
	}
})(jQuery);