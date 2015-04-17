@extends('_layouts/single')

@section('stylesheets')
	{{ HTML::style("css/jquery.fancybox.css"); }}
	<style>
	a.category-link { font-size: 15px;}
	#nav-toggle, #side-menu {
		display: none !important;
	}

	#back {
		display: block !important;
		margin-top: 12px !important;
	}
	</style>
@stop

@section('content')

<div id="categories-container">
	<h1 class="title">{{ trans('global.Category list') }}</h1>
	<ul id="categories-list">
	@forelse($categories as $cat)
		<li>
			<a class="category-link" href="{{ route('category.show', $cat->id) }}">{{ trans('global.'.$cat->category) }}</a> <br>
		</li>
	@empty

		 <p>{{ trans('global.Categories not found.') }}</p> 

	@endforelse
	</ul>
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
