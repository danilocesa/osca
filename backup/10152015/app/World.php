<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    protected $table = 'lkp_world';
	
	protected $fillable = ['world_id', 'world_name'];
	
	protected $primaryKey = 'world_id';
	
	public $timestamps = false;
	
	public function categories()
	{
		return $this->hasMany('App\Category', 'world_id', 'world_id');
	}
	
	/*
	 * Get only worlds with at least one subcategory on at least one category
	 */
	public static function getThreeLevelCategories()
	{
		$worlds = self::with([
			'categories' => function($query){
				$query->orderBy('category_name');
			},
			'categories.subcategories' => function($query){
				$query->orderBy('subcategory_name');
			}
		])->orderBy('world_name')->get();		
		
		$worldsArray = [];
		
		foreach($worlds as $world){
		
			$categoriesArray = [];
			
			foreach($world->categories as $category){
			
				$subcategoriesArray = [];
								
				foreach($category->subcategories as $subcategory){
					$subcategoriesArray[] = $subcategory;
				}
				
				// Get only categories with at least one subcategory
				if (count($subcategoriesArray) > 0)
					$categoriesArray[] = [
						'category_id' => $category->category_id,
						'category_name' => $category->category_name,
						'subcategories' => $subcategoriesArray
					];
			}
			
			// Get only worlds with at least one category
			if (count($categoriesArray) > 0)
				$worldsArray[] = [
					'world_id' => $world->world,
					'world_name' => $world->world_name,
					'categories' => $categoriesArray
				];
		}
		
		return $worldsArray;
	}
}