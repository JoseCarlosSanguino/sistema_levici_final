<div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
    <label for="city" class="control-label">{{ 'Ciudad' }}</label>
    <input class="form-control" name="city" type="text" id="city" value="{{ $city->city or ''}}" >
    {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Provincia' }}</label>
    <select name="province_id" class="form-control" id="province_id" >
    @foreach ($provinces as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($city->province_id) && $city->province_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
