<table id="variation-table" class="table table-bordered table-customized">
  <thead>
	  <tr>
	    <th class="es-color" width="10">Enable</th>
	    <th class="mms-color" >Color</th>
	    <th class="mms-color" width="10">Color<br/>Code</th>
	    <th class="mms-color">Color<br/>Display</th>
	    <th class="mms-color" >Size</th>
		<th class="mms-color" width="10">Size<br/>Code</th>
		<th class="mms-color" width="10">SKU<br/>Barcode</th>
		<th class="mms-color" width="10">Environment<br/>Code</th>
		<th class="mms-color">Variation<br/>Price</th>
		<th class="es-color" width="10">Weight</th>
		<th class="es-color" width="10">Length</th>
		<th class="es-color" width="10">Width</th>
		<th class="es-color" width="10">Height</th>
		<th class="mms-color" width="10">Stock<br/>Level</th>
		@if(\Auth::user()->role->hasPermission("CAN_APPROVE_PRODUCT"))
		<th class="es-color" width="10">Approve</th>
		@endif
	  </tr>
	</thead>
	<tbody>
		@foreach($item['variations'] as $variation)
			<?php
				$prod_id=$variation['product_id'];	
				$wt[]=Session::get('weight');								
				$weight=array_get($wt[0],$prod_id);
				
				$ht[]=Session::get('height');								
				$height=array_get($ht[0],$prod_id);
				
				$wid[]=Session::get('width');								
				$width=array_get($wid[0],$prod_id);
				
				$lg[]=Session::get('length');								
				$length=array_get($lg[0],$prod_id);
			?>					
			<tr data-product-id="{{ $variation['product_id'] }}">
				<td>
					<div>
						<input type="checkbox" name="enable[{{ $variation['product_id'] }}]" {{ $variation['enable'] ? 'checked' : null }} class="watch-variation-changes">
						<input type="hidden" name="product_id[{{ $variation['product_id'] }}]" value="{{ $variation['product_id'] }}">
						<input type="hidden" class="variation_changed" data-product-id="{{ $variation['product_id'] }}" name="variation_changed[{{ $variation['product_id'] }}]" value="0">
					</div>
				</td>
				<td>{{ $variation['color_name'] }}</td>
				<td>{{ $variation['color_code'] }}</td>
				<td>{{ $variation['color_display_name'] }}</td>
				<td>{{ $variation['size_name'] }}</td>
				<td>{{ $variation['size_code'] }}</td>
				<td>{{ $variation['sku_barcode'] }}</td>
				<td>{{ $variation['environment_code'] }}</td>
				<td>PHP 599.95</td>
				<td width="110" class="weight">
				<!--initialization of old inputs -->
					<div id="weight[{{ $variation['product_id'] }}]" class="input-group">
						<input type="text" name="weight[{{ $variation['product_id'] }}]" value="{{ $weight or $variation['weight'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">KG</div>
					</div>
					<div class="error-message">
						{{ $errors->errmess->first('weight['.$variation["product_id"].']') }}												
					</div>
				</td>
				<td width="110" class="length">
					<div id="length[{{ $variation['product_id'] }}]" class="input-group">
						<input type="text" name="length[{{ $variation['product_id'] }}]" value="{{ $length or $variation['length'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">CM</div>
					</div>
					<div class="error-message">
						{{ $errors->errmess->first('length['.$variation["product_id"].']') }}
					</div>					
				</td>
				<td width="110" class="width">
					<div id="width[{{ $variation['product_id'] }}]" class="input-group">
						<input type="text" name="width[{{ $variation['product_id'] }}]" value="{{ $width or $variation['width'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">CM</div>
					</div>
					<div class="error-message">
						{{ $errors->errmess->first('width['.$variation["product_id"].']') }}
					</div>
				</td>
				<td width="110" class="height">
					<div id="height[{{ $variation['product_id'] }}]" class="input-group">
						<input type="text" name="height[{{ $variation['product_id'] }}]" value="{{ $height or $variation['height'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">CM</div>
					</div>
					<div class="error-message">			
						{{ $errors->errmess->first('height['.$variation["product_id"].']') }}
					</div>
				</td>
				<td>{{ $variation['inventory'] }}</td>
				@if(\Auth::user()->role->hasPermission("CAN_APPROVE_PRODUCT"))
				<td>
					<div>
						<input type="checkbox" name="approved[{{ $variation['product_id'] }}]" {{ $variation['approved'] ? 'checked' : null }} class="watch-variation-changes">
					</div>
				</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>