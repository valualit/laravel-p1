<div class="card">
	@if(isset($image)&&isset($imagealign)&&$imagealign=='top')
		<img src="{{$image??null}}" class="bd-placeholder-img card-img-top" /> 
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='left')
		<div class="row"><div class="col-md-4 text-center">
		<img src="{{$image??null}}" class="d-inline-block align-middle" /> 
		</div><div class="col-md-8">
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='right')
		<div class="row"><div class="col-md-8">
	@endif
	<div class="card-body">
		<{!!$titlesize??'h1'!!} class="text-{!!$titlealign??'left'!!}">{!!$title??null!!}</{!!$titlesize??'h1'!!}>
		<div class="card-text">{!!$text??null!!}</div>
		@if(isset($buttonactive)&&$buttonactive=='Yes')
		<div class="text-{{$buttonalign??'center'}} m-3"><button type="button" onClick="zk.open_dialog('ModalEditUser','{{route('page.widjet.entities',[$widjetID,$entities['select']??0])}}','/*modal-xl*/','bg-light', '{{$entities['textbutton']??null}}')" class="btn {{$entities['classbutton']??null}}">{{$entities['textbutton']??null}}</button></div>
		@endif
	</div>
	@if(isset($image)&&isset($imagealign)&&$imagealign=='right')
		<div class="col-md-4 text-center align-middle">
		<img src="{{$image??null}}" class="d-inline-block" /> 
		</div></div>
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='left')
		</div></div>
	@endif
	@if(isset($image)&&isset($imagealign)&&$imagealign=='bottom')
		<img src="{{$image??null}}" class="bd-placeholder-img card-img-bottom" /> 
	@endif
</div>