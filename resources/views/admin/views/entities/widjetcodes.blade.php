<table class="table table-head-fixed text-nowrap">
	<thead>
		<tr>
			<th class="d-none d-sm-table-cell" style="width: 10px">ID</th>
			<th style="width: 20px">{{__('Название')}}</th>
			<th>{{__('WidjetForm')}}</th>
			<th>{{__('Код поля')}}</th>
		</tr>
	</thead>
	<tbody>
	@foreach ($list as $key=>$item)
		<tr>
			<td class="d-none d-sm-table-cell">{{$item['id']}}</td>
			<td><b>{{$key=='name'?($ComponentSettings['namerow']??'Заголовок'):$item['name']}}</b></td>
			<td><input type="text" value="{{$item['code']}}" class="form-control form-control-sm" /></td>
			<td><input type="text" value="{{$item['codeform']}}" class="form-control form-control-sm" /></td>
		</tr>
	@endforeach
	</tbody>
</table>
<hr />
<h3>Helper</h3>
<b><span class="text-danger">code-Поля</span>:Назание-поля-для-пользователя:<span class="text-danger">необязательное-поле-тип-поля-нужен-для-автозаполнения</span></b><br />
<h3>Примеры</h3>
<b>name:Введите свое имя:</b><br />
<p><u>name</u> - код поля<br />
<u>Введите свое имя</u> - текст поля который видет пользователь<br />
: - после двоеточия нет параметра, означает что пользователь будет вводить данные самостоятельно</p>
<br />
<b>created_at:можно не вводить:datetime</b><br />
<p><u>created_at</u> - код поля<br />
<u>можно не вводить</u> - название поль можно не выводить, третий параметр datetime указывает, что заполнится поле самостоятельно в нужном формате<br />
<u>datetime</u> - заполняет поле текущей датой в стиле 2020-06-27 19:27:03 - поле не доступно пользователю</p>
<u>default</u> - заполняет поле вторым параметром, само поле не отображается пользователю</p>

<h3>Список 3-их параметров</h3>
<p>
<u>datetime</u> - дата в стиле 2020-06-27 19:27:03<br />
<u>ip</u> - ip адрес пользователя заполняющего форму<br />
</p>