<div class="row">	<div class="col-md-3">		<div id="circle"></div>		<div class="circle-position">			<div id="circle2"><span class="number-incircle">1</span></div>		</div>		<div class="col-md-5">			<div class="demo-content">			<p class="p-small" id="primary_color_display_id">				<strong>Variations</strong>: Select and tick one priority variation of the product.			</p>			</div>		</div>		<div class="col-md-7 box-border vertical-scroll-only">			<table id="variation-primary-table" class="table table-condensed">				<thead>					<th>Variation</th>					<th>Primary</th>				</thead>				<tbody>					@foreach($color_variations as $key => $value)					<tr data-code-display-id="{{ $key }}" {!! $item['primary_color_display_id'] == $key ? 'class="selected"' : null !!}>						<td>{{ $value['color_display_name'] }}</td>						<td><input {{ $item['primary_color_display_id'] == $key ? 'checked' : null }} class="watch-product-changes color-variation " type="radio" name="primary_color_display_id" value="{{ $key }}"></td>						<input type="hidden" name="color_variations[]" value="{{ $key }}">					</tr>					@endforeach				</tbody>			</table>		</div>	</div>				<div class="col-md-9">		<div id="circle"></div>		<div class="circle-position">			<div id="circle2"><span class="number-incircle">2</span></div>		</div>		<div class="col-md-2">			<div class="demo-content">			<p class="p-small">				<strong>Upload</strong> : Upload all product angles then tick the primary display image. Select the hex code from the drop down list.			</p>			</div>		</div>		<div class="col-md-10">			<div class="hide">				<input class="watch-product-changes" type="file" id="imageUpload" name="images[]" multiple><br/>			</div>					@foreach($color_variations as $key => $value)			<div data-code-display-id="{{ $key }}" class="box-border color-variation-images" {!! $item['primary_color_display_id'] == $key ? 'style="display:block"' : null !!}>				<div class="col-md-2">					<div class="row">						<div class="col-md-12">							<form id="myForm" method="post">								<label class="p-small">Files:</label>								<button data-code-display-id="{{ $key }}" type="button" class="btn-xs btn-default btn-upload">CHOOSE FILE</button>							</form>						</div>					</div>				</div>									<div class="col-md-10" id="image-holder">					<div data-code-display-id="{{ $key }}" class="image-files">						@foreach( $value['variation_images'] as $value)						<div id="{{ $value['filename'] }}">							<input type="radio" name="primary_image_id[{{ $key }}]" value="{{ $value['filename'] }}" {{ $value['seq_no'] == 1 ? 'checked' : null }} class="watch-product-changes">							<a href="#" class="remove-image-link" data-code-display-id="{{ $key }}" data-filename="{{ $value['filename'] }}" data-seq-no="{{ $value['seq_no'] }}" >X</a>							{!! $value['image'] !!}						</div>						@endforeach					</div>					<input class="image_filenames" type="hidden" data-code-display-id="{{ $key }}" name="image_filenames[{{ $key }}]" value="">				</div>			</div>			@endforeach		</div>		</div></div><br><!--<div class="row">	<div class="col-md-2 col-md-offset-10">		<div id="circleapply"></div>		<div class="circle-position">		<div id="circle2apply"><span class="number-incircle">3</span></div>		</div>		<div class="demo-contentapply">		<button type="button" class="btn-sm btn-primary" id="applytoall" data-loading-text="LOADING..." autocomplete="off" >APPLY TO ALL</button>		<p class="p-small">		Click this to apply to all sizes of the variation.		</p>		</div>	</div>	</div>-->