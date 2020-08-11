<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use EntitiesFields;
use PageEntities; 
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\EntitiesController;
use Mail;

class PagesController extends Controller
{
	public function getWebPage($url,Request $request){
		return $this->getWebPageCode($url,$request,false);
	}
	public function getWebPageAdmin($url,Request $request){
		return $this->getWebPageCode($url,$request,true);
	}
	public function getWebPageCode($url,$request,$admin=true){
		if($admin){
			if(Auth::user()==null || Role::findById(Auth::user()->roles)->hasDirectPermission(1)==false){
				return redirect('/');
			}
		}
		$data['page']=DB::table('page')->where("url",$url)->first();
		$data['html']=null;
		if($admin){
			$widjetList = PageEntities::WidjetList();
			$types = EntitiesFields::TypesList();
			$widjets=DB::table('page_widjets')->where("page",$data['page']->id)->orderBy('position', 'ASC')->get();
			$data['widjets']=[];
			$i=1;
			$data['cardsize']=[2=>6,3=>4,4=>3,5=>2,6=>2];
			$oldCard=0;
			$cardOpen=false;
			$cardid=1;
			foreach($widjets as $widjet){
				$info = $this->WidjetInfoDecode($widjet, $widjetList, $types);
				$info['widjetID']=$widjet->id;
				// Card верстка виджетов
				if(!isset($info['card'])){ $info['card']=0; }
				if($cardOpen==false&&$info['card']>0&&$oldCard!=$info['card']){
					$data['html'].='<style>@media(min-width:576px){.card-columns-'.$cardid."-".$info['card'].'{-webkit-column-count:'.$info['card'].'!important;-moz-column-count:'.$info['card'].'!important;column-count:'.$info['card'].'!important;}</style>';
					$data['html'].='<div class="card-columns card-columns-'.$cardid."-".$info['card'].'">';
					$cardOpen=true;
					$oldCard=intval($info['card']);
					$data['widjets'][$widjet->id]['card']=intval($info['card']);
				} elseif($cardOpen==true&&$oldCard!=$info['card']){
					$data['html'].='</div>';
					$cardid++;
					$oldCard=$info['card'];
					$cardOpen=false;
					$data['widjets'][$widjet->id]['card']=$info['card'];
					if($info['card']>0){
						$data['html'].='<style>@media(min-width:576px){.card-columns-'.$cardid."-".$info['card'].'{-webkit-column-count:'.$info['card'].'!important;-moz-column-count:'.$info['card'].'!important;column-count:'.$info['card'].'!important;}</style>';
						$data['html'].='<div class="card-columns card-columns-'.$cardid."-".$info['card'].'">';
						$cardOpen=true;
						$oldCard=intval($info['card']);
						$data['widjets'][$widjet->id]['card']=intval($info['card']);
					}
				}
				// конец
				$data['html'].=trim(View::make($widjetList[$widjet->widjet]["template"],$info)->toHtml());
			}
		} else {
			$data['html']=$data['page']->text;
		}
		$data['name']=$data['page']->name;
		$data['title']=$data['page']->title;
		$data['description']=$data['page']->description;
		$data['keywords']=$data['page']->keywords;
		$data['canonical']=route('page.web',$data['page']->url);
		$data['template']='template.'.$data['page']->template.'.';
		$data['templatePath']=Storage::disk('disk')->path("/resources/views/template/".$data['page']->template."/");
		$data['templateURL']=Storage::disk('disk')->url("/resources/views/template/".$data['page']->template."/");
		return view($data['template'].'page',$data); 
	}
	public function addHtml(Request $request){ 
		$dirs = Storage::disk('disk')->directories("/resources/views/template/");
		$data['templates']=[];
		foreach($dirs as $dir){$data['templates'][]=pathinfo(Storage::disk('disk')->path($dir),PATHINFO_BASENAME );}
		$html = trim(View::make('admin.views.pages.add',$data)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить страницу'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.pages.addpost'),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function add(Request $request){
		if($request->has('page')) { 
			$page = $request->input('page');
			$page['image']=EntitiesFields::TypesList()["image"]["function_add"]($page['image']);			
			$lastInsertId = DB::table('page')->insertGetId([
				'name' => $page['name'],
				'url' => $page['url'],
				'template' => $page['template'],
				'title' => $page['title'],
				'description' => $page['description'],
				'keywords' => $page['keywords'],
				'image' => $page['image'],
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'), 
			]);
		}
		return redirect(route('admin.entities')); 
	}
	public function editHtml($id, Request $request){
		$page=DB::table('page')->where("id",$id)->first();
        if($page!=null&&$page!=false){
			$dirs = Storage::disk('disk')->directories("/resources/views/template/");
			$data['templates']=[];
			$data['page']=$page;
			foreach($dirs as $dir){$data['templates'][]=pathinfo(Storage::disk('disk')->path($dir),PATHINFO_BASENAME );}
			$html = trim(View::make('admin.views.pages.edit',$data)->toHtml());
		} else {
			$html = __('Ошибка! Запись не найдена');
		}
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать страницу'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.pages.editpost',$id),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Сохранить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function edit($id, Request $request){
		if($request->has('page')) { 
			$page = $request->input('page');
			$page['image']=EntitiesFields::TypesList()["image"]["function_add"]($page['image']);	
			$lastInsertId = DB::table('page')->where("id",$id)->update([
				'name' => $page['name'],
				'url' => $page['url'],
				'template' => $page['template'],
				'title' => $page['title'],
				'description' => $page['description'],
				'keywords' => $page['keywords'],
				'image' => $page['image'],
				'updated_at' => date('Y-m-d H:i:s'), 
			]);
		}
		return redirect(route('admin.entities')); 

	}
	public function drop($id, Request $request){
		$page=DB::table('page')->where("id",$id)->first();
        if($page!=null&&$page!=false){
			DB::table('page')->where('id', $id)->delete();
			Schema::dropIfExists('page'.$id);
			$request->session()->put('toasts', array(['body'=>__('Страница успешно удалена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления страницы'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.entities'));
	}
	public function isUrlPage(Request $request){
		$data = array(
			'success' => false,
			'isset' => true,
			'text' => __('Ошибка'),
		);
		if($request->has('url')) { 
			$user=DB::table('page')->where("url",$request->input('url'))->where("id","!=",$request->input('id'))->first();
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
	public function settingsHtml($id, Request $request){

	}
	public function settings($id, Request $request){

	}
	public function widjetRePosition($id, Request $request){
		$positions = $request->input('position');
		foreach($positions as $position=>$id){
			$data['position']=$position;
			$widjets=DB::table('page_widjets')->where("id",$id)->update($data);
		}
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($position); exit();
	}
	public function widjet($id, Request $request){
		$types = EntitiesFields::TypesList();
		$widjetList = PageEntities::WidjetList();
		$data['page']=DB::table('page')->where("id",$id)->first();
		$data['NavItemActive']='entities';
		$widjets=DB::table('page_widjets')->where("page",$id)->orderBy('position', 'ASC')->get();
		$data['widjets']=[];
		$i=1;
		$oldCard=0;
		foreach($widjets as $widjet){
			$info = $this->WidjetInfoDecode($widjet, $widjetList, $types);
			$info['widjetID']=$widjet->id;
			$data['widjets'][$widjet->id]=array(
				"id"=>$widjet->id,
				"name"=>$widjetList[$widjet->widjet]["name"],
				"edit"=>route('admin.pages.widjetedit',[$id,$widjet->widjet,$widjet->id]),
				"drop"=>route('admin.pages.widjetdrop',[$id,$widjet->id]),
				"html"=>trim(View::make($widjetList[$widjet->widjet]["template"],$info)->toHtml()),
				"position"=>$i++,
			);
			if(isset($info['card'])){
				$oldCard=intval($info['card']);
				$data['widjets'][$widjet->id]['card']=intval($info['card']);
			} else {
				$oldCard=0;
				$data['widjets'][$widjet->id]['card']=0;
			}
		}
		$data['cardsize']=[2=>6,3=>4,4=>3,5=>2,6=>2];
		$data['name']="Управление виджетами > ".$data['page']->name;
		$data['title']="Управление виджетами > ".$data['page']->name;
		return view('admin.views.pages.widjet',$data); 
	}
	public function widjetSave($id, Request $request){
		$data['page']=DB::table('page')->where("id",$id)->first();
		$data['html']=null;
		$types = EntitiesFields::TypesList();
		$widjetList = PageEntities::WidjetList();
		$widjets=DB::table('page_widjets')->where("page",$data['page']->id)->orderBy('position', 'ASC')->get();
		$data['widjets']=[];
		$i=1;
		$data['cardsize']=[2=>6,3=>4,4=>3,5=>2,6=>2];
		$oldCard=0;
		$cardOpen=false;
		$cardid=1;
		foreach($widjets as $widjet){
			$info = $this->WidjetInfoDecode($widjet, $widjetList, $types);
			$info['widjetID']=$widjet->id;
				// Card верстка виджетов
				if(!isset($info['card'])){ $info['card']=0; }
				if($cardOpen==false&&$info['card']>0&&$oldCard!=$info['card']){
					$data['html'].='<style>@media(min-width:576px){.card-columns-'.$cardid."-".$info['card'].'{-webkit-column-count:'.$info['card'].'!important;-moz-column-count:'.$info['card'].'!important;column-count:'.$info['card'].'!important;}</style>';
					$data['html'].='<div class="card-columns card-columns-'.$cardid."-".$info['card'].'">';
					$cardOpen=true;
					$oldCard=intval($info['card']);
					$data['widjets'][$widjet->id]['card']=intval($info['card']);
				} elseif($cardOpen==true&&$oldCard!=$info['card']){
					$data['html'].='</div>';
					$cardid++;
					$oldCard=$info['card'];
					$cardOpen=false;
					$data['widjets'][$widjet->id]['card']=$info['card'];
					if($info['card']>0){
						$data['html'].='<style>@media(min-width:576px){.card-columns-'.$cardid."-".$info['card'].'{-webkit-column-count:'.$info['card'].'!important;-moz-column-count:'.$info['card'].'!important;column-count:'.$info['card'].'!important;}</style>';
						$data['html'].='<div class="card-columns card-columns-'.$cardid."-".$info['card'].'">';
						$cardOpen=true;
						$oldCard=intval($info['card']);
						$data['widjets'][$widjet->id]['card']=intval($info['card']);
					}
				}
				// конец
			$data['html'].=trim(View::make($widjetList[$widjet->widjet]["template"],$info)->toHtml());

		}
		DB::table('page')->where('id',$data['page']->id)->update([
			'text' => $data['html'],
		]);
		return redirect(route('admin.pages.widjet',$id)); 
	}
	public function widjetAddHtml($id, $widjet, $position, Request $request){
		$widjetList = PageEntities::WidjetList();
		$types = EntitiesFields::TypesList();
		
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить виджет'),
			'html'=>null,   
			'form'=>['action'=>route('admin.pages.widjetaddpost',[$id,$widjet, $position]),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		if(isset($widjetList[$widjet])){
			$info['list'] = $widjetList[$widjet];
			$info['pageID'] = $id;
			$info['position'] = $position;
			$info['widjet'] = $widjet;
			$info['entitie']=[];
			foreach($info['list']["fields"] as $keyEntitie=>$entitie){
				$info['entitie'][$keyEntitie]=$entitie;
				$info['entitie'][$keyEntitie]['html']=$types[$entitie['type']]['html']($entitie['name'],$keyEntitie,"info[".$keyEntitie."]",$entitie['default'],$entitie['value']);
			}
			$data['html'] = trim(View::make('admin.views.pages.widjetadd',$info)->toHtml());
		} else {
			$data['html'] = "Виджет не существует!";
		}
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function widjetAdd($id, $widjet, $position, Request $request){
		if($request->has('info')) { 
			$widjetList = PageEntities::WidjetList();
			$types = EntitiesFields::TypesList();
			$infos = $request->input('info');
			$info = [];
			foreach($infos as $kInfo=>$vInfo){
				$info[$kInfo]=$types[$widjetList[$widjet]["fields"][$kInfo]['type']]['function_add']($vInfo);
			}
			$lastInsertId = DB::table('page_widjets')->insertGetId([
				'page' => $id,
				'widjet' => $widjet,
				'info' => json_encode($info),
				'position' => $position,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'), 
			]);
		}
		return redirect(route('admin.pages.widjet',$id)."#widjetscreen".$lastInsertId); 
	}
	public function widjetEditHtml($id, $widjet, $widjetid, Request $request){
		$widjetList = PageEntities::WidjetList();
		$types = EntitiesFields::TypesList();
		
		$widjetInfoDB=DB::table('page_widjets')->where("id",$widjetid)->first();
		$widjetInfo=json_decode($widjetInfoDB->info,true);
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать виджет'),
			'html'=>null,   
			'form'=>['action'=>route('admin.pages.widjeteditpost',[$id,$widjet, $widjetid]),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Сохранить'],
		);
		if(isset($widjetList[$widjet])){
			$info['list'] = $widjetList[$widjet];
			$info['pageID'] = $id;
			$info['widjet'] = $widjet;
			$info['entitie']=[];
			foreach($info['list']["fields"] as $keyEntitie=>$entitie){
				$info['entitie'][$keyEntitie]=$entitie;
				$info['entitie'][$keyEntitie]['html']=$types[$entitie['type']]['html']($entitie['name'],$keyEntitie,"info[".$keyEntitie."]",$entitie['default'],$widjetInfo[$keyEntitie]??null);
			}
			$data['html'] = trim(View::make('admin.views.pages.widjetadd',$info)->toHtml());
		} else {
			$data['html'] = "Виджет не существует!";
		}
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function widjetEdit($id, $widjet, $widjetid, Request $request){
		if($request->has('info')) { 
			$widjetList = PageEntities::WidjetList();
			$types = EntitiesFields::TypesList();
			$infos = $request->input('info');
			$info = [];
			foreach($infos as $kInfo=>$vInfo){
				$info[$kInfo]=$types[$widjetList[$widjet]["fields"][$kInfo]['type']]['function_add']($vInfo);
			}
			DB::table('page_widjets')->where('id',$widjetid)->update([
				'info' => json_encode($info),
				'updated_at' => date('Y-m-d H:i:s'), 
			]);
		}
		return redirect(route('admin.pages.widjet',$id)."#widjetscreen".$widjetid); 
	}
	public function widjetDrop($id, $widjet, Request $request){
		$page=DB::table('page_widjets')->where("id",$widjet)->first();
        if($page!=null&&$page!=false){
			DB::table('page_widjets')->where('id', $widjet)->delete();
			$request->session()->put('toasts', array(['body'=>__('Виджет успешно удален'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления виджета'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect(route('admin.pages.widjet',$id)); 
	}
	public function widjetListAjax($id, Request $request){
		$info['list'] = PageEntities::WidjetList();
		$info['pageID'] = $id;
		$info['position'] = $request->input('position');
		$data['html'] = trim(View::make('admin.views.pages.widjetlistajax',$info)->toHtml());
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function getWebWidjetEntitiesHtml($widjet, $entitie, Request $request){	
		$isWeb=false;	
		$data = array(
			'success' => false,
			'status' => 'OK', 
			'title'=>__('Отправка формы'),
			'html'=>__('Ошибка! Виджет не существует!'),
			'form'=>['action'=>route('page.widjet.entitiespost',[$widjet, $entitie, base64_encode(base64_encode(url()->previous()))]),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Отправить'],
		);
		$widjetList = PageEntities::WidjetList();
		$types = EntitiesFields::TypesList();
		$widjet=DB::table('page_widjets')->where("id",$widjet)->first();
		$fieldEntitiesList=false;
		$fieldEntitiesKey=false;
		if(isset($widjet->info)){
			$info = $this->WidjetInfoDecode($widjet, $widjetList, $types);
			if(isset($widjetList[$widjet->widjet]["fields"])){
				foreach($widjetList[$widjet->widjet]["fields"] as $kField=>$field){
					if($field['type']=='entitiesList'){
						$isWeb=true;
						$fieldEntitiesList=$field;
						$fieldEntitiesKey=$kField;
					}
				}
			}
		}
		if($isWeb){
			$data['success']=true;
			$data['title']=$info['title']??null;
			$data['button']['text']=$info[$fieldEntitiesKey]['textbutton'];
			$data['button']['class']=$info[$fieldEntitiesKey]['classbutton'];
			$WidjetCodeList = (new EntitiesController)->getWidjetCodeList($info[$fieldEntitiesKey]['select']);
			$info['list'] = [];
			$lists = explode("\n",$info[$fieldEntitiesKey]['entities']);
			foreach($lists as $keyField=>$field){
				$fieldInfo = explode(":",$field,3);
				if(isset($WidjetCodeList[$fieldInfo[0]])){
					if(mb_strlen(trim($fieldInfo[2]))==0){
						$info['list'][$fieldInfo[0]]=$WidjetCodeList[$fieldInfo[0]];
						$info['list'][$fieldInfo[0]]['name']=$fieldInfo[1];
						$info['list'][$fieldInfo[0]]['html']=str_replace("%name%",$fieldInfo[1],$info['list'][$fieldInfo[0]]['html']);
					}
				}
			}
		}
		$data['html'] = trim(View::make('services.pageentities.webwidjetentities',$info)->toHtml());
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
	public function getWebWidjetEntities($widjet, $entitie, $urlback, Request $request){	
		$isWeb=false;	
		if($request->has('info')) { 	
			$widjetList = PageEntities::WidjetList();
			$types = EntitiesFields::TypesList();
			$widjet=DB::table('page_widjets')->where("id",$widjet)->first();
			$fieldEntitiesList=false;
			$fieldEntitiesKey=false;
			if(isset($widjet->info)){
				$info = $this->WidjetInfoDecode($widjet, $widjetList, $types);
				if(isset($widjetList[$widjet->widjet]["fields"])){
					foreach($widjetList[$widjet->widjet]["fields"] as $kField=>$field){
						if($field['type']=='entitiesList'){
							$isWeb=true;
							$fieldEntitiesList=$field;
							$fieldEntitiesKey=$kField;
						}
					}
				}
			}
			if($isWeb){
				$TableDBSection='section'.$info[$fieldEntitiesKey]['select']; 
				$WidjetCodeList = (new EntitiesController)->getWidjetCodeList($info[$fieldEntitiesKey]['select']);
				$dbInfo = [];
				$infos = $request->input('info');
				$lists = explode("\n",$info[$fieldEntitiesKey]['entities']);
				foreach($lists as $keyField=>$field){
					$fieldInfo = explode(":",$field,3);
					if(isset($WidjetCodeList[$fieldInfo[0]])){
						$infoField = $WidjetCodeList[$fieldInfo[0]];
						$value=false;
						if(trim($fieldInfo[2])=='ip'){
							$value=request()->ip();
						} elseif(trim($fieldInfo[2])=='datetime'){
							$value=date('Y-m-d H:i:s');
						} elseif(trim($fieldInfo[2])=='default'){
							$value=$fieldInfo[1];
						} elseif(isset($infos[$infoField['key']])){
							$value=$types[$infoField['type']]['function_add']($infos[$infoField['key']]); 
						}
						if($value){
							if($infoField['db']!='info'){
								$dbInfo[$infoField['db']]=$value;
							} else {
								$dbInfo['info'][$infoField['id']]=['name'=>$infoField['name'],"text"=>$value]; 
							}
							// для рассылки
							if($info[$fieldEntitiesKey]['emailsend']==1){
								if($infoField['key']==$info[$fieldEntitiesKey]['emailentities']){
									if(filter_var($value, FILTER_VALIDATE_EMAIL)){
										$EMAILSENDADRESS = $value; 
									}
								}
							}
						}
					}
				}
				if(!isset($dbInfo["name"])){ $dbInfo["name"]=""; }
				$dbInfo["info"]=isset($dbInfo["info"])&&is_array($dbInfo["info"])?json_encode($dbInfo["info"]):json_encode([]);
			}
		}
        if($isWeb&&$dbInfo&&is_array($dbInfo)&&count($dbInfo)>0){ 

			if(isset($EMAILSENDADRESS)){
				$name = $info[$fieldEntitiesKey]['titleemail'];
				Mail::send('services.pageentities.widjetemail', ['name' => $name, 'email' => $EMAILSENDADRESS, 'content' => $info[$fieldEntitiesKey]['textemail']], function ($message) use ($EMAILSENDADRESS, $name) {
					$message->to($EMAILSENDADRESS)->subject($name);
				});
			}
			
			DB::table($TableDBSection)->insertGetId($dbInfo);
			
			$request->session()->put('toasts', array(['body'=>__('Форма успешно отправлена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка отправки формы'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect()->to(base64_decode(base64_decode($urlback))); 
	}
	public function WidjetInfoDecode(&$widjet, &$widjetList, &$types){
		$info = json_decode($widjet->info,true);
		if(!is_array($info)){$info=[];}
		foreach($info as $kInfo=>$vInfo){
			if(isset($widjetList[$widjet->widjet]["fields"][$kInfo]['type'])){
				$info[$kInfo]=$types[$widjetList[$widjet->widjet]["fields"][$kInfo]['type']]['function_views']($vInfo);
				if(!is_array($info[$kInfo])){
					$json=json_decode($info[$kInfo],true);
					if(is_array($json)){
						$info[$kInfo]=$json;
					}
				}
			}
		}
		return $info;
	}
}
