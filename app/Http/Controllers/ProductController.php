<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

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
		$products = \App\Product::with('brandMms', 'brandEs', 'variationsView')->select(['model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es'])->paginate(10);		
		
		//return response()->json($products);
		
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
		$color_variations = [];
		
		$variations = [];
		
		foreach($product->variationsView as $variation){
			$variations[] = [
				'product_id' => 		$variation->product_id,
				'enable' => 			$variation->enable,
				'color_name' => 		$variation->color_name,
				'color_code' => 		$variation->color_code,
				'color_display_id' => 	$variation->color_display_id,
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
			
			if (!array_key_exists($variation->color_display_id, $color_variations)){
				$color_variations[$variation->color_display_id] = [
					'color_display_name' => $variation->color_display_name,
					'color_hex_code' => $variation->color_hex_code
				];
			}
		}
		
		$item = [
			'model_code' => 				$product->model_code,
			'product_name_mms' => 			$product->product_name_mms,						
			'brand_name_mms' => 			isset($product->brandMms->brand_name) ? $product->brandMms->brand_name : null,
			'product_name_es' => 			$product->product_name_es,
			'brand_id_es' => 				isset($product->brandEs->brand_id) ? $product->brandMms->brand_id : null,
			'brand_name_es' => 				isset($product->brandEs->brand_name) ? $product->brandMms->brand_name : null,
			'variations' => 				$variations,
			'product_width' => 				$product->product_width,
			'product_height' => 			$product->product_height,
			'product_weight' => 			$product->product_weight,
			'product_depth' => 				$product->product_depth,
			'package_width' => 				$product->package_width,
			'package_height' => 			$product->package_height,
			'package_weight' => 			$product->package_weight,
			'package_depth' => 				$product->package_depth,
			'meta_keyword' => 				$product->meta_keyword,
			'meta_title' => 				$product->meta_title,
			'pdp_video' => 					$product->pdp_video,
			'recommended_score' => 			$product->recommended_score,
			'short_description' => 			$product->short_description,
			'description' => 				$product->description,
			'primary_color_display_id' => 	$product->primary_color_display_id,
			'top_category_id' =>			$product->top_category_id,
			'age_id' => 					$product->age_id,
			'gender_id' => 					$product->gender_id,
			'series_id' => 					$product->series_id,
			'product_style_id' => 			$product->product_style_id,
			'categories' => 				$product->categories,
			'shipping_group' => 			$product->shipping_group,
		];
		
		return view('product.edit', compact('item', 'categories', 'ages', 'product_styles', 'genders', 'worlds', 'color_variations'));
	}
	
	public function putEdit(Request $request, $model_code)
	{
		// validation
		
		//$this->updateMother($request);		
		$this->updateVariations($request);		
	
		/*return response()->json([
			'redirect' => $request->get('submit_button_clicked') == 'save_exit',
			'message' => 'Your changes are saved.']);*/
		return response()->json($request->all());
	}
	
	private function updateMother(Request $request)
	{
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
			
			$product->age_id = 					 $request->get('age_id');
			$product->gender_id = 				 $request->get('gender_id');
			$product->series_id = 				 $request->get('series_id');
			$product->product_style_id = 		 $request->get('product_style_id');
			$product->top_category_id = 		 $request->get('top_category_id');
				 
			$product->package_width = 			 $request->get('package_width');
			$product->package_height =			 $request->get('package_height');
			$product->package_weight =			 $request->get('package_weight');
			$product->package_depth =			 $request->get('package_depth');
			$product->shipping_group =			 $request->get('shipping_group');
				 
			$product->short_description =		 $request->get('short_description');
			$product->description =				 $request->get('description');
				 
			$product->product_width =			 $request->get('product_width');			
			$product->product_height =			 $request->get('product_height');	
			$product->product_weight =			 $request->get('product_weight');
			$product->product_depth =			 $request->get('product_depth');
			$product->recommended_score =		 $request->get('recommended_score');
				 
			$product->meta_keyword =			 $request->get('meta_keyword');	
			$product->meta_title =				 $request->get('meta_title');
			$product->pdp_video =				 $request->get('pdp_video');
			
			$product->primary_color_display_id = $request->get('primary_color_display_id');
			
			$product->save();
		}
	}
	
	private function updateVariations(Request $request)
	{
		$folderName = $this->uploadImages($request);
		
		foreach($request->get('product_id') as $key => $value){
			if ($request->get('variation_changed')[$key] || $request->get('product_changed')){
				
				$variation = \App\Variation::with('variationView')->find($key);
				
				if (is_array($request->get('enable'))){
					if (array_key_exists($key, $request->get('enable')))
						$variation->enable = true;
					else
						$variation->enable = false;
				}
				
				$variation->weight = $request->get('weight')[$key];
				$variation->length = $request->get('length')[$key];
				$variation->width = $request->get('width')[$key];
				$variation->height = $request->get('height')[$key];				
				
				if ($request->get('submit_button_clicked') == 'save_exit'){
					if (\Auth::user()->role->hasPermission("CAN_APPROVE_PRODUCT")){
						if (is_array($request->get('approved')) && array_key_exists($key, $request->get('approved')))
							$status_id = \App\Status::getStatusId('Approved');
						else
							$status_id = \App\Status::getStatusId('For Approval');
					} else {
						$status_id = \App\Status::getStatusId('For Approval');
					}
				} else if ($request->get('submit_button_clicked') == 'save_keep_editing'){
					$status_id = \App\Status::getStatusId('Updated');
				}
				
				$variation->status_id = $status_id ?: 1;
				
				$variation->last_update_date = \DB::raw('SYSDATE');
				$variation->last_update_by_id = \Auth::user()->id;
				
				$variation->save();
				
				// Update variation images
				
				// Get color display ID
				$colorDisplayId = $variation->variationView->color_display_id;
				
				// Get image filenames under color display id
				$images = $request->get('image_filenames')[$colorDisplayId];
				$imageArray = explode('|', $images);
				$seqNo = 2; // sequencing
				
				// Delete current records
				\App\Image::where('product_id', '=', $variation->product_id)->delete();
				
				foreach($imageArray as $fileName){
					if (!empty($fileName)){
						// '1' is reserved for primary image of variation					
						$curreSeqNo = array_key_exists($colorDisplayId, $request->get('primary_image_id')) && $request->get('primary_image_id')[$colorDisplayId] == $fileName ? 1 : $seqNo++;
					
						\App\Image::create([
							'product_id' => $variation->product_id,
							'image_full_path' => storage_path('app') . '/' . $folderName . '/' . $fileName,
							'seq_no' => $curreSeqNo,
							'filename' => $fileName
						]);
					}
				}
			}
		}
	}
	
	// I'm too hot to handle
	private function uploadImages(Request $request)
	{				
		$files = $request->file('images');
	
		if (count($files) > 0){
			// Create timestamp folder and upload all files to it
			$folderName = date("Y-m-d H:i:s", strtotime("now"));
			Storage::makeDirectory($folderName);
			
			foreach($files as $file){
				Storage::put($folderName . '//' . $file->getFileName() . '.' . $file->getClientOriginalExtension(), file_get_contents($file));
			}	
			
			return $folderName;
		}		
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