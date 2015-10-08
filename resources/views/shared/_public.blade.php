<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title') - OSCA Product Module</title>
	{!! HTML::style('css/bootstrap.min.css') !!}
	@yield('styles')
</head>
<body>
	@yield('content')
	{!! HTML::script('js/jquery.min.js') !!}
	{!! HTML::script('js/bootstrap.min.js') !!}
	@yield('scripts')	
</body>
</html>