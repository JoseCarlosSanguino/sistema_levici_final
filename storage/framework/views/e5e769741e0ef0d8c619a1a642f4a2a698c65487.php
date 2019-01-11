<div class="form-group <?php echo e($errors->has('trademark') ? 'has-error' : ''); ?>">
    <label for="trademark" class="control-label"><?php echo e('Marca'); ?></label>
    <input class="form-control" name="trademark" type="text" id="trademark" value="<?php echo e(isset($trademark->trademark) ? $trademark->trademark : ''); ?>" >
    <?php echo $errors->first('trademark', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
</div>
