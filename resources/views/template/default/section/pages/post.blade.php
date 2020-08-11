@extends($template.'index')

@section('content')
<div class="container-fluid section-entities {{$class??null}}">
	<div class="row">
		<div class="col-12">
			<h1>{{$item->name??null}}</h1>
			{!!$item->text!!}
		</div>
	</div>
</div>
@stop

@section('header')

@stop

@section('footer-js')

@stop