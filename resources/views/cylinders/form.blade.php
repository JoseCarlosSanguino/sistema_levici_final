
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('code','Código:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('code', isset($cylinder->code) ? $cylinder->code : '',['class'=>'form-control']); !!}
    </div>

    <div class="col-xs-2">
        {!! Form::label('external_code','Código externo:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('external_code', isset($cylinder->external_code) ? $cylinder->external_code : '',['class'=>'form-control']); !!}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('expiration', 'Vencimiento:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('expiration', isset($cylinder->expiration) ? $cylinder->expiration : '',['class'=>'form-control datepicker']);!!}
    </div>

    
    <div class="col-xs-2">
        {!! Form::label('cylindertype','Tipo:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('cylindertype_id', $cylindertypes, isset($cylinder->cylindertype_id) ? $cylinder->cylindertype_id : '',['class'=>'form-control']); !!}
    </div>
    
</div>
<br/>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('observation', 'Observaciones:'); !!}
    </div>
    <div class="col-xs-10">
        {!! Form::text('observation', isset($cylinder->observation) ? $cylinder->observation : '',['class'=>'form-control']);!!}
    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('is_own', 'Propio:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::hidden('is_own', false) !!}
        <input class="checkbox" name="is_own" type="checkbox" id="is_own" {{ (isset($cylinder->is_own) && $cylinder->is_own == 1)?'checked="checked"':''}}" >
    </div>

    <div class="col-xs-2">
        {!! Form::label('provider_id', 'Proveedor:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('provider_id', $providers, isset($cylinder->provider_id) ? $cylinder->provider_id : false,['class'=>'form-control','placeholder'=>'Elija Proveedor']); !!}
    </div>
</div>

<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('cliente', 'Cliente:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('customer_id', $customers, isset($cylinder->customer_id) ? $cylinder->customer_id : false,['class'=>'form-control','placeholder'=>'Elija cliente']); !!}
    </div>
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>


<script type="text/javascript">
$(function() {
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        language: "es",
        autoclose: true,
        todayHighlight: true,
        dateFormat: 'dd/mm/yy'
    });
});
</script>