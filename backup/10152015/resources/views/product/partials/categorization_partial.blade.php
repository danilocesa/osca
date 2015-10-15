<div class="form-horizontal">
	<div class="col-md-6">
		<label id="subcategories" for="estorecategories" class="col-md-2 label-customized">
			<span class="required-field">*</span> Categories
		</label>
		<a id="show-category-picker" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>		
		<div id="category-modal" class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="gridSystemModalLabel">Category Picker</h4>
				</div>
				<div class="modal-body">
					<div id="category-picker">
						<ul class="world">
							@foreach($categories as $world)
								<li>
									<a href="#"><span class="glyphicon glyphicon-triangle-right"></span> {{ $world['world_name'] }}</a>
									<ul class="category">													
										@foreach($world['categories'] as $category)
										<li>
											<a href="#"><span class="glyphicon glyphicon-triangle-right"></span> {{ $category['category_name'] }}</a>
											<ul class="subcategory">
												@foreach($category['subcategories'] as $subcategory)
													<li>
														<label>
															<input class="watch-product-changes" data-wn="{{ $world['world_name'] }}" data-cn="{{ $category['category_name'] }}" data-scn="{{ $subcategory['subcategory_name'] }}" data-scid="{{ $subcategory['subcategory_id'] }}" type="checkbox"> {{ $subcategory['subcategory_name'] }}
														</label>
													</li>
												@endforeach
											</ul>
										</li>
										@endforeach
									</ul>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="modal-footer">
					<a id="hide-category-picker" class="btn btn-primary btn-sm" href="#">Done</a>
				</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<br/><br/>
		
		<div id="category-list"></div>								
	</div>
	
	<div class="col-md-6">
		<div class="row between">
			<div class="form-group">
			<label for="categoryage" class="col-md-3 label-customized">Age:</label>
			<div class="col-sm-5">
				<select id="age_id" name="age_id" class="form-control watch-product-changes">
					<option value="" selected disabled>Select one</option>
					@foreach($ages as $age)
						<option {{ $item['age_id'] == $age->age_id ? 'selected' : null }} value="{{ $age->age_id }}">{{ $age->age_name }}</option>
					@endforeach
				</select>
			</div>
			</div>
		</div>
		
		<div class="row between">
			<div class="form-group">
			<label for="categorygender" class="col-md-3 label-customized">Gender:</label>
			<div class="col-sm-5">
				<select id="gender_id" name="gender_id" class="form-control watch-product-changes">
					<option value="" selected disabled>Select one</option>
					@foreach($genders as $gender)
						<option {{ $item['gender_id'] == $gender->gender_id ? 'selected' : null }} value="{{ $gender->gender_id }}">{{ $gender->gender_name }}</option>
					@endforeach
				</select>
			</div>
			</div>
		</div>
		
		<div class="row between">
			<div class="form-group">
			<label for="categoryseries" class="col-md-3 label-customized">Series:</label>
			<div class="col-sm-5">
				<select id="series_id" name="series_id" class="form-control watch-product-changes">
					<option value="" selected disabled>Select one</option>
				</select>
			</div>
			</div>
		</div>
		
		<div class="row between">
			<div class="form-group">
			<label for="categoryprodstyle" class="col-md-3 label-customized">Product Style:</label>
			<div class="col-sm-5">
				<select id="product_style_id" name="product_style_id" class="form-control watch-product-changes">
					<option value="" selected disabled>Select one</option>
					@foreach($product_styles as $product_style)
						<option {{ $item['product_style_id'] == $product_style->product_style_id ? 'selected' : null }} value="{{ $product_style->product_style_id }}">{{ $product_style->product_style_name }}</option>
					@endforeach
				</select>
			</div>
			</div>
		</div>
		
		<div class="row between">
			<div class="form-group">
			<label for="categorytop" class="col-md-3 label-customized">Top Category:</label>
			<div class="col-sm-5">
				<select id="top_category_id" name="top_category_id" class="form-control watch-product-changes">
					<option value="" selected disabled>Select one</option>
					@foreach($worlds as $world)
						<option {{ $item['top_category_id'] == $world->world_id ? 'selected' : null }} value="{{ $world->world_id }}">{{ $world->world_name }}</option>
					@endforeach
				</select>
			</div>
			</div>
		</div>
	</div>
</div>