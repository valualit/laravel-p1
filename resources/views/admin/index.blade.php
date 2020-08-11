<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$title??null}}</title>
  <meta name="description" content="{{$description??null}}" />
  <meta name="keywords" content="{{$keywords??null}}" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/dist/css/style.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('/resources/views/admin/plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  @yield('header')
</head>
<body class="hold-transition sidebar-mini layout-fixed text-sm">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
        </a>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
        </a>
      </li>
      <!-- Home link -->
      <li class="nav-item dropdown">
        <a class="nav-link" target="_blank" href="/">
          <i class="fa fa-home"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
		@php
			echo file_exists(base_path().'/favicon/favicon-32x32.png')?'<img src="/favicon/favicon-32x32.png" alt="'.config('app.name', 'ZlatKit').'" class="brand-image img-circle elevation-3"
           style="opacity: .8" /> ':null;
		@endphp
		<span class="brand-text font-weight-light">ZlatKit 1.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
			<!--li class="nav-item">
				<a href="{{ route('admin.pages') }}" class="nav-link{{(url()->current()==route('admin.pages')?' active':null)}}"> 
					<i class="nav-icon fas fa-file-alt"></i>
					<p>
						{{ __('Страницы') }}
					</p>
				</a>
			</li-->
			<li class="nav-item has-treeview {{ (isset($NavItemActive)&&$NavItemActive=='serm'?' menu-open':null) }}">
				<a href="{{route('admin.serm')}}" class="nav-link{{ (isset($NavItemActive)&&$NavItemActive=='serm'?' active':null) }}">
					<i class="nav-icon fas fa-award"></i>
					<p>
						{{ __('SERM') }}
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{route('admin.serm')}}" class="nav-link">
							<i class="fas fa-award nav-icon"></i>
							<p>{{ __('SERM') }}</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{route('admin.serm.sermupdate')}}" class="nav-link">
							<i class="fas fa-download nav-icon"></i>
							<p>{{ __('Синхронизация') }}</p>
						</a>
					</li>
				</ul>
			</li>
			@foreach ($admin_section_munu as $keySectionItem=>$SectionItem)
			<li class="nav-item{{count($SectionItem['items'])>0?' has-treeview':null}}">
				<a href="{{$SectionItem['url']}}" class="nav-link">
					<i class="nav-icon fas {{$SectionItem['icon']}}"></i>
					<p>
						{{$SectionItem['name']}}
						@if(count($SectionItem['items'])>0)
						<i class="right fas fa-angle-left"></i>
						@endif
					</p>
				</a>
				@if(count($SectionItem['items'])>0)
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{$SectionItem['url']}}" class="nav-link">
							<i class="fa {{$SectionItem['icon']}} nav-icon"></i>
							<p>{{$SectionItem['name']}}</p>
						</a>
					</li>
					@foreach ($SectionItem['items'] as $keySectionItem2=>$SectionItem2)
					<li class="nav-item">
						<a href="{{$SectionItem2['url']}}" class="nav-link">
							<i class="fa {{$SectionItem2['icon']}} nav-icon"></i>
							<p>{{$SectionItem2['name']}}</p>
						</a>
					</li>
					@endforeach
				</ul>
				@endif
			</li>
			@endforeach
			
			<li class="nav-item has-treeview {{ (isset($NavItemActive)&&$NavItemActive=='users'?' menu-open':null) }}">
				<a href="{{route('admin.users')}}" class="nav-link{{ (isset($NavItemActive)&&$NavItemActive=='users'?' active':null) }}">
					<i class="nav-icon fas fa-users"></i>
					<p>
						{{ __('Пользователи') }}
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{route('admin.users')}}" class="nav-link{{(url()->current()==route('admin.users')?' active':null)}}">
							<i class="fa fa-users nav-icon"></i>
							<p>{{ __('Список') }}</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{route('admin.roles')}}" class="nav-link{{(url()->current()==route('admin.roles')?' active':null)}}">
							<i class="fa fa-users-cog nav-icon"></i>
							<p>{{ __('Роли') }}</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{route('admin.users.userentities')}}" class="nav-link{{(url()->current()==route('admin.users.userentities')?' active':null)}}">
							<i class="fa fa-users-cog nav-icon"></i>
							<p>{{ __('Конфигурация полей') }}</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item{{ (isset($NavItemActive)&&$NavItemActive=='entities'?' menu-open':null) }}">
				<a href="{{route('admin.entities')}}" class="nav-link{{(url()->current()==route('admin.entities')?' active':null)}}">
					<i class="nav-icon fa fa-bars"></i>
					<p>{{ __('Разделы сайта') }}</p>
				</a>
			</li>
			<li class="nav-item has-treeview{{ (isset($NavItemActive)&&$NavItemActive=='views'?' menu-open':null) }}"> 
				<a href="{{route('admin.templates')}}" class="nav-link{{ (isset($NavItemActive)&&$NavItemActive=='views'?' active':null) }}">
					<i class="nav-icon fa fa-paint-brush"></i>
					<p>
						{{ __('Внешний вид') }}
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview">
					<!--li class="nav-item">
						<a href="{{route('admin.templates')}}" class="nav-link{{(url()->current()==route('admin.templates')?' active':null)}}">
							<i class="fa fa-newspaper nav-icon"></i>
							<p>{{ __('Шаблоны') }}</p>
						</a>
					</li-->
					<!--li class="nav-item">
						<a href="{{route('admin.widjets')}}" class="nav-link{{(url()->current()==route('admin.widjets')?' active':null)}}">
							<i class="fa fa-shapes nav-icon"></i>
							<p>{{ __('Виджеты') }}</p>
						</a>
					</li-->
					<li class="nav-item">
						<a href="{{route('admin.menu')}}" class="nav-link{{(url()->current()==route('admin.menu')?' active':null)}}">
							<i class="fa fa-bars nav-icon"></i>
							<p>{{ __('Меню') }}</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item has-treeview {{ (isset($NavItemActive)&&$NavItemActive=='settings'?' menu-open':null) }}">
				<a href="{{route('admin.settings')}}" class="nav-link{{(url()->current()==route('admin.settings')?' active':null)}}">
					<i class="nav-icon fas fa-cogs"></i>
					<p>{{ __('Настройки') }}</p>
					<i class="right fas fa-angle-left"></i>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{route('admin.settings')}}" class="nav-link{{(url()->current()==route('admin.settings')?' active':null)}}">
							<i class="fa fa-users nav-icon"></i>
							<p>{{ __('Общие') }}</p>
						</a>
					</li>
				</ul>
			</li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<!-- Content -->
		@yield('content') 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <a href="#">zlatkit</a>.</strong>
    All rights reserved. 
	<span class="ml-3">{{ round(microtime(true) - LARAVEL_START, 5) }} sec</span>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/resources/views/admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/resources/views/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/resources/views/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/resources/views/admin/plugins/chart.js/Chart.min.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('/resources/views/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/resources/views/admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/resources/views/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('/resources/views/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/summernote/lang/summernote-ru-RU.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/resources/views/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/resources/views/admin/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/resources/views/admin/dist/js/demo.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/resources/js/zk.js') }}"></script>
<script src="{{ asset('/resources/js/synctranslit.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@yield('footer-js') 
@if(Session::has('toasts'))
<script>
$( document ).ready(function() {
	@foreach (Session::pull('toasts') as $toast)
		$(document).Toasts('create', {
			class: '{{$toast['class']}}', 
			title: '{{$toast['title']}}', 
			subtitle: '{{$toast['subtitle']}}', 
			body: '{{$toast['body']}}'});
	@endforeach
});
$(document).ready(function (){bsCustomFileInput.init();});
</script>
@endif
</body>
</html>
