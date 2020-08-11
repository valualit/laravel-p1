@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.serm.sermupdate')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 card">
					<div class="card-header">
						<h3 class="card-title"></h3>
						<a href="{{route('admin.serm.sermupdate.project')}}" target="_blank" class="btn btn-success btn-sm m-3">{{__('Синхронизировать проекты')}}</a>
						<a href="{{route('admin.serm.sermupdate.pc')}}" target="_blank" class="btn btn-success btn-sm m-3">{{__('Синхронизировать поисковые системы и регионы')}}</a>
					</div>
					<!-- /.card-header -->
				<!-- /.card-body -->
				</div>
			</div>
        <!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop