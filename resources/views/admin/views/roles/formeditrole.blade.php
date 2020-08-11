{{ csrf_field() }}
<div class="form-group">
    <label for="renamerole">{{ __('Новое наименование роли') }}</label>
    <input type="text" class="form-control" id="renamerole" name="renamerole" value="{{htmlspecialchars($role->name)}}" placeholder="{{ __('Введите новое имя роли') }}" />
</div> 