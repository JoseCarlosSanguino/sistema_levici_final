
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('code','Código:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::text('code', isset($cylinder->code) ? $cylinder->code : '',['class'=>'form-control']);; ?>

    </div>

    <div class="col-xs-2">
        <?php echo Form::label('external_code','Código externo:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::text('external_code', isset($cylinder->external_code) ? $cylinder->external_code : '',['class'=>'form-control']);; ?>

    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('expiration', 'Vencimiento:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::text('expiration', isset($cylinder->expiration) ? $cylinder->expiration : '',['class'=>'form-control datepicker']);; ?>

    </div>

    
    <div class="col-xs-2">
        <?php echo Form::label('cylindertype','Tipo:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('cylindertype_id', $cylindertypes, isset($cylinder->cylindertype_id) ? $cylinder->cylindertype_id : '',['class'=>'form-control']);; ?>

    </div>
    
</div>
<br/>
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('observation', 'Observaciones:');; ?>

    </div>
    <div class="col-xs-10">
        <?php echo Form::text('observation', isset($cylinder->observation) ? $cylinder->observation : '',['class'=>'form-control']);; ?>

    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('is_own', 'Propio:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::hidden('is_own', false); ?>

        <input class="checkbox" name="is_own" type="checkbox" id="is_own" <?php echo e((isset($cylinder->is_own) && $cylinder->is_own == 1)?'checked="checked"':''); ?>" >
    </div>

    <div class="col-xs-2">
        <?php echo Form::label('provider_id', 'Proveedor:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('provider_id', $providers, isset($cylinder->provider_id) ? $cylinder->provider_id : false,['class'=>'form-control','placeholder'=>'Elija Proveedor']);; ?>

    </div>
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
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