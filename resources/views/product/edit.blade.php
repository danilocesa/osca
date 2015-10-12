@extends('shared._layout')

@section('title', 'Product Details')

@section('styles')
	{!! HTML::style('css/product-edit-styles.css') !!}
	{!! HTML::style('css/category-picker-styles.css') !!}
@endsection

@section('content')
<form method="POST" id="edit-product-form" class="form-horizontal" enctype="multipart/form-data" action="{{ url('product/edit/' . $item['model_code']) }}">
	{!! csrf_field() !!}
	<input type="hidden" name="_method" value="PUT">
	<input type="hidden" id="product_changed" name="product_changed" value="0">
	<input type="hidden" id="submit_button_clicked" name="submit_button_clicked" value="">

	<div class="row">
		<div class="col-md-6">
			<h2>Product Details</h2>
		</div>
		<div class="col-md-6">
			
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-customized mms-color">MMS</div>
				<div class="panel-body">
					@include('product.partials.mms_partial')	
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">	
			<div class="panel panel-default">
				<div class="panel-heading panel-heading-customized es-color">E-STORE</div>
				<div class="panel-body">
					<h5 class="panel panel-customized">Edit Product</h5>		  
					@include('product.partials.edit_product_partial')						
					<br/>						
					<h5 class="panel panel-customized">Categorization</h5>
					@include('product.partials.categorization_partial')
					<br />		  
					<div class="row">
						<div class="col-md-6">
							<h5 class="panel panel-customized">Shipping Details</h5>
							@include('product.partials.shipping_details_partial')
						</div>
			
						<div class="col-md-6">
							<h5 class="panel panel-customized">Product Description</h5>
							@include('product.partials.product_desc_partial')
						</div>
					</div>
					<br />
					<h5 class="panel panel-customized">Variations</h5>
					<div class="row">
						<div class="col-md-12">
							@include('product.partials.upload_images_partial')	
						</div>
					</div>					
					<br />		  
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-1">
								<div id="square" class="es-color"></div>
								<p class="side-note">E-Store</p>
							</div>
							<div class="col-md-1">
								<div id="square" class="mms-color"></div>
								<p class="side-note">MMS</p>
							</div>
						</div>	
					</div>
					<div class="row">
						<div class="col-md-12">
							@include('product.partials.variation_table_partial')
						</div>	
					</div>	   
					<div class="row">
						<div class="col-md-6">
							<h5 class="panel panel-customized">Other Details</h5>
							@include('product.partials.other_details_partial')
						</div>						
						<div class="col-md-6">
							<h5 class="panel panel-customized">Search Engine / Youtube Video</h5>
							@include('product.partials.search_engine_partial')
						</div>
					</div>		  
				</div>
			</div>
			@include('product.partials.buttons_partial')
		</div>
	</div>
</form>

<script id="image-template" type="text/x-handlebars-template">
	<div id="@{{ filename }}">
		<input type="radio" name="primary_image_id[@{{ variation_id }}]" value="@{{ filename }}">	
		<a href="#" class="remove-image-link" data-code-display-id="@{{ variation_id }}">X</a>
		<img src="@{{ image_url }}"/>
	</div>
</script>
@endsection
	
@section('scripts')
{!! HTML::script('js/category-picker.js') !!}
<script>
	var tmpImage = Handlebars.compile($("#image-template").html());
	
	var $productChanged = $("#product_changed");
	var $submitButtons = $("#submit-buttons");
	var $submitButtonClicked = $("#submit_button_clicked");
	var $imageUpload = $("#imageUpload");
	
	var images = {};
	
	$(document).ready(function() {
		// Initialize category picker
		initCategoryPicker();
		
		// Pre-select subcategories for the current product
		var preSelectedSubcategories = [];
		
		@foreach($item['categories'] as $category)
		preSelectedSubcategories.push({{ $category->subcategory_id }});
		@endforeach
		
		selectSubcategories(preSelectedSubcategories);
		
		// Initialize brand selector
		$("#brand_id_es").select2({
			ajax: {
				url: "{{ url('product/brands') }}",
				dataType: 'json',
				method: 'get',
				delay: 250,
				data: function (params) {
					return {
						q: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			},
			escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			minimumInputLength: 1
		});
		
		// Handling changes on product
		$(document).on("change", ".watch-product-changes", function(event){
			$productChanged.val(1);
			$submitButtons.css("display", "inline-block");
		});
		
		// Handling changes on product variation
		$(document).on("change", ".watch-variation-changes", function(event){
			$(this).parent().parent().parent().find("td:first-child > div > input.variation_changed").val(1);
			$submitButtons.css("display", "inline-block");
		});
		
		// Changing of primary variation (radio button)
		$(document).on("change", ".color-variation", function(event){
			
		});
		
		// Show images for selected variation
		$("table#variation-primary-table").on("click", "tr", function(event){
			$("table#variation-primary-table tr.selected").removeClass("selected");
			$(this).addClass("selected");
			
			$(".color-variation-images").hide();
			$(".color-variation-images[data-code-display-id=\"" + $(this).attr("data-code-display-id") + "\"]").show();
		});
		
		// Handling click of upload button
		$(document).on("click", ".btn-upload", function(event){
			$imageUpload.click();
		});
		
		// Changing of selected images for upload
		$imageUpload.change(function(event){
			var selectedVariationId = $("table#variation-primary-table tr.selected").attr("data-code-display-id");
			
			if (images[selectedVariationId] == null){
				images[selectedVariationId] = [];
			}
			
			var files = Array.prototype.slice.call(event.target.files);
			
			files.forEach(function(f) {
				// Make sure only image files are selected
				if(!f.type.match("image.*")) {
					return false;
				}
				
				// Check if image exists in array
				if (checkImagesExists(selectedVariationId, f.name))
					return false;
				
				// Add to array
				images[selectedVariationId].push(f);

				// Show image list
				renderImages(selectedVariationId);
			});	
			
			console.log(images);
		});
		
		// Handling click of one any submit button
		$submitButtons.on("click", "a.btn-submit", function(event){
			event.preventDefault();
		
			$submitButtonClicked.val($(this).attr("data-value"));
			
			if (confirm("Continue?"))
				$("form#edit-product-form").submit();
		});
		
		// Handling click of apply to all variations button
		$(document).on("click", "a#btn-apply-package", function(event){
			event.preventDefault();
		
			$("input[name^=\"weight\"]").val($("input#package_weight").val());
			$("input[name^=\"width\"]").val($("input#package_width").val());
			$("input[name^=\"length\"]").val($("input#package_depth").val());
			$("input[name^=\"height\"]").val($("input#package_height").val());
		});
		
		// Submit product details form
		/*$(document).on("submit", "form#edit-product-form", function(event){
		
			event.preventDefault();
			
			var $form = $(this);
			submitAjaxForm($form, function(data){
				if (data.redirect == true){
					document.location.href = "{{ url('product') }}";
				} else {
					// Reset state, hide submit buttons
					$(".variation_changed").val(0);
					$productChanged.val(0);					
					$submitButtons.hide();
					$("#top-alert").addClass("alert-success")
						.find("span#message")
						.html(data.message)
						.parent()
						.find("span#icon")
						.addClass("glyphicon-ok")
						.parent()
						.fadeIn(100);
					// Scroll to top
					$('body,html').animate({
						scrollTop: 0
					}, 100);
				}
			});
		});*/
	});
	
	// Checks if image file name already exists in files array
	function checkImagesExists(variationId, fileName)
	{		
		images[variationId].forEach(function(f){
			if (f.name == fileName)
				return true;
		});
		
		return false;
	}
	
	function renderImages(variationId)
	{
		var imageList = $(".image-files[data-code-display-id=\"" + variationId + "\"]");
		var imageFilenames = ""; // Concatenate image filenames, because hidden form field cannot have multiple values, thanks HTML5
		var imageFilenamesHidden = $(".image_filenames[data-code-display-id=\"" + variationId + "\"]");
		
		// Remove all contents first
		imageList.html("");
		
		images[variationId].forEach(function(f){
			var reader = new FileReader();
			
			reader.onload = function (e) {
				// To prevent duplication infestation
				if (imageList.find("div[id=\"" + f.name + "\"]").length == 0){
					imageList.append(tmpImage({
						image_url: e.target.result,
						variation_id: variationId,
						filename: f.name
					}));	
				}			
			}
			
			imageFilenames += f.name + "|";
		
			reader.readAsDataURL(f);
		});
		
		imageFilenamesHidden.val(imageFilenames);
	}
</script>
@endsection