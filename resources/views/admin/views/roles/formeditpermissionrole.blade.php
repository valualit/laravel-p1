{{ csrf_field() }}
<div class="form-group">
	@foreach ($PermissionAll as $PID=>$Perm)
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input" type="checkbox" name="PermissionID[{{$Perm->id}}]" id="PermissionID{{$Perm->id}}" value="{{$Perm->id}}" {{isset($Permission[$Perm->id])?'checked':null}}>
        <label for="PermissionID{{$Perm->id}}" class="custom-control-label">{{$Perm->name}}</label>
    </div>
	@endforeach
	<input type="hidden" name="PermissionID[0]" value="0" />
</div>