<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
	public function index(){
		$data = array(
			"NavItemActive"=>"views",
		);
		return view('admin.index',$data); 
	}
}
