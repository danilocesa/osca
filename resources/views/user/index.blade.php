@extends('shared._layout')

@section('title', 'Users')

@section('styles')
	{!! HTML::style('css/jake-custom-styles.css') !!}
	
@endsection

@section('content')
<div id="top_head">
		<!--<button type="button" class="btn btn-primary delete-btn" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>		-->
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content" id="vb_div">
			
			</div>
		  </div>
		</div>
</div>

	<div class="panel panel-default" id="vb_head">
		  <!-- Default panel contents -->
		<!--form method="post" action="{{ url('user/delete') }}"-->
			<div name="head">
					<!--div class="btn-group" id="vb_head_controls"  style="margin: 20px 10px 0 10px;"-->
					<div class="btn-group" style="padding: 10px 0 0 20px;">
						<button type="button" class="btn btn-primary navbar-btn" onclick="window.location='{{ url('user/create') }}'">Add User</button>
						{!! csrf_field() !!}
						<button type="button" class="btn btn-danger navbar-btn delete-btn" 
						        data-toggle="modal" 
								data-target=".bs-example-modal-lg">Delete Selected
						</button>
					</div>
					
				    <!-- search -->
					<div style="width: 30%; float:right; padding: 20px 20px 0 0">
                    <form action="{{ url('user/search') }}" method="get">
                      <div class="input-group"> <!-- style="width: 50%; float:right; padding: 20px 20px 0 0" -->
					    <input type="text" name="user_search" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="submit">
					        <span class="glyphicon glyphicon-search" />
					      </button>
                        </span>
                      </div><!-- /input-group -->
					</form>
                    </div>
					
					<div class="panel text-center">
						<!--a href="#">#</a-->
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
						<a href="{{url('user/index/Z')}}" style="padding-right: 10px;">Z</a>
						<!--a href="{{url('user/index/_NONE')}}" style="border-left: 1px solid #ccc; padding: 0 5px 0 10px;">Clear</a-->
						<a href="{{url('user/index/_ALL')}}" style="border-left: 1px solid #ccc; padding-left: 10px;">Clear</a>
					</div>
					<!--div id="vb_page_head">						
						{!! str_replace('/?', '?', $users->render()) !!}
					</div-->
		    </div>		  
		  <div class="page-body">			
		  </div>		  
		  <table class="table" id="user_table">
			<thead>
			  <div class="row">
			  <tr style="background-color: #C0C0C0;">	
				<th></th>
				<th>User</th>
				<th>Email Address</th>
				<th>Role</th>
				<th></th>
			  </tr>
			  </div>
			</thead>
			  <!-- fetch values from DB -->
			<tbody>
			  @if($users->total() != 0)
			    @foreach($users as $user)
			      <div class="row">
			        <tr data-bid="{{ $user->id }}" data-val="{{ $user->name }}">
				      <td class="col-sm-1" align="center">
				        <input type="checkbox" name="check[]" 
						       id="checks" value="{{ $user->id }}" 
							   data-bn="{{ $user->name }}" 
					    />
				      </td>
				      <td class="col-sm-3">{{$user->name}}</td>
					  <td class="col-sm-3">{{ $user->email }}</td>
				      <td class="col-sm-3">{{$user->role->role_name}}</td>
				      <td class="col-sm-2">
				    	<a href="{{ url('user/edit/'. $user->id) }}">
				    	  Edit
				    	</a>
				      </td>
				    </tr>
			      </div>
			    @endforeach
			  @else
				  <div class="row">
				  <tr>
					<td class="col-sm-1" align="center">
					  </td>
					  <td class="col-sm-5">No Records found</td>     
					  <td class="col-sm-4"></td>     
					  <td class="col-sm-2"></td>     
				  </tr>
				  </div>
			  @endif
			  @if(!empty($errors->all()))
				   <tr class="alert alert-danger">
					 <td class="col-sm-1" align="center"></td>
					 <td class="col-sm-5"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>{{ $errors->all()[0] }}<span class="sr-only">Error:</span></td>     
					 <td class="col-sm-4"></td>     
					 <td class="col-sm-2"></td>     						
				   </tr>
			  @endif
			</tbody>
			 <!-- fetch values from DB -->
		  </table>
		<!--/form-->		
	</div>

	
	<div name="foot" id="vb_foot" >
		<div class="col-sm-6 text-left">
		</div>		
		<div class="col-sm-6 text-right" id="vb_foot_pgn8" style="margin:0;">
				{!! str_replace('/?', '?', $users->appends(['user_search' => \Request::get('user_search')])->render()) !!}
		</div>			
	</div>
	
@endsection

@section('scripts')

<script id="delete-user-template" type="text/x-handlebars-template">
	<form action="{{ url('user/delete')}}" method="post">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal"> 
		  <span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>
		</button>
        <h4 class="modal-title">Please Confirm</h4>
      </div>
	  <div class="modal-body">
	    <p class="lead">
		  Are you sure you want to delete selected record/s?
		</p>
	    <input type="hidden" name="_method" value="DELETE">
	    {!! csrf_field() !!}
		
		<div class="list-group" id="modal_list"></div>
		
	  </div>
	  <!--<div class="modal-footer">
	    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		<button type="submit" class="btn btn-danger" name="delete_users" value="YES">
		  <i class="fa fa-times-circle"></i>Yes
		</button>
	  </div>-->
	</form>
</script>

<script>
	
	var brandTable = $("table#user_table tbody");				
	var user_modal= $("div#vb_div");
	
$(document).ready(function(){
	
	$(document).on("click", ".delete-btn", function(event){
		event.preventDefault();				
		var tmpDeleteBrandForm = Handlebars.compile($("#delete-user-template").html());
		
		user_modal.empty();		
		user_modal.append(tmpDeleteBrandForm);	
		
		if($("input:checked").length)
		{
			brandTable.find("input[type|='checkbox']").each(function()
		    {
		    	if($(this).is(":checked"))
				{
		    		//data.push($(this).attr('value'));
		    		//name.push($(this).attr('data-bn'));
		    		user_modal.find("div#modal_list").append('<label class="list-group-item">'
		    					  +$(this).attr('data-bn')
		    					  +'<input type="hidden" name="deluser[]" value="'
		    					  +$(this).attr('value')
		    					  +'" /></label>'
								  );
		    	}
		    });
			user_modal.find("div#modal_list").append(
			  '<div class="modal-footer">'
			  +'<button type="button" class="btn btn-default" data-dismiss="modal">No</button>'
			  +'<button type="submit" class="btn btn-danger" name="delete_users" value="YES">'
		      +'<i class="fa fa-times-circle"></i>Yes</button>'
			  +'</div>'
			);
		}else{
			user_modal.find("div#modal_list").append('<label class="list-group-item">There are no selected records to be deleted.</label>'
													  + '<div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">OK</button></div>'
													);
		}	
	});
	
	
});	

</script>

@endsection