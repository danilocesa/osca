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
		<th class="es-color" width="10">Approve</th>
	  </tr>
	</thead>
	<tbody>
		@foreach($item['variations'] as $variation)
			<tr>
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
				<td width="110">
					<div class="input-group">
						<input type="text" name="weight[{{ $variation['product_id'] }}]" value="{{ $variation['weight'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">KG</div>
					</div>
				</td>
				<td width="110">
					<div class="input-group">
						<input type="text" name="length[{{ $variation['product_id'] }}]" value="{{ $variation['length'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">CM</div>
					</div>
				</td>
				<td width="110">
					<div class="input-group">
						<input type="text" name="width[{{ $variation['product_id'] }}]" value="{{ $variation['width'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">CM</div>
					</div>
				</td>
				<td width="110">
					<div class="input-group">
						<input type="text" name="height[{{ $variation['product_id'] }}]" value="{{ $variation['height'] }}" class="form-control form-control-inline text-right watch-variation-changes" maxlength="7">
						<div class="input-group-addon">CM</div>
					</div>
				</td>
				<td>{{ $variation['inventory'] }}</td>
				<td><input type="checkbox" name="approved[{{ $variation['product_id'] }}]" {{ $variation['approved'] ? 'checked' : null }}></td>
			</tr>
		@endforeach
	</tbody>
</table>