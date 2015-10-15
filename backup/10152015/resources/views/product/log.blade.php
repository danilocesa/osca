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
	@if(count($productrecords)>0 && count($variationrecords)>0)
    <!-- Table -->
    <table id="log-table" class="table table-bordered table-customized">
	  <thead>
	    <tr>
	      <th>Model Code</th>
	      <th>SKU Barcode</th>
	      <th>Environment Code</th>
	      <th>Column Update</th>
	      <th>Old Value</th>
	      <th>New Value</th>
	      <th>Update Date</th>
	      <th>Username</th>
	    </tr>
	  </thead>
	  <tbody>
	    <!-- master item -->
	    @foreach($productrecords as $productrecord)
	    <tr>
	      <td>{{ $productrecord['model_code'] }}</td>
		  <td>N/A</td>
		  <td>N/A</td>
		  <td>{{ $productrecord['column_update'] }}</td>
		  <td>{{ $productrecord['old_value'] }}</td>
		  <td>{{ $productrecord['new_value'] }}</td>
		  <td>{{ $productrecord['update_date'] }}</td>
		  <td>{{ $productrecord->user['name'] }}</td>
	    </tr>
		@endforeach
		<!-- variation -->
		@foreach($variationrecords as $variationrecord)
	    <tr>
	      <td>{{ $variationrecord['model_code'] }}</td>
		  <td>{{ $variationrecord['sku_barcode'] }}</td>
		  <td>{{ $variationrecord['environment_code'] }}</td>
		  <td>{{ $variationrecord['column_update'] }}</td>
		  <td>{{ $variationrecord['old_value'] }}</td>
		  <td>{{ $variationrecord['new_value'] }}</td>
		  <td>{{ $variationrecord['update_date'] }}</td>
		  <td>{{ $variationrecord['name'] }}</td>
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