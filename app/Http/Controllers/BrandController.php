<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function getIndex()
	{
		return view('brand.index');
	}
}
