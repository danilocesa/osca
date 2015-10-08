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
								->orderBy('upper(BRAND_NAME)')->paginate(10);						
		}else if($a=='_NONE'){
			$brand=\App\Brand::where('rownum','=','0')
							  ->orderBy('upper(BRAND_NAME)')->take(0)->paginate(0);
		}
		else{
			//$a=substr($a,0,1); //URL control
			$brand=\App\Brand::where('upper(BRAND_NAME)','like',$a.'%')
				->orderBy('upper(BRAND_NAME)')->paginate(10);
		}
		return view('brand.index',[
			'brands'	=>	$brand
		]);
	}
	
	public function getSearch(){
		
		if($_GET['brand_search']==''){
			$brand=\App\Brand::select('brand_id','brand_name','(select count(1) from es_item_master eim join es_item_variation eiv on eim.model_code=eiv.model_code where brand_id_es=brand_id) brand_count')
								->where('rownum','=','0')
								->orderBy('BRAND_NAME')
								->get();
								//->paginate(10);						
		}else{
			$brand=\App\Brand::where('BRAND_NAME','like','%'.$_GET['brand_search'].'%')
				->orderBy('BRAND_NAME')->paginate(10);
		}
		
		return view('brand.index',[
			'brands'	=> $brand
		]);
		
		//return sizeof($brand);
		
	}
	
	public function postAddBrand(Request $request){		
				$validator = Validator::make($request->all(), [
				'brand_name' => 'required|unique:LKP_BRAND,brand_name|max:255'
			]);			
			
			if($validator->fails()){
				//return response()->json($validator->errors(), 422);
				//$brand=\App\Brand::orderBy('BRAND_NAME')->paginate(10);
				/*return view('brand.index',[
					'brands'	=>	$brand
					,'errors'	=>	$validator->errors()->first('brand_name')
				]);*/
				//return $validator->errors()->first('brand_name');
				
				
				return redirect('brand/index')->withErrors($validator)->withInput();
			}else{			

				$brand = new \App\Brand();
				$new_id = intval(json_decode(\App\Brand::select('MAX(brand_id) as new_id')->get())[0]->new_id) + 1;
				$brand->brand_id = $new_id;
				$brand->brand_name = ucfirst(strtolower($request->input('brand_name')));
				$brand->save();
			
				$brand=\App\Brand::orderBy('BRAND_NAME')->paginate(10);			
				return redirect('brand');
			}
	}
	
	
	public function putEdit(Request $request, $id){				
		
		$validator = Validator::make($request->all(), [
			'brand_name' => 'required|unique:LKP_BRAND,brand_name|max:255'
		]);			
		
		if($validator->fails()){
			return redirect('brand/index')->withErrors($validator)->withInput();
		}else{
				$brand = \App\Brand::find($id);
				$brand->brand_name = $request->input('brand_name');
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
			
			return view('brand.delete',[
				'detail'=>$data
			]);			
		}	
	}
	
	public function deleteDelete(Request $request){
		
		$data=array_get($request->all(),'delete_brands'); 	
		$pateros=array_get($request->all(),'delb');
	
		if( $data =='YES'){									
				foreach($pateros as $dat){
					$del_object =\App\Brand::find($dat);
					$del_object->delete();
				}			
			}		
	
		//return $request->all();
		return redirect('brand');
	}
}
