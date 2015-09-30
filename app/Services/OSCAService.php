<?php

namespace App\Services;

class OSCAService
{
	public function getCategories()
	{
		return $this->request('http://10.111.122.118/osca/public/api/category');
	}
	
	public function addWorld($data)
	{
		return $this->request('http://10.111.122.118/osca/public/api/category/add-world', 'POST', $data);
	}
	
	public function addCategory($world_id, $data)
	{
		return $this->request('http://10.111.122.118/osca/public/api/category/add-category/'.$world_id, 'POST', $data);
	}
	
	public function addSubcategory($category_id, $data)
	{
		return $this->request('http://10.111.122.118/osca/public/api/category/add-subcategory/'.$category_id, 'POST', $data);
	}
	
	public function editWorld($world_id, $data)
	{
		return $this->request('http://10.111.122.118/osca/public/api/category/edit-world/'.$world_id, 'PUT', $data);
	}
	
	public function editCategory($world_id, $category_id, $data)
	{
		return $this->request('http://10.111.122.118/osca/public/api/category/edit-category/'.$world_id.'/'.$category_id, 'PUT', $data);
	}

	public function editSubcategory($category_id, $subcategory_id, $data)
	{
		return $this->request('http://10.111.122.118/osca/public/api/category/edit-subcategory/'.$category_id.'/'.$subcategory_id, 'PUT', $data);
	}
	
	private function request($url, $method = 'GET', $data = null)
	{
		// Get cURL resource
		$curl = curl_init();
		
		// Set some options
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		switch ($method)
		{
			case 'GET':
			case 'DELETE':
				break;
			case 'POST':
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				break;
			case 'PUT':
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				break;
		}
		
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		
		//Get the resulting HTTP status code from the cURL handle.
		$http_status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		
		// Close request to clear up some resources
		curl_close($curl);		
		
		return ['data' => $resp, 'status' => $http_status_code];
	}
}