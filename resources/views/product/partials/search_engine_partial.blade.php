<div class="form-horizontal">	<div class="form-group between">	<label class="col-md-3 label-customized">Meta Title:</label>	<div class="col-sm-9">		<input id="meta_title" name="meta_title" value="{{ $item['meta_title'] }}" type="text" class="form-control watch-product-changes">	</div>	</div>		<div class="form-group between">	<label class="col-md-3 label-customized">Meta Keywords:</label>	<div class="col-sm-9">		<input id="meta_keyword" name="meta_keyword" value="{{ $item['meta_keyword'] }}" type="text" class="form-control watch-product-changes">	</div>	</div>	<label class="label-customized">		Youtube Video:	</label>	<div class="between">		<textarea id="pdp_video" name="pdp_video" class="form-control textarea-customized watch-product-changes">{{ $item['pdp_video'] }}</textarea>	</div></div>