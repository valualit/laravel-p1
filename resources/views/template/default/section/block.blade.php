@extends($template.'index')

@section('content')
	<ul id="portfolio_filters" class="portfolio-filters">
        <li class="active">
            <a class="filter btn btn-sm btn-link active" data-group="all">Все</a>
        </li>
		@foreach ($tags as $keyTag=>$tag)
        <li>
            <a class="filter btn btn-sm btn-link" data-group="{{$tag}}">{{$tag}}</a>
        </li>
		@endforeach
	</ul>
										
	<div id="portfolio_grid" class="row portfolio-grid portfolio-masonry masonry-grid-3">
		@foreach ($items as $keyEntitie=>$item)
		<figure class="item col-12 col-sm-6 col-md-4" data-groups='["all", "{{$item['tag']}}"]'>
            <a href="{{$item['link']}}" title="{{$item['title']}}" class="lightbox mfp-iframe">
                <img src="{{$item['img']}}" alt="{{$item['title']}}">
                <div>
                    <h5 class="name">{{$item['name']}}</h5>
                    <small>{{$item['title']}}</small>
                    <i class="fa fa-video-camera"></i>
                </div>
            </a>
        </figure>
		@endforeach
	</div>
	<div class="container"><div class="row"><div class="col-12 text-center justify-content-center mt-3">{!!$pagination!!}</div></div></div>
@stop

@section('header')

@stop

@section('footer-js')
<script type="text/javascript" src="{{$templateURL}}/js/modernizr.custom.js"></script>
<script type="text/javascript" src="{{$templateURL}}/js/jquery.shuffle.min.js"></script>
<script type="text/javascript">
$( document ).ready(function(){
	$('#portfolio_grid').shuffle({
        speed: 450,
        itemSelector: 'figure'
    });
    $('#portfolio_filters').on("click", ".filter", function (e) {
		$('#portfolio_filters .filter').parent().removeClass('active');
        $(this).parent().addClass('active');
        $('#portfolio_grid').shuffle('shuffle', $(this).attr('data-group'));
		var height = 200;
		$.each($('#portfolio_grid > figure'), function() {
			if($(this).hasClass("filtered")){
				var h = parseInt($(this).find("img").height());
				if(height<h){ height = h; }
			}
		});
		$('#portfolio_grid figure img').css("height",height);
	});
});
</script>
@stop