<?php 
$countImages = count($images);
$sliders=ceil($countImages/($rows??4)); 
$sizecol = array(2=>6,3=>4,4=>3,6=>2,12=>1);
?>
<div class="container-fluid">
	<{!!$titlesize??'h1'!!} class="m-3 text-{!!$titlealign??'left'!!}">{!!$title??null!!}</{!!$titlesize??'h1'!!}>
	<div id="carouselExampleCaptions{{$widjetID}}" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			@if(isset($images)&&is_array($images)&&count($images)>0)
				@for ($i=0;$i<$sliders;$i++)
				<li data-target="#carouselExampleCaptions{{$widjetID}}" data-slide-to="{{$i}}" class="{{$i==0?'active':null}}"></li>
				@endfor
			@endif
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<div class="row">
					@foreach ($images as $keyImage=>$Image)
					<div class="text-center col-md-{{isset($rows)&&isset($sizecol[$rows])?$sizecol[$rows]:3}}">
						<img src="{{$Image}}" @if(isset($images)&&is_array($images)&&count($images)>0) style="width:auto;height:{{$maxheight??'100px'}}" @endif alt="" />
					</div>
						@if(($keyImage+1)%$rows==0&&$countImages>$keyImage+1)
				</div>
			</div>
			<div class="carousel-item">
				<div class="row">
						@endif
					@endforeach
				</div>
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleCaptions{{$widjetID}}" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only"></span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleCaptions{{$widjetID}}" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only"></span>
		</a>
	</div>
</div>