{{ csrf_field() }}
<div class="form-group">
	<label for="name">{{ __('Название сущности') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="name" name="section[name]" placeholder="{{ __('Название сущности') }}" value="{{$Component->name}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="url">{{ __('URL сущности') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="url" name="section[url]" placeholder="{{ __('URL сущности') }}" value="{{$Component->url}}" />
	</div>
	<span id="url-help-block" class="help-block"></span>		
</div> 
<script type="text/javascript">
		var isUrlSectionTimer=null;
		var isUrlSectionTime=0;
		function isUrlSection(id){
			var time = new Date();
			time = time.getTime();
			if(isUrlSectionTime==0){ isUrlSectionTime = time; }
			if(isUrlSectionTimer!=null && isUrlSectionTime+500 > time){
				clearTimeout(isUrlSectionTimer);
				isUrlSectionTime = time;
			}
			isUrlSectionTimer = setTimeout(function() {
				var url=$('#url').val();
				$.ajax({ type: "POST", url: "{{route('admin.entities.isurlsection')}}", data: "_token={{csrf_token()}}&url="+url+"&id="+id, dataType: 'json', cache: false, success: function(data){ 
					if(data.success == false){
						$('#url').removeClass("is-valid").removeClass("is-invalid").addClass("is-invalid");
						$('#url-help-block').html(data.text).removeClass("text-success").addClass("text-danger");
					} else {
						$('#url').removeClass("is-valid").removeClass("is-invalid").addClass("is-valid");
						$('#url-help-block').html(data.text).removeClass("text-danger").addClass("text-success");
					}
				}, error: function(){ console.log(data); }});
				isUrlSectionTimer=null;
				isUrlSectionTime=0;
				return false;
			}, 500);
		}
	$(document).ready(function(){
		$('#url').keyup(function(){isUrlSection({{$Component->id}});}).change(function(){isUrlSection({{$Component->id}});}).click(function(){isUrlSection({{$Component->id}});});
		/*$('#name').syncTranslit({destination: 'url'});
		$('#url').syncTranslit({destination: 'url'});*/
	});
</script>
<div class="form-group">
	<label for="title">{{ __('Title страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="title" name="section[title]" placeholder="{{ __('Title страницы') }}" value="{{$Component->title??null}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="description">{{ __('Description страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="description" name="section[description]" placeholder="{{ __('Description страницы') }}" value="{{$Component->description??null}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="keywords">{{ __('Keywords страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="keywords" name="section[keywords]" placeholder="{{ __('Keywords страницы') }}" value="{{$Component->keywords??null}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="image">{{ __('og:Image страницы') }}</label>
	<div class="input-group">
		{!! EntitiesFields::TypesList()["image"]["html"](__('og:Image страницы'),"image","section[image]",null, ($Component->image??null)) !!}	
	</div>		
</div> 
<div class="form-group">
	<label for="parent">{{ __('Родительская сущность') }}</label>
	<select class="form-control" id="parent" name="section[parent]">
		<option value="0"{{$Component->parent==0?' selected':null}}>Базовая</option>
		<option value="-1"{{$Component->parent==-1?' selected':null}}>Пользователи</option>
		@foreach ($parents as $parentKey=>$parent)
		<option value="{{$parent->id}}"{{$Component->parent==$parent->id?' selected':null}}>{{$parent->name}}</option>
		@endforeach
	</select>
</div> 
<div class="form-group">
	<label for="template">{{ __('Шаблон') }}</label>
	<select class="form-control" id="template" name="section[template]">
		@foreach ($templates as $templateKey=>$template)
		<option value="{{$template}}"{{$Component->template==$template?' selected':null}}>{{$template}}</option>
		@endforeach
	</select>
</div> 