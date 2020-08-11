@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.pages.widjet',$page->id,$page->name)}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 mb-3 ml-0 pl-0">
						<a href="{{route('page.web.admin',$page->url)}}" target="_blank" class="btn btn-success btn-sm">{{__('Предпросмотр')}}</a>
						<a href="{{route('admin.pages.widjet.save',$page->id)}}" class="ml-1 btn btn-success btn-sm">{{__('Сохранить')}}</a>
						<a href="{{route('page.web',$page->url)}}" target="_blank" class="ml-1 btn btn-success btn-sm">{{__('Рабочая версия')}}</a>
				</div>
				<div class="col-12 card p-2">
					<ul id="sortable1">
						<li class="ui-state-default ui-state-disabled" id="WidjetScreen0">
							<input type="hidden" class="position" value="0" />
							<div class="WidjetScreenAdd">
								<i class="fa fa-plus" aria-hidden="true"></i>  
								<b class="ml-3 mr-3">Добавить виджет</b>
								<i class="fa fa-plus" aria-hidden="true"></i>  
							</div>
							<div class="ListWidjets"></div>
						</li>
						@foreach ($widjets as $keyWidjets=>$widjet)
						<li class="ui-state-default{{$widjet['card']>0?(' d-inline-block col-md-'.($cardsize[$widjet['card']]??null)):null}}" id="liwidjetscreen{{$widjet['position']}}">
							<div class="WidjetScreenTitle" id="widjetscreen{{$widjet['id']}}">
								<div class="btn-group">
									<a href="{{$widjet['drop']}}" id="widjet{{$keyWidjets}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="ml-5 btn btn-tool zk-confirm dropdown-item"><i class="fas fa-trash"></i></a>
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{$widjet['edit']}}','modal-xl','bg-light', '{{__('Редактировать')}}')" class="btn btn-tool dropdown-item"><i class="fas fa-edit"></i></a>
								</div>
								<small class="ml-3">{{$widjet['name']}}</small> 
							</div>
							<input type="hidden" class="position positionWidjet" name="position[{{$keyWidjets}}]" value="{{$keyWidjets}}" />
							<div class="row">
							{!! $widjet['html'] !!}
							</div>
							<div id="WidjetScreen{{$widjet['position']}}">
								<input type="hidden" class="position" value="{{$widjet['position']}}" />
								<div class="WidjetScreenAdd">
									<i class="fa fa-plus" aria-hidden="true"></i>  
									<b class="ml-3 mr-3">Добавить виджет</b>
									<i class="fa fa-plus" aria-hidden="true"></i>  
								</div>
								<div class="ListWidjets"></div>
							</div>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
        <!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop

@section('footer-js')
<style>
	.WidjetScreenAdd {display:block;border:1px solid #ccc;border-radius:6px;text-align:center;background-color:#ffc3fa;cursor:pointer;}
	.WidjetScreenTitle {display:block;margin:5px 0px;border:1px solid #ccc;border-radius:6px;text-align:left;background-color:#90d6ff;cursor:pointer;}
	.WidjetScreenTitle i {color:#000}
	#sortable1 { list-style-type: none; margin: 0; padding: 0; zoom: 1; }
	#sortable1 li { margin: 0; padding: 0;width: 100%;background-color:#fff;padding:0px 5px; }
</style>
<script>
$(function(){
    $( "#sortable1" ).sortable({
		update : function(event, ui) {
			var position = {};
			$(".positionWidjet").each(function(index){ position[index]=$( this ).val(); });
			$.ajax({type:'GET', url:"{{route('admin.pages.widjetreposition',$page->id)}}", dataType: "json", contentType: "application/json; charset=utf-8", data:{position : position, _token:$('meta[name="csrf-token"]').attr('content')}, success:function(data) {
				console.log("RePosition update: status OK >>> "+data);
			}, error:function(xhr, textStatus, errorThrown){console.log(xhr, textStatus, errorThrown);}});
		},	
		cancel: ".ui-state-disabled"
	});
    $( "#sortable1 li" ).disableSelection();
});
$(document).on("click", ".WidjetScreenAdd", function() {
	var id=generateUUID();
	var position=$(this).parent().find(".position").val();
	$(this).parent().find(".ListWidjets").html('<div class="bg-white text-center"><a href="javascript://" onClick="$(this).parent().parent().html(null)" class="text-danger">Отменить и свернуть</a><div id="'+id+'"></div></div>');
	$.ajax({type:'GET', url:"{{route('admin.pages.widjetlistajax',$page->id)}}", dataType: "json", contentType: "application/json; charset=utf-8", data:'position='+position+'&_token='+$('meta[name="csrf-token"]').attr('content'), success:function(data) {
		if(typeof data.html!=='undefined'){
			$("#"+id).html(data.html);
		}
    }, error:function(xhr, textStatus, errorThrown){console.log(xhr, textStatus, errorThrown);}});
	
});
</script>
@stop