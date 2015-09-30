@extends('shared._layout')

@section('title', 'Categories')

@section('styles')
<style>
table.table tbody td {
  border:none;
}
div.list{
  border:solid 1px #ccc;
  height:400px;
  padding:10px;
  overflow:auto;
}
tr.world-item > td:first-child, tr.category-item > td:first-child, tr.subcategory-item > td:first-child{
  color:#333;
  font-weight:bold;
}
tr.world-item, tr.category-item, tr.subcategory-item{
  cursor:pointer;
}
tr.world-item:hover, tr.category-item:hover, tr.subcategory-item:hover{
  outline:solid 1px #ccc;
}
tr.selected{
  background:#aef;
}
tr.category-item, tr.subcategory-item{
  display:none;
}
</style>
@endsection

@section('content')
<div class="row">
<div class="col-md-4">
	<h4>World</h4>
	<div class="list">
	<table id="world-table" class="table">
	<tbody>
		@foreach ($categories as $world)
		<tr class="world-item" data-wid="{{ $world->world_id }}">
			<td width="65%">{{ $world->world_name }}</td>
			<td>
				<a href="#">Products</a> |
				<a href="#" class="edit-world edit-item-link" data-wn="{{ $world->world_name }}" data-wid="{{ $world->world_id }}">Edit</a>
			</td>
		</tr>
		@endforeach
	</tbody>
	</table>
	</div>
	<br />
	<div class="text-right">
		<a href="#" class="add-world add-item-btn btn btn-default btn-sm">Add new world</a>
	</div>
</div>
<div class="col-md-4">
	<h4>Category</h4>
	<div class="list">
	<table id="category-table" class="table">
	<tbody>
		@foreach ($categories as $world)
			@foreach ($world->categories as $category)
			<tr class="category-item" data-wid="{{ $world->world_id }}" data-cid="{{ $category->category_id }}">
				<td width="65%">{{ $category->category_name }}</td>
				<td>
					<a href="#">Products</a> |
					<a href="#" class="edit-category edit-item-link" data-wid="{{ $world->world_id }}" data-cn="{{ $category->category_name }}" data-cid="{{ $category->category_id }}">Edit</a>
				</td>
			</tr>
			@endforeach
		@endforeach
	</tbody>
	</table>
	</div>
	<br />
	<div class="text-right">
		<a href="#" class="add-category add-item-btn btn btn-default btn-sm">Add new category</a>
	</div>
</div>
<div class="col-md-4">
	<h4>Subcategory</h4>
	<div class="list">
	<table id="subcategory-table" class="table">
	<tbody>
		@foreach ($categories as $world)
			@foreach ($world->categories as $category)
				@foreach ($category->subcategories as $subcategory)
				<tr class="subcategory-item" data-cid="{{ $category->category_id }}" data-scid="{{ $subcategory->subcategory_id }}">
					<td width="65%">{{ $subcategory->subcategory_name }}</td>
					<td>
						<a href="#">Products</a> |
						<a href="#" class="edit-subcategory edit-item-link" data-cid="{{ $category->category_id }}" data-scn="{{ $subcategory->subcategory_name }}" data-scid="{{ $subcategory->subcategory_id }}">Edit</a>
					</td>
				</tr>
				@endforeach
			@endforeach		
		@endforeach
	</tbody>
	</table>
	</div>
	<br />
	<div class="text-right">
		<a href="#" class="add-subcategory add-item-btn btn btn-default btn-sm">Add new subcategory</a>
	</div>
</div>
</div>
@endsection

@section('scripts')
<script id="add-world-form-template" type="text/x-handlebars-template">
	<tr>
		<td colspan="2">
			<form class="form-inline" id="add-world-form" action="{{ url('category/add-world') }}" method="post">
				{!! csrf_field() !!}
				<input class="form-control" type="text" name="world_name" placeholder="World name"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-world cancel-add-btn btn btn-default btn-xs" value="Cancel">
			</form>
		</td>
	</tr>
</script>

<script id="edit-world-form-template" type="text/x-handlebars-template">
	<tr>
		<td colspan="2">
			<form class="form-inline" id="edit-world-form" action="{{ url('category/edit-world') }}/@{{ world_id }}" method="post">
				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field() !!}
				<input class="form-control" type="text" name="world_name" value="@{{ world_name }}"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-world cancel-edit-btn btn btn-default btn-xs" data-wn="@{{ world_name }}" data-wid="@{{ world_id }}" value="Cancel">
			</form>
		</td>
	</tr>
</script>

<script id="add-category-form-template" type="text/x-handlebars-template">
	<tr>
		<td colspan="2">
			<form class="form-inline" id="add-category-form" action="{{ url('category/add-category') }}/@{{ world_id }}" method="post">
				{!! csrf_field() !!}
				<input class="form-control" type="text" name="category_name" placeholder="Category name"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-category cancel-add-btn btn btn-default btn-xs" value="Cancel">
			</form>
		</td>
	</tr>
</script>

<script id="edit-category-form-template" type="text/x-handlebars-template">
	<tr>
		<td colspan="2">
			<form class="form-inline" id="edit-category-form" action="{{ url('category/edit-category') }}/@{{ world_id }}/@{{ category_id }}" method="post">
				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field() !!}
				<input class="form-control" type="text" name="category_name" value="@{{ category_name }}"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-category cancel-edit-btn btn btn-default btn-xs" data-cn="@{{ category_name }}" data-wid="@{{ world_id }}" data-cid="@{{ category_id }}" value="Cancel">
			</form>
		</td>
	</tr>
</script>

<script id="add-subcategory-form-template" type="text/x-handlebars-template">
	<tr>
		<td colspan="2">
			<form class="form-inline" id="add-subcategory-form" action="{{ url('category/add-subcategory') }}/@{{ category_id }}" method="post">
				{!! csrf_field() !!}
				<input class="form-control" type="text" name="subcategory_name" placeholder="Subcategory name"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-subcategory cancel-add-btn btn btn-default btn-xs" value="Cancel">
			</form>
		</td>
	</tr>
</script>

<script id="edit-subcategory-form-template" type="text/x-handlebars-template">
	<tr>
		<td colspan="2">
			<form class="form-inline" id="edit-subcategory-form" action="{{ url('category/edit-subcategory') }}/@{{ category_id }}/@{{ subcategory_id }}" method="post">
				<input type="hidden" name="_method" value="PUT">
				{!! csrf_field() !!}
				<input class="form-control" type="text" name="subcategory_name" value="@{{ subcategory_name }}"/>
				<input type="submit" class="btn btn-primary btn-xs" value="Save"/>					
				<input type="button" class="cancel-subcategory cancel-edit-btn btn btn-default btn-xs" data-scn="@{{ subcategory_name }}" data-cid="@{{ category_id }}" data-scid="@{{ subcategory_id }}" value="Cancel">
			</form>
		</td>
	</tr>
</script>

<script id="world-item-template" type="text/x-handlebars-template">
	<tr class="world-item" data-wid="@{{ world_id }}">
		<td width="65%">@{{ world_name }}</td>
		<td>
			<a href="#">Products</a> |
			<a href="#" class="edit-world edit-item-link" data-wn="@{{ world_name }}" data-wid="@{{ world_id }}">Edit</a>
		</td>
	</tr>
</script>

<script id="category-item-template" type="text/x-handlebars-template">
	<tr class="category-item" data-wid="@{{ world_id }}" data-cid="@{{ category_id }}" style="display:table-row">
		<td width="65%">@{{ category_name }}</td>
		<td>
			<a href="#">Products</a> |
			<a href="#" class="edit-category edit-item-link" data-wid="@{{ world_id }}" data-cn="@{{ category_name }}" data-cid="@{{ category_id }}">Edit</a>
		</td>
	</tr>
</script>

<script id="subcategory-item-template" type="text/x-handlebars-template">
	<tr class="subcategory-item" data-cid="@{{ category_id }}" data-scid="@{{ subcategory_id }}" style="display:table-row">
		<td width="65%">@{{ subcategory_name }}</td>
		<td>
			<a href="#">Products</a> |
			<a href="#" class="edit-subcategory edit-item-link" data-cid="@{{ category_id }}" data-scn="@{{ subcategory_name }}" data-scid="@{{ subcategory_id }}">Edit</a>
		</td>
	</tr>
</script>

<script>
// Templates
var tmpAddWorldForm = Handlebars.compile($("#add-world-form-template").html());
var tmpAddCategoryForm = Handlebars.compile($("#add-category-form-template").html());
var tmpAddSubcategoryForm = Handlebars.compile($("#add-subcategory-form-template").html());

var tmpEditWorldForm = Handlebars.compile($("#edit-world-form-template").html());
var tmpEditCategoryForm = Handlebars.compile($("#edit-category-form-template").html());
var tmpEditSubcategoryForm = Handlebars.compile($("#edit-subcategory-form-template").html());

var tmpWorldItem = Handlebars.compile($("#world-item-template").html());
var tmpCategoryItem = Handlebars.compile($("#category-item-template").html());
var tmpSubcategoryItem = Handlebars.compile($("#subcategory-item-template").html());

var $worldTable = $("table#world-table tbody");
var $categoryTable = $("table#category-table tbody");
var $subcategoryTable = $("table#subcategory-table tbody");


$(document).ready(function(){

	// Row selection
	$(document).on("click", "tr.world-item, tr.category-item, tr.subcategory-item", function(){
		// If this row is already selected, have a coffee
		if ($(this).hasClass("selected"))
		return;
		
		// Deselect previously selected row and select current row
		$(this).siblings("tr.selected").removeClass("selected");
		$(this).addClass("selected");
		
		// Show categories under selected world
		if ($(this).hasClass("world-item")){
			// Hide previous category and subcategory items
			$("tr.category-item").removeClass("selected").hide();
			$categoryTable.find("tr:not(.category-item)").remove();
			$(".add-category").show();
			$("tr.subcategory-item").removeClass("selected").hide();
			$subcategoryTable.find("tr:not(.subcategory-item)").remove();
			$(".add-subcategory").show();
			
			$("tr.category-item[data-wid=\"" + $(this).attr("data-wid") + "\"]").fadeIn();
		}
		// Show subcategories under selected category
		else if ($(this).hasClass("category-item")){   
			// Hide previous subcategory items
			$("tr.subcategory-item").removeClass("selected").hide();
			$subcategoryTable.find("tr:not(.subcategory-item)").remove();
			$(".add-subcategory").show();
      
			$("tr.subcategory-item[data-cid=\"" +  $(this).attr("data-cid") + "\"]").fadeIn();
		}
	});
  
	// Add new item button click
	$(".add-item-btn").click(function(){
		event.preventDefault();
		
		if ($(this).hasClass("add-world")){
			$worldTable.append(tmpAddWorldForm).find("tr:last td input[type=\"text\"]").focus();
			$(this).hide();
		} else if ($(this).hasClass("add-category")) {
			// Check if there is a selected world
			if (!$("tr.world-item").hasClass("selected")){
				alert("Please select a world first!");
				return;
			}
			
			var currWorldId = $worldTable.find("tr.selected").attr("data-wid");
			$categoryTable.append(tmpAddCategoryForm({ world_id: currWorldId })).find("tr:last td input[type=\"text\"]").focus();
			$(this).hide();
		} else if ($(this).hasClass("add-subcategory")) {
			// Check if there is a selected category
			if (!$("tr.category-item").hasClass("selected")){
				alert("Please select a category first!");
				return;
			}
			
			var currCategoryId = $categoryTable.find("tr.selected").attr("data-cid");
			$subcategoryTable.append(tmpAddSubcategoryForm({ category_id: currCategoryId })).find("tr:last td input[type=\"text\"]").focus();
			$(this).hide();
		}
	});
	
	// Cancel add item button
	$(document).on("click", ".cancel-add-btn", function(){
		event.preventDefault();
		
		// Remove form, and show add button
		if ($(this).hasClass("cancel-world")){
			$(this).parent().parent().remove();
			$(".add-world").show();
		} else if ($(this).hasClass("cancel-category")){
			$(this).parent().parent().remove();
			$(".add-category").show();
		} else if ($(this).hasClass("cancel-subcategory")){
			$(this).parent().parent().remove();
			$(".add-subcategory").show();
		}
	});
  
	// Edit item link click
	$(document).on("click", ".edit-item-link", function(event){
		event.preventDefault();
		event.stopPropagation();
		
		// Remove form, and show add button
		if ($(this).hasClass("edit-world")){
			var worldName = $(this).attr('data-wn');
			var worldId = $(this).attr('data-wid');			
			$(this).parent().parent().after(tmpEditWorldForm({ world_id: worldId, world_name: worldName})).remove();
		} else if ($(this).hasClass("edit-category")){
			var categoryName = $(this).attr('data-cn');
			var categoryId = $(this).attr('data-cid');			
			var worldId = $(this).attr('data-wid');			
			$(this).parent().parent().after(tmpEditCategoryForm({ world_id: worldId, category_name: categoryName, category_id: categoryId})).remove();
		} else if ($(this).hasClass("edit-subcategory")){
			var subcategoryName = $(this).attr('data-scn');
			var subcategoryId = $(this).attr('data-scid');			
			var categoryId = $(this).attr('data-cid');			
			$(this).parent().parent().after(tmpEditSubcategoryForm({ category_id: categoryId, subcategory_name: subcategoryName, subcategory_id: subcategoryId})).remove();
		}
	});

	// Cancel edit item link click
	$(document).on("click", ".cancel-edit-btn", function(event){
		event.preventDefault();
		
		// Remove form, and show add button
		if ($(this).hasClass("cancel-world")){
			var worldName = $(this).attr('data-wn');
			var worldId = $(this).attr('data-wid');			
			$(this).parent().parent().parent().after(tmpWorldItem({ world_id: worldId, world_name: worldName})).remove();		
		} else if ($(this).hasClass("cancel-category")){
			var categoryName = $(this).attr('data-cn');
			var categoryId = $(this).attr('data-cid');			
			var worldId = $(this).attr('data-wid');			
			$(this).parent().parent().parent().after(tmpCategoryItem({ world_id: worldId, category_name: categoryName, category_id: categoryId})).remove();
		} else if ($(this).hasClass("cancel-subcategory")){
			var subcategoryName = $(this).attr('data-scn');
			var subcategoryId = $(this).attr('data-scid');			
			var categoryId = $(this).attr('data-cid');			
			$(this).parent().parent().parent().after(tmpSubcategoryItem({ category_id: categoryId, subcategory_name: subcategoryName, subcategory_id: subcategoryId})).remove();
		}
	});
  
	// AJAX Forms
	$(document).on("submit", "form#add-world-form", function(){
		var $form = $(this);
	
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {				
                var json = JSON.parse(data);
				$worldTable.append(tmpWorldItem(json));
				$form.parent().parent().remove();
				$(".add-world").show();
            },
			error : function(data) {
				var json = JSON.parse(data.responseJSON);
				alert(json.world_name);
			}
        });
		event.preventDefault();
	});
	
	$(document).on("submit", "form#edit-world-form", function(){
		var $form = $(this);
	
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {				
                var json = JSON.parse(data);
				$form.parent().parent().after(tmpWorldItem(json)).remove();	
            },
			error : function(data) {
				var json = JSON.parse(data.responseJSON);
				alert(json.world_name);
			}
        });
		event.preventDefault();
	});
	
	$(document).on("submit", "form#add-category-form", function(){
		var $form = $(this);
	
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {				
                var json = JSON.parse(data);
				$categoryTable.append(tmpCategoryItem(json));
				$form.parent().parent().remove();
				$(".add-category").show();
            },
			error : function(data) {
				var json = JSON.parse(data.responseJSON);
				alert(json.category_name);
			}
        });
		event.preventDefault();
	});

	$(document).on("submit", "form#edit-category-form", function(){
		var $form = $(this);
	
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {				
                var json = JSON.parse(data);
				$form.parent().parent().after(tmpCategoryItem(json)).remove();	
            },
			error : function(data) {
				var json = JSON.parse(data.responseJSON);
				alert(json.category_name);
			}
        });
		event.preventDefault();
	});
	
	$(document).on("submit", "form#add-subcategory-form", function(){
		var $form = $(this);
	
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {				
                var json = JSON.parse(data);
				$subcategoryTable.append(tmpSubcategoryItem(json));
				$form.parent().parent().remove();
				$(".add-subcategory").show();
            },
			error : function(data) {
				var json = JSON.parse(data.responseJSON);
				alert(json.subcategory_name);
			}
        });
		event.preventDefault();
	});

	$(document).on("submit", "form#edit-subcategory-form", function(){
		var $form = $(this);
	
		$.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {				
                var json = JSON.parse(data);
				$form.parent().parent().after(tmpSubcategoryItem(json)).remove();	
            },
			error : function(data) {
				var json = JSON.parse(data.responseJSON);
				alert(json.subcategory_name);
			}
        });
		event.preventDefault();
	});
});
</script>	
@endsection