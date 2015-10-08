<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	public function __construct()
	{
		setlocale(LC_MONETARY, 'en_PH');
	}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
		$products = \App\Product::with('brandMms', 'brandEs', 'variationsView')->select(['model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es'])->paginate(5);		
		
		$items = [];
		
		foreach($products as $product){
			$brand_name = is_null($product->brandEs) ? (is_null($product->brandMms) ? 'Not Available' : $product->brandMms->brand_name) : $product->brandEs->brand_name;
			
			$product_name = $product->product_name_es ?: $product->product_name_mms;
		
			// If product has only one variation, put all mother and child data in one row
			if (count($product->variations) > 1) {
				
				$variations = [];
			
				foreach ($product->variationsView as $variation){
					$variations[] = [
						'sku_barcode' => $variation->sku_barcode,
						'environment_code' => $variation->environment_code,
						'variation_name' => $variation->variations,
						'inventory' => $variation->inventory,
						'sku_price' => money_format('%.2n', $variation->price),
						'status_name' => $variation->status_name,
						'enable' => $variation->enable,
					];
				}
			
				$items[] = [
					'image' => $product->image_id,
					'model_code' => $product->model_code,
					'product_name' => ucwords(strtolower($product_name)),
					'brand_name' => ucwords(strtolower($brand_name)),
					'variations' => $variations
				];	
			}
			else {
				$variation = $product->variationsView[0];
			
				$items[] = [
					'image' => $product->image_id,
					'model_code' => $product->model_code,
					'product_name' => ucwords(strtolower($product_name)),
					'brand_name' => ucwords(strtolower($brand_name)),
					'environment_code' => $variation->environment_code,
					'sku_price' => money_format('%.2n', $variation->price),
					'sku_barcode' => $variation->sku_barcode,
					'inventory' => $variation->inventory,
					'enable' => $variation->enable,
					'status' => $variation->status_name
				];	
			}		
		}
		
        return view('product.index', compact('items', 'products'));
    }
	
	public function getEdit($model_code)
	{
		$product = \App\Product::with('brandMms', 'brandEs', 'variationsView', 'categories')->findOrFail($model_code);		
		$categories = \App\World::getThreeLevelCategories();		
		$worlds = \App\World::orderBy('world_name')->get();		
		$ages = \App\Age::orderBy('age_name')->get();		
		//$series = \App\Series::all(); SOON		
		$product_styles = \App\ProductStyle::orderBy('product_style_name')->get();		
		$genders = \App\Gender::orderBy('gender_name')->get();
		
		$variations = [];
		
		foreach($product->variationsView as $variation){
			$variations[] = [
				'product_id' => 		$variation->product_id,
				'enable' => 			$variation->enable,
				'color_name' => 		$variation->color_name,
				'color_code' => 		$variation->color_code,
				'color_display_name' => $variation->color_display_name,
				'size_name' => 			$variation->size_name,
				'size_code' => 			$variation->size_code,
				'sku_barcode' => 		$variation->sku_barcode,
				'environment_code' => 	$variation->environment_code,
				'price' => 				money_format('%.2n', $variation->price),
				'width' => 				$variation->width,
				'height' => 			$variation->height,
				'weight' => 			$variation->weight,
				'length' => 			$variation->length,
				'approved' => 			$variation->approved,
				'inventory' => 			$variation->inventory,
			];
		}
		
		$item = [
			'model_code' => 			$product->model_code,
			'product_name_mms' => 		$product->product_name_mms,						
			'brand_name_mms' => 		$product->brandMms->brand_name,
			'product_name_es' => 		$product->product_name_es,
			'brand_id_es' => 			$product->brandEs->brand_id,
			'brand_name_es' => 			$product->brandEs->brand_name,
			'variations' => 			$variations,
			'product_width' => 			$product->product_width,
			'product_height' => 		$product->product_height,
			'product_weight' => 		$product->product_weight,
			'product_depth' => 			$product->product_depth,
			'package_width' => 			$product->package_width,
			'package_height' => 		$product->package_height,
			'package_weight' => 		$product->package_weight,
			'package_depth' => 			$product->package_depth,
			'meta_keyword' => 			$product->meta_keyword,
			'meta_title' => 			$product->meta_title,
			'pdp_video' => 				$product->pdp_video,
			'recommended_score' => 		$product->recommended_score,
			'short_description' => 		$product->short_description,
			'description' => 			$product->description,
			'primary_product_id' => 	$product->primary_product_id,
			'top_category_id' =>		$product->top_category_id,
			'age_id' => 				$product->age_id,
			'gender_id' => 				$product->gender_id,
			'series_id' => 				$product->series_id,
			'product_style_id' => 		$product->product_style_id,
			'categories' => 			$product->categories,
			'shipping_group' => 		$product->shipping_group,
		];
		
		return view('product.edit', compact('item', 'categories', 'ages', 'product_styles', 'genders', 'worlds'));
	}
	
	public function putEdit(Request $request, $model_code)
	{
		// validation
		
		if ($request->get('product_changed')){
			$product = \App\Product::findOrFail($model_code);
			
			$product->product_name_es = 	$request->get('product_name_es');
			$product->brand_id_es = 		$request->get('brand_id_es');
			
			// Save subcategories, replace all subcategories related to product
			\App\ProductCategory::where('model_code', '=', $model_code)->delete();
			foreach($request->get('subcategories') as $subcategory){
				\App\ProductCategory::create([
					'model_code' => 		$model_code,
					'subcategory_id' => 	$subcategory
				]);
			}
			
			$product->age_id = 				$request->get('age_id');
			$product->gender_id = 			$request->get('gender_id');
			$product->series_id = 			$request->get('series_id');
			$product->product_style_id = 	$request->get('product_style_id');
			$product->top_category_id = 	$request->get('top_category_id');
			
			$product->package_width = 		$request->get('package_width');
			$product->package_height =		$request->get('package_height');
			$product->package_weight =		$request->get('package_weight');
			$product->package_depth =		$request->get('package_depth');
			$product->shipping_group =		$request->get('shipping_group');
			
			$product->short_description =	$request->get('short_description');
			$product->description =			$request->get('description');
			
			$product->product_width =		$request->get('product_width');			
			$product->product_height =		$request->get('product_height');	
			$product->product_weight =		$request->get('product_weight');
			$product->product_depth =		$request->get('product_depth');
			$product->recommended_score =	$request->get('recommended_score');
			
			$product->meta_keyword =		$request->get('meta_keyword');	
			$product->meta_title =			$request->get('meta_title');
			$product->pdp_video =			$request->get('pdp_video');
			
			$product->save();
		}
		
		// Update variations
		foreach($request->get('product_id') as $key => $value){
			if ($request->get('variation_changed')[$key] || $request->get('product_changed')){
				$variation = \App\Variation::find($key);
				if (array_key_exists($key, $request->get('enable')))
					$variation->enable = true;
				else
					$variation->enable = false;
				
				$variation->weight = $request->get('weight')[$key];
				$variation->length = $request->get('length')[$key];
				$variation->width = $request->get('width')[$key];
				$variation->height = $request->get('height')[$key];				
				
				$status_id = null;
				
				if ($request->has('update-submit'))
					$status_id = \App\Status::where('status_name', '=', 'Updated')->first()->status_id;
				else if ($request->has('approval-submit'))
					$status_id = \App\Status::where('status_name', '=', 'For Approval')->first()->status_id;
				
				$variation->status_id = $status_id;
				
				$variation->save();
			}
		}
	
		return response()->json($request->all());
	}
	
	// TEMP
	public function getBrands(Request $request)
	{
		if (!$request->has('q'))
			abort(404);
	
		$brands = \App\Brand::where(\DB::raw('UPPER(brand_name)'), 'like', strtoupper($request->get('q') . '%'))->get();
		
		$data = [];
		
		// Make sure we have a result
		if(count($brands) > 0){
			foreach ($brands as $brand){
				$data[] = ['id' => $brand->brand_id, 'text' => $brand->brand_name];
			}
		} else {
			$data[] = ['id' => '0', 'text' => 'No Products Found'];
		}
		
		return $data;
	}
}