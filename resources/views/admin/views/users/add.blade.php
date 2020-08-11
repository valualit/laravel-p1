{{ csrf_field() }}
@if($CatList->count()>0)
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="default-tab" data-toggle="tab" href="#default" role="tab" aria-controls="default" aria-selected="true">{{ __('Основные') }}</a>
	</li>
	@foreach ($CatList as $indexKay=>$Item)
	<li class="nav-item">
		<a class="nav-link" id="cat{{$Item->id}}-tab" data-toggle="tab" href="#cat{{$Item->id}}" role="tab" aria-controls="cat{{$Item->id}}" aria-selected="false">{{$Item->name}}</a>
	</li>
	@endforeach
</ul>
<div class="tab-content" id="myTabContent">
@endif

	<div class="tab-pane fade show active" id="default" role="tabpanel" aria-labelledby="default-tab">
		<div class="form-group">
			<label for="name">{{ __('Имя пользователя/Login') }}</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">@</span>
				</div> 
				<input type="text" class="form-control" id="name" name="user[name]" placeholder="{{ __('Имя пользователя/Login') }}" />
			</div>
			
		</div> 
		<div class="form-group">
			<label for="email">{{ __('E-Mail') }}</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-envelope"></i></span>
				</div> 
				<input type="text" class="form-control" id="email" name="user[email]" placeholder="{{ __('E-Mail') }}" />
			</div>
			<span id="email-help-block" class="help-block"></span>
		</div> 
		<script>
		var isUserEmailTimer=null;
		var isUserEmailTime=0;
		function isUserEmail(id){
			var time = new Date();
			time = time.getTime();
			if(isUserEmailTime==0){ isUserEmailTime = time; }
			if(isUserEmailTimer!=null && isUserEmailTime+500 > time){
				clearTimeout(isUserEmailTimer);
				isUserEmailTime = time;
			}
			isUserEmailTimer = setTimeout(function() {
				var email=$('#email').val();
				$.ajax({ type: "POST", url: "{{route('admin.users.isuseremail')}}", data: "_token={{csrf_token()}}&email="+email+"&id="+id, dataType: 'json', cache: false, success: function(data){ 
					if(data.success == false){
						$('#email').removeClass("is-valid").removeClass("is-invalid").addClass("is-invalid");
						$('#email-help-block').html(data.text).removeClass("text-success").addClass("text-danger");
					} else {
						$('#email').removeClass("is-valid").removeClass("is-invalid").addClass("is-valid");
						$('#email-help-block').html(data.text).removeClass("text-danger").addClass("text-success");
					}
				}, error: function(){ console.log(data); }});
				isUserEmailTimer=null;
				isUserEmailTime=0;
				return false;
			}, 500);
		}
		$( document ).ready(function() {
			$('#email').keyup(function(){isUserEmail(0);}).change(function(){isUserEmail(0);}).click(function(){isUserEmail(0);});
		}); </script>
		<div class="form-group">
			<label for="phone">{{ __('Телефон') }}</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-phone"></i></span>
				</div> 
				<input type="text" class="form-control" id="phone" name="user[phone]" placeholder="{{ __('Телефон') }}" />
			</div>
		</div> 
		<div class="form-group">
			<label for="password">{{ __('Пароль') }}</label>
			
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-key"></i></span>
				</div> 
				<input type="text" class="form-control" id="password" name="user[password]" placeholder="{{ __('Пароль') }}" />
			</div>
		</div>
		<div class="form-group">
			<label for="roles">{{ __('Роль') }}</label>
			<select class="form-control" id="roles" name="user[roles]">
				@foreach ($roles as $indexKay=>$role)
				<option value="{{$role->id}}"{{$role->default==1?' selected':null}}>{{$role->name}}</option>
				@endforeach
			</select>
		</div> 
		@foreach ($List as $KeyItem=>$ListItem) @if($ListItem['parent']===0)
		<div class="form-group">
			<label for="enitities{{$ListItem['id']}}">{{ __($ListItem['entitie_name']) }}</label>
			{!! $ListItem['html'] !!}
		</div>
		@endif @endforeach
	</div> 
	@foreach ($CatList as $indexKay=>$Item)
	<div class="tab-pane fade" id="cat{{$Item->id}}" role="tabpanel" aria-labelledby="cat{{$Item->id}}-tab">
		@foreach ($List as $KeyItem=>$ListItem) @if($ListItem['parent']==$Item->id)
		<div class="form-group">
			<label for="enitities{{$ListItem['id']}}">{{ __($ListItem['entitie_name']) }}</label>
			{!! $ListItem['html'] !!} 
		</div>
		@endif @endforeach 
	</div>
	@endforeach
	
@if($CatList->count()>0)
</div>
@endif