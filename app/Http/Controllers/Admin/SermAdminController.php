<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckAdminPanel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;
use App\User;
use View;
use Seranking;


use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class SermAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware(CheckAdminPanel::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {			
		$data = array(
			"NavItemActive"=>"serm",
			"name"=>__('SERM'), 
			"title"=>__('SERM'), 
			"projects"=>\App\SermProject::all(), 
		);
		return view('admin.views.serm.index',$data); 
    }
	
	public function sermConnect()
	{
		return new \App\Services\Seranking("295bc582cd3db40be36b0e788a6bc87c3a9a1cd7");
	}
	
	public function sermUpdatePC(Request $request)
	{
		$serm = $this->sermConnect();
		$return=$serm->send("/system/search-engines","GET"); 
		$insert=[];
		if(is_array($return)&&count($return)>0){
			foreach($return as $pc){
				$insert[]=array(
					"serach_id"=>$pc->id,
					"serach_name"=>$pc->name,
					"region_id"=>$pc->region_id,
					"type"=>$pc->type,
				);
			}
		}
		$countSearchEngines = count($insert);
		if($countSearchEngines>0){
			\App\SermSearch::truncate();
			\App\SermSearch::insert($insert);
			echo "Перезагружено <b>". $countSearchEngines ."</b> search engines из seranking.com <br />\n";
		}
		$return=$serm->send("/system/yandex-regions","GET"); 
		$insert=[];
		foreach($return as $id=>$region){
			$insert[]=array(
				"region_id"=>$id,
				"name"=>$region,
			);
		}
		$countYandexRegion = count($insert); 
		if($countYandexRegion>0){
			\App\SermYandexRegion::truncate();
			\App\SermYandexRegion::insert($insert);
			echo "Перезагружено <b>". $countYandexRegion ."</b> yandex region из seranking.com <br />\n";
		}
		exit();
	}
	
	public function sermUpdateProject(Request $request)
	{
		$count = $this->sermUpdateProjectCode(Auth::user()->id);
		echo "Перезагружено <b>". $count ."</b> проектов <br />\n";
		exit();
	}
	
	public function sermUpdateProjectCode($user_id)
	{
		$serm = $this->sermConnect();
		$return=$serm->send("/sites","GET");
		$ids=[];
		if(is_array($return)&&count($return)>0){
			foreach($return as $project){
				$ids[]=$project->id;
			}
		}
		$projects = \App\SermProject::whereIn('serm_id',$ids)->get();
		$ids=[];
		foreach($projects as $project){
			$ids[$project->serm_id]=$project;
		}
		$insert=[];
		if(is_array($return)&&count($return)>0){
			foreach($return as $project){
				if(!isset($ids[$project->id])){
					$insert[]=array(
						"serm_id"=>$project->id,
						"name"=>$project->title,
						"url"=>$project->name,
						"user"=>$user_id,
					);
				}
			}
		}
		\App\SermProject::insert($insert);
		return count($insert);
	}
	
	public function sermUpdate(Request $request)
	{
		$data = array(
			"NavItemActive"=>"serm",
			"name"=>__('SERM'), 
			"title"=>__('SERM'), 
		);
		return view('admin.views.serm.sermupdate',$data); 
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function projectAdd(Request $request)
    {		
		$formdata = array();
		$formdata['self']=Auth::user()->id;
		$formdata['users']=User::all();
		$html = trim(View::make('admin.views.serm.add',$formdata)->toHtml());
		$data = array(
			'success' => true,
			'status' => 'OK', 
			'title'=>__('Добавить проект'),
			'html'=>$html,   
			'form'=>['action'=>route('admin.serm.add.post'),'method'=>'POST'],
			'button'=>['class'=>'btn-primary','text'=>'Добавить'],
		);
		header("HTTP/1.1 200 OK"); 
		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data); exit();
    }
	
	public function projectAddPost(Request $request)
	{
		$serm = $this->sermConnect();
		$project = $request->input('project');
		$data = array(
			'title'=>$project['name'],
			'url'=>$project['url'],
			'is_active'=>1,
			'exact_url'=>0,
			'subdomain_match'=>0,
			'depth'=>100,
			'check_freq'=>'check_daily',
			'auto_reports'=>1,
		);
		$return=$serm->send("/sites","POST",$data); 
		$this->sermUpdateProjectCode($project['user']);
		return redirect(route('admin.serm')); 
	}
	
    public function projectEdit(Request $request)
    {
        //
    }
	
    public function projectEditPost(Request $request)
    {
        //
    }
	
	public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    } 

    /**
     * Store a newly created resource in storage./
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
