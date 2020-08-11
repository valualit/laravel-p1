@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.users')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<h3 class="card-title"></h3>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.users.add')}}','modal-xl','bg-light', '{{__('Добавить пользователя')}}')" class="btn btn-success btn-sm">{{__('Добавить пользователя')}}</a>
						<div class="card-tools">
							{{ $users->links() }}
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
					<table class="table table-head-fixed text-nowrap">
						<thead>
							<tr>
								<th class="d-none d-sm-table-cell" style="width: 10px">#</th>
								<th style="width: 20px"></th>
								<th>{{__('Имя')}}</th>
								<th>{{__('E-Mail')}}</th>
								<th>{{__('Телефон')}}</th>
								<th>{{__('Роль')}}</th>
								<th>{{__('Зарегистрирован')}}</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($users as $indexKay=>$user)
						<tr>
							<td class="d-none d-sm-table-cell">{{$indexKay+1}}.</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fas fa-edit"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-left" role="menu" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(46px, 19px, 0px);">
										<a href="javascript://" onClick="zk.open_dialog('ModalEditUser','{{route('admin.users.edit',$user->id)}}','modal-xl','bg-light', '{{__('Редактировать')}}')" class="dropdown-item">{{__('Редактировать')}}</a>
										<a href="{{route('admin.users.drop',$user->id)}}" id="userdrop{{$user->id}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="zk-confirm dropdown-item">{{__('Удалить')}}</a>
									</div>
								</div>
							</td>
							<td><a href=""><b>{{$user->name}}</b></a></td>
							<td>{{$user->email}}</td>
							<td>{{$user->phone}}</td>
							<td>{{$roles[$user->roles]['name']}}</td>
							<td>{{$user->created_at}}</td>
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