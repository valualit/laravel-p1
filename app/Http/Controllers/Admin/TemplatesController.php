<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    //
	public function index(){
		$data = array(
			"NavItemActive"=>"views",
		);
		return view('admin.index',$data); 
	}
}
