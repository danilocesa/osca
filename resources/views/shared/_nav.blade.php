<nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Admin Control Panel</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	
      <ul class="nav navbar-nav">
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ url('product') }}">View Products</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ url('brand') }}">Brands</a></li>
			<li><a href="{{ url('category') }}">Categories</a></li>
          </ul>
        </li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Marketing <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">(coming soon)</a></li>
          </ul>
        </li>
		<li><a href="{{ url('user') }}">Users</a></li>
		<li><a href="{{ url('role') }}">Roles</a></li>
      </ul>
	  
      <ul class="nav navbar-nav navbar-right">
		<li><p class="navbar-text">Signed in as: <a href="#" class="navbar-link"><strong>{{ Auth::user()->name }}</strong></a></p></li>
		<li><a href="{{ url('auth/logout') }}">Log off</a></li> 
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>