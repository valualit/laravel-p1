@extends('admin.index')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				{{Breadcrumbs::render('admin.settings')}}
			</div>
		</div><!-- /.container-fluid -->
    </section>
	
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">{{ __('Настройка главной страницы') }}</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form role="form" action="{{route('admin.settings.post')}}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="card-body">
								<div class="form-group">
									<label>{{ __('Короткое название проекта') }}</label>
									<input type="text" class="form-control" name="settings[app.name]" placeholder="1920" value="{{option('app.name','ZlatKit')}}">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">{{ __('Выберете главный раздел сайта') }}</label>
									<div class="form-group">
										<select class="form-control" name="settings[home-url]">
										  @foreach ($entities as $keyEntitie=>$entitie)
										  <option value="{{$keyEntitie}}"{{$entitie['selected']?' selected':null}}>{{$entitie['name']}}</option>
										  @endforeach
										  @foreach ($pages as $keyPage=>$page)
										  <option value="{{$keyPage}}"{{$page['selected']?' selected':null}}>{{$page['name']}}</option> 
										  @endforeach
										  <option value="0"{{option('home-url',false)===0?' selected':null}}>404 Error</option> 
										</select>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
							</div>
						</form>
					</div>
					<!-- /.card -->
				</div>
				<!--/.col (left) -->
				<!-- right column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">{{ __('Настройка загрузки изображений') }}</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form action="{{route('admin.settings.post')}}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('Максимальная ширина px') }}</label>
											<input type="text" class="form-control" name="settings[img-max-width]" placeholder="1920" value="{{option('img-max-width',1920)}}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('Максимальная высота px') }}</label>
											<input type="text" class="form-control" name="settings[img-max-height]" placeholder="1080" value="{{option('img-max-height',1080)}}">
										</div>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
							</div>
						</form>
					</div>
					<!-- /.card -->
				</div>
				<!--/.col (right) -->
				
				<!-- column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">{{ __('Настройка SMTP') }}</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						<form action="{{route('admin.settings.post')}}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('SMTP Host') }}</label>
											<input type="text" class="form-control" name="settings[smtp-host]" placeholder="smtp.yandex.ru" value="{{option('smtp-host','smtp.yandex.ru')}}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('SMTP port') }}</label>
											<input type="text" class="form-control" name="settings[smtp-port]" placeholder="587" value="{{option('smtp-port','587')}}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('SMTP username') }}</label>
											<input type="text" class="form-control" name="settings[smtp-username]" placeholder="user@yandex.ru" value="{{option('smtp-username','user@yandex.ru')}}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('SMTP password') }}</label>
											<input type="text" class="form-control" name="settings[smtp-password]" placeholder="SMTP password" value="{{option('smtp-password','')}}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('SMTP encryption') }}</label>
											<input type="text" class="form-control" name="settings[smtp-encryption]" placeholder="tls" value="{{option('smtp-encryption','tls')}}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>{{ __('SMTP test e-mail') }}</label>
											<input type="text" class="form-control" name="settings[smtp-test-email]" placeholder="tls" value="{{option('smtp-test-email','yanzlatov@gmail.com')}}">
										</div>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
								<button type="button" onClick="zk.open_dialog('ModalEditUser','{{route('admin.settings.smtptest')}}','/*modal-xl*/','bg-light', '{{ __('Тестовое письмо') }}')" class="ml-1 btn btn-warning">{{ __('Тестовое письмо') }}</button>
							</div>
						</form>
					</div>
					<!-- /.card -->
				</div>
				<!--/.col -->
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
    </section>
@stop