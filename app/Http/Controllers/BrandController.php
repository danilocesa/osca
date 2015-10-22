<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Validator;
use DB;

class BrandController extends Controller
{
    public function getIndex($a='_ALL')
	{		
		if($a =='_ALL'){
			$brand=\App\Brand::select('brand_id','brand_name','(select count(1) from es_item_master eim join es_item_variation eiv on eim.model_code=eiv.model_code where brand_id_es=brand_id) brand_count')
								->where('status','=','6')
								->orderBy('BRAND_NAME')->paginate(10);						
		}else{
			//$a=substr($a,0,1); //URL control
			$brand=\App\Brand::select('brand_id','brand_name','(select count(1) from es_item_master eim join es_item_variation eiv on eim.model_code=eiv.model_code where brand_id_es=brand_id) brand_count')
				->where('BRAND_NAME','like',$a.'%')
				->where('status','=','6')
				->orderBy('BRAND_NAME')->paginate(10);
		}
		return view('brand.index',[
			'brands'	=>	$brand
		]);
	}
	
	public function getSearch(){
		
		if($_GET['brand_search']==''){
			$brand=\App\Brand::select('brand_id','brand_name','(select count(brand_id_es) from es_item_master eim join es_item_variation eiv on eim.model_code=eiv.model_code where brand_id_es=brand_id) brand_count')
								->orderBy('upper(BRAND_NAME)')
								->paginate(10);						
		}else{
			$brand=\App\Brand::select('brand_id','brand_name','(select count(brand_id_es) from es_item_master eim join es_item_variation eiv on eim.model_code=eiv.model_code where brand_id_es=brand_id) brand_count')
				->where('upper(BRAND_NAME)','like','%'.strtoupper($_GET['brand_search']).'%')
				->where('status','=','6')
				->orderBy('UPPER(BRAND_NAME)')->paginate(10);
		}
		
		return view('brand.index',[
			'brands'	=> $brand
		]);
		
		//return count($brand);
		
	}
	
	public function postAddBrand(Request $request){		
				
			$validator = Validator::make($request->all(), [
			'brand_name' => 'required|max:25'
			]);			
			
			$validator->after(function($validator){
				$brand_name=array_get($validator->getData(),'brand_name');
				$exists=\App\Brand::where('upper(trim(BRAND_NAME))','like',strtoupper(trim($brand_name)))
									->where('status','like','6')
									->count();
				if($exists > 0){
					//You scum!					
					$validator->errors()->add('brand_name','Brand name unavailable');					
				}else{
					$exists=\App\Brand::where('upper(trim(BRAND_NAME))','like',strtoupper(trim($brand_name)))
									->where('status','like','7')
									->count();					
					if($exists > 0){
						$validator->errors()->add('brand_name','Brand name was previously deleted');						
					}
				}
			});
			
			
			if($validator->fails()){				
				return redirect('brand/index')->withErrors($validator)->withInput();
			}else{			

				$brand = new \App\Brand();
				$new_id = intval(json_decode(\App\Brand::select('MAX(brand_id) as new_id')->get())[0]->new_id) + 1;
				$brand->brand_id = $new_id;
				$brand->brand_name = trim($request->input('brand_name'),"\x00..\x1F");				
				$brand->status=6;
				$brand->last_update_date = \DB::raw('SYSDATE');					
				$brand->last_update_by = \Auth::user()->id;
				$brand->save();		 
				$brand=\App\Brand::orderBy('BRAND_NAME')->paginate(10);			
				return redirect('brand');
			}
	}
	
	
	public function putEdit(Request $request, $id){				
		
		// $validator = Validator::make($request->all(), [
			// 'brand_name' => 'required|unique:LKP_BRAND,brand_name|max:25'
		// ]);			

		$validator = Validator::make($request->all(), [
			'brand_name' => 'required|max:25'
			]);			
			
			$validator->after(function($validator){
				$brand_name=array_get($validator->getData(),'brand_name');
				$exists=\App\Brand::where('upper(BRAND_NAME)','like',strtoupper($brand_name))
									->where('status','like','6')
									->count();
				if($exists > 0){
					//You scum!					
					$validator->errors()->add('brand_name','Brand name unavailable');					
				}else{
					$exists=\App\Brand::where('upper(BRAND_NAME)','like',$brand_name)
									->where('status','like','7')
									->count();					
					if($exists > 0){
						$validator->errors()->add('brand_name','Brand name was previously deleted');						
					}
				}
			});
		
		if($validator->fails()){
			return redirect('brand/index')
					->withErrors($validator)
					->withInput();
		}else{
				$brand = \App\Brand::find($id);
				$brand->brand_name = trim($request->input('brand_name'));	
				$brand->last_update_date = \DB::raw('SYSDATE');					
				$brand->last_update_by = \Auth::user()->id;
				$brand->update();
			
				return redirect('brand');
		}		
	}
	
	public function postDelete(Request $request){
		
		$checks=array_get($request->all(),'check');
		
		if(sizeof($checks)==0){ //if nothing was checked
			
			return redirect('brand');
			
		}else{
			$data =\App\Brand::wherein('brand_id',$checks)->get();			
			
			/*return view('brand.delete',[
				'detail'=>$data
			]);			
			*/
			return redirect('brand');
		}	
	}
	
	public function putDelete(Request $request){
		
		$data=array_get($request->all(),'delete_brands'); 	
		$pateros=array_get($request->all(),'delb');
	
		if( $data =='YES'){									
				foreach($pateros as $dat){
					$del_object =\App\Brand::find($dat);
					$del_object->status=7;
					$del_object->last_update_date = \DB::raw('SYSDATE');					
					$del_object->last_update_by = \Auth::user()->id;
					$del_object->update();
				}			
			}		
		
		return redirect('brand');
		
		//return $request->all();
	}
}
