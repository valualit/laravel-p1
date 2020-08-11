<?php
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::url(), $route) ? ' active' : '';
    }
    return Request::url() == $route ? ' active' : '';
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{$title??null}}</title>
<meta property="og:title" content="{{$title??null}}" />
<meta name="twitter:title" content="{{$title??null}}" />
@if(isset($description))
<meta name="description" content="{{$description??null}}" />
<meta property="og:description" content="{{$description??null}}" />
<meta name="twitter:description" content="{{$description??null}}"/>
@endif
@if(isset($keywords))
<meta name="keywords" content="{{$keywords??null}}" />
@endif
@if(isset($canonical))
<link rel="canonical" href="{{$canonical??null}}" /> 
<meta property="og:url" content="{{$canonical??null}}" /> 
@endif
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{csrf_token()}}" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
@if(file_exists($templatePath."css/style.css"))
<link rel="stylesheet" href="{{$templateURL}}css/style.css">
@endif
@if(file_exists($templatePath."css/toast.css"))
<link rel="stylesheet" href="{{$templateURL}}css/toast.css">
@endif
@yield('header')
<meta name="generator" content="ZlatKit.1.0" />
</head>
<body class="">
<header class="container">
	<div class="container-fluid" id="header-navbar">
		<div class="row">
			<div class="col-sm-8">
				<nav class="navbar navbar-expand-lg">
					<div class="container">
						<a class="navbar-brand" href="/"><img src="#" alt="ACE PRO" /></a>
						<a class="d-inline-block d-sm-none textlogomobile" href="#"><strong>ZlatKit</strong></a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="fa fa-bars"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav mr-auto">
								<li class="nav-item{{set_active(route('page.web','/'))}}">
									<a class="nav-link" href="{{route('page.web','/')}}">Home</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div class="col-sm-4 text-sm-right d-none d-sm-block"> 
				<div class="row mt-3">
					<div class="col-6 text-sm-right pt-1">
						<span class="header-phone"><i class="las la-phone"></i> +79787505392</span>
					</div>
					<div class="col-6">
						<div class="contactlink">
							<a href="" target="_blank" title="НАПИШИТЕ НАМ WhatsUp" class="btn btn-primary mt-1">НАПИШИТЕ НАМ <span><i class="lab la-whatsapp"></i></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<main role="main" class="container">
@yield('content')
</main>
<!-- Footer -->
<footer class="container page-footer font-small blue pt-4">
	<div class="container-fluid text-center text-sm-left">
		<div class="row">
			<div class="col-sm-3 mt-sm-0 mt-3 footer-logo">
				<img src="{{$templateURL}}img/logotitle.png" alt="ACE PRO" />
				<b>Copyright © {{date("Y")}}</b>
			</div>
			<div class="col-sm-7 sm-sm-0 mt-sm-3">
				<ul class="list-unstyled">
					<li><a href="{{route('page.web','publichnaja-oferta')}}">Публичная оферта</a></li>
				</ul>
			</div>
			<div class="col-sm-2 mb-sm-0 mb-3 mt-sm-3 dateyear text-sm-right">
			
				<a href="#" target="_blank"><i class="lab la-facebook-square"></i></a>
				<a href="#" target="_blank><i class="lab la-instagram"></i></a>
				<a href="#" target="_blank"><i class="lab la-vk"></i></a>
				
			</div>
		</div>
	</div>
</footer>
<!-- Footer -->
<script src="{{ asset('/resources/views/admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/resources/views/admin/plugins/toastr/toastr.min.js') }}"></script> 
<script src="{{ asset('/resources/views/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script> 
<script src="{{ asset('/resources/js/zk.js') }}"></script>
@if(file_exists($templatePath."js/script.js"))
<script src="{{$templateURL}}js/script.js"></script>
@endif
@if(file_exists($templatePath."js/toast.js"))
<script src="{{$templateURL}}js/toast.js"></script>
@endif
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
</script>
@endif
</body>
</html>
