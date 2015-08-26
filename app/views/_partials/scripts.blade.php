<script type="text/javascript">
	$(document).ready(function() {

		var msg="";
		var elements = document.getElementsByTagName("INPUT");

		for (var i = 0; i < elements.length; i++) {
		   elements[i].oninvalid =function(e) {
		        if (!e.target.validity.valid) {
		        switch(e.target.id){
		            // case 'password' : 
		            // e.target.setCustomValidity("Bad password");break;
		            // case 'username' : 
		            // e.target.setCustomValidity("Username cannot be blank");break;
		        default : e.target.setCustomValidity("{{trans('global.Please fill out this field.')}}");break;

		        }
		       }
		    };
		   elements[i].oninput = function(e) {
		        e.target.setCustomValidity(msg);
		    };
		} 

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			testMode: true,
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
						location.reload();
					}
				});
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',
			testMode: true,
			onChange: function(evt){
				$.ajax({
					url: "{{ URL::route('choose_language') }}",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: token
					},
					success: function(data) {
					    location.reload();
					}
				});
			}
		});

		var resize = false;
		$('.tablet ul.menu li').each(function() {
			if($(this).height() > 70) 
			{
				resize = true;
			} 
			
		})
		if(resize) 
		{
			$('.tablet ul.menu li').find('a').css('font-size', '10px');
			$('.tablet ul.menu li').find('a').css('padding', '50px 0 5px');
			  
		}

	});
</script>