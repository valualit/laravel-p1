<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Storage;
use Image;
use ImageOptimizer;

class PagesController extends Controller
{
	public function mb_wordwrap($str, $width = 75, $break = "\n", $cut = false) {
		$lines = explode($break, $str);
		foreach ($lines as &$line) {
			$line = rtrim($line);
			if (mb_strlen($line) <= $width)
				continue;
			$words = explode(' ', $line);
			$line = '';
			$actual = '';
			foreach ($words as $word) {
				if (mb_strlen($actual.$word) <= $width)
					$actual .= $word.' ';
				else {
					if ($actual != '')
						$line .= rtrim($actual).$break;
					$actual = $word;
					if ($cut) {
						while (mb_strlen($actual) > $width) {
							$line .= mb_substr($actual, 0, $width).$break;
							$actual = mb_substr($actual, $width);
						}
					}
					$actual .= ' ';
				}
			}
			$line .= trim($actual);
		}
		return implode($break, $lines);
	}
    //
	public function get(){
		if(isset($_FILES["fileToUpload"]["tmp_name"])){
			$img = Image::make($_FILES["fileToUpload"]["tmp_name"]);
			$img->save(public_path('uploads')."/get.jpg");
			ImageOptimizer::optimize(public_path('uploads')."/get.jpg",public_path('uploads')."/get_opt.jpg");
			var_dump(
				Storage::disk('disk')->url("public/uploads/get.jpg"),
				Storage::disk('disk')->size("public/uploads/get.jpg"),
				Storage::disk('disk')->url("public/uploads/get_opt.jpg"),
				Storage::disk('disk')->size("public/uploads/get_opt.jpg")
			);
		} else {
			?>
			<!DOCTYPE html>
			<html>
			<body>

			<form action="" method="post" enctype="multipart/form-data">
				<?=csrf_field()?>
				Select image to upload:
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload Image" name="submit">
			</form>

			</body>
			</html>
			<?php
		}
		exit();
		
	}
	public function index(){
		
		$DataImage = ['link'=>'ППУ трубы и отводы / polymerizol.ru  ','img'=>'http://polymerizol.ru/UserFiles/Image/trubi.jpg','name'=>"Планируете сократить расходы на прокладку теплотрассы и увеличить ее долговечность?"];    
		//$img = Image::canvas(320, 320, '#ff0000'); 
		$img = Image::make($DataImage['img']); 
		$width = 580; $height = 225;
		//$img->flip('h');
		$img->width() > $img->height() ? $width=null : $height=null;
		$img->resize(null, 225, function ($constraint) {
			$constraint->aspectRatio();
		});
		$imgWidth = $img->width();
		if($imgWidth>300){
			$img->crop(300, 225, ceil(($imgWidth-300)/2), 0);
		}
		$imgWidth = $img->width();
		$img->resizeCanvas(580, 225, 'top-left', false, '#000000');
		$points = array(
			$imgWidth,  3,
			577,  3,
			577,  222,
			($imgWidth-40), 222
		);
		$img->polygon($points, function ($draw) {
			$draw->background('#000000');
			$draw->border(2, '#ffffff');
		});
		$img->line(3, 3, 577, 3, function ($draw) {
			$draw->color('#fff');
			$draw->width(2);
		});
		$img->line(577, 3, 577, 222, function ($draw) {
			$draw->color('#fff');
			$draw->width(2);
		});
		$img->line(577, 222, 3, 222, function ($draw) {
			$draw->color('#fff');
			$draw->width(2);
		});
		$img->line(3, 222, 3, 3,  function ($draw) {
			$draw->color('#fff');
			$draw->width(2);
		}); 		
		$text=$DataImage['link'];
		$font_size=14;
		$widthLink = intval(ceil(mb_strlen($text)*$font_size/2.1)+$font_size*1.5);
		$widthLinkStart = 570-$widthLink;
		
		$points = array(
			$widthLinkStart,  195,
			$widthLink+$widthLinkStart,  195,
			$widthLink+$widthLinkStart,  215,
			$widthLinkStart,  215
		);
		$img->polygon($points, function ($draw) {
			$draw->background('#51749d');
		});
		$img->text($text, $widthLinkStart+5, 200, function($font) use ($font_size) {
			$font->file(base_path('resources/font/KelsonSans-BoldRU.ttf'));
			$font->size($font_size);
			$font->color('#ffffff');
			$font->align('left');
			$font->valign('top');
		});
		$text = $DataImage['name'];
		$lines = mb_strlen($text)>22?explode("\n", $this->mb_wordwrap($text, 20)):array($text);
		$l=1;
		$font_size=24; 
		$startText=$imgWidth+(count($lines)>1?$font_size/2:-10);
		foreach($lines as $text){
			$img->text($text, $startText, $font_size*(3.5-count($lines)+$l+(count($lines)>2?1.5:0)), function($font) use ($font_size){
				$font->file(base_path('resources/font/KelsonSans-BoldRU.ttf'));
				$font->size($font_size);
				$font->color('#ffffff');
				$font->align('left');
				$font->valign('top');
			});
			$startText=$startText-5;
			$l++;
		}
		$img->save(public_path('uploads')."/gor.jpg");
		ImageOptimizer::optimize(public_path('uploads')."/gor.jpg",public_path('uploads')."/gor_opt.jpg");
		var_dump(
			Storage::disk('disk')->url("public/uploads/gor.jpg"),
			Storage::disk('disk')->size("public/uploads/gor.jpg"),
			Storage::disk('disk')->url("public/uploads/gor_opt.jpg"),
			Storage::disk('disk')->size("public/uploads/gor_opt.jpg")
		);
		exit();
		echo '<img src="'.$img->encode('data-url').'" />';
		/*
		$data = array(
			"template"=>"admin.dashboard",
		);
		return view('admin.index',$data); 
		*/
		exit();
	}
}
