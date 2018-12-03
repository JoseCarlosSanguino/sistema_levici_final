<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Razón Social' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $provider->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('cuit') ? 'has-error' : ''}}">
    <label for="cuit" class="control-label">{{ 'Cuit' }}</label>
    <input class="form-control" name="cuit" type="text" id="cuit" value="{{ $provider->cuit or ''}}" >
    {!! $errors->first('cuit', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    <label for="address" class="control-label">{{ 'Dirección' }}</label>
    <input class="form-control" name="address" type="text" id="address" value="{{ $provider->address or ''}}" >
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
    <label for="telephone" class="control-label">{{ 'Teléfono' }}</label>
    <input class="form-control" name="telephone" type="text" id="telephone" value="{{ $provider->telephone or ''}}" >
    {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('web') ? 'has-error' : ''}}">
    <label for="web" class="control-label">{{ 'Página web' }}</label>
    <input class="form-control" name="web" type="text" id="web" value="{{ $provider->web or ''}}" >
    {!! $errors->first('web', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('ivacondition_id') ? 'has-error' : ''}}">
    <label for="ivacondition_id" class="control-label">{{ 'Condición de IVA' }}</label>
    <select name="ivacondition_id" class="form-control" id="ivacondition_id" >
    @foreach ($ivaconditions as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($customer->ivacondition_id) && $customer->ivacondition_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('ivacondition_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Provincia' }}</label>
    <select name="province_id" class="form-control" id="province_id" >
    @foreach ($provinces as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($provider->province_id) && $provider->province_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
