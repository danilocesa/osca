@extends('shared._layout')

@section('title', 'Roles')

@section('styles')
	{!! HTML::style('css/jake-custom-styles.css') !!}
@endsection

@section('content')
	<div class="panel panel-default" id="vb_head">
		  <!-- Default panel contents -->
			<div name="head">
					<div class="btn-group" id="vb_head_controls">
						<button type="button" class="btn btn-default">Add Roles</button>
						<button type="button" class="btn btn-default">Delete Selected</button>
					</div>
					<div id="vb_alpha">
							<a href="#">#</a>
							<a href="#">A</a>
							<a href="#">B</a>
							<a href="#">C</a>
							<a href="#">D</a>
							<a href="#">E</a>
							<a href="#">F</a>
							<a href="#">G</a>
							<a href="#">H</a>
							<a href="#">I</a>
							<a href="#">J</a>
							<a href="#">K</a>
							<a href="#">L</a>
							<a href="#">M</a>
							<a href="#">N</a>
							<a href="#">O</a>
							<a href="#">P</a>
							<a href="#">Q</a>
							<a href="#">R</a>
							<a href="#">S</a>
							<a href="#">T</a>
							<a href="#">U</a>
							<a href="#">V</a>
							<a href="#">W</a>
							<a href="#">X</a>
							<a href="#">Y</a>
							<a href="#">Z</a>
							<a href="#">Clear</a>
							<a href="#">View All</a>
						</div>
					<div id="vb_page_head">						
						<nav>
						  <ul class="pagination pagination-sm">
							<li>
							  <a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							  </a>
							</li>
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li>
							  <a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							  </a>
							</li>
						  </ul>
						</nav>
					</div>
					<div class="btn-group" id="vb_head_drop">
						  <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							Per Page
							<span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
						  </ul>
					</div>
		    </div>		  
		  <div class="page-body">			
		  </div>		  
		  <table class="table">
			  <!---->
			  <div class="row">
			  <tr style="background-color: #C0C0C0;">	
				<th></th>
				<th>Roles</th>
				<th></th>
				<th></th>
			  </tr>
			  <tr>
				  <td class="col-sm-1" align="center">
					<input type="checkbox" aria-label="..." />				  
				  </td>
				  <td class="col-sm-5">Administrator</td>     
				  <td class="col-sm-4"></td>     
				  <td class="col-sm-2"><a href="#">Edit</a></td>     
			  </tr>
			  </div>
			  <div class="row">
			  <tr>
				  <td class="col-sm-1" align="center">					
					<input type="checkbox" aria-label="..." />
				  </>			  
				  <td class="col-sm-5">Approver</td>     
				  <td class="col-sm-4"></td>     
				  <td class="col-sm-2"><a href="#">Edit</a></td>     
			  </tr>
			  </div>			  		  
		</table>
	</div>
	<div name="foot" id="vb_foot">
		<div id="vb_foot_pgn8">
			<nav>
			  <ul class="pagination pagination-sm">
				<li>
				  <a href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				  </a>
				</li>
				<li class="active"><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li>
				  <a href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				  </a>
				</li>
			  </ul>
			</nav>		
		</div>		
		<div class="btn-group dropup" id="vb_foot_drop">
			  <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Per Page
				<span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
			  </ul>
		</div>		
	</div>
@endsection