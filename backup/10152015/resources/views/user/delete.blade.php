@extends('shared._layout')

@section('title', 'Brands')

@section('styles')
	{!! HTML::style('css/jake-custom-styles.css') !!}

@endsection

@section('content')
<div>

	<form action="{{url('user/delete')}}" method="post">
		{!! csrf_field() !!}
		<input type="hidden" name="_method" value="DELETE" />		
		<h2>Are you sure you wish to delete these Brands?</h2>
		<div class="input-group">		
		<span class="input-group-btn">
		<button type="submit" name="delete_brands" value="YES" class="btn btn-default">Yes</button>
		</span>
		<a role="button" class="btn btn-default" href={{ url('user')}}>No</a>
		</div>
		<table class="table"> <!--  id="brand_table" -->
		<thead>
		<tr class="row" style="background-color: #C0C0C0;">
			<th>User Name</th>
		</tr>
		</thead>
		<tbody>
		@foreach($detail as $details)
			<tr class="row">
			<td>{{ $details->name}}<input type="hidden" name="deluser[]" value="{{ $details->id }}"/></td>
			</tr>
		@endforeach				
		</tbody>
		</table>
	</form>	

</div>

@endsection