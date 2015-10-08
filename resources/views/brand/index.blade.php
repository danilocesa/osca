@extends('shared._layout')

@section('title', 'Brands')

@section('styles')
	{!! HTML::style('css/jake-custom-styles.css') !!}

@endsection

@section('content')
<div id="top_head">
	<div class="col-lg-6">
	</div>
	<div class="col-lg-6" align="right">
		<div class="input-group" id="vb_search">
		<form action="{{ url('brand/search') }}" method="get">
			<input type="text" class="form-control" name="brand_search" placeholder="Search for brands.." />
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search" />
				</button>
			</span>
		</form>
		</div>
	</div>
</div>
	<div class="panel panel-default" id="vb_head">
		  <!-- Default panel contents -->
		  <form method="post" action="{{ url('brand/delete') }}">
			<div name="head">			
					<div class="btn-group" id="vb_head_controls">
						<button type="button" class="btn btn-default add-brand-btn add-brand">Add Brand</button>						
						{!! csrf_field() !!}
						<button type="submit" class="btn btn-default" id="delete_brand">Delete Selected</button>
					</div>
					<div id="vb_alpha">
							<a href="#">#</a>
							<a href="{{url('brand/index/A')}}">A</a>
							<a href="{{url('brand/index/B')}}">B</a>
							<a href="{{url('brand/index/C')}}">C</a>
							<a href="{{url('brand/index/D')}}">D</a>
							<a href="{{url('brand/index/E')}}">E</a>
							<a href="{{url('brand/index/F')}}">F</a>
							<a href="{{url('brand/index/G')}}">G</a>
							<a href="{{url('brand/index/H')}}">H</a>
							<a href="{{url('brand/index/I')}}">I</a>
							<a href="{{url('brand/index/J')}}">J</a>
							<a href="{{url('brand/index/K')}}">K</a>
							<a href="{{url('brand/index/L')}}">L</a>
							<a href="{{url('brand/index/M')}}">M</a>
							<a href="{{url('brand/index/N')}}">N</a>
							<a href="{{url('brand/index/O')}}">O</a>
							<a href="{{url('brand/index/P')}}">P</a>
							<a href="{{url('brand/index/Q')}}">Q</a>
							<a href="{{url('brand/index/R')}}">R</a>
							<a href="{{url('brand/index/S')}}">S</a>
							<a href="{{url('brand/index/T')}}">T</a>
							<a href="{{url('brand/index/U')}}">U</a>
							<a href="{{url('brand/index/V')}}">V</a>
							<a href="{{url('brand/index/W')}}">W</a>
							<a href="{{url('brand/index/X')}}">X</a>
							<a href="{{url('brand/index/Y')}}">Y</a>
							<a href="{{url('brand/index/Z')}}">Z</a>
						<a href="{{url('brand/index/_NONE')}}" style="border-left: 1px solid #ccc; padding: 0 5px 0 10px;">Clear</a>
						<a href="{{url('brand/index/_ALL')}}" style="border-left: 1px solid #ccc; padding: 0 5px 0 10px;">View All</a>
						</div>
					<div id="vb_page_head">
							{!! str_replace('/?', '?', $brands->render()) !!}						
					</div>					
		    </div>		  
		  <div class="page-body"></div>		
		  <table class="table" id="brand_table">
			<thead>
			<div class="row">
			  <tr style="background-color: #C0C0C0;">	
				<th></th>
				<th>Brands</th>
				<th>Products</th>
				<th></th>
			  </tr>
			  </div>
			</thead>
			<tbody>
			@if(!empty($brands))
				  @foreach($brands as $brand)
				  <div class="row">
				  <tr data-bid="{{ $brand->brand_id }}" data-val="{{$brand->brand_count}}">
					<td class="col-sm-1" align="center">
						<input type="checkbox" name="check[]" value="{{ $brand->brand_id }}" />				  
					  </td>
					  <td class="col-sm-5">{{$brand->brand_name}}</td>     
					  <td class="col-sm-4">{{ $brand->brand_count}}</td>     
					  <td class="col-sm-2"><a class="edit-brand edit-brand-link" href="{{url('brand/edit/')}}/{{ $brand->brand_id }}" data-bid="{{ $brand->brand_id }}" data-bn="{{ $brand->brand_name }}" data-val="{{$brand->brand_count}}">Edit</a></td>     
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
		</table>
		</form>
	</div>
	<div name="foot" id="vb_foot" >
		<div class="col-sm-5 text-left">
		</div>
		<div class="col-sm-7 text-right" id="vb_foot_pgn8">
				{!! str_replace('/?', '?', $brands->render()) !!}
		</div>				
	</div>
@endsection

@section('scripts')
<script id="add-brand-form-template" type="text/x-handlebars-template">
	<tr class="add-brand-form">
		<td class="col-sm-1"></td>
		<td class="col-sm-5" align="Left">
			<form class="form-inline" id="add-brand-form" action="{{ url('brand/add-brand') }}" method="post">				
				{!! csrf_field() !!}
				<input class="form-control" type="text" id="brand_name" name="brand_name" placeholder="Alpha numeric" value="@{{ brand_name }}"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-brand cancel-add-btn btn btn-default btn-xs" value="Cancel">
			</form>
		</td>
		<td class="col-sm-4"></td>
		<td class="col-sm-2"></td>
	</tr>
</script>

<script id="brand-template" type="text/x-handlebars-template">
	<tr data-bid="@{{ brand_id }}" data-bn="@{{ brand_name}}" data-val="@{{ brand_count }}">
		<td class="col-sm-1" align="center"><input type="checkbox" name="check[]" /></td>
		<td class="col-sm-5" align="Left">@{{ brand_name }}</td>
		<td class="col-sm-4">@{{ brand_count }}</td>
		<td class="col-sm-2"><a class="edit-brand edit-brand-link" data-bid="@{{brand_id}}" data-bn="@{{ brand_name}}" data-val="@{{ brand_count }}">Edit</a></td>
	</tr>
</script>

<script id="edit-brand-template" type="text/x-handlebars-template">
	<tr class="edit-brand-form" data-bid="@{{ brand_id }}" data-bn="@{{ brand_name }}" data-val="@{{brand_count}}">
		<td class="col-sm-1"></td>
		<td class="col-sm-5">
			<form class="form-inline" id="edit-brand-form" action="{{ url('brand/edit') }}/@{{ brand_id }}" method="post">
				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field() !!}
				<input class="form-control" type="text" id="brand_name" name="brand_name" value="@{{ brand_name }}"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-brand cancel-edit-btn btn btn-default btn-xs" data-bn="@{{ brand_name }}" data-bid="@{{ brand_id }}" data-val="@{{brand_count}}" value="Cancel">
			</form>
		</td>
		<td class="col-sm4"></td>
		<td class="col-sm2"></td>
	</tr>
</script>


<script>
	var tmpAddBrandForm = Handlebars.compile($("#add-brand-form-template").html());
	var tmpBrandItem = Handlebars.compile($("#brand-template").html());
	var brandTable = $("table#brand_table tbody");			
	var tmpEditBrandForm = Handlebars.compile($("#edit-brand-template").html());	
	var brandName	='';
	var brandId		=''; 	
	var brandCount	='';
$(document).ready(function(){
	
	//$( ".pagination" ).addClass("pagination-sm");
	
	$(".add-brand-btn").click(function(event){
		event.preventDefault();
		
		$(this).prop('disabled','true');	
		
		if ($(this).hasClass("add-brand")){
			brandTable.append(tmpAddBrandForm).find("tr:last td input[type=\"text\"]").focus();
			//$(this).disable();
		}
	});	
	
	// Cancel add item link click
	$(document).on("click", ".cancel-add-btn", function(event){
		event.preventDefault();
		
		if ($(this).hasClass("cancel-brand")){
			$(this).parent().parent().remove();
			$(".add-brand-btn").prop("disabled",false);		
			$("tr").remove(".add-brand-form");
		}
	});
	
	// Edit item link click
	$(document).on("click", ".edit-brand-link", function(event){
		event.preventDefault();
		event.stopPropagation();
		
		// Remove form, and show add button
		if ($(this).hasClass("edit-brand")){
			var brandName = $(this).attr('data-bn');
			var brandId = $(this).attr('data-bid');			
			var brandCount = $(this).attr('data-val');			
			$(this).parent().parent().after(tmpEditBrandForm({ brand_id: brandId, brand_name: brandName, brand_count:brandCount})).remove();
		}		
	});
	
	$(document).on("click", ".cancel-edit-btn", function(event){
		event.preventDefault();
		event.stopPropagation();	
		
		if ($(this).hasClass("cancel-brand")){
			brandName 	= $(this).attr('data-bn');
			brandId 	= $(this).attr('data-bid');
			brandCount 	= $(this).attr('data-val');		
			$(this).parent().parent().parent()
			.after(tmpBrandItem({ brand_id: brandId, brand_name: brandName, brand_count: brandCount}))
			.remove();		
		} 
				
	});
	
});	

</script>

@endsection
