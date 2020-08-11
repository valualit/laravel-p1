<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use View;

class RolesController extends Controller
{
    //
	public function index(){
		$data = array(
			"NavItemActive"=>"users",
			"name"=>__('Роли и права'), 
			"title"=>__('Роли и права'), 
		);
		$data['roles']=Role::all();
		return view('admin.views.roles',$data);  
	}
	
	public function EditPermissionRole($id){
		if(Role::where('id',$id)->first()!=false){
			$formdata = ['role'=>Role::where('id',$id)->first()];
			$formdata['PermissionAll']=Permission::all();
			$Permission=$formdata['role']->getAllPermissions();
			foreach($Permission as $p){
				$formdata['Permission'][$p->id]=$p;
			}
			$html = trim(View::make('admin.views.roles.formeditpermissionrole',$formdata)->toHtml());
			$data = array(
				'success' => true,
				'status' => 'OK', 
				'title'=>__('Права доступа')." ".__('группы').": <b class='text-danger'>".$formdata['role']->name."</b>",
				'html'=>$html,   
				'form'=>['action'=>route('admin.roles.formeditpermissionrole.post',$id),'method'=>'POST'],
				'button'=>['class'=>'btn-primary','text'=>__('Сохранить')],
			);
			//$response = response()->json($data, 200);
			header("HTTP/1.1 200 OK");
			header('Content-type:application/json;charset=utf-8');
			echo json_encode($data); exit();
			return $response;
		}
	}
	public function PostEditPermissionRole($id, Request $request){
		if($request->has('PermissionID')){
			$role = Role::where('id',$id)->first();
			DB::table(config('permission.table_names')['role_has_permissions'])->where('role_id', $id)->delete();
			$Permissions = $request->input('PermissionID');
			unset($Permissions[0]);
			foreach($Permissions as $idPerm=>$Perm){
				$permission = Permission::where("id",$Perm)->first();
				$role->givePermissionTo($permission); 
			}
			$request->session()->put('toasts', array(['body'=>__('Права роли успешно установлены!'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Роль не существует! Управление правами невозможно.'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.roles'));
	}
	public function FormEditRole($id){
		if(Role::where('id',$id)->first()!=false){
			$formdata = ['role'=>Role::where('id',$id)->first()];
			$html = trim(View::make('admin.views.roles.formeditrole',$formdata)->toHtml());
			$data = array(
				'success' => true,
				'status' => 'OK', 
				'title'=>__('Переименовать роль'),
				'html'=>$html,   
				'form'=>['action'=>route('admin.roles.formeditrole.post',$id),'method'=>'POST'],
				'button'=>['class'=>'btn-primary','text'=>'Переименовать роль'],
			);
			//$response = response()->json($data, 200);
			header("HTTP/1.1 200 OK");
			header('Content-type:application/json;charset=utf-8');
			echo json_encode($data); exit();
			return $response;
		}
	}
		
	public function FormAddRole(){
		$formdata = [];
		$html = trim(View::make('admin.views.roles.formaddrole',$formdata)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить новую роль'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.roles.formaddrole.post'),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить роль'],
		);
		//$response = response()->json($data, 200);
		header("HTTP/1.1 200 OK");
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
		return $response;
	}
	
	public function PostEditRole($id, Request $request){
		if($request->has('renamerole')){
			if(Role::where('id',$id)->first()!=false){
				DB::table(config('permission.table_names')['roles'])->where('id', $id)->update(array('name' =>$request->input('renamerole')));
				$request->session()->put('toasts', array(['body'=>__('Роль успешно переименвована!'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
				return back();
			} else {
				$request->session()->put('toasts', array(['body'=>__('Роль не существует. Переименование невозможно.'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
				return back();
			}
		}
		return redirect(route('admin.roles'));
	}
	
	
	public function PostAddRole(Request $request){
		if($request->has('namenewrole')){
			if(Role::where('name',$request->input('namenewrole'))->first()!=false){
				$request->session()->put('toasts', array(['body'=>__('Роль с тками именем существует'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
				return back();
			} else {
				$request->session()->put('toasts', array(['body'=>__('Роль успешно добавлена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
				Role::create(['name' => $request->input('namenewrole')]);
			}
		}
		return redirect(route('admin.roles'));
	}
	
	public function DropRole($id, Request $request){
		if($id<=4){
			$request->session()->put('toasts', array(['body'=>__('Роль защищена от удаления!'),'class'=>'bg-warning','title'=>__('Предупреждение'),'subtitle'=>null])); 
			return back();
		} elseif(Role::where('id',$id)->first()!=false){
			$role = Role::findOrFail($id); 
			if($role->delete()){
				$request->session()->put('toasts', array(['body'=>__('Роль успешно удалена!'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
			} else {
				$request->session()->put('toasts', array(['body'=>__('Ошибка удаление существующей роли.'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			}
			return back();
		} else {
			$request->session()->put('toasts', array(['body'=>__('Роль не существует! Удаление невозможно.'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			return back();
		}
	}
	
	public function SetDefault($id, Request $request){
		if(Role::where('id',$id)->first()!=false){
			DB::table(config('permission.table_names')['roles'])->update(array('default' => 0));
			DB::table(config('permission.table_names')['roles'])->where('id', $id)->update(array('default' => 1));
			$request->session()->put('toasts', array(['body'=>__('Роль успешно установлена по умолчанию для новых пользователей!'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
			return back();
		} else {
			$request->session()->put('toasts', array(['body'=>__('Роль не существует! Установить по умолчанию невозможно.'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			return back();
		}
	}
}
