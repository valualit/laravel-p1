<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;
use ImageOptimizer;
use PageEntities;

class EntitiesFields {
	
	// Главная управления конфигурации полей
    public function index($entities,$template = 'services.entitiesfields.index',$button=['btn-add'=>'admin.users.userentities.add','btn-catadd'=>'admin.users.userentities.catadd','catedit'=>'admin.users.userentities.catedit','catdelete'=>'admin.users.userentities.catdelete','edit'=>'admin.users.userentities.edit','delete'=>'admin.users.userentities.delete',],$section=false,$breadcrumbs='admin.users.userentities',$breadcrumbsName=null){ 
        $data = array(
			"NavItemActive"=>$entities,
			"name"=>__('Конфигурация полей'), 
			"title"=>__('Конфигурация полей'), 
			"types"=>$this->TypesList(), 
			"CatList"=>$this->GetCatList($entities), 
			"GetEntitiesList"=>$this->GetEntitiesList($entities), 
			"button"=>$button, 
			"breadcrumbs"=>$breadcrumbs, 
			"breadcrumbsSection"=>$section, 
			"breadcrumbsName"=>$breadcrumbsName, 
		);
		$data['List']=$this->GetInputInArray($data,$button,false,$section);
		return view($template,$data);
    }
	// Добавление категории
    public function catAdd($entities, $request, $route){
        if($request->has('name') && mb_strlen($request->input('name'))>0){
			$id = DB::table('userentities_cat')->insertGetId([
				'name' => $request->input('name'),
				'entities' => $entities, 
			]);
			if($id>0){
				$request->session()->put('toasts', array(['body'=>__('Категория успешно добалена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
			} else {
				$request->session()->put('toasts', array(['body'=>__('Ошибка добавления категории'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			}
			return redirect($route);
		}
    }
    public function catAddHTML($template='services.entitiesfields.catadd',$redirect=null){
		$formdata = [];
		$html = trim(View::make($template,$formdata)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить категорию'),
			'html'=>$html,   
			'form'=>['action'=>$redirect,'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
    }
	// Редактирование категории
    public function catEdit($id,$request,$redirect){
        if($id > 0 && $request->has('name') && mb_strlen($request->input('name'))>0){
			DB::table('userentities_cat')->where('id', $id)->update(array('name' =>$request->input('name')));
			if($id>0){
				$request->session()->put('toasts', array(['body'=>__('Категория успешно изменена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
			} else {
				$request->session()->put('toasts', array(['body'=>__('Ошибка изменения категории'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			}
			return redirect($redirect);
		}
    }
    public function catEditHTML($id,$template='services.entitiesfields.catedit',$redirect=null){
        $formdata['entitiesCat']=DB::table('userentities_cat')->where("id",$id)->first();
		$html = trim(View::make($template,$formdata)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать категорию'),
			'html'=>$html,   
			'form'=>['action'=>$redirect,'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Редактировать'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
    }
	// Удаление категории
    public function catDelete($id,$request,$redirect){
		$cat=DB::table('userentities_cat')->where("id",$id)->first();
        if($cat){
			DB::table('userentities_cat')->where('id', $id)->delete();
			$request->session()->put('toasts', array(['body'=>__('Категория успешно удалена'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления категории'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect($redirect); 
    } 
	// Добавление поля
    public function FieldsAdd($entitiesG, $request, $redirect){
        if($request->has('entities')){
			$entities = $request->input('entities'); 
			if(is_array($entities)&&count($entities)>0){
				$entities['entities']=$entitiesG;
				$id = DB::table('userentities')->insertGetId($entities);
				$request->session()->put('toasts', array(['body'=>__('Поле успешно добалено'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
				return redirect($redirect);
			}				
			$request->session()->put('toasts', array(['body'=>__('Ошибка добавления нового поля'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			return redirect($redirect);
		}
    }
    public function FieldsAddHTML($entities, $template='services.entitiesfields.catadd',$redirect=null){
		
		$formdata = array( 
			"CatList"=>$this->GetCatList($entities), 
			"TypesList"=>$this->TypesList(), 
		);
		$html = trim(View::make($template,$formdata)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить поле'),
			'html'=>$html,   
			'form'=>['action'=>$redirect,'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
    }
	// Редактирование поля
    public function FieldsEdit($id,$request, $redirect){
		$Field=DB::table('userentities')->where("id",$id)->first();
		if($Field==null||$Field==false){
			$request->session()->put('toasts', array(['body'=>__('Редактируемое поле не существует!'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			return redirect($redirect);
		}
        if($request->has('entities')){
			$entities = $request->input('entities'); 
			if(is_array($entities)&&count($entities)>0){
				$id = DB::table('userentities')->where("id",$id)->update($entities);
				$request->session()->put('toasts', array(['body'=>__('Поле успешно изменено'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
				return redirect($redirect);
			}				
			$request->session()->put('toasts', array(['body'=>__('Ошибка изменения поля'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
			return redirect($redirect);
		}
    }
    public function FieldsEditHTML($id, $entities, $template='services.entitiesfields.catadd',$redirect=null, $request){
		$Field=DB::table('userentities')->where("id",$id)->first();
        if($Field==null||$Field==false){
			$html= __('Ошибка');
		} else {
			$formdata = array( 
				"CatList"=>$this->GetCatList($entities), 
				"TypesList"=>$this->TypesList(), 
				"Field"=>$Field, 
			);
			$html = trim(View::make($template,$formdata)->toHtml());
		}
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Редактировать поле'),
			'html'=>$html,   
			'form'=>['action'=>$redirect,'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>__('Сохранить')],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
    }
	// Удаление поля
    public function FieldsDelete($id,$request, $redirect){
		$Field=DB::table('userentities')->where("id",$id)->first();
        if($Field!=null&&$Field!=false){
			DB::table('userentities')->where('id', $id)->delete();
			$request->session()->put('toasts', array(['body'=>__('Поле успешно удалено'),'class'=>'bg-success','title'=>__('Успешно'),'subtitle'=>null]));
		} else {
			$request->session()->put('toasts', array(['body'=>__('Ошибка удаления поля'),'class'=>'bg-danger','title'=>__('Ошибка'),'subtitle'=>null]));
		}
		return redirect($redirect); 
    }
    public function FieldsDeleteHTML($id,$request, $redirect){
        
    }
	
    public function GetInputInArray(&$data,$button=false,$value=false,$entities=false){
		$arr=array();
		if(isset($data['GetEntitiesList'][0])){ foreach ($data['GetEntitiesList'][0] as $EntitieKay=>$Entitie){
			$arr[]=array(
				"id"=>$Entitie->id,
				"cat"=>false,
				"parent"=>0,
				"name"=>"Основная",
				"type"=>$Entitie->type, 
				"html"=>$button==false?$data['types'][$Entitie->type]['html']($Entitie->name,"enitities".$Entitie->id,"info[".$Entitie->id."]",$Entitie->default,$value[$Entitie->id]['text']??false):null,  
				"edit"=>$button?($entities?route($button['edit'],[$entities,$Entitie->id]):route($button['edit'],$Entitie->id)):null,
				"delete"=>$button?($entities?route($button['delete'],[$entities,$Entitie->id]):route($button['delete'],$Entitie->id)):null,
				"entitie_name"=>$Entitie->name,
				"entitie_type"=>$data['types'][$Entitie->type]['name'],
				"entitie_required"=>$Entitie->required,
				"entitie_main"=>$Entitie->main,
			);
		}}
		foreach ($data['CatList'] as $indexKay=>$cat){
			$arr[]=array(
				"id"=>$cat->id,
				"cat"=>true,
				"parent"=>false,
				"name"=>$cat->name,
				"type"=>false, 
				"html"=>null, 
				"edit"=>$button?($entities?route($button['catedit'],[$entities,$cat->id]):route($button['catedit'],$cat->id)):null,
				"delete"=>$button?($entities?route($button['catdelete'],[$entities,$cat->id]):route($button['catdelete'],$cat->id)):null,
				"entitie_name"=>null,
				"entitie_type"=>null,
				"entitie_required"=>null,
				"entitie_main"=>null,
			);
			if(isset($data['GetEntitiesList'][$cat->id])){ foreach ($data['GetEntitiesList'][$cat->id] as $EntitieKay=>$Entitie){
				$arr[]=array(
					"id"=>$Entitie->id,
					"cat"=>false,
					"parent"=>$cat->id,
					"name"=>$cat->name, 
					"type"=>$Entitie->type, 
					"html"=>$button==false?$data['types'][$Entitie->type]['html']($Entitie->name,"enitities".$Entitie->id,"info[".$Entitie->id."]",$Entitie->default,$value[$Entitie->id]['text']??false):null,   
					"edit"=>$button?($entities?route($button['edit'],[$entities,$Entitie->id]):route($button['edit'],$Entitie->id)):null,
					"delete"=>$button?($entities?route($button['delete'],[$entities,$Entitie->id]):route($button['delete'],$Entitie->id)):null,
					"entitie_name"=>$Entitie->name,
					"entitie_type"=>$data['types'][$Entitie->type]['name'],
					"entitie_required"=>$Entitie->required,
					"entitie_main"=>$Entitie->main,
				);
			}}
		}
		return $arr;
	}
	// Список категорий сущности
    public function GetCatList($entities){
        return DB::table('userentities_cat')->where('entities', $entities)->get();
    }
	// Список полей сущности
    public function GetEntitiesList($entities){
		$return = array();
        $list = DB::table('userentities')->where('entities', $entities)->get();
		foreach($list as $entitie){
			$return[$entitie->cat][$entitie->id]=$entitie;
		}
		return $return;
    }
	// Типы полей
    public function TypesList(){
        $types = array(
			"input"=>array(
				"name"=>"Поле ввода",
				"function_add"=>function ($text){
							return $text;
						},
				"function_views"=>function ($text){
							return $text;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							return '<input type="text" class="form-control" id="'.($attr_id).'" name="'.($attr_name).'" placeholder="'.htmlspecialchars($name).'"'.($value?' value="'.htmlspecialchars($value).'"':null).($required?' required':null).' />'; 
						},  
				),
			"input-email"=>array(
				"name"=>"Поле ввода (E-Mail)",
				"function_add"=>function ($text){
							return $text;
						},
				"function_views"=>function ($text){
							return $text;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							return '<input type="email" class="form-control" id="'.($attr_id).'" name="'.($attr_name).'" placeholder="'.htmlspecialchars($name).'"'.($value?' value="'.htmlspecialchars($value).'"':null).($required?' required':null).' />'; 
						},  
				),
			"input-date"=>array(
				"name"=>"Поле ввода (дата)",
				"function_add"=>function ($text){
							return $text;
						},
				"function_views"=>function ($text){
							return $text;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							$html = '<div class="input-group date" id="datetimepicker'.($attr_id).'" data-target-input="nearest"><input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker'.($attr_id).'" id="'.($attr_id).'" name="'.($attr_name).'" placeholder="'.htmlspecialchars($name).'"'.($value?' value="'.htmlspecialchars($value).'"':null).($required?' required':null).' /><div class="input-group-append" data-target="#datetimepicker'.($attr_id).'" data-toggle="datetimepicker"><div class="input-group-text"><i class="fa fa-calendar"></i></div></div></div>';
							$html.='<script>$(function(){$("#datetimepicker'.($attr_id).'").datetimepicker({locale:\'ru\',format:\'YYYY-MM-DD HH:mm:ss\'});});</script>';
							return $html;					
						},  
				),
			"select"=>array(
				"name"=>"Раскрывающийся список",
				"function_add"=>function ($text){
							return $text;
						},
				"function_views"=>function ($text){
							return $text;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							$retun = '<select class="form-control" id="'.($attr_id).'" name="'.($attr_name).'" placeholder="'.htmlspecialchars($name).'"'.($required?' required':null).'>';
							$list = explode("\n",$default);
							foreach($list as $param){
								$retun.='<option value="'.$param.'"'.($value==$param?' selected':null).'>'.$param.'</option>';
							}
							$retun.='</select>';
							return $retun;
						},  
				),
			"textarea"=>array(
				"name"=>"Текстовое поле",
				"function_add"=>function ($text){
							return $text;
						},
				"function_views"=>function ($text){
							return $text;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							return '<textarea class="form-control" id="'.($attr_id).'" name="'.($attr_name).'" placeholder="'.htmlspecialchars($name).'"'.($required?' required':null).'>'.($value?htmlspecialchars($value):null).'</textarea>';
						},  
				),
			"textarea wysiwyg"=>array(
				"name"=>"Текстовое поле с визуальным редактором",
				"function_add"=>function ($text){
							$text=$this->SaveImageBase64($text);
							return $text;
						},
				"function_views"=>function ($text){
							return $text;
						}, 
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							$attr_id=md5($attr_id.microtime());
							return "<a onClick='$(\"body\").addClass(\"modal-open\");'><small>(scroll-fix)</small></a>".'<textarea class="form-control" id="'.($attr_id).'" name="'.($attr_name).'" placeholder="'.htmlspecialchars($name).'"'.($required?' required':null).'>'.($value?htmlspecialchars($value):null).'</textarea>'."
							<script>$( document ).ready(function() {
								$('#".$attr_id."').summernote({
									dialogsInBody: true, 
									dialogsFade: false,
									tabsize: 2, 
									lang: 'ru-RU',
									prettifyHtml: true,
									toolbar: [
										['style', ['style']],
										['fontsize', ['fontsize']],
										['font', ['bold', 'italic', 'underline', 'clear']],
										['fontname', ['fontname']],
										['color', ['color']],
										['para', ['ul', 'ol', 'paragraph']],
										['height', ['height']],
										['table', ['table']],
										['insert', ['link', 'picture', 'hr']],
										['view', ['fullscreen', 'codeview']],
										['help', ['help']]
									  ]
								}); 
							}); </script>";
						},  
				),
			"image"=>array(
				"name"=>"Изображение",
				"function_add"=>function ($text){	
							if(isset($_FILES[$text]['tmp_name'])&&$_FILES[$text]["size"]>0){
								if($_FILES[$text]["type"]=="image/gif"){
									$nameFile = md5(md5(md5($_FILES[$text]['tmp_name'].time()))).".gif";
									$paths=$this->CreateNewPathFile();
									$path=$paths['path']; $link=$paths['link'];
									File::copy($_FILES[$text]['tmp_name'],$path."/".$nameFile);
									return Storage::disk('disk')->url("public/".$link."/".$nameFile);
								}
								if(in_array($_FILES[$text]["type"],["image/jpeg","image/png"])){
									$img = Image::make($_FILES[$text]['tmp_name']); 
									if($img){
										$extension = pathinfo($_FILES[$text]['name'], PATHINFO_EXTENSION);
										$nameFile = md5(md5(md5($_FILES[$text]['tmp_name'].time()))).".".$extension;
										$paths=$this->CreateNewPathFile();
										$path=$paths['path']; $link=$paths['link'];
										$maxHeight=option('img-max-height',1080);
										if($maxHeight<$img->height()){
											$img = $img->resize(null, $maxHeight, function ($constraint) { $constraint->aspectRatio(); });
										}
										$maxWidth=option('img-max-width',1080);
										if($maxWidth<$img->width()){
											$img = $img->resize($maxWidth, null, function ($constraint) { $constraint->aspectRatio(); });
										}
										$img->save($path."/".$nameFile);		
										ImageOptimizer::optimize($path."/".$nameFile);
										return Storage::disk('disk')->url("public/".$link."/".$nameFile);
									}
								}
							} else {
								if(request()->has('default_'.$text)) {
									return request()->input('default_'.$text);
								}
							}
							return null;
						},
				"function_views"=>function ($text){
							return $text; 
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							$return = '<input type="hidden" name="'.($attr_name).'" value="file_'.($attr_id).'" /><div class="custom-file"><input type="file" class="custom-file-input" id="'.($attr_id).'" name="file_'.($attr_id).'" /><label class="custom-file-label" for="'.($attr_id).'">'.htmlspecialchars($name).'</label></div>';
							if($value!=null&&$value!=false){
								$return .= '</div><div class="col-md-3"><a href="javascript://" onClick="$(this).parent().remove()"><small class="text-danger">Удалить</small></a><br /><img src="'.$value.'" alt="" style="max-width:100px;max-height:100px" /><input type="hidden" name="default_file_'.($attr_id).'" value="'.htmlspecialchars($value).'" /></div>';
							}
							return $return;
						},  
				),
			"image_multiple"=>array(
				"name"=>"Изображение (галерея)",
				"function_add"=>function ($text){	
							$imagesList=[];
							$total = count($_FILES[$text]['tmp_name']);
							if(request()->has('default_'.$text)) {
								$old=request()->input('default_'.$text);
								foreach($old as $image){
									$imagesList[]=$image;
								}
							}
							for( $i=0 ; $i < $total ; $i++ ) {
								if(isset($_FILES[$text]['tmp_name'][$i])&&$_FILES[$text]["size"][$i]>0){
									if($_FILES[$text]["type"][$i]=="image/gif"){
										$nameFile = md5(md5(md5($_FILES[$text]['tmp_name'][$i].time()))).".gif";
										$paths=$this->CreateNewPathFile();
										$path=$paths['path']; $link=$paths['link'];
										File::copy($_FILES[$text]['tmp_name'][$i],$path."/".$nameFile);
										$imagesList[]=Storage::disk('disk')->url("public/".$link."/".$nameFile);
									}
									if(in_array($_FILES[$text]["type"][$i],["image/jpeg","image/png"])){
										$img = Image::make($_FILES[$text]['tmp_name'][$i]); 
										if($img){
											$extension = pathinfo($_FILES[$text]['name'][$i], PATHINFO_EXTENSION);
											$nameFile = md5(md5(md5($_FILES[$text]['tmp_name'][$i].time()))).".".$extension;
											$paths=$this->CreateNewPathFile();
											$path=$paths['path']; $link=$paths['link'];
											$maxHeight=option('img-max-height',1080);
											if($maxHeight<$img->height()){
												$img = $img->resize(null, $maxHeight, function ($constraint) { $constraint->aspectRatio(); });
											}
											$maxWidth=option('img-max-width',1080);
											if($maxWidth<$img->width()){
												$img = $img->resize($maxWidth, null, function ($constraint) { $constraint->aspectRatio(); });
											}
											$img->save($path."/".$nameFile);		
											ImageOptimizer::optimize($path."/".$nameFile);
											$imagesList[]=Storage::disk('disk')->url("public/".$link."/".$nameFile);
										}
									}
								}
							}
							return json_encode($imagesList);
						},
				"function_views"=>function ($text){
							return json_decode($text,true);
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null,$required=false){ 
							$return = '<input type="hidden" name="'.($attr_name).'" value="file_'.($attr_id).'" /><div class="custom-file"><input type="file" multiple="multiple" class="custom-file-input" id="'.($attr_id).'" name="file_'.($attr_id).'[]" /><label class="custom-file-label" for="'.($attr_id).'">'.htmlspecialchars($name).'</label></div>';
							$vals=json_decode($value,true);
							if(is_array($vals)){
								$return .= '</div><div class="row">';
								foreach($vals as $val){
									$return .= '<div class="col-md-2"><a href="javascript://" onClick="$(this).parent().remove()"><small class="text-danger">Удалить</small></a><br /><img src="'.$val.'" alt="" style="max-width:100px;max-height:100px" /><input type="hidden" name="default_file_'.($attr_id).'[]" value="'.htmlspecialchars($val).'" /></div>';
								}
								$return .= '</div>';
							}
							return $return;
						},  
				), 
			"files"=>array(
				"name"=>"Файлы",
				"function_add"=>function ($text){	
							$filesList=[];
							$total = count($_FILES[$text]['tmp_name']);
							if(request()->has('default_'.$text)) {
								$old=request()->input('default_'.$text);
								foreach($old as $nameFile=>$file){
									$filesList[$nameFile]=$file;
								}
							}
							for( $i=0 ; $i < $total ; $i++ ) {
								if(isset($_FILES[$text]['tmp_name'][$i])&&$_FILES[$text]["size"][$i]>0){
									$extension = pathinfo($_FILES[$text]['name'][$i], PATHINFO_EXTENSION);
									$nameFile = md5(md5(md5($_FILES[$text]['tmp_name'][$i].time()))).".".$extension;
									$paths=$this->CreateNewPathFile();
									$path=$paths['path']; $link=$paths['link'];
									File::copy($_FILES[$text]['tmp_name'][$i],$path."/".$nameFile);
									$filesList[$_FILES[$text]['name'][$i]]=Storage::disk('disk')->url("public/".$link."/".$nameFile);
								}
							}
							return json_encode($filesList);
						},
				"function_views"=>function ($text){
							$html=null;
							$files = json_decode($text,true);
							if(is_array($files)){
								$html.='<ul>';
								foreach($files as $nameFile=>$file){
									$html.='<li><a href="'.$file.'" target="_blank">'.$nameFile.'</a></li>';
								}
								$html.='</ul>';
							}
							return $html;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null){ 
							$return = '<input type="hidden" name="'.($attr_name).'" value="file_'.($attr_id).'" /><div class="custom-file"><input type="file" multiple="multiple" class="custom-file-input" id="'.($attr_id).'" name="file_'.($attr_id).'[]" /><label class="custom-file-label" for="'.($attr_id).'">'.htmlspecialchars($name).'</label></div>';
							$vals=json_decode($value,true);
							if(is_array($vals)){
								$return .= '</div><div class="row">';
								foreach($vals as $nameFile=>$val){
									$return .= '<div class="col-md-2"><a href="javascript://" onClick="$(this).parent().remove()"><small class="text-danger">Удалить</small></a><br /><a href="'.$val.'" target="_blank">'.$nameFile.'</a><input type="hidden" name="default_file_'.($attr_id).'['.$nameFile.']" value="'.htmlspecialchars($val).'" /></div>';
								}
								$return .= '</div>';
							}
							return $return;
						},  
				), 
			"entitiesList"=>array(
				"name"=>"Сущность",
				"function_add"=>function ($text){
							$data['select']=request()->has('Select'.$text)?request()->input('Select'.$text):null;
							$data['entities']=request()->has('Entities'.$text)?request()->input('Entities'.$text):null;
							$data['textbutton']=request()->has('TextButton'.$text)?request()->input('TextButton'.$text):null;
							$data['classbutton']=request()->has('ClassButton'.$text)?request()->input('ClassButton'.$text):null;
							$data['emailsend']=request()->has('EmailSend'.$text)?request()->input('EmailSend'.$text):null;
							$data['emaillink']=request()->has('EmailLink'.$text)?request()->input('EmailLink'.$text):null;
							$data['emailentities']=request()->has('EmailEntities'.$text)?request()->input('EmailEntities'.$text):null;
							$data['titleemail']=request()->has('EmailTitle'.$text)?request()->input('EmailTitle'.$text):null;
							$data['textemail']=request()->has('TextEmail'.$text)?request()->input('TextEmail'.$text):null;
							return json_encode($data);
						},
				"function_views"=>function ($text){
							$json=json_decode($text,true);
							if(is_array($json)){
								return $json;
							}
							return $text;
						},
				"htmladd"=>null,
				"html"=>function ($name,$attr_id,$attr_name,$default=null,$value=null){ 
							$vals=json_decode($value,true);
							$retun = '<input type="hidden" name="'.($attr_name).'" value="'.($attr_id).'" />';
							$retun .= '<select class="form-control" id="Select'.($attr_id).'" name="Select'.($attr_id).'" placeholder="'.htmlspecialchars($name).'">';
							$list = explode("\n",$default);
							$entities=DB::table('section')->get(); 
							foreach($entities as $entitie){
								$selected=($vals['select']??0);
								$retun.='<option value="'.$entitie->id.'"'.(intval($selected)===intval($entitie->id)?' selected':null).'>'.$entitie->name.'</option>';
							}
							$retun.='</select>';
							$retun.='<textarea class="form-control" id="Entities'.($attr_id).'" name="Entities'.($attr_id).'" rows="5" placeholder="'.__('Название используемых полей ввести в столбик').'">'.($vals['entities']??0).'</textarea>';
							$retun.='</div></div>';
							$retun.='<div class="row"><div class="col-sm-4">';
							$retun.='<div class="form-group"><input type="text" class="form-control form-control-sm" id="TextButton'.($attr_id).'" name="TextButton'.$attr_id.'" placeholder="'.__('Текст кнопки').'" value="'.($vals['textbutton']??null).'"></div>'; 
							$retun .= '<div class="form-group"><select class="form-control" id="ClassButton'.($attr_id).'" name="ClassButton'.($attr_id).'" placeholder="'.htmlspecialchars($name).'">';
							$buttons=array(
								"btn-primary"=>"primary",
								"btn-secondary"=>"secondary",
								"btn-success"=>"success",
								"btn-danger"=>"danger",
								"btn-warning"=>"warning",
								"btn-info"=>"info",
								"btn-light"=>"light",
								"btn-dark"=>"dark",
								"btn-link"=>"link",
							);
							foreach($buttons as $key=>$button){
								$selected=($vals['classbutton']??0);
								$retun.='<option value="'.$key.'"'.($selected===$key?' selected':null).'>'.$button.'</option>';
							}
							$retun.='</select></div>';
							$retun.='</div><div class="col-sm-4">';
							$retun.='<div class="form-group mt-1"><div class="custom-control form-control-sm custom-switch"><input type="checkbox"'.(isset($vals['emailsend'])&&$vals['emailsend']==1?' checked':null).' class="custom-control-input" id="EmailSend'.($attr_id).'" name="EmailSend'.$attr_id.'" value="1" /><label class="custom-control-label" for="EmailSend'.($attr_id).'">'.__('Email уведомление').'</label></div></div>';
							//$retun.='</div><div class="col-sm-3">';
							//$retun.='<div class="form-group mt-1"><div class="custom-control form-control-sm custom-switch"><input type="checkbox"'.(isset($vals['emaillink'])&&$vals['emaillink']==1?' checked':null).' class="custom-control-input" id="EmailLink'.($attr_id).'" name="EmailLink'.$attr_id.'" value="1" /><label class="custom-control-label" for="EmailLink'.($attr_id).'">'.__('Обязательное подтверждение').'</label></div></div>';
							$retun.='</div><div class="col-sm-4">';
							$retun.='<div class="form-group"><input type="text" class="form-control form-control-sm" id="EmailEntities'.($attr_id).'" name="EmailEntities'.$attr_id.'" placeholder="'.__('E-Mail Поле').'" value="'.($vals['emailentities']??0).'"></div>'; 
							$retun.='</div></div>';
							$retun.='<div class="form-group"><label>'.__('Тема письма').'</label><input type="text" class="form-control form-control-sm" id="EmailTitle'.($attr_id).'" name="EmailTitle'.$attr_id.'" placeholder="'.__('Тема письма уведомления').'" value="'.($vals['titleemail']??null).'"></div>';
							$retun.='<div class="form-group"><label>'.__('HTML шаблон письма').'</label><textarea class="form-control" rows="3" id="TextEmail'.($attr_id).'" name="TextEmail'.$attr_id.'" placeholder="HTML code письма уведомления">'.htmlspecialchars($vals['textemail']??null).'</textarea></div>';
							return $retun;
						},  
				), 
		);
		return $types;
    }
	public function SaveImageBase64(&$text){
		//preg_match_all("~src=\"data\:image\/([a-z]*)\;base64\,([^\"]*)\"~isuU",$text,$base64);
		//if(isset($base64)&&isset($base64[1])&&isset($base64[1][0])){ foreach($base64[1] as $k=>$v){
		if(mb_strlen(trim($text))>0){
			$dom = new \DOMDocument;
			$isDOM = $dom->loadHTML($text);
			if($isDOM){
				$xpath = new \DOMXPath($dom);
				$src = $xpath->evaluate("//img/@src");
				for($i=0;$i<$src->length;$i++){
					$string=$src->item($i)->nodeValue;
					if(mb_substr($string,0,mb_strlen("data:image/"))=="data:image/"){
						preg_match_all("~data\:image\/([a-z]*)\;base64\,~isuU",$string,$match);
						//$nameFile = md5(md5(md5($base64[2][$k]))).".".$v;
						if(!isset($match[1][0])){ var_dump($string, $match); exit(); }
						$nameFile = md5(md5(md5($string))).".".$match[1][0];
						$paths=$this->CreateNewPathFile();
						$path=$paths['path']; $link=$paths['link'];
						//$content = base64_decode($base64[2][$k]);
						$content = base64_decode(str_replace($match[0][0],"",$string));
						file_put_contents($path."/".$nameFile,$content);
						if(mime_content_type($path."/".$nameFile)=="image/gif"){
							// GIF не обрабатываем
						} else {
							ImageOptimizer::optimize($path."/".$nameFile);
							$img = Image::make($path."/".$nameFile); 
							$maxHeight=option('img-max-height',1080);
							if($maxHeight<$img->height()){
								$img = $img->resize(null, $maxHeight, function ($constraint) { $constraint->aspectRatio(); });
							}
							$maxWidth=option('img-max-width',1080);
							if($maxWidth<$img->width()){
								$img = $img->resize($maxWidth, null, function ($constraint) { $constraint->aspectRatio(); });
							}
							$img->save($path."/".$nameFile);		
							ImageOptimizer::optimize($path."/".$nameFile);
						}
						$text=str_replace($string,Storage::disk('disk')->url("public/".$link."/".$nameFile),$text);
					}			
				}
			}
		}
		//}}
		return $text;
	}
	public function CreateNewPathFile(){
		$link='uploads/'.date("Y");
		$path=public_path($link);
		if(!is_dir($path)){mkdir($path);}
		$link.="/".date("m");
		$path=public_path($link);
		if(!is_dir($path)){mkdir($path);}
		$link.="/".date("d");
		$path=public_path($link);
		if(!is_dir($path)){mkdir($path);}
		$link.="/".date("H");
		$path=public_path($link);
		if(!is_dir($path)){mkdir($path);}
		return ['path'=>$path,'link'=>$link];
	}
}
