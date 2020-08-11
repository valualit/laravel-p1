@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.users.entities')}} 
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<a href="" class="btn btn-success btn-sm mr-1">{{__('Добавить поле')}}</a>
						<a href="javascript://" onClick="zk.open_dialog('ModalAddRole','{{route('admin.users.userentities.cat')}}','/*modal-xl*/','bg-light', '{{__('Список категорий')}}')" class="btn btn-info btn-sm mr-1">{{__('Список категорий')}}</a>
					
						<br /><br />
					
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#page-tab-entities">{{__('Список полей')}}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#page-tab-cat">{{__('Список категорий')}}</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="page-tab-entities">
								123
							</div>
							<div class="tab-pane fade" id="page-tab-cat">
								234
							</div>
						</div> 
					</div>
				</div>
			</div>
        <!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop