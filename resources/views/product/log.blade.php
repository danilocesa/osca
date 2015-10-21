@extends('shared._layout')

@section('title', 'Product Details')

@section('styles')
	{!! HTML::style('css/product-edit-styles.css') !!}
	{!! HTML::style('css/category-picker-styles.css') !!}
@endsection

@section('content')

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Log Details</div>

  <div class="panel-body">
	@if(count($productrecords)>0)
    <!-- Table -->
    <table id="log-table" class="table table-bordered table-customized">
	  <thead>
	    <tr>
	      <th>Model Code</th>
	      <th>SKU Barcode</th>
	      <th>Column Update</th>
	      <th>Old Value</th>
	      <th>New Value</th>
	      <th>Update Date</th>
	      <th>Username</th>
	    </tr>
	  </thead>
	  <tbody>
	    @foreach($productrecords as $productrecord)
	    <tr>
	      <td>{{ $productrecord['model_code'] }}</td>
		  <td>{{ $productrecord['sku_barcode'] }}</td>
		  <td>{{ $productrecord['column_update'] }}</td>
		  <td>{{ $productrecord['old_value'] }}</td>
		  <td>{{ $productrecord['new_value'] }}</td>
		  <td>{{ $productrecord['update_date'] }}</td>
		  <td>{{ $productrecord['name'] }}</td>
	    </tr>
		@endforeach
	  </tbody>
    </table>
	@else
	  <label><h3 class="text-warning">No Records found</h3></label>
    @endif
  </div><!-- .panel-body -->
</div><!-- .panel -->

@endsection