@extends('shared._layout')

@section('title', 'Products')

@section('styles')
	{!! HTML::style('css/image-styles.css') !!}
	{!! HTML::style('css/table-styles.css') !!}
@endsection

@section('content')
	<table class="table table-condensed table-striped">
		<thead>
			<th></th>
			<th>Image</th>
			<th>Model Code</th>
			<th>SKU Barcode</th>
			<th>Brand</th>
			<th>Product Name</th>
			<th>Inventory</th>
			<th>Price</th>
			<th>Enable</th>
			<th>Status</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach($items as $item)
			<tr class="product-parent">
				<td><input type="checkbox"></td>
				<td>{!! HTML::image('images/products/sample.jpg', null, ['class' => 'product-img-main']) !!}</td>
				<td>{{ $item->model_code }}</td>
				<td></td>
				<td>{{ $item->brand }}</td>
				<td>{{ $item->product_name }}</td>
				<td></td>
				<td>PhP 599.75</td>
				<td></td>
				<td></td>
				<td>
					<a href="#" class="btn btn-default btn-xs" title="Preview"><span class="glyphicon glyphicon-eye-open"></span></a>
					<a href="#" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="#" class="btn btn-default btn-xs" title="Log"><span class="glyphicon glyphicon-list-alt"></span></a>
				</td>
			</tr>
			@endforeach
			<!--tr>
				<td></td>
				<td></td>
				<td rowspan="4">{!! HTML::image('images/products/sample.jpg', null, ['class' => 'product-img-main']) !!}</td>
				<td>45678</td>
				<td></td>
				<td>Color: Blue, Size: 32</td>
				<td>15</td>
				<td>PhP 599.75</td>
				<td><span class="glyphicon glyphicon-ok"></span></td>
				<td>Approved</td>
				<td>
					<a href="#" class="btn btn-default btn-xs" title="Edit"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="#" class="btn btn-default btn-xs" title="Log"><span class="glyphicon glyphicon-list-alt"></span></a>
				</td>
			</tr-->			
		</tbody>
	</table>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		
	});
</script>	
@endsection