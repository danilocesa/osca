@extends('shared._layout')

@section('title', 'Users')

@section('styles')
	{!! HTML::style('css/jake-custom-styles.css') !!}
	
@endsection

@section('content')
	<div class="panel panel-default" id="vb_head">
		  <!-- Default panel contents -->
		<form method="post" action="{{ url('users/delete') }}">
			<div name="head">
					<div class="btn-group" id="vb_head_controls"  style="margin: 20px 10px 0 10px;">
						<button type="button" class="btn btn-default navbar-btn" onclick="window.location='{{ url('user/create') }}'">Add User</button>
						{!! csrf_field() !!}
						<button type="submit" class="btn btn-default navbar-btn" id="delete_user">Delete Selected</button>
					</div>
					<div id="vb_alpha">
						<a href="#">#</a>
						<a href="{{url('user/index/A')}}">A</a>
						<a href="{{url('user/index/B')}}">B</a>
						<a href="{{url('user/index/C')}}">C</a>
						<a href="{{url('user/index/D')}}">D</a>
						<a href="{{url('user/index/E')}}">E</a>
						<a href="{{url('user/index/F')}}">F</a>
						<a href="{{url('user/index/G')}}">G</a>
						<a href="{{url('user/index/H')}}">H</a>
						<a href="{{url('user/index/I')}}">I</a>
						<a href="{{url('user/index/J')}}">J</a>
						<a href="{{url('user/index/K')}}">K</a>
						<a href="{{url('user/index/L')}}">L</a>
						<a href="{{url('user/index/M')}}">M</a>
						<a href="{{url('user/index/N')}}">N</a>
						<a href="{{url('user/index/O')}}">O</a>
						<a href="{{url('user/index/P')}}">P</a>
						<a href="{{url('user/index/Q')}}">Q</a>
						<a href="{{url('user/index/R')}}">R</a>
						<a href="{{url('user/index/S')}}">S</a>
						<a href="{{url('user/index/T')}}">T</a>
						<a href="{{url('user/index/U')}}">U</a>
						<a href="{{url('user/index/V')}}">V</a>
						<a href="{{url('user/index/W')}}">W</a>
						<a href="{{url('user/index/X')}}">X</a>
						<a href="{{url('user/index/Y')}}">Y</a>
						<a href="{{url('user/index/Z')}}">Z</a>
						<a href="{{url('user/index/_NONE')}}" style="border-left: 1px solid #ccc; padding: 0 5px 0 10px;">Clear</a>
						<a href="{{url('user/index/_ALL')}}" style="border-left: 1px solid #ccc; padding: 0 5px 0 10px;">View All</a>
					</div>
					<div id="vb_page_head">						
						{!! str_replace('/?', '?', $users->render()) !!}
					</div>
		    </div>		  
		  <div class="page-body">			
		  </div>		  
		  <table class="table" id="user_table">
			  <!---->
			  <div class="row">
			  <tr style="background-color: #C0C0C0;">	
				<th></th>
				<th>User</th>
				<th>Role</th>
				<th></th>
			  </tr>
			  </div>
			  
			  <!-- fetch values from DB -->
			  @foreach($users as $user)
			  <div class="row">
			    <tr>
				  <td class="col-sm-1" align="center"><input type="checkbox" aria-label="..." /></td>
					<td class="col-sm-5">{{$user->name}}</td>
					<td class="col-sm-4">{{$user->role->role_name}}</td>
					
					<td class="col-sm-2">
					  <a href="{{ url('user/edit/'. $user->id) }}">
					    Edit
					  </a>
					</td>
					
				</tr>
			  </div>
			  @endforeach
			  @if(!empty($errors->all()))
				   <tr class="alert alert-danger">
					 <td class="col-sm-1" align="center"></td>
					 <td class="col-sm-5"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>{{ $errors->all()[0] }}<span class="sr-only">Error:</span></td>     
					 <td class="col-sm-4"></td>     
					 <td class="col-sm-2"></td>     						
				   </tr>
			  @endif	
			 <!-- fetch values from DB -->
		  </table>
		</form>
		<div class="col-sm-6 text-right" id="vb_foot_pgn8" style="margin:0;">
				{!! str_replace('/?', '?', $users->render()) !!}
		</div>	
	</div>
	<div name="foot" id="vb_foot" >
		<div class="col-sm-6 text-left">
		</div>			
	</div>
@endsection