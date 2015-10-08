@extends('shared._layout')

@section('title', 'Products')

@section('styles')
	{!! HTML::style('css/product-index-styles.css') !!}
	<style>
	tr.product-parent td{
		vertical-align:middle !important;
	}
	tr.product-parent{
		cursor:pointer;
	}
	tr.product-child{
		display:none;
	}
	tr.selected{
		background:#aef !important;
	}
	tr.product-parent:hover{
		outline:solid 1px #ccc;
	}
	ul.pagination{
		font-size:0.75em;		
		margin:0px;
	}
	</style>
@endsection

@section('content')
	<table class="table table-condensed table-striped">
		<thead>
			<th></th>
			<th>Image</th>
			<th>Model Code</th>
			<th>SKU Barcode</th>
			<th>Environment Code</th>
			<th>Brand</th>
			<th width="300">Product Name</th>
			<th>Inventory</th>
			<th>Price</th>
			<th>Enable</th>
			<th>Status</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach($items as $item)
				@if(isset($item['variations']))
					<tr class="product-parent" data-mc="{{ $item['model_code'] }}">
						<td><a href="#" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-triangle-right"></span></a></td>
						<td>{!! HTML::image('images/products/sample.jpg', null, ['class' => 'product-img-main']) !!}</td>
						<td>{{ $item['model_code'] }}</td>
						<td></td>
						<td></td>
						<td>{{ $item['brand_name'] }}</td>
						<td>{{ $item['product_name'] }}</td>
						<td></td>				
						<td></td>
						<td></td>
						<td></td>
						<td class="text-center">
							<a href="{{ url('product/edit/' . $item['model_code']) }}" title="Edit">Edit</a><br/>
							<a href="#" title="Log">Log</a>
						</td>
					</tr>
					@foreach($item['variations'] as $variation)
						<tr class="product-child" data-mc="{{ $item['model_code'] }}">
							<td></td>
							<td></td>
							<td>{!! HTML::image('images/products/sample.jpg', null, ['class' => 'product-img-main']) !!}</td>
							<td>{{ $variation['sku_barcode'] }}</td>
							<td>{{ $variation['environment_code'] }}</td>
							<td></td>
							<td>{{ $variation['variation_name'] }}</td>
							<td>{{ $variation['inventory'] }}</td>
							<td>{{ $variation['sku_price'] }}</td>
							<td class="text-center"><span {!! $variation['enable'] ? 'class="glyphicon glyphicon-ok"' : 'class="glyphicon glyphicon-remove"' !!}></span></td>
							<td>{{ $variation['status_name'] }}</td>
							<td></td>
						</tr>
					@endforeach
				@else
					<tr class="product-parent" data-mc="{{ $item['model_code'] }}">
						<td></td>
						<td>{!! HTML::image('images/products/sample.jpg', null, ['class' => 'product-img-main']) !!}</td>
						<td>{{ $item['model_code'] }}</td>
						<td>{{ $item['sku_barcode'] }}</td>
						<td>{{ $item['environment_code'] }}</td>
						<td>{{ $item['brand_name'] }}</td>
						<td>{{ $item['product_name'] }}</td>
						<td>{{ $item['inventory'] }}</td>				
						<td>{{ $item['sku_price'] }}</td>
						<td class="text-center"><span {!! $item['enable'] ? 'class="glyphicon glyphicon-ok"' : 'class="glyphicon glyphicon-remove"' !!}></span></td>
						<td>{{ $item['status'] }}</td>
						<td class="text-center">
							<a href="{{ url('product/edit/' . $item['model_code']) }}" title="Edit">Edit</a><br/>
							<a href="#" title="Log">Log</a>
						</td>
					</tr>
				@endif
			@endforeach		
		</tbody>
	</table>
	<div class="text-right">
		{!! str_replace('/?', '?', $products->render()) !!}
	</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$("tr.product-parent td:first-child > a").click(function(event){
			event.preventDefault();
			event.stopPropagation();
			
			$(this).find("span").toggleClass("glyphicon glyphicon-triangle-right").toggleClass("glyphicon glyphicon-triangle-bottom");
			$(this).parent().parent().siblings('tr.product-child[data-mc="' + $(this).parent().parent().attr("data-mc") + '"]').fadeToggle(100);
		});
		
		$("tr.product-parent").click(function(){
			$(this).toggleClass("selected");
		})
	});
</script>	
@endsection