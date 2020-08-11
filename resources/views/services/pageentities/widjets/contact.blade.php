<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<form id="contactWidjetForm{{$widjetID}}" action="" method="POST" enctype="multipart/form-data" data-zkonload="{{route('page.widjet.entities',[$widjetID,$entities['select']??0])}}">
			
			</form>
		</div>
		<div class="col-md-6">{!!$text??null!!}</div>
	</div>
</div>