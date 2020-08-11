@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render($breadcrumbs,$breadcrumbsSection,$breadcrumbsName)}}   
			</div>
		</div><!-- /.container-fluid -->
    </section> 
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{$button['btn-add']}}','/*modal-xl*/','bg-light', '{{__('Добавить поле')}}')" class="btn btn-info btn-sm mr-1">{{__('Добавить поле')}}</a>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{$button['btn-catadd']}}','/*modal-xl*/','bg-light', '{{__('Добавить категорию')}}')" class="btn btn-info btn-sm mr-1">{{__('Добавить категорию')}}</a>
						
						@if(isset($button['btn-content']))	
						<a href="{{$button['btn-content']}}" class="btn btn-success btn-sm mr-1">{{__('Контент')}}</a>
						@endif
						@if(isset($button['btn-list-section']))	
						<a href="{{$button['btn-list-section']}}" class="btn btn-warning btn-sm mr-1">{{__('Список сущностей')}}</a>
						@endif
					
						<br /><br />
					
						<table class="table table-head-fixed text-nowrap">
							<thead>
								<tr>
									<th class="d-none d-sm-table-cell" style="width: 10px">#</th>
									<th style="width: 20px"></th>
									<th>{{__('Категория')}}</th>
									<th>{{__('Поле')}}</th>
									<th>{{__('Тип')}}</th>
									<th>{{__('Обязательное')}}</th>
									<th>{{__('Заголовок')}}</th>
								</tr>
							</thead>
							<tbody>
							@foreach ($List as $indexKay=>$Item)
							<tr{{$Item['cat']?' class=table-secondary':null}}>
								<td class="d-none d-sm-table-cell">.</td>
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<i class="fas fa-edit"></i>
										</button>
										<div class="dropdown-menu dropdown-menu-left" role="menu" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(46px, 19px, 0px);">
											<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{$Item['edit']}}','/*modal-xl*/','bg-light', 'Переименовать')" class="dropdown-item">{{$Item['cat']==0?__('Редактировать'):__('Переименовать')}}</a>
											<a href="{{$Item['delete']}}" data-confirm-text="{{__('Подтвердите удаление')}}" class="zk-confirm dropdown-item">{{__('Удалить')}}</a>  
										</div>
									</div>
								</td>
								<td><a href=""><b>{{$Item['name']}}</b></a> <small>  {{$Item['cat']?'(id: '.$Item['id'].')':null}}</small></td>
								@if($Item['cat']==1) 
								<td class="text-danger">категория</td> 
								@else
								<td>{{$Item['entitie_name']}}</td>
								@endif
								<td>{{$Item['entitie_type']}}</td>
								<td>@if($Item['cat']==0) @if($Item['entitie_required']==1) <span class="btn bg-gradient-success btn-xs pl-2 pr-2 pt-0 pm-0">&nbsp;Да&nbsp;&nbsp;</span> @else <span class="btn bg-gradient-secondary btn-xs pl-2 pr-2 pt-0 pm-0">Нет</span> @endif @endif</td>
								<td>@if($Item['cat']==0) @if($Item['entitie_main']==1) <span class="btn bg-gradient-success btn-xs pl-2 pr-2 pt-0 pm-0">&nbsp;Да&nbsp;&nbsp;</span> @else <a href="{{route('admin.users.userentities.catdelete',$Item['id'])}}" class="btn bg-gradient-secondary btn-xs pl-2 pr-2 pt-0 pm-0">Нет</a> @endif @endif</td> 
							</tr>   
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
        <!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop