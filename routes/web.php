<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


if(Schema::hasTable('options')) {
	if(option('isViewDefaultAuth', 1)==1){
		Auth::routes();
		Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
	}
}

Route::group([
    'prefix' => config('app.admin_url','admin'),
    'namespace' => 'Admin',
    'as' => 'admin.',
	'middleware' => ['checkadminpanel']
	],
	function(){
		Route::get('/',['as' => 'dashboard','uses' => 'DashboardController@index']); 
		Route::get('/pages',['as' => 'pages','uses' => 'PagesController@index']);
		Route::get('/views/templates',['as' => 'templates','uses' => 'TemplatesController@index']);
		Route::get('/views/widjets',['as' => 'widjets','uses' => 'WidjetsController@index']);
		Route::get('/views/menu',['as' => 'menu','uses' => 'MenuController@index']); 
		Route::get('/users',['as' => 'users','uses' => 'UsersController@index']);
		Route::get('/users/add',['as' => 'users.add','uses' => 'UsersController@addHTML']);
		Route::post('/users/add',['as' => 'users.addpost','uses' => 'UsersController@add']);
		Route::post('/users/isuseremail',['as' => 'users.isuseremail','uses' => 'UsersController@isUserEmail']);
		Route::get('/users/drop/{id}',['as' => 'users.drop','uses' => 'UsersController@drop']);
		Route::get('/users/edit/{id}',['as' => 'users.edit','uses' => 'UsersController@editHTML']);
		Route::post('/users/edit/{id}',['as' => 'users.editpost','uses' => 'UsersController@edit']);
		
		// Упрвление ролями
		Route::get('/users/roles',['as' => 'roles','uses' => 'RolesController@index']); 
		Route::get('/users/roles/formaddrole',['as' => 'roles.formaddrole','uses' => 'RolesController@FormAddRole']);   
		Route::get('/users/roles/formeditrole/{id}',['as' => 'roles.formeditrole','uses' => 'RolesController@FormEditRole']);   
		Route::get('/users/roles/droprole/{id}',['as' => 'roles.droprole','uses' => 'RolesController@DropRole']);   
		Route::get('/users/roles/setdefault/{id}',['as' => 'roles.setdefault','uses' => 'RolesController@SetDefault']);   
		Route::post('/users/roles/formaddrole',['as' => 'roles.formaddrole.post','uses' => 'RolesController@PostAddRole']);   
		Route::post('/users/roles/formeditrole/{id}',['as' => 'roles.formeditrole.post','uses' => 'RolesController@PostEditRole']);   
		Route::get('/users/roles/formeditpermissionrole/{id}',['as' => 'roles.formeditpermissionrole','uses' => 'RolesController@EditPermissionRole']);   
		Route::post('/users/roles/formeditpermissionrole/{id}',['as' => 'roles.formeditpermissionrole.post','uses' => 'RolesController@PostEditPermissionRole']);  
		// Управление дополнительными полями ПОЛЬЗОВАТЕЛЕЙ
		Route::get('/users/userentities',['as' => 'users.userentities','uses' => 'UsersController@UserEntitiesIndex']);  
		Route::get('/users/userentities/catadd',['as' => 'users.userentities.catadd','uses' => 'UsersController@UserEntitiesCatAdd']);   
		Route::post('/users/userentities/catadd',['as' => 'users.userentities.cataddpost','uses' => 'UsersController@UserEntitiesCatAddPOST']);     
		Route::get('/users/userentities/catedit/{id}',['as' => 'users.userentities.catedit','uses' => 'UsersController@catEditHTML']); 
		Route::post('/users/userentities/catedit/{id}',['as' => 'users.userentities.cateditpost','uses' => 'UsersController@catEdit']);
		Route::get('/users/userentities/catdelete/{id}',['as' => 'users.userentities.catdelete','uses' => 'UsersController@catDelete']);  
		Route::get('/users/userentities/add',['as' => 'users.userentities.add','uses' => 'UsersController@FieldsAddHTML']);  
		Route::post('/users/userentities/add',['as' => 'users.userentities.addpost','uses' => 'UsersController@FieldsAdd']);  
		Route::get('/users/userentities/edit/{id}',['as' => 'users.userentities.edit','uses' => 'UsersController@FieldsEditHTML']); 
		Route::post('/users/userentities/edit/{id}',['as' => 'users.userentities.editpost','uses' => 'UsersController@FieldsEdit']);
		Route::get('/users/userentities/delete/{id}',['as' => 'users.userentities.delete','uses' => 'UsersController@FieldsDelete']);   
		
		// Управление сущностями
		Route::get('/component/{section}',['as' => 'component.index','uses' => 'EntitiesController@ComponentIndex']);  
		Route::get('/component/{section}/add',['as' => 'component.item.add','uses' => 'EntitiesController@ComponentItemAddHtml']);  
		Route::post('/component/{section}/add',['as' => 'component.item.addpost','uses' => 'EntitiesController@ComponentItemAdd']);  
		
		Route::get('/component/{section}/edit/{id}',['as' => 'component.item.edit','uses' => 'EntitiesController@ComponentItemEditHtml']);  
		Route::post('/component/{section}/edit/{id}',['as' => 'component.item.editpost','uses' => 'EntitiesController@ComponentItemEdit']); 
		
		Route::get('/component/{section}/drop/{id}',['as' => 'component.item.drop','uses' => 'EntitiesController@ComponentItemDrop']);  
		
		Route::get('/component/{section}/view/{id}',['as' => 'component.item.view','uses' => 'EntitiesController@ComponentItemView']);  
		
		
		Route::get('/settings',['as' => 'settings','uses' => 'SettingsController@index']);  
		Route::post('/settings',['as' => 'settings.post','uses' => 'SettingsController@upload']);
		Route::get('/settings-smtp-test',['as' => 'settings.smtptest','uses' => 'SettingsController@smtpTest']);
		
		Route::get('/settings/entities',['as' => 'entities','uses' => 'EntitiesController@index']);  
		Route::get('/settings/entities/add',['as' => 'entities.add','uses' => 'EntitiesController@ComponentAddHtml']);  
		Route::post('/settings/entities/add',['as' => 'entities.addpost','uses' => 'EntitiesController@ComponentAdd']); 
		Route::get('/settings/entities/drop/{id}',['as' => 'entities.drop','uses' => 'EntitiesController@ComponentDrop']);  
		
		Route::get('/settings/entities/{section}/widjetcodes',['as' => 'entities.widjetcodes','uses' => 'EntitiesController@getEntitiesWidjetCode']); 
		Route::get('/settings/entities/edit/{id}',['as' => 'entities.edit','uses' => 'EntitiesController@ComponentEditHtml']);  
		Route::post('/settings/entities/edit/{id}',['as' => 'entities.editpost','uses' => 'EntitiesController@ComponentEdit']);
		
		Route::get('/settings/entities/setting/{id}',['as' => 'entities.setting','uses' => 'EntitiesController@ComponentSettingHtml']);  
		Route::post('/settings/entities/setting/{id}',['as' => 'entities.settingpost','uses' => 'EntitiesController@ComponentSetting']);
		
		Route::post('/settings/entities/isurlsection',['as' => 'entities.isurlsection','uses' => 'EntitiesController@isUrlSection']);	 
		Route::get('/settings/entities/{section}/userentities',['as' => 'entities.userentities','uses' => 'EntitiesController@UserEntitiesIndex']);  
		Route::get('/settings/entities/{section}/userentities/catadd',['as' => 'entities.userentities.catadd','uses' => 'EntitiesController@UserEntitiesCatAdd']);   
		Route::post('/settings/entities/{section}/userentities/catadd',['as' => 'entities.userentities.cataddpost','uses' => 'EntitiesController@UserEntitiesCatAddPOST']); 
		Route::get('/settings/entities/{section}/userentities/add',['as' => 'entities.userentities.add','uses' => 'EntitiesController@FieldsAddHTML']);  
		Route::post('/settings/entities/{section}/userentities/add',['as' => 'entities.userentities.addpost','uses' => 'EntitiesController@FieldsAdd']);  
		Route::get('/settings/entities/{section}/userentities/catedit/{id}',['as' => 'entities.userentities.catedit','uses' => 'EntitiesController@catEditHTML']); 
		Route::post('/settings/entities/{section}/userentities/catedit/{id}',['as' => 'entities.userentities.cateditpost','uses' => 'EntitiesController@catEdit']); 
		Route::get('/settings/entities/{section}/userentities/catdelete/{id}',['as' => 'entities.userentities.catdelete','uses' => 'EntitiesController@catDelete']); 
		Route::get('/settings/entities/{section}/userentities/edit/{id}',['as' => 'entities.userentities.edit','uses' => 'EntitiesController@FieldsEditHTML']); 
		Route::post('/settings/entities/{section}/userentities/edit/{id}',['as' => 'entities.userentities.editpost','uses' => 'EntitiesController@FieldsEdit']);
		Route::get('/settings/entities/{section}/userentities/delete/{id}',['as' => 'entities.userentities.delete','uses' => 'EntitiesController@FieldsDelete']);  

		// страницы-сущности
		Route::get('/pages/add',['as' => 'pages.add','uses' => 'PagesController@addHtml']);  
		Route::post('/pages/add',['as' => 'pages.addpost','uses' => 'PagesController@add']);  
		Route::post('/pages/isurlpage',['as' => 'pages.isurlpage','uses' => 'PagesController@isUrlPage']);
		Route::get('/pages/edit/{id}',['as' => 'pages.edit','uses' => 'PagesController@editHtml']);    
		Route::post('/pages/edit/{id}',['as' => 'pages.editpost','uses' => 'PagesController@edit']); 
		Route::get('/pages/drop/{id}',['as' => 'pages.drop','uses' => 'PagesController@drop']); 
		Route::get('/pages/settings/{id}',['as' => 'pages.settings','uses' => 'PagesController@settingsHtml']); 
		Route::post('/pages/settings/{id}',['as' => 'pages.settingspost','uses' => 'PagesController@settings']); 
		Route::get('/pages/widjet/{id}',['as' => 'pages.widjet','uses' => 'PagesController@widjet']); 
		Route::get('/pages/widjet/{id}/save',['as' => 'pages.widjet.save','uses' => 'PagesController@widjetSave']); 
		Route::get('/pages/widjetlistajax/{id}',['as' => 'pages.widjetlistajax','uses' => 'PagesController@widjetListAjax']);  
		Route::get('/pages/widjetreposition/{id}',['as' => 'pages.widjetreposition','uses' => 'PagesController@widjetRePosition']);  
		Route::get('/pages/widjetadd/{id}/{widjet}/{position}',['as' => 'pages.widjetadd','uses' => 'PagesController@widjetAddHtml']);  
		Route::post('/pages/widjetadd/{id}/{widjet}/{position}',['as' => 'pages.widjetaddpost','uses' => 'PagesController@widjetAdd']); 
		Route::get('/pages/widjetedit/{id}/{widjet}/{widjetid}',['as' => 'pages.widjetedit','uses' => 'PagesController@widjetEditHtml']);  
		Route::post('/pages/widjetedit/{id}/{widjet}/{widjetid}',['as' => 'pages.widjeteditpost','uses' => 'PagesController@widjetEdit']);  
		Route::get('/pages/widjetdrop/{id}/{widjet}',['as' => 'pages.widjetdrop','uses' => 'PagesController@widjetDrop']);  
		   
		   
		// SERM
		Route::get('/serm',['as' => 'serm','uses' => 'SermAdminController@index']);
		Route::get('/serm/project-add/',['as' => 'serm.add','uses' => 'SermAdminController@projectAdd']);
		Route::post('/serm/project-add/',['as' => 'serm.add.post','uses' => 'SermAdminController@projectAddPost']);
		Route::get('/serm/project-edit/{id}',['as' => 'serm.edit','uses' => 'SermAdminController@projectEdit']);
		
		Route::get('/serm/exports',['as' => 'serm.export','uses' => 'SermAdminController@export']);
		
		
		Route::get('/serm/serm-update',['as' => 'serm.sermupdate','uses' => 'SermAdminController@sermUpdate']);
		Route::get('/serm/serm-update/pc',['as' => 'serm.sermupdate.pc','uses' => 'SermAdminController@sermUpdatePC']);
		Route::get('/serm/serm-update/project',['as' => 'serm.sermupdate.project','uses' => 'SermAdminController@sermUpdateProject']);
	}
);


Route::match('get',"/page-widjet-entities/{widjet}/{entitie}",['as' => 'page.widjet.entities','uses' => 'Admin\PagesController@getWebWidjetEntitiesHtml']);
Route::match('post',"/page-widjet-entities/{widjet}/{entitie}/{urlback}",['as' => 'page.widjet.entitiespost','uses' => 'Admin\PagesController@getWebWidjetEntities']);

Route::match('get',"/{url}.html",['as' => 'page.web','uses' => 'Admin\PagesController@getWebPage']);
Route::match('get',"/{url}.html.admin",['as' => 'page.web.admin','uses' => 'Admin\PagesController@getWebPageAdmin']);
Route::match('get',"/{url}/{id}-{translate}.html",['as' => 'section.item','uses' => 'Admin\EntitiesController@getWebItem']); 
Route::match('get',"/{url}",['as' => 'section.id','uses' => 'Admin\EntitiesController@getWebIndex']);
		

$home = json_decode(option('home-url',false),true);
if($home==false||$home==0){
	Route::get('/', function () { return Response::view('errors.404', array(), 404); });
} else {
	$Controllers=['Admin\PagesController@getWebPage','Admin\EntitiesController@getWebIndex'];
	if(in_array($home['uses'],$Controllers)){
		Route::match('get',"/",['as' => 'home','uses' => $home['uses']])->defaults('url',$home['url']['url']);
	}
	unset($Controllers);
}


