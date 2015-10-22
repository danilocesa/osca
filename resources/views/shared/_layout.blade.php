<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>@yield('title') - OSCA Product Module</title>	
	{!! HTML::style('css/bootstrap.min.css') !!}
	{!! HTML::style('css/select2.min.css') !!}
	{!! HTML::style('css/select2-bootstrap.css') !!}
	{!! HTML::style('css/bootstrap-override.css') !!}
	@yield('styles')
</head>
<body>
	@include('shared._nav')	
	<div class="container-fluid">
		@include('shared._alert')
		@yield('content')
	</div>
	{!! HTML::script('js/jquery.min.js') !!}
	{!! HTML::script('js/bootstrap.min.js') !!}
	{!! HTML::script('js/handlebars-v4.0.2.js') !!}
	{!! HTML::script('js/jquery.ajaxFormCustom.js') !!}
	{!! HTML::script('js/select2.min.js') !!}
	@yield('scripts')	
<script>	
	idleTimer = null;	
	idleState = false;
	idleWait = 7200000;
	(function ($) {
	    $(document).ready(function () {
	        $('*').bind('mousemove keydown scroll', function () {
	            clearTimeout(idleTimer);
	            idleState = false;
	            idleTimer = setTimeout(function () { 
	            	alert("You've been idle for 5 seconds");
	            	 {{ Auth::logout() }}
	            	window.location.reload();
	                idleState = true; }, idleWait);
	        });
	        
	        $("body").trigger("mousemove");
	    
	    });
	}) (jQuery)
</script>	
</body>
</html>