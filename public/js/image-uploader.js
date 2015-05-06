/*IMAGE UPLOADER FOR GAMES MEDIA BOOM!!*/
/*TODO: improve reusability*/

(function($) {
	"use strict";
	$.fn.uploadBOOM = function(options, callback)  
	{
		var file = this;
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
					   },		   
			methods = {
						init: function() 
						{	
							if (options){
                                $.extend(Data, options);
                            }
							//onchange event
							file.change(function() {
								if(methods.validate()) 
								{
									methods.show(this);									
									methods.submit();
								}	
								else 
								{
									alert('Not a correct file format!');
								}
							})
						},
						validate: function() 
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
						}
					  };

		 return methods.init.apply(this);
	}
})(jQuery);