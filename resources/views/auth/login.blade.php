@extends('shared._public')

@section('styles')
{!! HTML::style('css/login-styles.css') !!}
@endsection

@section('content')}
<div class="container-fluid">	
    <div class="row">
		<div class="col-md-offset-1 col-md-7">
			<div id="app-name" class="row">
				<div class="col-md-5">
					<h1>OSCA</h1>
				</div>
				<div class="col-md-7">
					<h3>Online Store Central Application Server</h3>
				</div>
			</div>
		</div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-lock"></span> Login to Administration Panel</div>
                <div class="panel-body">
					@foreach ($errors->all() as $message)
						<div class="alert alert-danger" role="alert">{{ $message }}</div>
					@endforeach
                    <form method="POST" action="{{ url('/auth/login') }}" class="form-vertical" role="form">
					{!! csrf_field() !!}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control"name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-12 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"/>
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-primary btn-sm">Log In</button>
                            <button type="reset" class="btn btn-default btn-sm">Reset</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection