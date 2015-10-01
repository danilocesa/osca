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
			$response = $service->addWorld($request->only(['world_name']));
			
			return response()->json($response['data'], $response['status']);
		}
	}
	
	public function putEditWorld(Request $request, $world_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->editWorld($request->only(['world_name']));
			
			return response()->json($response['data'], $response['status']);
		}
	}
	
	public function postAddCategory(Request $request, $world_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->addCategory($world_id, $request->only(['category_name']));
			
			return response()->json($response['data'], $response['status']);
		}
	}
	
	public function putEditCategory(Request $request, $world_id, $category_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->editCategory($world_id, $category_id, $request->only(['category_name']));
			
			return response()->json($response['data'], $response['status']);
		}
	}
	
	public function postAddSubcategory(Request $request, $category_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->addSubcategory($category_id, $request->only(['subcategory_name']));
			
			return response()->json($response['data'], $response['status']);
		}
	}
	
	public function putEditSubcategory(Request $request, $category_id, $subcategory_id)
	{
		if ($request->ajax()){
			$service = new OSCAService();
			$response = $service->editSubcategory($category_id, $subcategory_id, $request->only(['subcategory_name']));
			
			return response()->json($response['data'], $response['status']);
		}
	}
}
