<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use ImageOptimizer;
use PageEntities; 
use Illuminate\Support\Facades\DB;
use Mail;

class SettingsController extends Controller
{
    //
	public function index(){
		$data = array(
			"NavItemActive"=>"settings",
			"name"=>__('Настройки'), 
			"title"=>__('Настройки'), 
		);
		$data['pages']=[];
		$pages=PageEntities::ListPage();
		foreach($pages as $page){
			//$url =route('page.web',$page->url);
			$url = json_encode(['uses'=>'Admin\PagesController@getWebPage','url'=>['url'=>$page->url]]); 
			$data['pages'][$url]=['name'=>$page->name,'selected'=>$url===option('home-url',0)];
		}
		$data['entities']=[];
		$entities=DB::table('section')->get(); 
		foreach($entities as $entitie){ 
			//$url = route('section.id',$entitie->url);
			$url = json_encode(['uses'=>'Admin\EntitiesController@getWebIndex','url'=>['url'=>$entitie->url]]);  
			$data['entities'][$url]=['name'=>$entitie->name,'selected'=>$url===option('home-url',0)];
		}
		return view('admin.views.settings',$data); 
	}
	
	public function upload(Request $request){
		$settings=[];
		$sets = $request->input('settings');
		foreach($sets as $keySetting=>$Setting){
			$settings[$keySetting]=$Setting;
		}
		option($settings); 
        return redirect(route('admin.settings')); 
	}
	public function smtpTest(Request $request){
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__("Test SMTP"),
			'html'=>__('Ошибка!'),
			'form'=>['action'=>route('admin.settings'),'method'=>'GET'],
			'button'=>['class'=>'btn-primary','text'=>'Закрыть'],
		);
		
		$EMAILSENDADRESS = option('smtp-test-email','yanzlatov@gmail.com');
		Mail::send('services.pageentities.emailtest', ['name' => "Test SMTP", 'email' => $EMAILSENDADRESS, 'content' => null], function ($message) use ($EMAILSENDADRESS) {
			$message->to($EMAILSENDADRESS)->subject("Test SMTP");
		});
		$failures=Mail::failures();
		if(count($failures)==0){
			$data['html']="Test успешно отправлен!";		
		} else {
			$data['html']=json_encode(Mail::failures());
		}
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
	}
}
