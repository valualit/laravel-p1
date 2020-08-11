@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.component.item.view',$Component->id,$Component->name,$item->id)}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="mb-3">
					<a href="{{route('admin.component.item.drop',[$Component->id, $item->id])}}" id="itemdrop{{$item->id}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="btn btn-warning btn-sm mr-1">{{__('Удалить')}}</a>
					<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.component.item.edit',[$Component->id, $item->id])}}','modal-xl','bg-light', '{{__('Редактировать')}}')" class="ml-1 btn btn-success btn-sm mr-1">{{__('Редактировать')}}</a>
					<a href="{{route('section.item',[$Component->url,$item->id,Str::slug($item->name, '-')])}}" target="_blank" class="ml-1 btn btn-primary btn-sm mr-1">{{__('На сайт')}}</a>
				</div>
				@if(isset($ComponentSettings['formatview'])&&$ComponentSettings['formatview']=="table")
				<div class="card col-12">
				<table class="table table-head-fixed">
					<tbody>
					@foreach ($ComponentSettings['admin-table'] as $keyRow=>$row)
					<tr>
					<td class="text-success">{{$row=='name'?($ComponentSettings['namerow']??'Заголовок'):$WidjetCode[$row]['name']}}</td>
					<td>{{isset($WidjetCode[$row]['id'])&&is_int($WidjetCode[$row]['id'])?(json_decode($item->info,true)[$WidjetCode[$row]['id']]['text']??null):$item->{$WidjetCode[$row]['id']} }}</td>
					</tr>
					@endforeach
					
					@foreach ($WidjetCode as $keyWidjetCode=>$code) @if(!isset($ComponentSettings['admin-table'])||!in_array($keyWidjetCode, $ComponentSettings['admin-table']))<tr>
					<td class="text-success">{{$code['name']}}</td>
					<td>{!!isset($code['id'])&&is_int($code['id'])?(json_decode($item->info,true)[$code['id']]['text']??null):$item->{$code['id']} !!}</td>
					</tr>
					@endif @endforeach
					</tbody> 
				</table>
				</div>
				@else
				<div class="card-body card p-3">
					<h1>{{$item->name??null}}</h1>
					{!!$item->text!!}
				</div>
				@endif
			</div>
        <!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop