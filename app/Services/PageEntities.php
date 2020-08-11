<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use ImageOptimizer;

class PageEntities { 
	
	public function ListPage(){
		$data=[];
		$pages=DB::table('page')->get(); 
		foreach($pages as $page){
			$data[$page->id]=$page;
		}
		return $data;
	}
	
    public function WidjetList(){
		$list = array(
			"default"=>array(
				"name"=>"Стандартный (заголовок+текст)",
				"template"=>'services.pageentities.widjets.default',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
				),
			),
			"default-row2"=>array(
				"name"=>"Стандартный (2 колонки)",
				"template"=>'services.pageentities.widjets.row2',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text1size"=>array("name"=>"Размер 1 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>6),
					"text1"=>array("name"=>"Текст 1 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text2size"=>array("name"=>"Размер 2 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>6),
					"text2"=>array("name"=>"Текст 2 колнки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
				),
			),
			"default-row3"=>array(
				"name"=>"Стандартный (3 колонки)",
				"template"=>'services.pageentities.widjets.row3',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text1size"=>array("name"=>"Размер 1 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>4),
					"text1"=>array("name"=>"Текст 1 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text2size"=>array("name"=>"Размер 2 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>4),
					"text2"=>array("name"=>"Текст 2 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text3size"=>array("name"=>"Размер 3 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>4),
					"text3"=>array("name"=>"Текст 3 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
				),
			),
			"default-row4"=>array(
				"name"=>"Стандартный (4 колонки)",
				"template"=>'services.pageentities.widjets.row4',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text1size"=>array("name"=>"Размер 1 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>3),
					"text1"=>array("name"=>"Текст 1 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text2size"=>array("name"=>"Размер 2 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>3),
					"text2"=>array("name"=>"Текст 2 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text3size"=>array("name"=>"Размер 3 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>3),
					"text3"=>array("name"=>"Текст 3 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text4size"=>array("name"=>"Размер 4 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>3),
					"text4"=>array("name"=>"Текст 4 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
				),
			),
			"code"=>array(
				"name"=>"Свой код",
				"template"=>'services.pageentities.widjets.code',
				"image"=>false,
				"fields"=>array(
					"text"=>array("name"=>"HTML код экрана","type"=>"textarea", 'default'=>null, 'value'=>"<div class=\"container-fluid\">\n\t<div class=\"row\">\n\t\t<div class=\"col-md-12\">\n\t\t\t<h3 class=\"text-center\">Заголовок</h3>\n\t\t\t<p>Содержимое виджета</p>\n\t\t</div>\n\t</div>\n</div>"),
				),
			),
			"row2image"=>array(
				"name"=>"Картинка+текст (2 колонки)",
				"template"=>'services.pageentities.widjets.row2image',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text1size"=>array("name"=>"Размер 1 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>6),
					"text1"=>array("name"=>"Текст 1 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text2size"=>array("name"=>"Размер колнки изображения","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>6),
					"text2"=>array("name"=>"Изображение","type"=>"image", 'default'=>null, 'value'=>null),
					"imagealign"=>array("name"=>"Выравнивание изображения","type"=>"select", 'default'=>"left\nright", 'value'=>null),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
					"files"=>array("name"=>"Файлы","type"=>"files", 'default'=>null, 'value'=>null),
					"buttonactive"=>array("name"=>"Показывать кнопку","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),		
					"buttontext"=>array("name"=>"Текст кнопки","type"=>"input", 'default'=>null, 'value'=>null),  
					"buttonlink"=>array("name"=>"Ссылка кнопки","type"=>"input", 'default'=>null, 'value'=>null),
					"buttontargetblank"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
					"buttonalign"=>array("name"=>"Выравнивание кнопки","type"=>"select", 'default'=>"center\nleft\nright", 'value'=>null),
					//"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  
				),
			),
			"row2image_entities"=>array(
				"name"=>"Картинка+текст (2 колонки) сущность",
				"template"=>'services.pageentities.widjets.row2image_entities',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text1size"=>array("name"=>"Размер 1 колонки","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>6),
					"text1"=>array("name"=>"Текст 1 колонки","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"text2size"=>array("name"=>"Размер колнки изображения","type"=>"select", 'default'=>"2\n3\n4\n5\n6\n7\n8\n9\n10", 'value'=>6),
					"text2"=>array("name"=>"Изображение","type"=>"image", 'default'=>null, 'value'=>null),
					"imagealign"=>array("name"=>"Выравнивание изображения","type"=>"select", 'default'=>"left\nright", 'value'=>null),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
					"files"=>array("name"=>"Файлы","type"=>"files", 'default'=>null, 'value'=>null),
					"buttonalign"=>array("name"=>"Выравнивание кнопки","type"=>"select", 'default'=>"center\nleft\nright", 'value'=>null),
					"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  
				),
			),
			"default_entities"=>array(
				"name"=>"Стандартный (заголовок+текст) кнопка-сущность",
				"template"=>'services.pageentities.widjets.default_entities',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  
				),
			),
			"default_button"=>array(
				"name"=>"Стандартный (заголовок+текст) кнопка-ссылка",
				"template"=>'services.pageentities.widjets.default_button',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"buttontext"=>array("name"=>"Текст кнопки","type"=>"input", 'default'=>null, 'value'=>null),  
					"buttonlink"=>array("name"=>"Ссылка кнопки","type"=>"input", 'default'=>null, 'value'=>null),
					"buttontargetblank"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),					
				),
			),
			"default_card"=>array(
				"name"=>"CardType (заголовок+текст) кнопка-ссылка",
				"template"=>'services.pageentities.widjets.default_card',
				"image"=>false,
				"fields"=>array(
					"card"=>array("name"=>"Количество колонок для кооператиции","type"=>"select", 'default'=>"2\n3\n4\n5\n6", 'value'=>null),					
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"buttonactive"=>array("name"=>"Показывать кнопку","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),		
					"buttontext"=>array("name"=>"Текст кнопки","type"=>"input", 'default'=>null, 'value'=>null),  
					"buttonlink"=>array("name"=>"Ссылка кнопки","type"=>"input", 'default'=>null, 'value'=>null),
					"buttontargetblank"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
					"image"=>array("name"=>"Изображение","type"=>"image", 'default'=>null, 'value'=>null),
					"imagealign"=>array("name"=>"Выравнивание изображения","type"=>"select", 'default'=>"top\nleft\nright\nbottom", 'value'=>null),					
				),
			),
			"default_card_entities"=>array(
				"name"=>"CardType (заголовок+текст) кнопка-сущность",
				"template"=>'services.pageentities.widjets.default_card_entities',
				"image"=>false,
				"fields"=>array(
					"card"=>array("name"=>"Количество колонок для кооператиции","type"=>"select", 'default'=>"2\n3\n4\n5\n6", 'value'=>null),					
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"buttonactive"=>array("name"=>"Показывать кнопку","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),		
					//"buttontext"=>array("name"=>"Текст кнопки","type"=>"input", 'default'=>null, 'value'=>null),  
					//"buttonlink"=>array("name"=>"Ссылка кнопки","type"=>"input", 'default'=>null, 'value'=>null),
					//"buttontargetblank"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					//"buttonstyle"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
					"image"=>array("name"=>"Изображение","type"=>"image", 'default'=>null, 'value'=>null),
					"imagealign"=>array("name"=>"Выравнивание изображения","type"=>"select", 'default'=>"top\nleft\nright\nbottom", 'value'=>null),		
					"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  			
				),
			),
			"banner"=>array(
				"name"=>"Баннер",
				"template"=>'services.pageentities.widjets.banner',
				"image"=>false,
				"fields"=>array(	
					"bgtext"=>array("name"=>"Размер контент части из 12","type"=>"select", 'default'=>"12\n6\n4\n3", 'value'=>12),				
					"bgmarginleft"=>array("name"=>"Отступ слева из 12","type"=>"input", 'default'=>"0", 'value'=>0),
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlecolor"=>array("name"=>"Цвет заголовка","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>'dark'),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"titlemargintop"=>array("name"=>"Отступ заголовка сверху","type"=>"input", 'default'=>"0", 'value'=>0),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"textcolor"=>array("name"=>"Цвет текста","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>'dark'),
					"buttonactive"=>array("name"=>"Показывать кнопку","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),		
					"buttontext"=>array("name"=>"Текст кнопки","type"=>"input", 'default'=>null, 'value'=>null),  
					"buttonlink"=>array("name"=>"Ссылка кнопки","type"=>"input", 'default'=>null, 'value'=>null),
					"buttontargetblank"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
					"buttonalign"=>array("name"=>"Выравнивание кнопки","type"=>"select", 'default'=>"center\nleft\nright", 'value'=>null),
					"image"=>array("name"=>"Изображение","type"=>"image", 'default'=>null, 'value'=>null),	
					"bg"=>array("name"=>"Фон под картинкой","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>'light'),					
					"bggradient"=>array("name"=>"Затемнение фона","type"=>"select", 'default'=>"none\nblue-30%\nblue-60%\ndark-30%\ndark-60%", 'value'=>'none'),					
				),
			),
			"banner_entities"=>array(
				"name"=>"Баннер (сущность)",
				"template"=>'services.pageentities.widjets.banner_entities',
				"image"=>false,
				"fields"=>array(				
					"bgtext"=>array("name"=>"Размер контент части из 12","type"=>"select", 'default'=>"12\n6\n4\n3", 'value'=>12),				
					"bgmarginleft"=>array("name"=>"Отступ слева из 12","type"=>"input", 'default'=>"0", 'value'=>0),
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlecolor"=>array("name"=>"Цвет заголовка","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>'dark'),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"titlemargintop"=>array("name"=>"Отступ заголовка сверху","type"=>"input", 'default'=>"0", 'value'=>0),
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"textcolor"=>array("name"=>"Цвет текста","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>'dark'),
					"buttonactive"=>array("name"=>"Показывать кнопку","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),		
					"buttonalign"=>array("name"=>"Выравнивание кнопки","type"=>"select", 'default'=>"center\nleft\nright", 'value'=>null),
					"image"=>array("name"=>"Изображение","type"=>"image", 'default'=>null, 'value'=>null),	
					"bg"=>array("name"=>"Фон под картинкой","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>'light'),			
					"bggradient"=>array("name"=>"Затемнение фона","type"=>"select", 'default'=>"none\nblue-30%\nblue-60%\ndark-30%\ndark-60%", 'value'=>'none'),	
					"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  			
				),
			),
			"carouselimage"=>array(
				"name"=>"Карусель картинки",
				"template"=>'services.pageentities.widjets.carouselimage',
				"image"=>false,
				"fields"=>array(
					"title"=>array("name"=>"Заголовок","type"=>"input", 'default'=>null, 'value'=>null),
					"titlesize"=>array("name"=>"Размер заголовка","type"=>"select", 'default'=>"h1\nh2\nh3\nh4\nh5", 'value'=>null),
					"titlealign"=>array("name"=>"Выравнивание заголовка","type"=>"select", 'default'=>"left\ncenter\nright", 'value'=>null),
					"images"=>array("name"=>"Изображения","type"=>"image_multiple", 'default'=>null, 'value'=>null),
					"rows"=>array("name"=>"Количество колонок","type"=>"select", 'default'=>"2\n3\n4\n6\n12", 'value'=>4),
					"maxheight"=>array("name"=>"Высота картинки","type"=>"input", 'default'=>null, 'value'=>'100px'),
					"class"=>array("name"=>"CSS класс","type"=>"input", 'default'=>null, 'value'=>null),
					//"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  
				),
			),
			"defaultprices"=>array(
				"name"=>"Стандартный прайс",
				"template"=>'services.pageentities.widjets.defaultprices',
				"image"=>false,
				"fields"=>array(
					"title1"=>array("name"=>"Заголовок 1","type"=>"input", 'default'=>null, 'value'=>'Предложение №1'),
					"price1"=>array("name"=>"Цена 1","type"=>"input", 'default'=>null, 'value'=>'$0 <small class="text-muted">/ mo</small>'),
					"text1"=>array("name"=>"Описание 1","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"buttonlink1"=>array("name"=>"Кнопка (ссылка) 1","type"=>"input", 'default'=>null, 'value'=>"#"),
					"buttontext1"=>array("name"=>"Кнопка (текст) 1","type"=>"input", 'default'=>null, 'value'=>'Подробнее'),
					"buttontargetblank1"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle1"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
					"title2"=>array("name"=>"Заголовок 2","type"=>"input", 'default'=>null, 'value'=>'Предложение №2'),
					"price2"=>array("name"=>"Цена 2","type"=>"input", 'default'=>null, 'value'=>'$0 <small class="text-muted">/ mo</small>'),
					"text2"=>array("name"=>"Описание 2","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),
					"buttonlink2"=>array("name"=>"Кнопка (ссылка) 1","type"=>"input", 'default'=>null, 'value'=>"#"),
					"buttontext2"=>array("name"=>"Кнопка (текст) 1","type"=>"input", 'default'=>null, 'value'=>'Подробнее'),
					"buttontargetblank2"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle2"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
					"title3"=>array("name"=>"Заголовок 3","type"=>"input", 'default'=>null, 'value'=>'Предложение №3'),
					"price3"=>array("name"=>"Цена 3","type"=>"input", 'default'=>null, 'value'=>'$0 <small class="text-muted">/ mo</small>'),
					"text3"=>array("name"=>"Описание 3","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>null),  
					"buttonlink3"=>array("name"=>"Кнопка (ссылка) 1","type"=>"input", 'default'=>null, 'value'=>"#"),
					"buttontext3"=>array("name"=>"Кнопка (текст) 1","type"=>"input", 'default'=>null, 'value'=>'Подробнее'),
					"buttontargetblank3"=>array("name"=>"Открывать в новом окне","type"=>"select", 'default'=>"Not\nYes", 'value'=>null),					
					"buttonstyle3"=>array("name"=>"Стиль кнопки","type"=>"select", 'default'=>"primary\nsecondary\nsuccess\ndanger\nwarning\ninfo\nlight\ndark\nlink", 'value'=>null),
				),
			),
			"contact"=>array(
				"name"=>"Контакты (сущность)",
				"template"=>'services.pageentities.widjets.contact',
				"image"=>false,
				"fields"=>array(				
					"text"=>array("name"=>"Текст","type"=>"textarea wysiwyg", 'default'=>null, 'value'=>'<p><b>Адрес</b>: </p><p><b>Телефон</b>: </p><p><b>E-Mail</b>: </p>'),
					"entities"=>array("name"=>"Сущность","type"=>"entitiesList", 'default'=>null, 'value'=>null),  			
				),
			),
		);
		return $list;
    }
	
	
}
