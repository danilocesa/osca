<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class CategoryController extends Controller
{
    public function getIndex()
	{
		// Sort world, category, subcategory alphabetically
        $categories = \App\World::with([
			'categories' => function($query){
				$query->orderBy('category_name');
			},
			'categories.subcategories' => function($query){
				$query->orderBy('subcategory_name');
			}
		])->orderBy('world_name')->get();
		
		return view('category.index', compact('categories'));
	}
	
	public function postAddWorld(Request $request)
	{
		if ($request->ajax()){
			$validator = Validator::make($request->all(), [
				'world_name' => 'required|unique:LKP_WORLD|max:255'
			]);
			
			if ($validator->fails()){
				return response()->json($validator->errors(), 422);
			}
			
			$world = new \App\World();
			$new_id = intval(json_decode(\App\World::select('MAX(world_id) as new_id')->get())[0]->new_id) + 1;
			$world->world_id = $new_id;
			$world->world_name = $request->input('world_name');
			$world->save();
			
			return response()->json($world, 200);
		}		
	}
	
	public function putEditWorld(Request $request, $world_id)
	{
		if ($request->ajax()){
			$validator = Validator::make($request->all(), [
				'world_name' => 'required|unique:LKP_WORLD,world_name,'.$world_id.',world_id|max:255'
			]);
			
			if ($validator->fails()){
				return response()->json($validator->errors(), 422);
			}
			
			$world = \App\World::find($world_id);
			$world->world_name = $request->input('world_name');
			$world->save();
			
			return response()->json($world, 200);
		}
	}
	
	public function postAddCategory(Request $request, $world_id)
	{
		if ($request->ajax()){
			$validator = Validator::make($request->all(), [
				'category_name' => 'required|unique:LKP_CATEGORY,category_name,NULL,category_id,world_id,'.$world_id.'|max:255',
			]);
			
			if ($validator->fails()){
				return response()->json($validator->errors(), 422);
			}
			
			$category = new \App\Category();
			$new_id = intval(json_decode(\App\Category::select('MAX(category_id) as new_id')->get())[0]->new_id) + 1;
			$category->category_id = $new_id;
			$category->category_name = $request->input('category_name');
			$category->world_id = $world_id;
			$category->save();
			
			return response()->json($category, 200);
		}
	}
	
	public function putEditCategory(Request $request, $world_id, $category_id)
	{
		if ($request->ajax()){
			$validator = Validator::make($request->all(), [
				'category_name' => 'required|unique:LKP_CATEGORY,category_name,'.$category_id.',category_id,world_id,'.$world_id.'|max:255'
			]);
			
			if ($validator->fails()){
				return response()->json($validator->errors(), 422);
			}
			
			$category = \App\Category::find($category_id);
			$category->category_name = $request->input('category_name');
			$category->save();
			
			return response()->json($category, 200);
		}
	}
	
	public function postAddSubcategory(Request $request, $category_id)
	{
		if ($request->ajax()){
			$validator = Validator::make($request->all(), [
				'subcategory_name' => 'required|unique:LKP_SUBCATEGORY,subcategory_name,NULL,subcategory_id,category_id,'.$category_id.'|max:255'
			]);
			
			if ($validator->fails()){
				return response()->json($validator->errors(), 422);
			}
			
			$subcategory = new \App\Subcategory();
			$new_id = intval(json_decode(\App\Subcategory::select('MAX(subcategory_id) as new_id')->get())[0]->new_id) + 1;
			$subcategory->subcategory_id = $new_id;
			$subcategory->subcategory_name = $request->input('subcategory_name');
			$subcategory->category_id = $category_id;
			$subcategory->save();
			
			return response()->json($subcategory, 200);
		}
	}
	
	public function putEditSubcategory(Request $request, $category_id, $subcategory_id)
	{
		if ($request->ajax()){
			$validator = Validator::make($request->all(), [
				'subcategory_name' => 'required|unique:LKP_SUBCATEGORY,subcategory_name,'.$subcategory_id.',subcategory_id,category_id,'.$category_id.'|max:255'
			]);
			
			if ($validator->fails()){
				return response()->json($validator->errors(), 422);
			}
			
			$subcategory = \App\Subcategory::find($subcategory_id);
			$subcategory->subcategory_name = $request->input('subcategory_name');
			$subcategory->save();
			
			return response()->json($subcategory, 200);
		}
	}
}
