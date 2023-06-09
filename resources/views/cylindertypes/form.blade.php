<div class="form-group {{ $errors->has('cylindertype') ? 'has-error' : ''}}">
    <label for="cylindertype" class="control-label">{{ 'Tipo de cilindro' }}</label>
    <input class="form-control" name="cylindertype" type="text" id="cylindertype" value="{{ $cylindertype->cylindertype or ''}}" >
    {!! $errors->first('cylindertype', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('capacity') ? 'has-error' : ''}}">
    <label for="capacity" class="control-label">{{ 'Capacidad' }}</label>
    <input class="form-control" name="capacity" step= "0.01" type="number" id="capacity" value="{{ $cylindertype->capacity or ''}}" >
    {!! $errors->first('capacity', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
