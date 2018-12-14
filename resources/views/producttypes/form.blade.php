<div class="form-group {{ $errors->has('producttype') ? 'has-error' : ''}}">
    <label for="producttype" class="control-label">{{ 'Tipo de producto' }}</label>
    <input class="form-control" name="producttype" type="text" id="producttype" value="{{ $producttype->producttype or ''}}" >
    {!! $errors->first('producttype', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('salable') ? 'has-error' : ''}}">
    {!! Form::hidden('salable', false) !!}
    <label for="salable" class="control-label">{{ 'Vendible' }}</label>
    <input class="checkbox" name="salable" type="checkbox" id="salable" {{ (isset($producttype->salable) && $producttype->salable == 1)?'checked="checked"':''}}" >
    {!! $errors->first('salable', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('rentable') ? 'has-error' : ''}}">
    {!! Form::hidden('rentable', false) !!}
    <label for="rentable" class="control-label">{{ 'Alquilable' }}</label>
    <input class="checkbox" name="rentable" type="checkbox" id="rentable" {{ (isset($producttype->rentable) && $producttype->rentable == 1)?'checked="checked"':''}}" >
    {!! $errors->first('rentable', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
