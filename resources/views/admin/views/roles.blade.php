@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.users.roles')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<h3 class="card-title"></h3>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.roles.formaddrole')}}','/*modal-xl*/','bg-light', 'Добавить новую роль')" class="btn btn-success btn-sm">{{__('Добавить роль')}}</a>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
					<table class="table table-head-fixed text-nowrap">
						<thead>
							<tr>
								<th class="d-none d-sm-table-cell" style="width: 10px">#</th>
								<th style="width: 20px"></th>
								<th>{{__('Роль')}}</th>
								<th style="width: 40px">{{__('По умолчанию')}}</th>
								<th class="d-none d-sm-table-cell"></th>
							</tr>
						</thead>
						<tbody>
						@foreach ($roles as $indexKay=>$role)
						<tr>
							<td class="d-none d-sm-table-cell">{{$indexKay+1}}.</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fas fa-edit"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-left" role="menu" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(46px, 19px, 0px);">
										<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.roles.formeditpermissionrole',$role->id)}}','/*modal-xl*/','bg-light', 'Переименовать роль')" class="dropdown-item">{{__('Управление правами')}}</a>
										<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.roles.formeditrole',$role->id)}}','/*modal-xl*/','bg-light', 'Переименовать роль')" class="dropdown-item">{{__('Переименовать')}}</a>
										@if($role->id>4)
										<a href="{{route('admin.roles.droprole',$role->id)}}" data-confirm-text="{{__('Подтвердите удаление роли')}}" class="zk-confirm dropdown-item">{{__('Удалить')}}</a>  
										@endif
									</div>
								</div>
							</td>
							<td><a href=""><b>{{$role->name}}</b></a> <small> (id: {{$role->id}})</small></td>
							<td>@if($role->default==1) <span class="btn bg-gradient-success btn-xs pl-2 pr-2 pt-0 pm-0">&nbsp;Да&nbsp;&nbsp;</span> @else <a href="{{route('admin.roles.setdefault',$role->id)}}" class="btn bg-gradient-secondary btn-xs pl-2 pr-2 pt-0 pm-0">Нет</a> @endif</td>
							<td class="d-none d-sm-table-cell"><a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.roles.formeditpermissionrole',$role->id)}}','/*modal-xl*/','bg-light', 'Переименовать роль')"><small>{{__('Права доступа')}} {{__('группы')}}</small></a></td> 
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