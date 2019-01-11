<div class="form-group <?php echo e($errors->has('province') ? 'has-error' : ''); ?>">
    <label for="province" class="control-label"><?php echo e('Provincia'); ?></label>
    <input class="form-control" name="province" type="text" id="province" value="<?php echo e(isset($province->province) ? $province->province : ''); ?>" >
    <?php echo $errors->first('province', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
</div>
