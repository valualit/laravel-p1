@extends('auth/template')

@section('content')
<form method="POST" action="{{ route('password.email') }}" class="login100-form validate-form">
	@csrf
	<span class="login100-form-title p-b-29">
		@php
			echo file_exists(base_path().'/favicon/favicon-32x32.png')?'<img src="/favicon/favicon-32x32.png" width="32" height="32" alt="'.config('app.name', 'ZlatKit').'" /> ':null
		@endphp
		{{ __('Восстановление доступа') }}
	</span>
	
	@if (session('status'))
	<div class="wrap-input100 mb-4">
           <span class="text-danger" role="alert"><strong>{{ session('status') }}</strong></span> 
	</div>
    @endif

	<div class="wrap-input100 validate-input m-b-23" data-validate='{{ __('Поле "E-Mail" обязательное для ввода') }}'>
		<span class="label-input100">E-Mail</span>
		<input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Введите Ваш E-Mail') }}">
		<span class="focus-input100" data-symbol="&#xf206;"></span>
	</div>
	@error('email')
	<div class="wrap-input100 mb-4">
           <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span> 
	</div>
    @enderror 

	<div class="p-b-31"></div>

	<div class="container-login100-form-btn">
		<div class="wrap-login100-form-btn">
			<div class="login100-form-bgbtn"></div>
			<button type="submit" class="login100-form-btn">
				{{ __('Отправить ссылку для восстановления пароля') }}
			</button>
		</div>
	</div>

	<div class="flex-col-c mt-4">
		<span class="txt1 p-b-17">
			<a href="{{ route('login') }}">{{ __('Я помню пароль, войти на сайт') }}</a>
		</span>

		<a href="/" class="txt2">{{ config('app.name', 'ZlatKit') }}</a>
	</div>
</form> 
@endsection
