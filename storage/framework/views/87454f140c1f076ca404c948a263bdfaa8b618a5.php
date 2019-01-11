<div class="form-group <?php echo e($errors->has('cylindertype') ? 'has-error' : ''); ?>">
    <label for="cylindertype" class="control-label"><?php echo e('Tipo de cilindro'); ?></label>
    <input class="form-control" name="cylindertype" type="text" id="cylindertype" value="<?php echo e(isset($cylindertype->cylindertype) ? $cylindertype->cylindertype : ''); ?>" >
    <?php echo $errors->first('cylindertype', '<p class="help-block">:message</p>'); ?>

</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
</div>
