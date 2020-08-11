<div class="card">
	@if(isset($image)&&isset($imagealign)&&$imagealign=='top')
		<img src="{{$image??null}}" class="bd-placeholder-img card-img-top" /> 
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='left')
		<div class="row"><div class="col-md-6 text-center">
		<img src="{{$image??null}}" class="d-inline-block align-middle" style="width:100%" /> 
		</div><div class="col-md-6">
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='right')
		<div class="row"><div class="col-md-6">
	@endif
	<div class="card-body" @if(isset($imagealign)&&($imagealign=='right'||$imagealign=='left')) style="padding: 0!important" @endif >
		<{!!$titlesize??'h1'!!} class="text-{!!$titlealign??'left'!!}">{!!$title??null!!}</{!!$titlesize??'h1'!!}>
		<div class="card-text">{!!$text??null!!}</div>
		@if(isset($buttonactive)&&$buttonactive=='Yes')
		<div class="text-{{$buttonalign??'center'}} m-3"><a href="{{$buttonlink??null}}"{{$buttontargetblank=='Yes'?' target="_blank"':null}} class="btn btn-{{$buttonstyle??null}}">{{$buttontext??null}}</a></div>
		@endif
	</div>
	@if(isset($image)&&isset($imagealign)&&$imagealign=='right')
		</div><div class="col-md-6 text-center align-middle"> 
		<img src="{{$image??null}}" class="d-inline-block" style="width:100%" /> 
		</div></div>
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='left')
		</div></div>
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='bottom')
		<img src="{{$image??null}}" class="bd-placeholder-img card-img-bottom" /> 
	@endif
</div>