<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<{!!$titlesize??'h1'!!} class="text-{!!$titlealign??'left'!!}">{!!$title??null!!}</{!!$titlesize??'h1'!!}>
			{!!$text??null!!}
			<div class="text-{{$buttonalign??'center'}} m-3"><button type="button" onClick="zk.open_dialog('ModalEditUser','{{route('page.widjet.entities',[$widjetID,$entities['select']??0])}}','/*modal-xl*/','bg-light', '{{$entities['textbutton']??null}}')" class="btn {{$entities['classbutton']??null}}">{{$entities['textbutton']??null}}</button></div>
		</div>
	</div>
</div>