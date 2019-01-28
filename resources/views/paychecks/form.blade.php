
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('number','Número:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('number', isset($paycheck->number) ? $paycheck->number : '',['class'=>'form-control']); !!}
    </div>

    <div class="col-xs-2">
        {!! Form::label('amount','Monto:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::number('amount', isset($paycheck->amount) ? $paycheck->amount : 0,['step' => '0.01', 'class'=>'form-control']); !!}
    </div>
</div>

<div class="form-group">

    <div class="col-xs-2">
        {!! Form::label('type','Tipo:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('type', ['al portador'=>'Al portador','diferido' => 'Diferido', 'cruzado' => 'Cruzado'], isset($paycheck->type) ? $paycheck->type : 'al portador',['class'=>'form-control']); !!}
    </div>

</div>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('payment_date', 'Fecha de pago:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('paymentdate', isset($paycheck->paymentdate) ? $paycheck->paymentdate : '',['id' => 'paymentdate', 'class'=>'form-control datepicker']);!!}
    </div>

    <div class="col-xs-2">
        {!! Form::label('expiration', 'Vencimiento:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('expiration', isset($paycheck->expiration) ? $paycheck->expiration : '',['id' => 'expiration', 'class'=>'form-control datepicker']);!!}
    </div>

    
    
    
</div>
<br/>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('owner_name', 'Propietario:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('owner_name', isset($paycheck->owner_name) ? $paycheck->owner_name : '',['class'=>'form-control']);!!}
    </div>

    
    <div class="col-xs-2">
        {!! Form::label('owner_cuit','Cuit:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('owner_cuit', isset($paycheck->owner_cuit) ? $paycheck->owner_cuit : '',['class'=>'form-control']);!!}
    </div>
    
</div>
<br/>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('observation', 'Observaciones:'); !!}
    </div>
    <div class="col-xs-10">
        {!! Form::text('observation', isset($paycheck->observation) ? $paycheck->observation : '',['class'=>'form-control']);!!}
    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('bank_id', 'Banco:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('bank_id', $banks, isset($paycheck->bank_id) ? $paycheck->bank_id : false,['class'=>'form-control','placeholder'=>'Elija un banco']); !!}
    </div>
</div>

@if(!isset($operationtype_id))
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>
@endif

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