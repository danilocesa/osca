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
		$columns = ['image_id', 'model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es', 'sku_price'];
	
		$products = \App\Product::with('brandMms', 'brandEs', 'variations')->select($columns)->groupBy($columns)->paginate(5);
		
		$items = [];
		
		setlocale(LC_MONETARY, 'en_PH');
		
		foreach($products as $product){
			$brand_name = is_null($product->brandEs) ? (is_null($product->brandMms) ? 'Not Available' : $product->brandMms->brand_name) : $product->brandEs->brand_name;
			
			$product_name = $product->product_name_es ?: $product->product_name_mms;
		
			// If product has only one variation, put all mother and child data in one row
			if (count($product->variations) > 1) {
				
				$variations = [];
			
				foreach ($product->variations as $variation){
					$variations[] = [
						'product_id' => $variation->product_id,
						'sku_barcode' => $variation->sku_barcode,
						'variations' => $variation->variations,
						'inventory' => $variation->inventory,
						'price' => money_format('%.2n', $variation->price),
						'status_name' => $variation->status_name,
						'enable' => $variation->enable,
					];
				}				
			
				$items[] = [
					'image' => $product->image_id,
					'model_code' => $product->model_code,
					'product_name' => ucwords(strtolower($product_name)),
					'brand_name' => ucwords(strtolower($brand_name)),
					'sku_price' => money_format('%.2n', $product->sku_price),
					'variations' => $variations
				];	
			}
			else {
				$variation = $product->variations[0];
			
				$items[] = [
					'image' => $product->image_id,
					'model_code' => $product->model_code,
					'product_name' => ucwords(strtolower($product_name)),
					'brand_name' => ucwords(strtolower($brand_name)),
					'sku_price' => money_format('%.2n', $product->sku_price),
					'sku_barcode' => $variation->sku_barcode,
					'inventory' => $variation->inventory,
					'enable' => $variation->enable,
					'status' => $variation->status_name
				];	
			}		
		}
		
        return view('product.index', compact('items', 'products'));
    }
}
