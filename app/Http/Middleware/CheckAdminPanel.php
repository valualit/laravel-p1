<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use View;

class CheckAdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(Auth::user()==null || Role::findById(Auth::user()->roles)->hasDirectPermission(1)==false){
            return redirect(route("login"));
        } else {
			$munu=$this->getMenu(0);
			View::share('admin_section_munu', $munu);
		}
        return $next($request);
    }
    public function getMenu($parent=0){
		$munu=[];
		$sections = DB::table('section')->where('parent',$parent)->get();
		foreach($sections as $section){
			$munu[$section->id]=array(
				'icon'=>null,
				'name'=>$section->name,
				'url'=>route('admin.component.index',$section->id),
				'items'=>$this->getMenu($section->id),
			);
		}
		return $munu;
	}
}
