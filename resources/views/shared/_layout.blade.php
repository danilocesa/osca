<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>OSCA Admin Control Panel - @yield('title')</title>	
	{!! HTML::style('css/bootstrap.min.css') !!}
	{!! HTML::style('css/nav-styles.css') !!}
	@yield('styles')
</head>
<body>
	@include('shared._nav')
	<div class="container-fluid">
		@yield('content')
	</div>
	{!! HTML::script('js/jquery.min.js') !!}
	{!! HTML::script('js/bootstrap.min.js') !!}
	{!! HTML::script('js/handlebars-v4.0.2.js') !!}
	{!! HTML::script('js/jquery.formError.js') !!}
	{!! HTML::script('js/jquery.ajaxFormCustom.js') !!}
	@yield('scripts')	
</body>
</html>