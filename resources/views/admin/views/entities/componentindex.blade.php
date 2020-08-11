@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.component.index',$Component->id,$Component->name)}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<h3 class="card-title"></h3>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{$BtnItemAdd}}','modal-xl','bg-light', '{{__('Добавить пользователя')}}')" class="btn btn-success btn-sm">{{__('Добавить')}}</a>
						<a href="{{route('admin.entities')}}" class="ml-1 btn btn-warning btn-sm mr-1">{{__('Список сущностей')}}</a>
						<div class="card-tools">
							{{ $items->links() }}
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
					<table class="table table-head-fixed text-nowrap">
						<thead>
							<tr>
								<th class="d-none d-sm-table-cell" style="width: 10px">#</th>
								<th style="width: 20px"></th>
								@foreach ($ComponentSettings['admin-table'] as $keyRow=>$row)
								<th>{{$row=='name'?($ComponentSettings['namerow']??'Заголовок'):$WidjetCode[$row]['name']}}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
						@foreach ($items as $keyEntitie=>$item)
						<tr>
							<td class="d-none d-sm-table-cell">{{$item->id}}.</td>
							<td>
								<div class="btn-group">
									<a href="{{route('admin.component.item.drop',[$section, $item->id])}}" id="itemdrop{{$item->id}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="btn btn-tool zk-confirm dropdown-item" title="{{__('Удалить')}}"><i class="fas fa-trash"></i></a>
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.component.item.edit',[$section, $item->id])}}','modal-xl','bg-light', '{{__('Редактировать')}}')" title="{{__('Редактировать')}}" class="btn btn-tool dropdown-item"><i class="fas fa-edit"></i></a>
									<a href="{{route('section.item',[$Component->url,$item->id,Str::slug($item->name, '-')])}}" class="btn btn-tool" target="blank"><i class="fas fa-link"></i></a>
									<a href="{{route('admin.component.item.view',[$section, $item->id])}}" class="btn btn-tool" target="_blank"><i class="fa fa-address-card" aria-hidden="true"></i></a>
									
								</div>
							</td>
							@foreach ($ComponentSettings['admin-table'] as $keyRow=>$row)
								<td>{{isset($WidjetCode[$row]['id'])&&is_int($WidjetCode[$row]['id'])?(json_decode($item->info,true)[$WidjetCode[$row]['id']]['text']??null):$item->{$WidjetCode[$row]['id']} }}</td>
							@endforeach
						</tr>
						@endforeach
						</tbody>
					</table>
					</div>
				<!-- /.card-body -->
				</div>
			</div>
        <!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop