<div class="container-fluid">
    <div class="jumbotron p-3 p-md-5 rounded bg-{!!$bg??'dark'!!}" @if(isset($image)&&mb_strlen($image)>0) style="background: linear-gradient({{isset($bggradient)&&isset(["blue-30%"=>'rgba(25, 35, 78, 0.3)',"blue-60%"=>'rgba(25, 35, 78, 0.6)',"dark-30%"=>'rgba(0, 0, 0, 0.3)',"dark-60%"=>'rgba(0, 0, 0, 0.6)'][$bggradient])?["blue-30%"=>'rgba(25, 35, 78, 0.3)',"blue-60%"=>'rgba(25, 35, 78, 0.6)',"dark-30%"=>'rgba(0, 0, 0, 0.3)',"dark-60%"=>'rgba(0, 0, 0, 0.6)'][$bggradient].",".["blue-30%"=>'rgba(25, 35, 78, 0.3)',"blue-60%"=>'rgba(25, 35, 78, 0.6)',"dark-30%"=>'rgba(0, 0, 0, 0.3)',"dark-60%"=>'rgba(0, 0, 0, 0.6)'][$bggradient]:'rgba(0, 0, 0, 0),rgba(0, 0, 0, 0)'}}), url('{{$image??null}}') no-repeat center center;background-size:cover;" @endif >
        @if(isset($bgtext)&&$bgtext!=12) <div class="row"><div class="col-md-{{$bgmarginleft??12}}"></div>@endif
        <div class="col-md-{{$bgtext??12}} px-9">
			<{!!$titlesize??'h1'!!} class="text-{!!$titlealign??'left'!!} text-{!!$titlecolor??'success'!!}" @if(isset($titlemargintop)&&$titlemargintop>0) style="margin-top:{{$titlemargintop??0}}"@endif>{!!$title??null!!}</{!!$titlesize??'h1'!!}>
			<div class="text-{!!$textcolor??'dark'!!}">{!!$text??null!!}</div>
			@if(isset($buttonactive)&&$buttonactive=='Yes')
			<div class="text-{{$buttonalign??'center'}} m-3"><a href="{{$buttonlink??null}}"{{$buttontargetblank=='Yes'?' target="_blank"':null}} class="btn btn-{{$buttonstyle??null}}">{{$buttontext??null}}</a></div>
			@endif
        </div>@if(isset($bgtext)&&$bgtext!=12)</div>@endif
    </div>
</div>