{{ csrf_field() }}
<div class="form-group">
    <label for="name">{{ __('Название поля') }}</label>
    <input type="text" class="form-control" id="name" name="entities[name]" placeholder="{{ __('Введите название поля') }}" value="{{$Field->name}}" /> 
</div> 
<div class="form-group">
    <label for="title">{{ __('Краткий заголовок') }}</label>
    <input type="text" class="form-control" id="title" name="entities[title]" placeholder="{{ __('Краткий заголовок') }}"  value="{{$Field->title}}" />
</div> 
<div class="form-group">
    <label for="type">{{ __('Тип поля') }}</label>
    <select class="form-control" id="type" name="entities[type]">
		@foreach ($TypesList as $typeID=>$type)
		<option value="{{$typeID}}"{{$Field->type==$typeID?' selected':null}}>{{$type['name']}}</option>
		@endforeach
	</select>
</div>    
<div class="form-group">
    <label for="default">{{ __('Значение по умолчанию') }}</label>
    <textarea class="form-control" id="default" name="entities[default]" placeholder="{{ __('Значение по умолчанию') }}">{{$Field->default}}</textarea> 
</div> 
<div class="form-group">
    <label for="error">{{ __('Сообщение об ошибке') }}</label>
    <input type="text" class="form-control" id="error" name="entities[error]" placeholder="{{ __('Сообщение об ошибке') }}" value="{{$Field->error}}" />
</div>
<div class="form-group">
    <label for="required">{{ __('Обязательное поле для заполнения') }}</label>
    <select class="form-control" id="required" name="entities[required]">
		<option value="0"{{$Field->required==0?' selected':null}}>Нет</option>
		<option value="1"{{$Field->required==1?' selected':null}}>Да</option>
	</select>
</div>
<div class="form-group">
    <label for="main">{{ __('Использовать как заголовок страницы') }}</label>
    <select class="form-control" id="main" name="entities[main]">
		<option value="0"{{$Field->main==0?' selected':null}}>Нет</option>
		<option value="1"{{$Field->main==1?' selected':null}}>Да</option>
	</select>
</div>

<div class="form-group">
    <label for="cat">{{ __('Поле для категории') }}</label>
    <select class="form-control" id="cat" name="entities[cat]">
		<option value="0"{{$Field->cat==0?' selected':null}}>Основная</option>
		@foreach ($CatList as $indexKay=>$cat)
		<option value="{{$cat->id}}"{{$Field->cat==$cat->id?' selected':null}}>{{$cat->name}}</option> 
		@endforeach
	</select>
</div> 