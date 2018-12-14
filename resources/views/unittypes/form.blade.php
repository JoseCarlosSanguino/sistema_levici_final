<div class="form-group {{ $errors->has('unittype') ? 'has-error' : ''}}">
    <label for="unittype" class="control-label">{{ 'Tipo de unidad' }}</label>
    <input class="form-control" name="unittype" type="text" id="unittype" value="{{ $unittype->unittype or ''}}" >
    {!! $errors->first('unittype', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
