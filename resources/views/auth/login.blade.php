@extends('auth/template')

@section('content')
<form method="POST" action="{{ route('login') }}" class="login100-form validate-form">
	@csrf
	<span class="login100-form-title p-b-29">
		@php
			echo file_exists(base_path().'/favicon/favicon-32x32.png')?'<img src="/favicon/favicon-32x32.png" alt="'.config('app.name', 'ZlatKit').'" /> ':null
		@endphp
		{{ __('Вход на сайт') }}
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
		<span class="label-input100">{{ __('Пароль') }}</span>
		<input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Введите Ваш пароль') }}">
		<span class="focus-input100" data-symbol="&#xf190;"></span>
	</div>


	<div class="row p-t-8 p-b-31">
		
		<div class="col-12 col-md-6 pt-2 text-center">
			<input class="" type="checkbox" checked name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
			<label class="ml-2" for="remember">
				{{ __('Запомнить меня') }}
			</label>
		</div>
		<div class="col-12 col-md-6 text-center">
			@if (Route::has('password.request'))
				<a class="btn btn-link" href="{{ route('password.request') }}">
					{{ __('Забыли пароль?') }}
				</a>
			@endif
		</div>
	</div>

	<div class="container-login100-form-btn">
		<div class="wrap-login100-form-btn">
			<div class="login100-form-bgbtn"></div>
			<button type="submit" class="login100-form-btn">
				{{ __('ВОЙТИ') }}
			</button>
		</div>
	</div>

	<div class="flex-col-c mt-4">
		<span class="txt1 p-b-17">
			<a href="{{ route('register') }}">{{ __('Регистрация') }}</a>
		</span>

		<a href="/" class="txt2">{{ config('app.name', 'ZlatKit') }}</a>
	</div>
</form> 
@endsection		
