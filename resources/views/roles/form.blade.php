<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', 'Nombre: ', ['class' => 'control-label']) !!}
    {!! Form::text('name', isset($role->name) ? $role->name : '', ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('label', 'Etiqueta: ', ['class' => 'control-label']) !!}
    {!! Form::text('label', isset($role->label) ? $role->label : '', ['class' => 'form-control']) !!}
    {!! $errors->first('label', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('description', 'Descripción: ', ['class' => 'control-label']) !!}
    {!! Form::text('description', isset($role->description) ? $role->description : '', ['class' => 'form-control']) !!}
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('label') ? ' has-error' : ''}}">
    {!! Form::label('label', 'Permisos: ', ['class' => 'control-label']) !!}
    {!! Form::select('permissions[]', $permissions, isset($role) ? $role->permissions->pluck('name') : [], ['class' => 'form-control', 'multiple' => true]) !!}
    {!! $errors->first('label', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Actulizar' : 'Crear', ['class' => 'btn btn-primary']) !!}
</div>
