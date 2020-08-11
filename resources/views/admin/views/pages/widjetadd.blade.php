{{ csrf_field() }}
@foreach ($entitie as $KeyEntitie=>$entitie)
	<div class="form-group">
		<label for="{{$KeyEntitie}}">{{$entitie['name']}}</label>
		{!! $entitie['html'] !!}
	</div>
@endforeach