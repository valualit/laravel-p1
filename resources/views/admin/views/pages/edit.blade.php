{{ csrf_field() }}
<div class="form-group">
	<label for="name">{{ __('Название страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="name" name="page[name]" placeholder="{{ __('Название страницы') }}" value="{{$page->name}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="url">{{ __('URL страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="url" name="page[url]" placeholder="{{ __('URL страницы') }}" value="{{$page->url}}" />
	</div>
	<span id="url-help-block" class="help-block"></span>		
</div> 
<script type="text/javascript">
		var isUrlPageTimer=null;
		var isUrlPageTime=0;
		function isUrlPage(id){
			var time = new Date();
			time = time.getTime();
			if(isUrlPageTime==0){ isUrlPageTime = time; }
			if(isUrlPageTimer!=null && isUrlPageTime+500 > time){
				clearTimeout(isUrlPageTimer);
				isUrlPageTime = time;
			}
			isUrlPageTimer = setTimeout(function() {
				var url=$('#url').val();
				$.ajax({ type: "POST", url: "{{route('admin.pages.isurlpage')}}", data: "_token={{csrf_token()}}&url="+url+"&id="+id, dataType: 'json', cache: false, success: function(data){ 
					if(data.success == false){
						$('#url').removeClass("is-valid").removeClass("is-invalid").addClass("is-invalid");
						$('#url-help-block').html(data.text).removeClass("text-success").addClass("text-danger");
					} else {
						$('#url').removeClass("is-valid").removeClass("is-invalid").addClass("is-valid");
						$('#url-help-block').html(data.text).removeClass("text-danger").addClass("text-success");
					}
				}, error: function(){ console.log(data); }});
				isUrlPageTimer=null;
				isUrlPageTime=0;
				return false;
			}, 500);
		}
	$(document).ready(function(){
		$('#url').keyup(function(){isUrlPage({{$page->id}});}).change(function(){isUrlPage({{$page->id}});}).click(function(){isUrlPage({{$page->id}});});
		// $('#name').syncTranslit({destination: 'url'});
		// $('#url').syncTranslit({destination: 'url'});
	});
</script>
<div class="form-group">
	<label for="title">{{ __('Title страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="title" name="page[title]" placeholder="{{ __('Title страницы') }}" value="{{$page->title}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="description">{{ __('Description страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="description" name="page[description]" placeholder="{{ __('Description страницы') }}" value="{{$page->description}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="keywords">{{ __('Keywords страницы') }}</label>
	<div class="input-group">
		<input type="text" class="form-control" id="keywords" name="page[keywords]" placeholder="{{ __('Keywords страницы') }}" value="{{$page->keywords}}" />
	</div>		
</div> 
<div class="form-group">
	<label for="image">{{ __('og:Image страницы') }}</label>
	<div class="input-group">
		{!! EntitiesFields::TypesList()["image"]["html"](__('og:Image страницы'),"image","page[image]",null,$page->image) !!}	
	</div>		
</div> 
<div class="form-group">
	<label for="template">{{ __('Шаблон') }}</label>
	<select class="form-control" id="template" name="page[template]">
		@foreach ($templates as $templateKey=>$template)
		<option value="{{$template}}"{{$page->template==$template?' selected':null}}>{{$template}}</option>
		@endforeach
	</select>
</div> 