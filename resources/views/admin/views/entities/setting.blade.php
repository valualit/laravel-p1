{{ csrf_field() }}
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="default-tab" data-toggle="tab" href="#default" role="tab" aria-controls="default" aria-selected="true">{{ __('Основные') }}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="roles-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles" aria-selected="true">{{ __('Права доступа') }}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="admin-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="admin" aria-selected="true">{{ __('Админка') }}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="widjet-tab" data-toggle="tab" href="#widjet" role="tab" aria-controls="widjet" aria-selected="true">{{ __('Виджеты') }}</a>
	</li>
</ul>
<div class="tab-content" id="myTabContent">

	<div class="tab-pane fade show active" id="default" role="tabpanel" aria-labelledby="default-tab">
		<div class="form-group">
			<label for="template-index">{{ __('Шаблон вывода категории') }}</label>
			<select class="form-control" id="template-cat" name="settings[template-cat]">
				@foreach ($sections as $keySection=>$section)
				<option value="{{$section}}"{{isset($ComponentSettings['template-cat'])&&$ComponentSettings['template-cat']==$section?' selected':null}}>{{$section}}</option>
				@endforeach
			</select>
		</div> 
		<div class="form-group">
			<label for="template-tree">{{ __('Шаблон вывода записи') }}</label>
			<select class="form-control" id="template-post" name="settings[template-post]">
				@foreach ($pages as $keyPost=>$post)
				<option value="{{$post}}"{{isset($ComponentSettings['template-post'])&&$ComponentSettings['template-post']==$post?' selected':null}}>{{$post}}</option>
				@endforeach
			</select>
		</div> 
		<div class="form-group">
			<label for="template-index">{{ __('Видимость в поисковых системах') }}</label>
			<select class="form-control" id="template-index" name="settings[robots]">
				<option value="index, follow"{{isset($ComponentSettings['robots'])&&$ComponentSettings['robots']=="index, follow"?' selected':null}}>index, follow</option>
				<option value="noindex, follow"{{isset($ComponentSettings['robots'])&&$ComponentSettings['robots']=="noindex, follow"?' selected':null}}>noindex, follow</option>
			</select>
		</div> 
		
		<div class="form-group">
			<label for="title">{{ __('Title страницы') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="title" name="settings[title]" placeholder="[name]" value="{{$ComponentSettings['title']??'[name]'}}" />
			</div>		
		</div> 
		<div class="form-group">
			<label for="description">{{ __('Description страницы') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="description" name="settings[description]" placeholder="[name]" value="{{$ComponentSettings['description']??'[name]'}}" />
			</div>		
		</div> 
		<div class="form-group">
			<label for="keywords">{{ __('Keywords страницы') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="keywords" name="settings[keywords]" placeholder="[name]" value="{{$ComponentSettings['keywords']??'[name]'}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="text">{{ __('Текст страницы') }}</label>
			<div class="input-group">
				<textarea class="form-control" id="text" name="settings[text]" placeholder="[text]">{{$ComponentSettings['text']??'[text]'}}</textarea>
			</div>		
		</div> 
		<div class="form-group">
			<label for="tag">{{ __('Tag страницы') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="tag" name="settings[tag]" placeholder="[name]" value="{{$ComponentSettings['tag']??null}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="img">{{ __('Img страницы') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="img" name="settings[img]" placeholder="[name]" value="{{$ComponentSettings['img']??null}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="keywords">{{ __('Название поля name') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="keywords" name="settings[namerow]" placeholder="Заголовок" value="{{$ComponentSettings['namerow']??'Заголовок'}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="rows">{{ __('Количество записей на страницу') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="img" name="settings[rows]" placeholder="10" value="{{$ComponentSettings['rows']??10}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="formatview">{{ __('Формат вывода') }}</label>
			<select class="form-control" id="formatview" name="settings[formatview]">
				<option value="text"{{isset($ComponentSettings['formatview'])&&$ComponentSettings['formatview']=="text"?' selected':null}}>Текст</option>
				<option value="table"{{isset($ComponentSettings['formatview'])&&$ComponentSettings['formatview']=="table"?' selected':null}}>Таблица</option>
			</select>	
		</div>
	</div>
	<div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
		<h3>Доступ разрешен для</h3>
		<div class="form-group">
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" name="settings[roles][0]" type="checkbox" id="role0" value="1" {{isset($ComponentSettings['roles'][0])?' checked':null}}>
                <label for="role0" class="custom-control-label">Всех</label>
            </div>
			@foreach ($roles as $indexKay=>$role)
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" name="settings[roles][{{$role->id}}]" type="checkbox" id="role{{$role->id}}" value="{{$role->id}}" {{isset($ComponentSettings['roles'][$role->id])||isset($ComponentSettings['roles'][0])?' checked':null}}>
                <label for="role{{$role->id}}" class="custom-control-label">{{$role->name}}</label>
            </div>
			@endforeach
		</div>
	</div>
	<div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
		<h3>Отображать в таблице админ-панели поля:</h3>
		<ul class="todo-list" data-widget="todo-list">
		@if(isset($ComponentSettings['admin-table'])) @foreach ($ComponentSettings['admin-table'] as $keyRow=>$row)
			<li>
                <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                </span>
				<div class="d-inline-block custom-control custom-checkbox">
					<input class="custom-control-input" name="settings[admin-table][]" type="checkbox" id="adt{{$row}}" value="{{$row}}" checked>
					<label for="adt{{$row}}" class="custom-control-label">{{$row=='name'?($ComponentSettings['namerow']??'Заголовок'):$WidjetCode[$row]['name']}} <small>{{$WidjetCode[$row]['codeform']}}</small></label>
				</div>
			</li>
		@endforeach @endif 
		@foreach ($WidjetCode as $keyWidjetCode=>$code) @if(!isset($ComponentSettings['admin-table'])||!in_array($keyWidjetCode, $ComponentSettings['admin-table']))
			<li>
                <span class="handle">
                    <i class="fas fa-ellipsis-v"></i>
                    <i class="fas fa-ellipsis-v"></i>
                </span>
				<div class="d-inline-block custom-control custom-checkbox">
					<input class="custom-control-input" name="settings[admin-table][]" type="checkbox" id="adt{{$keyWidjetCode}}" value="{{$keyWidjetCode}}">
					<label for="adt{{$keyWidjetCode}}" class="custom-control-label">{{$code['name']}} <small>{{$code['codeform']}}</small></label>
				</div>
			</li>
		@endif @endforeach
        </ul>
	</div>
	<div class="tab-pane fade" id="widjet" role="tabpanel" aria-labelledby="widjet-tab">
	
	</div>
	
</div>
<script type="text/javascript">$(document).ready(function(){
$('.todo-list').sortable({placeholder:'sort-highlight',handle:'.handle',forcePlaceholderSize:true,zIndex              : 999999});});</script>


