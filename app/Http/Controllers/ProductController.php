<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
		$columns = ['image', 'model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es', 'sku_price'];
	
		$products = \App\Product::with('brandMms', 'brandEs')->select($columns)->groupBy($columns)->get();
		
		$items = [];
		
		foreach($products as $product){
			$items[] = [
				'image' => $product->image,
				'model_code' => $product->model_code,
				'product_name' => $product->product_name_es ?: $product->product_name_mms,
				'brand_name' => is_null($product->brand_mms),
				'sku_price' => $product->sku_price
			];
		}
		
		return $items;
		
        return view('product.index', compact('items'));
    }
}
