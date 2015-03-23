@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/jquery.fancybox.css"); }}
	<style>
		a.category-link { font-size: 15px;}
	</style>
@stop

@section('content')

<div id="container">

	<div id="content">

		<div class="container">

			<h1 class="title">Category list</h1>

			@forelse($categories as $cat)

				<a class="category-link" href="{{ route('category.show', $cat->id) }}">{{ $cat->category }}</a> <br>

			@empty

				 <p>Categories not found.</p> 

			@endforelse

		</div>

	</div>

</div>

@stop

@section('javascripts')
	{{ HTML::script("js/fastclick.js"); }}
	{{ HTML::script("js/jquery.polyglot.language.switcher.js"); }}
	{{ HTML::script("js/jquery.fancybox.js"); }}
	{{ HTML::script("js/jqSocialSharer.min.js"); }}

	<script>
		FastClick.attach(document.body);

		var _token = $('#token input').val();

		$('#polyglotLanguageSwitcher1').polyglotLanguageSwitcher1({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$('#polyglotLanguageSwitcher2').polyglotLanguageSwitcher2({ 
			effect: 'fade',
			paramName: 'locale', 
			websiteType: 'dynamic',

			onChange: function(evt){

				$.ajax({
					url: "language",
					type: "POST",
					data: {
						locale: evt.selectedItem,
						_token: _token
					},
					success: function(data) {
					}
				});

				return true;
			}
		});

		$("#inline").fancybox({
            'titlePosition'     : 'inside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none'
        });

        $("#share a").jqSocialSharer();

        $('.fancybox').fancybox({ padding: 0 });
	</script>
@stop
