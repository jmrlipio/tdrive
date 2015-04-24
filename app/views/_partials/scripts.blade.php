<script type="text/javascript">
	$(document).ready(function() {



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