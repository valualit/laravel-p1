<div class="container-fluid {{$class??null}}">
	<div class="row">
		<div class="col-md-12">
			<{!!$titlesize??'h1'!!} class="text-{!!$titlealign??'left'!!}">{!!$title??null!!}</{!!$titlesize??'h1'!!}>
			{!!$text??null!!}
			<div class="text-{{$buttonalign??'center'}} m-3"><a href="{{$buttonlink??null}}"{{$buttontargetblank=='Yes'?' target="_blank"':null}} class="btn btn-{{$buttonstyle??null}}">{{$buttontext??null}}</a></div>
		</div>
	</div>
</div>