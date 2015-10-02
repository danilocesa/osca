<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function getIndex()
	{
		$brand=\App\Brand::paginate(10);
		return view('brand.index',['brands'=> $brand ]);
	}
}
