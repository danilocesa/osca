<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>OSCA Admin Control Panel - @yield('title')</title>
	{!! HTML::style('css/image-styles.css') !!}
	{!! HTML::style('css/table-styles.css') !!}
	{!! HTML::style('css/bootstrap.min.css') !!}
	@yield('styles')
</head>
<body>
	@yield('content')
	@yield('scripts')	
	{!! HTML::script('js/jquery.min.js') !!}
	{!! HTML::script('js/bootstrap.min.js') !!}
</body>
</html>