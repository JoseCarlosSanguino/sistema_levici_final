<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', 'Nombre: ', ['class' => 'control-label']) !!}
    {!! Form::text('name', isset($permission->name) ? $permission->name : '', ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('label', 'Etiqueta: ', ['class' => 'control-label']) !!}
    {!! Form::text('label', isset($permission->label) ? $permission->label : '', ['class' => 'form-control']) !!}
    {!! $errors->first('label', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('menu_name', 'Menu: ', ['class' => 'control-label']) !!}
    {!! Form::text('menu_name', isset($permission->menu_name) ? $permission->menu_name : '', ['class' => 'form-control']) !!}
    {!! $errors->first('menu_name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('order', 'Orden: ', ['class' => 'control-label']) !!}
    {!! Form::text('order', isset($permission->order) ? $permission->order : '', ['class' => 'form-control']) !!}
    {!! $errors->first('order', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('controller', 'Controlador: ', ['class' => 'control-label']) !!}
    {!! Form::text('controller', isset($permission->controller) ? $permission->controller : '', ['class' => 'form-control']) !!}
    {!! $errors->first('controller', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('action', 'Acción: ', ['class' => 'control-label']) !!}
    {!! Form::text('action', isset($permission->action) ? $permission->action : '', ['class' => 'form-control']) !!}
    {!! $errors->first('action', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('route', 'Ruta: ', ['class' => 'control-label']) !!}
    {!! Form::text('route', isset($permission->route) ? $permission->route : '', ['class' => 'form-control']) !!}
    {!! $errors->first('route', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Actulizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>
