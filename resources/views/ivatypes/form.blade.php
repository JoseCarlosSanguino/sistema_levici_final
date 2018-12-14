<div class="form-group {{ $errors->has('ivatype') ? 'has-error' : ''}}">
    <label for="ivatype" class="control-label">{{ 'Tipo de IVA' }}</label>
    <input class="form-control" name="ivatype" type="text" id="ivatype" value="{{ $ivatype->ivatype or ''}}" >
    {!! $errors->first('ivatype', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('percent') ? 'has-error' : ''}}">
        <label for="percent" class="control-label">{{ 'Procentaje' }}</label>
        <input class="form-control" name="percent" type="number" step=0.1 id="percent" value="{{ $ivatype->percent or ''}}" >
        {!! $errors->first('percent', '<p class="help-block">:messagepercentp>') !!}
    </div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
