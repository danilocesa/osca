@extends('shared._layout')

@section('title', 'Products')

@section('styles')
	{!! HTML::style('css/product-index-styles.css') !!}
@endsection

@section('content')
<div class="navbar" style="margin:0;">
	<!-- search -->
	<div class="navbar-right"><!-- style="width: 30%; float:right; padding: 20px 20px 0 0" -->
      <form class="navbar-form navbar-left" role="search" action="{{ url('product/search') }}" method="get">
        <div class="input-group"> <!-- style="width: 50%; float:right; padding: 20px 20px 0 0" -->
	      <input type="text" name="product_search" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit">
	            <span class="glyphicon glyphicon-search" />
	          </button>
            </span>
        </div><!-- /input-group -->
	  </form>
    </div>
</div>

	<div class="panel" id="vb_head">
		<div name="head">
				<div class="text-center">
					<!--a href="#">#</a-->
					<a href="{{url('product/index/A')}}">A</a>
					<a href="{{url('product/index/B')}}">B</a>
					<a href="{{url('product/index/C')}}">C</a>
					<a href="{{url('product/index/D')}}">D</a>
					<a href="{{url('product/index/E')}}">E</a>
					<a href="{{url('product/index/F')}}">F</a>
					<a href="{{url('product/index/G')}}">G</a>
					<a href="{{url('product/index/H')}}">H</a>
					<a href="{{url('product/index/I')}}">I</a>
					<a href="{{url('product/index/J')}}">J</a>
					<a href="{{url('product/index/K')}}">K</a>
					<a href="{{url('product/index/L')}}">L</a>
					<a href="{{url('product/index/M')}}">M</a>
					<a href="{{url('product/index/N')}}">N</a>
					<a href="{{url('product/index/O')}}">O</a>
					<a href="{{url('product/index/P')}}">P</a>
					<a href="{{url('product/index/Q')}}">Q</a>
					<a href="{{url('product/index/R')}}">R</a>
					<a href="{{url('product/index/S')}}">S</a>
					<a href="{{url('product/index/T')}}">T</a>
					<a href="{{url('product/index/U')}}">U</a>
					<a href="{{url('product/index/V')}}">V</a>
					<a href="{{url('product/index/W')}}">W</a>
					<a href="{{url('product/index/X')}}">X</a>
					<a href="{{url('product/index/Y')}}">Y</a>
					<a href="{{url('product/index/Z')}}" style="padding-right: 10px;">Z</a>
					<a href="{{url('product/index/_ALL')}}" style="border-left: 1px solid #ccc; padding-left: 10px;">View All</a>
				</div>
	    </div>		  
	  <div class="page-body">			
	  </div>
	</div>
	@if(count($items)>0)
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
						<td class="image">{!! $item['image'] !!}</td>
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
							<a href="{{ url('product/log/' . $item['model_code']) }}" title="Log">Log</a>
						</td>
					</tr>
					@foreach($item['variations'] as $variation)
						<tr class="product-child" data-mc="{{ $item['model_code'] }}">
							<td></td>
							<td></td>
							<td class="image">{!! $variation['image'] !!}</td>
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
						<td class="image">{!! $item['image'] !!}</td>
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
							<a href="{{ url('product/log/' . $item['model_code']) }}" title="Log">Log</a>
						</td>
					</tr>
				@endif
			@endforeach		
		</tbody>
	</table>
	@else
	  <label><h3 class="text-warning">No Records found</h3></label>
    @endif
	
	<div class="text-right">
		{!! str_replace('/?', '?', $products->appends(['product_search' => \Request::get('product_search') ])->render()) !!}
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