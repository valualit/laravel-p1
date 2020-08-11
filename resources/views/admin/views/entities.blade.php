@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.entities')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<h3 class="card-title"></h3>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.entities.add')}}','modal-xl','bg-light', '{{__('Добавить сущность')}}')" class="btn btn-success btn-sm">{{__('Добавить сущность')}}</a>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.pages.add')}}','modal-xl','bg-light', '{{__('Добавить страницу')}}')" class="ml-1 btn btn-success btn-sm">{{__('Добавить страницу')}}</a>
						<div class="card-tools">
							<?php /* {{ $entities->links() }} */ ?>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
					<table class="table table-striped trhover">
						<thead>
							<tr>
								<!--th class="d-none d-sm-table-cell" style="width: 10px">ID</th-->
								<th style="width: 20px"></th>
								<th style="max-width: 300px">{{__('Название')}}</th>
								<!--th>{{__('URL')}}</th-->
							</tr>
						</thead>
						<tbody>
						@foreach ($entities as $keyEntitie=>$entitie)
						<tr>
							<!--td class="d-none d-sm-table-cell">{{$entitie->id}}.</td-->
							<td>
								<div class="btn-group">
									<a href="{{route('admin.entities.drop',$entitie->id)}}" id="userdrop{{$entitie->id}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="btn btn-tool zk-confirm dropdown-item" title="{{__('Удалить')}}"><i class="fas fa-trash"></i></a>
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.entities.edit',$entitie->id)}}','modal-xl','bg-light', '{{__('Редактировать')}}')" title="{{__('Редактировать')}}" class="btn btn-tool dropdown-item"><i class="fas fa-edit"></i></a>
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.entities.setting',$entitie->id)}}','modal-xl','bg-light', '{{__('Настройки')}}')" title="{{__('Настройки')}}" class="btn btn-tool" title="{{__('Настройки')}}"><i class="nav-icon fas fa-cog"></i></a>
									
									
									<a href="{{route('section.id',$entitie->url)}}" target="_blank" class="btn btn-tool"><i class="fa fa-link" aria-hidden="true" title="{{__('Перейти на сайт')}}"></i></a>
									
									<!--a href="{{route('admin.component.index',$entitie->id)}}" class="btn btn-tool text-success"><i class="fa fa-folder-open" aria-hidden="true" title="{{__('Контент')}}"></i></a-->
									
									<a href="{{route('admin.entities.userentities',$entitie->id,$entitie->id)}}" class="btn btn-tool" title="{{__('Дополнительные поля')}}"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
									
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.entities.widjetcodes',$entitie->id)}}','modal-xl','bg-light', '{{__('ВиджетКоды')}}')" title="{{__('ВиджетКоды')}}" class="btn btn-tool"><i class="fa fa-file-code" aria-hidden="true"></i></a> 
								</div>
							</td>
							<td><small>{{$entitie->parent>0&&isset($entities[$entitie->parent])?$entities[$entitie->parent]->name." / ":null}}</small><a href="{{route('admin.component.index',$entitie->id)}}"><b>{{$entitie->name}}</b></a><sub>раздел</sub></td>
							<!--td>[{{$entitie->url}}]</td-->
						</tr>
						@endforeach
						
						
						@foreach ($pages as $keyPage=>$page)
						<tr>
							<!--td class="d-none d-sm-table-cell">{{$page->id}}.</td-->
							<td>
								<div class="btn-group">
									<a href="{{route('admin.pages.drop',$page->id)}}" id="pagedrop{{$page->id}}" data-confirm-text="{{__('Подтвердите удаление')}}" title="{{__('Удалить')}}" class="btn btn-tool zk-confirm dropdown-item"><i class="fas fa-trash"></i></a>
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.pages.edit',$page->id)}}','modal-xl','bg-light', '{{__('Редактировать')}}')" title="{{__('Редактировать')}}" class="btn btn-tool dropdown-item"><i class="fas fa-edit"></i></a>
									<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.pages.edit',$page->id)}}','modal-xl','bg-light', '{{__('Настройки')}}')" title="{{__('Настройки')}}" class="btn btn-tool" title="{{__('Настройки')}}"><i class="nav-icon fas fa-cog"></i></a>
									<a href="{{route('page.web',$page->url)}}" target="_blank" class="btn btn-tool"><i class="fa fa-link" aria-hidden="true" title="{{__('Перейти на сайт')}}"></i></a>
									<!--a href="{{route('admin.pages.widjet',$page->id)}}" title="{{__('Виджеты')}}" class="btn btn-tool text-success"><i class="fa fa-tags" aria-hidden="true"></i></a-->
								</div>
							</td>
							<td><a href="{{route('admin.pages.widjet',$page->id)}}"><b>{{$page->name}}</b></a><sub>страница</sub></td>
							<!--td>[{{$page->url}}]</td-->
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