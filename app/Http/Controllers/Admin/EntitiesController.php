<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use View;
use EntitiesFields;
use PageEntities; 
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EntitiesController extends Controller
{
	public function index(){
		$data = array(
			"NavItemActive"=>"entities",
			"name"=>__('Сущности'), 
			"title"=>__('Сущности'), 
		);
		$data['pages']=PageEntities::ListPage();
		$data['entities']=[];
		$entities=DB::table('section')->get(); 
		foreach($entities as $entitie){
			$data['entities'][$entitie->id]=$entitie;
		}
		return view('admin.views.entities',$data); 
	}
	public function ComponentAddHtml(){
		$data['parents']=DB::table('section')->get();  
		$dirs = Storage::disk('disk')->directories("/resources/views/template/");
		$data['templates']=[];
		foreach($dirs as $dir){$data['templates'][]=pathinfo(Storage::disk('disk')->path($dir),PATHINFO_BASENAME );}
		$html = trim(View::make('admin.views.entities.add',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить сущность'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.entities.addpost'),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function ComponentAdd(Request $request){
		$section = $request->input('section');
		$settings = $request->input('settings');
		$lastInsertId = DB::table('section')->insertGetId([
            'name' => $section['name'],
            'url' => $section['url'],
            'title' => $section['title'],
            'description' => $section['description'],
            'keywords' => $section['keywords'],
            'image' => $section['image'],
            'template' => $section['template'],
            'parent' => $section['parent'],
            'settings' => json_encode($settings),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'), 
        ]);
		Schema::create('section'.$lastInsertId, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); 
            $table->text('text')->nullable();
            $table->integer('parent')->default(0);
            $table->integer('user')->default(0);
            $table->json('info')->nullable();
            $table->timestamps();
        });
		return redirect(route('admin.entities')); 
	}
	public function ComponentEditHtml($id, Request $request){
		$data['Component']=DB::table('section')->where('id',$id)->first();  
		$data['ComponentAdmin']=json_decode($data['Component']->admin,true);
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$data['parents']=DB::table('section')->where('id',"!=",$id)->get();  
		$dirs = Storage::disk('disk')->directories("/resources/views/template/");
		$data['templates']=[];
		foreach($dirs as $dir){$data['templates'][]=pathinfo(Storage::disk('disk')->path($dir),PATHINFO_BASENAME );}
		$html = trim(View::make('admin.views.entities.edit',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать сущность'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.entities.editpost',$id),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Сохранить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function ComponentEdit($id, Request $request){
		$section = $request->input('section');
		$settings = $request->input('settings');
		DB::table('section')->where('id',$id)->update([
            'name' => $section['name'],
            'url' => $section['url'],
            'title' => $section['title'],
            'description' => $section['description'],
            'keywords' => $section['keywords'],
            'image' => $section['image'],
            'template' => $section['template'],
            'parent' => $section['parent'],
            'settings' => json_encode($settings),
            'updated_at' => date('Y-m-d H:i:s'), 
        ]);
		return redirect(route('admin.entities')); 
	}
	public function ComponentSettingHtml($id, Request $request){
		$data['Component']=DB::table('section')->where('id',$id)->first();  
		$data['ComponentAdmin']=json_decode($data['Component']->admin,true);
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$data['parents']=DB::table('section')->where('id',"!=",$id)->get();  
		$data['WidjetCode'] = $this->getWidjetCodeList($id);
		$sections = Storage::disk('disk')->files("/resources/views/template/".$data['Component']->template."/section/");
		$pages = Storage::disk('disk')->files("/resources/views/template/".$data['Component']->template."/section/pages/");
		$data['sections']=[];
		$data['pages']=[];
		foreach($sections as $dir){$data['sections'][]=str_replace(".blade.php",null,pathinfo(Storage::disk('disk')->path($dir),PATHINFO_BASENAME ));}
		foreach($pages as $dir){$data['pages'][]=str_replace(".blade.php",null,pathinfo(Storage::disk('disk')->path($dir),PATHINFO_BASENAME ));}
		$data['roles']=Role::all();
		//var_dump($data['roles']); exit();
		$html = trim(View::make('admin.views.entities.setting',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Настройки'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.entities.settingpost',$id),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Сохранить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function ComponentSetting($id, Request $request){
		
		$data['Component']=DB::table('section')->where('id',$id)->first();  
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$settings = $request->input('settings');
		foreach($settings as $key=>$value){
			$data['ComponentSettings'][$key]=$value;
		}
		
		DB::table('section')->where('id',$id)->update([
            'settings' => json_encode($data['ComponentSettings']),
            'updated_at' => date('Y-m-d H:i:s'), 
        ]);
		return redirect(route('admin.entities')); 
	}
	public function isUrlSection(Request $request){
		$data = array(
			'success' => false,
			'isset' => true,
			'text' => __('Ошибка'),
		);
		if($request->has('url')) { 
			$user=DB::table('section')->where("url",$request->input('url'))->where("id","!=",$request->input('id'))->first();
			if($user){
				$data['text']=__('URL занят!');
			} else {
				$data['success']=true;
				$data['isset']=false;
				$data['text']=__('URL доступен');
			}
		} else {
			$data['text']=__('Введен некорректный URL');
		}
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	
	public function ComponentDrop($id, Request $request){
		$user=DB::table('section')->where("id",$id)->first();
        if($user!=null&&$user!=false){
			DB::table('section')->where('id', $id)->delete();
			Schema::dropIfExists('section'.$id);
			$request->session()->put('toasts', array(['body'=>__('Сущность успешно удалена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления сущности'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.entities'));  
	}
	
	/**********************************/
	/**********************************/
	
	
	// Главная управления доп полями сущности пользователей
	public function UserEntitiesIndex($sectionID){
		$section = DB::table('section')->where('id',$sectionID)->first(); 
		return EntitiesFields::index(
			$sectionID,
			'services.entitiesfields.index',
			[	
				'btn-content'=>route('admin.component.index',$sectionID),
				'btn-list-section'=>route('admin.entities'),
				'btn-add'=>route('admin.entities.userentities.add',$sectionID),
				'btn-catadd'=>route('admin.entities.userentities.catadd',$sectionID),
				'catedit'=>'admin.entities.userentities.catedit',
				'catdelete'=>'admin.entities.userentities.catdelete',
				'edit'=>'admin.entities.userentities.edit',
				'delete'=>'admin.entities.userentities.delete'
			],
			$sectionID,
			'admin.entities.userentities',
			$section->name); 
	} 
	
	public function UserEntitiesCatAddPOST($section,Request $request){
		return EntitiesFields::catAdd($section,$request, route('admin.entities.userentities',$section));
	}
	public function UserEntitiesCatAdd($section){
		return EntitiesFields::catAddHTML('services.entitiesfields.catadd',route('admin.entities.userentities.cataddpost', $section));
	}
	
	// Добавление поля
    public function FieldsAdd($section, Request $request){
        return EntitiesFields::FieldsAdd($section, $request, route('admin.entities.userentities',$section)); 
    }
    public function FieldsAddHTML($section){
		return EntitiesFields::FieldsAddHTML($section,'services.entitiesfields.add',route('admin.entities.userentities.addpost',$section)); 
    }
	
	// Редактирование категории
    public function catEdit($section, $id, Request $request){
        return EntitiesFields::catEdit($id,$request,route('admin.entities.userentities',$section));
    }
    public function catEditHTML($section, $id){ 
        return EntitiesFields::catEditHTML($id,'services.entitiesfields.catedit',route('admin.entities.userentities.cateditpost',[$section, $id]));
    } 
	// Удаление категории
    public function catDelete($section, $id, Request $request){
        return EntitiesFields::catDelete($id,$request,route('admin.entities.userentities',$section)); 
    }
    public function catDeleteHTML($section){
        
    }
	// Редактирование поля
    public function FieldsEdit($section, $id,Request $request){ 
        return EntitiesFields::FieldsEdit($id, $request, route('admin.entities.userentities',$section)); 
    }
    public function FieldsEditHTML($section, $id, Request $request){
		return EntitiesFields::FieldsEditHTML($id, $section,'services.entitiesfields.edit',route('admin.entities.userentities.editpost',[$section,$id]), $request);   
    }
	// Удаление поля
    public function FieldsDelete($section, $id,Request $request){
        return EntitiesFields::FieldsDelete($id,$request,route('admin.entities.userentities',$section)); 
        
    }
    public function FieldsDeleteHTML($section){
        
    }
	
	/**********************************/
	/**********************************/
	
    //
	public function ComponentIndex($section, Request $request){
		$data['section']=$section;  
		$data['Component']=DB::table('section')->where('id',$section)->first();  
		$data['ComponentAdmin']=json_decode($data['Component']->admin,true);
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$data["name"]=$data['Component']->name; 
		$data["title"]=$data['Component']->name;
		$data['table']='section'.$data['Component']->id;  
		$data['BtnItemAdd']=route('admin.component.item.add',$data['Component']->id);  
		
		$data['WidjetCode'] = $this->getWidjetCodeList($section);
		if(!isset($data['ComponentSettings']['admin-table'])||count($data['ComponentSettings']['admin-table'])==0){
			$data['ComponentSettings']['admin-table']['name']='name';
		}
		
		$data['items']=DB::table($data['table'])->orderBy('created_at','DESC')->paginate(50);   
		return view('admin.views.entities.componentindex',$data); 
	}
	
	public function ComponentItemView($section, $id, Request $request){		
		$data['Component']=DB::table('section')->where('id',$section)->first(); 
		$data['table']='section'.$data['Component']->id; 
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$data['template']='template.'.$data['Component']->template.'.';
		$data['templatePath']=Storage::disk('disk')->path("/resources/views/template/".$data['Component']->template."/");
		$data['templateURL']=Storage::disk('disk')->url("/resources/views/template/".$data['Component']->template."/");
		
		$data['item']=DB::table($data['table'])->where('id',$id)->first();
		
		$data['name']=$this->ReplaceRowCode(($data['ComponentSettings']['name']??null),$data['item'],$data['Component']->id);
		$data['title']=$this->ReplaceRowCode(($data['ComponentSettings']['title']??null),$data['item'],$data['Component']->id);
		$data['description']=$this->ReplaceRowCode(($data['ComponentSettings']['description']??null),$data['item'],$data['Component']->id);
		$data['keywords']=$this->ReplaceRowCode(($data['ComponentSettings']['keywords']??null),$data['item'],$data['Component']->id);	
		$data['tag']=$this->ReplaceRowCode(($data['ComponentSettings']['tag']??null),$data['item'],$data['Component']->id);	
		$data['img']=$this->ReplaceRowCode(($data['ComponentSettings']['img']??null),$data['item'],$data['Component']->id);	
		$data['canonical']=route('section.item',[$data['Component']->url,$data['item']->id,Str::slug($data['item']->name)]);	
		
		$data['WidjetCode'] = $this->getWidjetCodeList($section);
		if(!isset($data['ComponentSettings']['admin-table'])||count($data['ComponentSettings']['admin-table'])==0){
			$data['ComponentSettings']['admin-table']['name']='name';
		}
		
		return view('admin.views.entities.componentview',$data); 
	}
	
	public function ComponentItemAddHtml($section, Request $request){
		
		$data = array( 
			"CatList"=>EntitiesFields::GetCatList($section), 
			"types"=>EntitiesFields::TypesList(), 
			"GetEntitiesList"=>EntitiesFields::GetEntitiesList($section), 
		);
		
		$data['Component']=DB::table('section')->where('id',$section)->first();  
		$data['ComponentAdmin']=json_decode($data['Component']->admin,true);
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		
		$data['List']=EntitiesFields::GetInputInArray($data);
		$data['isTab']=$data['CatList']->count()>0;
		
		$html = trim(View::make('admin.views.entities.componentitemadd',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.component.item.addpost',$section),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function ComponentItemAdd($section, Request $request){
		$ComponentItemNew = $request->input('section');
		$ComponentItemNewInfo = $request->input('info');
		$info = array();
		$data = array( 
			"CatList"=>EntitiesFields::GetCatList($section), 
			"types"=>EntitiesFields::TypesList(), 
			"GetEntitiesList"=>EntitiesFields::GetEntitiesList($section), 
		);
		$list=EntitiesFields::GetInputInArray($data); 
		foreach($list as $Entities){
			if($Entities['cat']==false&&isset($ComponentItemNewInfo[$Entities['id']])){
				$info[$Entities['id']]=['name'=>$Entities['entitie_name'],'text'=>$data["types"][$Entities['type']]['function_add']($ComponentItemNewInfo[$Entities['id']])];
			}
		}
		$data['Component']=DB::table('section')->where('id',$section)->first(); 
		$data['table']='section'.$data['Component']->id; 
		$lastInsertId = DB::table($data['table'])->insertGetId([
            'name' => $ComponentItemNew['name'],
            'text' => $ComponentItemNew['text']?EntitiesFields::TypesList()["textarea wysiwyg"]["function_add"]($ComponentItemNew['text']):null,
            'user' => $ComponentItemNew['user'],
            'parent' => $ComponentItemNew['parent'],
            'info' => json_encode($info),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'), 
        ]);
		return redirect(route('admin.component.index',$section)); 
	}
	
	public function ComponentItemEditHtml($section, $id, Request $request){
		$data['Component']=DB::table('section')->where('id',$section)->first(); 
		$data['table']='section'.$data['Component']->id; 
		$item=DB::table($data['table'])->where("id",$id)->first();
		
		$data = array( 
			"CatList"=>EntitiesFields::GetCatList($section), 
			"types"=>EntitiesFields::TypesList(), 
			"GetEntitiesList"=>EntitiesFields::GetEntitiesList($section), 
		);
		
		
		$data['Component']=DB::table('section')->where('id',$section)->first();  
		$data['ComponentAdmin']=json_decode($data['Component']->admin,true);
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		
		$data['List']=EntitiesFields::GetInputInArray($data,false,json_decode($item->info,true));
		$data['isTab']=$data['CatList']->count()>0;
		$data['item']=$item;
		
		$html = trim(View::make('admin.views.entities.componentitemedit',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать запись'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.component.item.editpost',[$section,$id]),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Сохранить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function ComponentItemEdit($section, $id, Request $request){
		$data['Component']=DB::table('section')->where('id',$section)->first(); 
		$data['table']='section'.$data['Component']->id; 
		$item=DB::table($data['table'])->where("id",$id)->first();
		
		$ComponentItemNew = $request->input('section');
		$ComponentItemNewInfo = $request->input('info');
		//var_dump(EntitiesFields::TypesList()["textarea wysiwyg"]["function_add"]($ComponentItemNew['text'])); exit();
		$info = array();
		$data = array( 
			"CatList"=>EntitiesFields::GetCatList($section), 
			"types"=>EntitiesFields::TypesList(), 
			"GetEntitiesList"=>EntitiesFields::GetEntitiesList($section), 
		);
		$list=EntitiesFields::GetInputInArray($data); 
		foreach($list as $Entities){
			if($Entities['cat']==false&&isset($ComponentItemNewInfo[$Entities['id']])){
				$info[$Entities['id']]=['name'=>$Entities['entitie_name'],'text'=>$data["types"][$Entities['type']]['function_add']($ComponentItemNewInfo[$Entities['id']])];
			}
		}
		$data['Component']=DB::table('section')->where('id',$section)->first(); 
		$data['table']='section'.$data['Component']->id; 
		DB::table($data['table'])->where("id",$id)->update([
            'name' => $ComponentItemNew['name'],
            'text' => $ComponentItemNew['text']?EntitiesFields::TypesList()["textarea wysiwyg"]["function_add"]($ComponentItemNew['text']):null,
            'user' => $ComponentItemNew['user'],
            'parent' => $ComponentItemNew['parent'],
            'info' => json_encode($info),
            'created_at' => $ComponentItemNew['created_at'],
            'updated_at' => date('Y-m-d H:i:s'), 
        ]);
		return redirect(route('admin.component.index',$section)); 
	}
	
	
	public function ComponentItemDrop($section, $id, Request $request){
		$data['Component']=DB::table('section')->where('id',$section)->first(); 
		$data['table']='section'.$data['Component']->id; 
		
		$item=DB::table($data['table'])->where("id",$id)->first();
        if($item!=null&&$item!=false){
			DB::table($data['table'])->where('id', $id)->delete();
			$request->session()->put('toasts', array(['body'=>__('Запись успешно удалена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления записи'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.component.index',$section)); 
	}
	
	public function ReplaceRowCode($text,$Component,$section){
		$WidjetCode = $this->getWidjetCodeList($section);
		$info=json_decode($Component->info,true);
		foreach($WidjetCode as $keyWidjetCode=>$code){
			$text = str_replace($code['codeform'],($code['db']=='info'?($info[$code['id']]['text']??null):($Component->{$code['id']}??null)),$text);
		}
		return $text;
	}
	
	public function getWebIndex($url, Request $request){
		$data['Component']=DB::table('section')->where('url',$url)->first(); 
		$data['table']='section'.$data['Component']->id; 
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$data['name']=$data['Component']->name;
		$data['title']=$data['Component']->title;
		$data['description']=$data['Component']->description;
		$data['keywords']=$data['Component']->keywords;
		$data['canonical']=route('section.id',$data['Component']->url);
		$data['template']='template.'.$data['Component']->template.'.';
		$data['templatePath']=Storage::disk('disk')->path("/resources/views/template/".$data['Component']->template."/");
		$data['templateURL']=Storage::disk('disk')->url("/resources/views/template/".$data['Component']->template."/");
		
		$items=DB::table($data['table'])->orderBy('created_at','DESC')->paginate($data['ComponentSettings']['rows']??10);  
		$data['pagination']=$items->links(); 
		$data['tags']=[];		
		$data['items']=[];	
		foreach($items as $keyEntitie=>$item){
			$info = json_decode($item->info,true);
			$tag = $this->ReplaceRowCode(($data['ComponentSettings']['tag']??null),$item,$data['Component']->id);
			$data['items'][$keyEntitie]=array(
				"id"=>$item->id,
				"name"=>$this->ReplaceRowCode(($data['ComponentSettings']['name']??null),$item,$data['Component']->id),
				"title"=>$this->ReplaceRowCode(($data['ComponentSettings']['title']??null),$item,$data['Component']->id),
				"img"=>$this->ReplaceRowCode(($data['ComponentSettings']['img']??null),$item,$data['Component']->id),
				"tag"=>$tag,
				"link"=>route('section.item',[$data['Component']->url,$item->id,Str::slug($item->name)]),
			);
			$data['tags'][$tag]=$tag;
		}
		
		return view($data['template'].'section.'.($data['ComponentSettings']['template-cat']??'table'),$data); 
	}
	public function getWebItem($url, $id, $translate, Request $request){
		$data['Component']=DB::table('section')->where('url',$url)->first(); 
		$data['table']='section'.$data['Component']->id; 
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		$data['template']='template.'.$data['Component']->template.'.';
		$data['templatePath']=Storage::disk('disk')->path("/resources/views/template/".$data['Component']->template."/");
		$data['templateURL']=Storage::disk('disk')->url("/resources/views/template/".$data['Component']->template."/");
		
		$data['item']=DB::table($data['table'])->where('id',$id)->first();
		
		$data['name']=$this->ReplaceRowCode(($data['ComponentSettings']['name']??null),$data['item'],$data['Component']->id);
		$data['title']=$this->ReplaceRowCode(($data['ComponentSettings']['title']??null),$data['item'],$data['Component']->id);
		$data['description']=$this->ReplaceRowCode(($data['ComponentSettings']['description']??null),$data['item'],$data['Component']->id);
		$data['keywords']=$this->ReplaceRowCode(($data['ComponentSettings']['keywords']??null),$data['item'],$data['Component']->id);	
		$data['tag']=$this->ReplaceRowCode(($data['ComponentSettings']['tag']??null),$data['item'],$data['Component']->id);	
		$data['img']=$this->ReplaceRowCode(($data['ComponentSettings']['img']??null),$data['item'],$data['Component']->id);	
		$data['canonical']=route('section.item',[$data['Component']->url,$data['item']->id,Str::slug($data['item']->name)]);	
		
		return view($data['template'].'section.pages.'.($data['ComponentSettings']['template-page']??'post'),$data); 
	}
	public function getEntitiesWidjetCode($section){
		
		$data['Component']=DB::table('section')->where('id',$section)->first();  
		$data['ComponentSettings']=json_decode($data['Component']->settings,true);
		
		$data['list'] = $this->getWidjetCodeList($section);
		$html = trim(View::make('admin.views.entities.widjetcodes',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Коды полей'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.entities'),'method'=>'GET'],
			'button'=>['class'=>'btn-primary','text'=>"Закрыть"],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();		
	} 
	public function getWidjetCodeList($section){
		$types = EntitiesFields::TypesList();
		$Entities = []; 
		$EntitiesFields = EntitiesFields::GetEntitiesList($section); 

		$Component=DB::table('section')->where('id',$section)->first();  
		$ComponentSettings=json_decode($Component->settings,true);
		
		$key='name';
		$Entities[$key]=array(
					"id"=>$key,
					"key"=>$key,
					"db"=>$key,
					"name"=>$ComponentSettings['namerow']??'Заголовок', 
					"code"=>$key.":".($ComponentSettings['namerow']??'Заголовок').":", 
					"codeform"=>"[".$key."]", 
					"type"=>'input',
					"required"=>true,
					"html"=>$types['input']['html']("%name%",$key,"info[".$key."]",null,null,true),
		);
		$key='text';
		$Entities[$key]=array(
					"id"=>$key,
					"key"=>$key,
					"db"=>$key,
					"name"=>'Текст', 
					"code"=>$key.":Введите текст:", 
					"codeform"=>"[".$key."]", 
					"type"=>'textarea',
					"required"=>false,
					"html"=>$types['textarea']['html']("%name%",$key,"info[".$key."]",null,null,false),
		);
		$key='created_at';
		$Entities[$key]=array(
					"id"=>$key,
					"key"=>$key,
					"db"=>$key,
					"name"=>'Дата создания', 
					"code"=>$key."::datetime", 
					"codeform"=>"[".$key."]", 
					"type"=>'input',
					"required"=>false,
					"html"=>$types['input']['html']("%name%",$key,"info[".$key."]",null,null,false),
		);
		$key='updated_at';
		$Entities[$key]=array(
					"id"=>$key,
					"key"=>$key,
					"db"=>$key,
					"name"=>'Дата обновления', 
					"code"=>$key."::datetime", 
					"codeform"=>"[".$key."]", 
					"type"=>'input',
					"required"=>false,
					"html"=>$types['input']['html']("%name%",$key,"info[".$key."]",null,null,false),
		);
		foreach($EntitiesFields as $list0){
			foreach($list0 as $Entitie){
				$key="i".$Entitie->id;
				$Entities[$key]=array(
					"id"=>$Entitie->id,
					"key"=>$key,
					"db"=>'info',
					"name"=>$Entitie->name, 
					"code"=>$key.":".$Entitie->name.":", 
					"codeform"=>"[".$key."]", 
					"type"=>$Entitie->type,
					"required"=>($Entitie->required?true:false),
					"html"=>$types[$Entitie->type]['html']("%name%",$key,"info[".$key."]",null,null,($Entitie->required?true:false)),
				);
			}
		} 
		return $Entities;
	} 
}
