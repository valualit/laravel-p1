@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.serm')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<h3 class="card-title"></h3>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.serm.add')}}','','bg-light', '{{__('Добавить проект')}}')" class="btn btn-success btn-sm">{{__('Добавить проект')}}</a>
					</div>
					<!-- /.card-header -->
					<div class="card-body table-responsive p-0">
					<table class="table table-head-fixed text-nowrap">
						<thead>
							<tr>
								<th class="d-none d-sm-table-cell" style="width: 10px">#</th>
								<th style="width: 20px"></th>
								<th>{{__('Проект')}}</th>
								<th>{{__('URL')}}</th>
								<th>{{__('Администратор')}}</th>
							</tr>
						</thead>
						<tbody>
						@foreach ($projects as $indexKay=>$project)
						<tr>
							<td class="d-none d-sm-table-cell">{{$indexKay+1}}.</td>
							<td>
								<div class="btn-group">
									<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fas fa-edit"></i>
									</button>
									<div class="dropdown-menu dropdown-menu-left" role="menu" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(46px, 19px, 0px);">
										<a href="javascript://" class="dropdown-item">{{__('Редактировать')}}</a>
										<a href="#" id="userdrop{{$project->id}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="zk-confirm dropdown-item">{{__('Удалить')}}</a>
									</div>
								</div>
							</td>
							<td><a href=""><b>{{$project->name}}</b></a></td>
							<td>{{$project->url}}</td>
							<td>{{$project->userInfo->name}}</td>
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