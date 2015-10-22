<?php
//dyow
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;
use Validator;

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
    public function getIndex($a = '')
    {
		$products = \App\Product::with('brandMms', 'brandEs', 'variationsView')
				->select(['model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es', 'primary_color_display_id']);
	
		if($a == '') {
			$products = $products
					->orderBy('UPPER(product_name_mms)')
					->paginate(10);			
			return $this->getVariations($products);			
		} else {
			$a = substr(strtoupper($a), 0, 1);
			$products = $products->where('upper(product_name_mms)','like', $a.'%')
				->orderBy('UPPER(product_name_mms)')
				->paginate(10);
			return $this->getVariations($products);
		}
		
    }
	
	//search field
	public function getSearch(Request $request)
	{	
		$searchString = $request->get('product_search');
		
		if($searchString){
			$products = \App\Product::with('brandMms', 'brandEs', 'variationsView')
				//->select(['model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es'])
				->join('vw_product_variation', 'es_item_master.model_code', '=', 'vw_product_variation.model_code')
				->where('upper(product_name_mms)','like','%'.strtoupper($searchString).'%')
				->orWhere('es_item_master.model_code','like', '%'.strtoupper($searchString).'%')
				->orWhere('sku_barcode', 'like', '%'.strtoupper($searchString).'%')
				->orderBy('UPPER(product_name_mms)')
				->paginate(10);
			
				return $this->getVariations($products);
		}else{
			$products = \App\Product::with('brandMms', 'brandEs', 'variationsView')
				->select(['model_code', 'product_name_mms', 'product_name_es', 'brand_id_mms', 'brand_id_es'])
				->orderBy('UPPER(product_name_mms)')
				->paginate(10);
				
				return $this->getVariations($products);
		}
		
	}
	
	//products data
	public function getVariations($products)
	{		
		$items = [];
		
		foreach($products as $product){
			$brand_name = is_null($product->brandEs) ? (is_null($product->brandMms) ? 'Not Available' : $product->brandMms->brand_name) : $product->brandEs->brand_name;
			
			$product_name = $product->product_name_es ?: $product->product_name_mms;

			$image = $product->getPrimaryImage();
			$image = is_null($image) ? 'No image' : $image->createImageTag();
			// If product has only one variation, put all mother and child data in one row
			if (count($product->variations) > 1) {
				
				$variations = [];
			
				foreach ($product->variationsView as $variation){
					$variation_image = \App\Variation::find($variation->product_id)->getPrimaryImage();
					$variation_image = is_null($variation_image) ? 'No image' : $variation_image->createImageTag();
					$variations[] = [
						'image' => $variation_image,
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
					'image' => $image,
					'model_code' => $product->model_code,
					'product_name' => ucwords(strtolower($product_name)),
					'brand_name' => ucwords(strtolower($brand_name)),
					'variations' => $variations
				];	
			}
			else {
				$variation = $product->variationsView[0];
			
				$items[] = [
					'image' => $image,
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
				'color_name' => 		empty($variation->color_name) ? '(No color)' : $variation->color_name,
				'color_code' => 		empty($variation->color_code) ? '(No color)' : $variation->color_code,
				'color_display_id' => 	empty($variation->color_display_id) ? '(No color)' : $variation->color_display_id,
				'color_display_name' => empty($variation->color_display_name) ? '(No color)' : $variation->color_display_name,
				'size_name' => 			empty($variation->size_name) ? '(No size)' : $variation->size_name,
				'size_code' => 			empty($variation->size_code) ? '(No size)' : $variation->size_code,
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
				$variationImages = [];
				
				$images = \App\Image::where('model_code', '=', $model_code)
					->where('color_display_id', '=', $variation->color_display_id)
					->get();
					
				foreach($images as $image){
					$variationImages[] = [
						'filename' => $image->filename,
						'seq_no' => $image->seq_no,
						'image' => $image->createImageTag(),
					];
				}


				$color_variations[$variation->color_display_id] = [
					'color_display_name' => empty($variation->color_display_name) ? '(No color)' : $variation->color_display_name,
					'variation_images' => $variationImages
				];
			}
			
		}


		
		$item = [
			'model_code' => 				$product->model_code,
			'product_name_mms' => 			$product->product_name_mms,						
			'brand_name_mms' => 			isset($product->brandMms->brand_name) ? $product->brandMms->brand_name : null,
			'product_name_es' => 			$product->product_name_es,
			'brand_id_es' => 				isset($product->brandEs) ? $product->brandEs->brand_id : null,
			'brand_name_es' => 				isset($product->brandEs) ? $product->brandEs->brand_name : null,
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
		
		// dump($product->brandMms);

		return view('product.edit', compact('item', 'categories', 'ages', 'product_styles', 'genders', 'worlds', 'color_variations'));
	}
	
	public function putEdit(Request $request, $model_code)
	{
		// validation
		$messages=[
			'product_name_es.required' 			=> 'Product name is required'
		,	'brand_id_es.required'				=> 'Brand name is required'
		,	'primary_color_display_id.required'	=> 'Primary color is required'
		,	'subcategories.required'			=> 'You must select at least 1 category'	
		,	'package_weight.numeric'			=> 'Please enter a number'
		,	'package_width.numeric'				=> 'Please enter a number'
		,	'package_height.numeric'			=> 'Please enter a number'
		,	'package_depth.numeric'				=> 'Please enter a number'
		,	'product_weight.numeric'			=> 'Please enter a number'
		,	'product_width.numeric'				=> 'Please enter a number'
		,	'product_height.numeric'			=> 'Please enter a number'
		,	'product_depth.numeric'				=> 'Please enter a number'
		,	'recommended_score.numeric'			=> 'Please enter a number'		
		,	'image_filenames.required'          => 'Images are required'
		];
		
		$validator = Validator::make($request->all(),[
			'product_name_es'			=> 'required|max:150'
		,	'brand_id_es'				=> 'required'
		,	'subcategories'				=> 'required'
		,	'package_weight'			=> 'numeric'
		,	'package_width'				=> 'numeric'
		,	'package_height'			=> 'numeric'
		,	'package_depth'				=> 'numeric'
		,	'short_description'			=> 'max:555'
		,	'description'				=> 'max:555'
		,	'primary_color_display_id'  => 'required'
		,	'image_filenames'           => 'required'
		,	'product_weight'			=> 'numeric'
		,	'product_width'				=> 'numeric'
		,	'product_height'			=> 'numeric'
		,	'product_depth'				=> 'numeric'
		,	'meta_title'				=> 'max:555'
		,	'meta_keyword'              => 'max:555'
		,	'recommended_score'			=> 'numeric'
		]
		,$messages);
			
		
		// Additional validations validations
		$validator->after(function($validator){
			$data = $validator->getData();
			$weight = $data['weight'];
			$height = $data['height'];
			$width =  $data['width'];
			$length = $data['length'];
			
			// Variation details are required
			foreach($weight as $key=>$val){				
				if(empty($val) || !is_numeric($val))
					$validator->errors()->add('weight['.$key.']','Please enter a number');
			}
			
			foreach($height as $key=>$val){
				if(empty($val) || !is_numeric($val))
					$validator->errors()->add('height['.$key.']','Please enter a number');
			}
			
			foreach($width as $key=>$val){
				if(empty($val) || !is_numeric($val))
					$validator->errors()->add('width['.$key.']','Please enter a number');
			}
			
			foreach($length as $key=>$val){
				if(empty($val) || !is_numeric($val))
					$validator->errors()->add('length['.$key.']','Please enter a number');				
					
					// Check if there are color variations for the product		
					if (count($data['color_variations']) > 0){				
						foreach($data['color_variations'] as $colorDisplayId){
							// Check if color variation has images for upload
							if (array_key_exists($colorDisplayId, $data['image_filenames'])) {	
								if (!empty($data['image_filenames'][$colorDisplayId])) {
									// Check if there is selected primary image among uploaded images
									if (!isset($data['primary_image_id'][$colorDisplayId])) {
										$validator->errors()->add('primary_image_id\\[' . $colorDisplayId . '\\]', 'Please select the primary image among the images you selected');
									}
								}
							}
						}
					}			
			}
			
		});		

		if($validator->fails()){
			return redirect('product/edit/'.$model_code)
						->with('weight',array_get($validator->getData(),'weight'))
						->with('height',array_get($validator->getData(),'height'))
						->with('width',array_get($validator->getData(),'width'))
						->with('length',array_get($validator->getData(),'length'))
						->withErrors($validator,'errmess')
						->withInput();		
		} else {
			// dump($request->all());
			$this->updateMother($request,$model_code);
			$this->updateVariations($request,$model_code);		

			return response()->json([
			'redirect' => $request->get('submit_button_clicked'), //== 'save_exit',
			'message' => 'Your changes are saved.']);
		}
		
		
	}
	
	private function updateMother(Request $request, $model_code)
	{
		$product = \App\Product::findOrFail($model_code);
		
		if ($request->get('product_changed')){
			//$product = \App\Product::findOrFail($model_code);
			
			$product->product_name_es = 	$request->get('product_name_es');
			$product->brand_id_es = 		$request->get('brand_id_es');
			
			// Save subcategories, replace all subcategories related to product
			\App\ProductCategory::where('model_code', '=', $model_code)->delete();
			foreach($request->get('subcategories') as $subcategory){
				\App\ProductCategory::create([
					'model_code' => 		$model_code,
					'subcategory_id' => 	$subcategory,
					'last_update_date' =>   \DB::raw('SYSDATE'),
					'last_update_by' =>     \Auth::user()->id
				]);
				
				//added
				//$updateCategory = \App\ProductCategory::find($subcategory);
				//$updateCategory->model_code = $model_code;
				//$updateCategory->subcategory_id = $subcategory;
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
			
			//added
			$product->last_update_date = \DB::raw('SYSDATE');
			$product->last_update_by = \Auth::user()->id;
			
			//$product->save();
		}
		
			//added 20-OCT-2015 starts
			//------------------------
			
			//$product->sell_start_date = \DB::raw('SYSDATE');
			
			//if ($request->get('submit_button_clicked') == 'save_exit'){
			//	if (\Auth::user()->role->hasPermission("CAN_APPROVE_PRODUCT")){
			//		$product->sell_start_date = \DB::raw('SYSDATE');
			//	}
			//}
			
			
				if ($request->get('submit_button_clicked') == 'save_exit'){
					if (\Auth::user()->role->hasPermission("CAN_APPROVE_PRODUCT")){
						if (is_array($request->get('approved'))) //&& array_key_exists($key, $request->get('approved')))
							$status_id = \App\Status::getStatusId('Approved');
						else
							$status_id = \App\Status::getStatusId('For Approval');
					} else {
						$status_id = \App\Status::getStatusId('For Approval');
					}
				} else if ($request->get('submit_button_clicked') == 'save_keep_editing'){
					$status_id = \App\Status::getStatusId('Updated');
				}
				dump($status_id);
				if($status_id == 2 ){
					$product->sell_start_date = \DB::raw('SYSDATE');
					dump($product->sell_start_date);
				}//else{
					//$product->sell_start_date = \DB::raw('SYSDATE');
				//}
				
			$product->save();
			//------------------------
			//added ends - mp
	}
	
	private function updateVariations(Request $request, $model_code)
	{
		//If request has file 
		if($request->hasFile('images')){
			$folderName = $this->uploadImages($request);	
		}
		foreach($request->get('product_id') as $key => $value){
			if ($request->get('variation_changed')[$key] || $request->get('product_changed')){
				
				//$product = \App\Product::findOrFail($model_code);
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

				//If request has file
				if($request->hasFile('images')){


					// Check for existing image for update seq_no column
					$image = new \App\Image();
					$existImage = $image->where([
						'model_code' =>			$model_code,
						'color_display_id' =>	$request->get('primary_color_display_id')
					])->get();

					if(count($existImage) > 0){
						$existsID = [];
						foreach($existImage as $key => $val)
						{
							$existsID[$val['filename']] = $val['seq_no'];
						}
						foreach ($existsID as $key => $value) {
							$newSeqNo = $value + 1;
							$image->where([
								'model_code' =>			$model_code,
								'color_display_id' =>	$request->get('primary_color_display_id'),
								'seq_no' =>				$value,
								'filename' =>			$key
							])->update(['seq_no' => $newSeqNo]);
						}


					}

					// Get image filenames under color display id
					$images = $request->get('image_filenames')[$colorDisplayId];
					$imageArray = explode('|', $images);
					$seqNo = isset($existsID) ? max($existsID) + 2 : 2 ; // sequencing
					foreach($imageArray as $fileName){
						if (!empty($fileName)){
							// '1' is reserved for primary image of variation
							$curreSeqNo = array_key_exists($colorDisplayId, $request->get('primary_image_id')) && $request->get('primary_image_id')[$colorDisplayId] == $fileName ? 1 : $seqNo++;
							$image = new \App\Image();
							$image->folder = $folderName;
							$image->extension = strtolower(substr($fileName, strrpos($fileName, '.') + 1)); // quick copy paste xD
							$image->model_code = $model_code;
							$image->color_display_id = $colorDisplayId;
							$image->image_full_path = storage_path('app') . '/' . $folderName . '/' . $fileName;
							$image->seq_no = $curreSeqNo;
							$image->filename = $fileName;
							$image->last_update_date = \DB::raw('SYSDATE');
							$image->last_update_by = \Auth::user()->id;
							$image->save();
							
						}
					}
				}
				else{

					//Get selected image
					$changePrimary = [
						'model_code' =>			$model_code,
						'color_display_id' =>	$request->get('primary_color_display_id'),
						'filename' =>			$request->get('primary_image_id')[$request->get('primary_color_display_id')]
					];
					$currImage = \App\Image::where($changePrimary)->get()->first();

					// Get primary image
					$getPrimaryImage = [
						'model_code' =>			$model_code,
						'color_display_id' =>	$request->get('primary_color_display_id'),
						'seq_no' =>				1
					];
					$currPrimaryImage = \App\Image::where($getPrimaryImage)->get()->first();
					
					//Update the primary image
					$updatePrimaryImage =[
						'model_code' =>			$currPrimaryImage['model_code'],
						'color_display_id' =>	$currPrimaryImage['color_display_id'],
						'seq_no' =>				$currPrimaryImage['seq_no'],
						'filename' =>			$currPrimaryImage['filename'],
						'image_full_path' =>	$currPrimaryImage['image_full_path']
					];
					$currPrimaryImage = \App\Image::where($updatePrimaryImage)->update(['seq_no'=>$currImage['seq_no']]);

					//Update the selected image to primary
					$updateImagePrimary = \App\Image::where($changePrimary)->update(['seq_no'=>1]);
						
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
				Storage::put($folderName . '//' . $file->getClientOriginalName(), file_get_contents($file));
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
	//log
	public function getLog($model_code)
	{
		$productrecords = \App\productUpdateLog::
						where('model_code', $model_code)
						->orderBy('update_date', 'desc')
						->get(); //find($model_code);
			
		return view('product.log', [
			'productrecords' => $productrecords
		]);
			
	}
	

	public function deleteImages(Request $request,$model_code){
		//Get image
		$image = \App\Image::where([
			'model_code' => 		$model_code,
			'seq_no' => 			$request->get('seqNo'),
			'filename' =>			$request->get('fileName'),
			'color_display_id' =>	$request->get('colorDisplayID')
		])->get()->first();

		//Delete directory
		Storage::delete($image->folder . '//' .$image->filename);

		//Delete to database
		$image = \App\Image::where([
			'model_code' => 		$model_code,
			'seq_no' => 			$request->get('seqNo'),
			'filename' =>			$request->get('fileName'),
			'color_display_id' =>	$request->get('colorDisplayID')
		])->delete();


	}

	
}