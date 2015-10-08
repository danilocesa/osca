<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">OSCA Product Module</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<li {!! Request::is('product*') ? 'class="active"' : null !!}><a href="{{ url('product') }}">Products</a></li>
		<li {!! Request::is('category*') ? 'class="active"' : null !!}><a href="{{ url('category') }}">Categories</a></li>
		<li {!! Request::is('brand*') ? 'class="active"' : null !!}><a href="{{ url('brand') }}">Brands</a></li>
		<li {!! Request::is('user*') ? 'class="active"' : null !!}><a href="{{ url('user') }}">Users</a></li>
      </ul>
	  
      <ul class="nav navbar-nav navbar-right">
		<li><p class="navbar-text">Signed in as: <a href="#" class="navbar-link"><strong>{{ Auth::user()->name }}</strong></a></p></li>
		<li><a href="{{ url('auth/logout') }}">Log off</a></li> 
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>