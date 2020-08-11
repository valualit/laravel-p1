<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
			<div class="card-header">
				<h4 class="my-0 font-weight-normal">{{$title1??null}}</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title pricing-card-title">{!!$price1??null!!}</h3>
				<div class="list-unstyled mt-3 mb-4">{!!$text1??null!!}</div>
				<a href="{{$buttonlink1??null}}"{{isset($buttontargetblank1)&&$buttontargetblank1=='Yes'?' target="_blank"':null}} class="btn btn-lg btn-block btn-{{$buttonstyle1??null}}">{{$buttontext1??null}}</a>
			</div>
        </div>
        <div class="card mb-4 box-shadow">
			<div class="card-header">
				<h4 class="my-0 font-weight-normal">{{$title2??null}}</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title pricing-card-title">{!!$price2??null!!}</h3>
				<div class="list-unstyled mt-3 mb-4">{!!$text2??null!!}</div>
				<a href="{{$buttonlink2??null}}"{{isset($buttontargetblank2)&&$buttontargetblank2=='Yes'?' target="_blank"':null}} class="btn btn-lg btn-block btn-{{$buttonstyle2??null}}">{{$buttontext2??null}}</a>
			</div>
        </div>
        <div class="card mb-4 box-shadow">
			<div class="card-header">
				<h4 class="my-0 font-weight-normal">{{$title3??null}}</h4>
			</div>
			<div class="card-body">
				<h3 class="card-title pricing-card-title">{!!$price3??null!!}</h3>
				<div class="list-unstyled mt-3 mb-4">{!!$text3??null!!}</div>
				<a href="{{$buttonlink3??null}}"{{isset($buttontargetblank3)&&$buttontargetblank3=='Yes'?' target="_blank"':null}} class="btn btn-lg btn-block btn-{{$buttonstyle3??null}}">{{$buttontext3??null}}</a>
			</div>
        </div>
    </div>
</div>