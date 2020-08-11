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
			<label for="name">{{$ComponentSettings['namerow']??'Заголовок'}}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="name" name="section[name]" placeholder="{{$ComponentSettings['namerow']??'Заголовок'}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="name">{{ __('Текст') }}</label>
			{!! EntitiesFields::TypesList()["textarea wysiwyg"]["html"](__('Текст'),"text","section[text]",null,null) !!}	
		</div> 
		<div class="form-group">
			<label for="user">{{ __('ID автора') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="user" name="section[user]" placeholder="{{ __('ID автора') }}" value="{{Auth::id()}}" />
			</div>		
		</div>
		<div class="form-group">
			<label for="parent">{{ __('ID родительского елемента') }}</label>
			<div class="input-group">
				<input type="text" class="form-control" id="parent" name="section[parent]" placeholder="{{ __('ID автора') }}" value="0" />
			</div>		
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