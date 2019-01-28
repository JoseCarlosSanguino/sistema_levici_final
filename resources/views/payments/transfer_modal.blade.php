
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('number','Número:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('number', '',['class'=>'form-control']); !!}
    </div>

    <div class="col-xs-2">
        {!! Form::label('amount','Monto:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::number('amount', 0,['step' => '0.01', 'class'=>'form-control']); !!}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('bank_id', 'Banco:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('bank_id', $banks, isset($paycheck->bank_id) ? $paycheck->bank_id : false,['class'=>'form-control','placeholder'=>'Elija un banco']); !!}
    </div>
</div>
<br/>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('date_of', 'Fecha:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('date_of', date('d/m/Y') ,['class'=>'form-control datepicker']);!!}
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