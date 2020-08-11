{{ csrf_field() }}
<div class="form-group">
	<!--label for="name">{{ __('Название проекта') }}</label-->
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fab fa-amilia"></i></span>
		</div> 
		<input type="text" class="form-control" id="name" name="project[name]" required placeholder="{{ __('Название проекта') }}" />
	</div>
</div> 
<div class="form-group">
	<!--label for="url">{{ __('URL адрес/домен') }}</label-->
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fas fa-link"></i></span>
		</div> 
		<input type="text" class="form-control" id="url" name="project[url]" required placeholder="{{ __('URL адрес/домен') }}" />
	</div>
</div> 
<div class="form-group">
	<!--label for="user">{{ __('Администратор') }}</label-->
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fas fa-user"></i></span>
		</div> 
		<select type="text" class="form-control" id="user" name="project[user]" required>
		@foreach ($users as $indexKay=>$user)
		<option value="{{$user->id}}"{{$user->id==$self?' selected':null}}>{{$user->name}}</option>
		@endforeach
		</select>
	</div>
</div> 

<script>$(document).ready(function(){$('#user').select2();});</script>