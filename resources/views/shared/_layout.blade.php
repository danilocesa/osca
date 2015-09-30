<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>OSCA Admin Control Panel - @yield('title')</title>	
	{!! HTML::style('css/bootstrap.min.css') !!}
	{!! HTML::style('css/nav-styles.css') !!}
	{!! HTML::style('css/image-styles.css') !!}
	{!! HTML::style('css/table-styles.css') !!}
	@yield('styles')
</head>
<body>
	@include('shared._nav')
	<div class="container">
		<h3>@yield('title')</h3>
		@yield('content')
	</div>
	{!! HTML::script('js/jquery.min.js') !!}
	{!! HTML::script('js/bootstrap.min.js') !!}
	{!! HTML::script('js/handlebars-v4.0.2.js') !!}
	@yield('scripts')	
</body>
</html>