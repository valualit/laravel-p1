@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.dashboard')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		Главная
	</section>
@stop