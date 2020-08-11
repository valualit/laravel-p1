<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<{!!$titlesize??'h1'!!} class="text-{!!$titlealign??'left'!!}">{!!$title??null!!}</{!!$titlesize??'h1'!!}>
			{!!$text??null!!}
		</div>
	</div>
	<div class="row justify-content-md-center">
		@if(isset($imagealign)&&$imagealign=='left')
		<div class="col-md-{!!$text2size??6!!}">
			<img src="{!!$text2??null!!}" alt="" />
		</div>
		@endif
		<div class="col-md-{!!$text1size??6!!}">
			{!!$text1??null!!}
			{!!$files??null!!}
			<div class="text-{{$buttonalign??'center'}} m-3"><button type="button" onClick="zk.open_dialog('ModalEditUser','{{route('page.widjet.entities',[$widjetID,$entities['select']??0])}}','/*modal-xl*/','bg-light', '{{$entities['textbutton']??null}}')" class="btn {{$entities['classbutton']??null}}">{{$entities['textbutton']??null}}</button></div>
		</div>
		@if(isset($imagealign)&&$imagealign=='right')
		<div class="col-md-{!!$text2size??6!!}">
			<img src="{!!$text2??null!!}" alt="" />
		</div>
		@endif
	</div>
</div>