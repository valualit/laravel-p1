{{ csrf_field() }}
<div class="form-group">
    <label for="name">{{ __('Название новой категории') }}</label>
    <input type="text" class="form-control" id="name" name="name" value="{{htmlspecialchars($entitiesCat->name)}}" placeholder="{{ __('Введите название новой категории') }}" />
</div>   