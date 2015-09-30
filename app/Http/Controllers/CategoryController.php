<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\OSCAService;

class CategoryController extends Controller
{
    public function getIndex()
	{
		$service = new OSCAService();
		$response = $service->getCategories();
		
		if ($response['status'] == 200){
			$categories = json_decode($response['data']);
			return view('category.index', compact('categories'));
		}
	}
	
	public function postAddWorld(Request $request)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->addWorld([
				'world_name' => $request->input('world_name')
			]);
			
			if ($response['status'] == 200) {
				return $response['data'];
			} else if ($response['status'] == 422){
				return response()->json($response['data'], 422);
			}
		}
	}
	
	public function putEditWorld(Request $request, $world_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->editWorld($world_id, [
				'world_name' => $request->input('world_name')
			]);
			
			if ($response['status'] == 200) {
				return $response['data'];
			} else if ($response['status'] == 422){
				return response()->json($response['data'], 422);
			}
		}
	}
	
	public function postAddCategory(Request $request, $world_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->addCategory($world_id, [
				'category_name' => $request->input('category_name')
			]);
			
			if ($response['status'] == 200) {
				return $response['data'];
			} else if ($response['status'] == 422){
				return response()->json($response['data'], 422);
			}
		}
	}
	
	public function putEditCategory(Request $request, $world_id, $category_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->editCategory($world_id, $category_id, [
				'category_name' => $request->input('category_name')
			]);
			
			if ($response['status'] == 200) {
				return $response['data'];
			} else if ($response['status'] == 422){
				return response()->json($response['data'], 422);
			}
		}
	}
	
	public function postAddSubcategory(Request $request, $category_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->addSubcategory($category_id, [
				'subcategory_name' => $request->input('subcategory_name')
			]);
			
			if ($response['status'] == 200) {
				return $response['data'];
			} else if ($response['status'] == 422){
				return response()->json($response['data'], 422);
			}
		}
	}
	
	public function putEditSubcategory(Request $request, $category_id, $subcategory_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->editSubcategory($category_id, $subcategory_id, [
				'subcategory_name' => $request->input('subcategory_name')
			]);
			
			if ($response['status'] == 200) {
				return $response['data'];
			} else if ($response['status'] == 422){
				return response()->json($response['data'], 422);
			}
		}
	}
}
