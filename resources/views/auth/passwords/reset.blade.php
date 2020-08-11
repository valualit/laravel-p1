@extends('auth/template')

@section('content')
<form method="POST" action="{{ route('password.update') }}" class="login100-form validate-form">
	@csrf
    <input type="hidden" name="token" value="{{ $token }}">
	<span class="login100-form-title p-b-29">
		@php
			echo file_exists(base_path().'/favicon/favicon-32x32.png')?'<img src="/favicon/favicon-32x32.png" width="32" height="32" alt="'.config('app.name', 'ZlatKit').'" /> ':null
		@endphp
		{{ __('Сброс пароля') }}
	</span>

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
	
	<div class="wrap-input100 validate-input" data-validate='{{ __('Поле "Пароль" обязательное для ввода') }}'>
		<span class="label-input100">{{ __('Новый пароль') }}</span>
		<input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Введите Ваш новый пароль') }}">
		<span class="focus-input100" data-symbol="&#xf190;"></span>
	</div>
	@error('password')
	<div class="wrap-input100 mb-4">
           <span class="text-danger" role="alert"><strong>{{ $message }}</strong></span> 
	</div>
    @enderror 
	
	<div class="wrap-input100 validate-input" data-validate='{{ __('Поле "Пароль" обязательное для ввода') }}'>
		<span class="label-input100">{{ __('Повторите новый пароль') }}</span>
		<input id="password_confirmation" type="password" class="input100" autocomplete="new-password"  name="password_confirmation" required placeholder="{{ __('Повторите Ваш новый пароль') }}">
		<span class="focus-input100" data-symbol="&#xf190;"></span> 
	</div>

	<div class="p-b-31"></div>

	<div class="container-login100-form-btn">
		<div class="wrap-login100-form-btn">
			<div class="login100-form-bgbtn"></div>
			<button type="submit" class="login100-form-btn">
				{{ __('Сохранить новый пароль') }}
			</button>
		</div>
	</div>

	<div class="flex-col-c mt-4">
		<a href="/" class="txt2">{{ config('app.name', 'ZlatKit') }}</a>
	</div>
</form> 
@endsection
