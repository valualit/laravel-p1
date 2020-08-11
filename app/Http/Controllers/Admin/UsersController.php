<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use View;
use EntitiesFields;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller {
    //
	public function index(){
		$data = array(
			"NavItemActive"=>"users",
			"name"=>__('Пользователи'), 
			"title"=>__('Пользователи'), 
		);
		$users = User::paginate(50);
		$data['users']=$users; 
		$roles = Role::all();
		$data['roles'] = array();
		foreach($roles as $role){ $data['roles'][$role->id]['name']=$role->name; }
		//var_dump($data['roles'][3]); exit();
		return view('admin.views.users',$data); 
	}
	public function addHTML(){
		$formdata = array( 
			"CatList"=>EntitiesFields::GetCatList('users'), 
			"types"=>EntitiesFields::TypesList(), 
			"GetEntitiesList"=>EntitiesFields::GetEntitiesList('users'), 
		);
		$formdata['List']=EntitiesFields::GetInputInArray($formdata);
		$formdata['roles']=Role::all();
		$formdata['isTab']=$formdata['CatList']->count()>0;
		$html = trim(View::make('admin.views.users.add',$formdata)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить пользователя'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.users.addpost'),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function add(Request $request){
		$userNew = $request->input('user');
		$userNewInfo = $request->input('info');
		$info = array();
		$data = array( 
			"CatList"=>EntitiesFields::GetCatList('users'), 
			"types"=>EntitiesFields::TypesList(), 
			"GetEntitiesList"=>EntitiesFields::GetEntitiesList('users'), 
		);
		$list=EntitiesFields::GetInputInArray($data); 
		foreach($list as $Entities){
			if($Entities['cat']==false&&isset($userNewInfo[$Entities['id']])){
				$info[$Entities['id']]=['name'=>$Entities['entitie_name'],'text'=>$data["types"][$Entities['type']]['function_add']($userNewInfo[$Entities['id']])];
			}
		}
		$lastInsertId = DB::table('users')->insertGetId([
            'name' => $userNew['name'],
            'phone' => $userNew['phone'],
            'email' => $userNew['email'],
            'roles' => $userNew['roles'],
            'password' => bcrypt($userNew['password']),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'), 
            'info' => json_encode($info), 
        ]);
		return redirect(route('admin.users')); 
	}
	public function editHTML($id){
		$user=DB::table('users')->where("id",$id)->first();
        if($user==null||$user==false){
			$html= __('Ошибка');
		} else {
			$formdata = array( 
				"CatList"=>EntitiesFields::GetCatList('users'), 
				"types"=>EntitiesFields::TypesList(), 
				"GetEntitiesList"=>EntitiesFields::GetEntitiesList('users'), 
			);
			$formdata['user']=$user;
			$formdata['List']=EntitiesFields::GetInputInArray($formdata,false,json_decode($user->info,true));
			$formdata['roles']=Role::all();
			$formdata['isTab']=$formdata['CatList']->count()>0;
			$html = trim(View::make('admin.views.users.edit',$formdata)->toHtml());
		}
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать пользователя'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.users.editpost',$user->id),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Сохранить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function edit($id, Request $request){
		$user=DB::table('users')->where("id",$id)->first();
        if($user!=null&&$user!=false){
			$userNew = $request->input('user');
			$userNewInfo = $request->input('info');
			$info = array();
			$data = array( 
				"CatList"=>EntitiesFields::GetCatList('users'), 
				"types"=>EntitiesFields::TypesList(), 
				"GetEntitiesList"=>EntitiesFields::GetEntitiesList('users'), 
			);
			$list=EntitiesFields::GetInputInArray($data); 
			foreach($list as $Entities){
				if($Entities['cat']==false&&isset($userNewInfo[$Entities['id']])){
					$info[$Entities['id']]=['name'=>$Entities['entitie_name'],'text'=>$data["types"][$Entities['type']]['function_add']($userNewInfo[$Entities['id']])];
				}
			}
			$update = [
				'name' => $userNew['name'],
				'phone' => $userNew['phone'],
				'email' => $userNew['email'],
				'roles' => $userNew['roles'],
				'updated_at' => date('Y-m-d H:i:s'), 
				'info' => json_encode($info), 
			];
			if(isset($userNew['password'])&&mb_strlen($userNew['password'])>3){
				$update['password']=bcrypt($userNew['password']);
			}
			$lastInsertId = DB::table('users')->where("id",$id)->update($update);
			$request->session()->put('toasts', array(['body'=>__('Пользователь успешно сохранен'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка сохранения пользователя'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.users')); 
	}
	public function drop($id, Request $request){
		$user=DB::table('users')->where("id",$id)->first();
        if($user!=null&&$user!=false){
			DB::table('users')->where('id', $id)->delete();
			$request->session()->put('toasts', array(['body'=>__('Пользователь успешно удален'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления пользователя'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.users')); 
	}
	public function isUserEmail(Request $request){
		$data = array(
			'success' => false,
			'isset' => true,
			'text' => __('Ошибка'),
		);
		if(filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) { 
			$user=DB::table('users')->where("email",$request->input('email'))->where("id","!=",$request->input('id'))->first();
			if($user){
				$data['text']=__('EMAIL уже используется!');
			} else {
				$data['success']=true;
				$data['isset']=false;
				$data['text']=__('EMAIL доступен для регистрации!');
			}
		} else {
			$data['text']=__('Введен некорректный EMAIL');
		}
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	// Главная управления доп полями сущности пользователей
	public function UserEntitiesIndex(){
		return EntitiesFields::index(
			'users',
			'services.entitiesfields.index',
			['btn-add'=>route('admin.users.userentities.add'),'btn-catadd'=>route('admin.users.userentities.catadd'),'catedit'=>'admin.users.userentities.catedit','catdelete'=>'admin.users.userentities.catdelete','edit'=>'admin.users.userentities.edit','delete'=>'admin.users.userentities.delete'],
			false,
			'admin.users.userentities');
	}
	
	public function UserEntitiesCatAddPOST(Request $request){
		return EntitiesFields::catAdd('users',$request,route('admin.users.userentities'));
	}
	public function UserEntitiesCatAdd(){
		return EntitiesFields::catAddHTML('services.entitiesfields.catadd',route('admin.users.userentities.cataddpost'));
	}
	
	// Редактирование категории
    public function catEdit($id, Request $request){
        return EntitiesFields::catEdit($id,$request,route('admin.users.userentities'));
    }
    public function catEditHTML($id){
        return EntitiesFields::catEditHTML($id,'services.entitiesfields.catedit',route('admin.users.userentities.cateditpost',$id));
    }
	// Удаление категории
    public function catDelete($id, Request $request){
        return EntitiesFields::catDelete($id,$request,route('admin.users.userentities')); 
    }
    public function catDeleteHTML(){
        
    }
	// Добавление поля
    public function FieldsAdd(Request $request){
        return EntitiesFields::FieldsAdd('users', $request, route('admin.users.userentities')); 
    }
    public function FieldsAddHTML(){
		return EntitiesFields::FieldsAddHTML('users','services.entitiesfields.add',route('admin.users.userentities.addpost')); 
    }
	// Редактирование поля
    public function FieldsEdit($id,Request $request){ 
        return EntitiesFields::FieldsEdit($id, $request, route('admin.users.userentities')); 
    }
    public function FieldsEditHTML($id, Request $request){
		return EntitiesFields::FieldsEditHTML($id, 'users','services.entitiesfields.edit',route('admin.users.userentities.editpost',$id), $request);   
    }
	// Удаление поля
    public function FieldsDelete($id,Request $request){
        return EntitiesFields::FieldsDelete($id,$request,route('admin.users.userentities')); 
        
    }
    public function FieldsDeleteHTML(){
        
    }
}
