{{ csrf_field() }}
@foreach ($list as $KeyItem=>$ListItem)
	<div class="form-group">
		<label for="enitities{{$ListItem['id']}}">{{ __($ListItem['name']) }}</label>
		{!! $ListItem['html'] !!} 
	</div>
@endforeach 