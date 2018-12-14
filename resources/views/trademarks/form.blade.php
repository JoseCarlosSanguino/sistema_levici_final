<div class="form-group {{ $errors->has('trademark') ? 'has-error' : ''}}">
    <label for="trademark" class="control-label">{{ 'Marca' }}</label>
    <input class="form-control" name="trademark" type="text" id="trademark" value="{{ $trademark->trademark or ''}}" >
    {!! $errors->first('trademark', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
