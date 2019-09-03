<div class="form-group <?php echo e($errors->has('producttype') ? 'has-error' : ''); ?>">
    <label for="producttype" class="control-label"><?php echo e('Tipo de producto'); ?></label>
    <input class="form-control" name="producttype" type="text" id="producttype" value="<?php echo e(isset($producttype->producttype) ? $producttype->producttype : ''); ?>" >
    <?php echo $errors->first('producttype', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('salable') ? 'has-error' : ''); ?>">
    <?php echo Form::hidden('salable', false); ?>

    <label for="salable" class="control-label"><?php echo e('Vendible'); ?></label>
    <input class="checkbox" name="salable" type="checkbox" id="salable" <?php echo e((isset($producttype->salable) && $producttype->salable == 1)?'checked="checked"':''); ?>" >
    <?php echo $errors->first('salable', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('rentable') ? 'has-error' : ''); ?>">
    <?php echo Form::hidden('rentable', false); ?>

    <label for="rentable" class="control-label"><?php echo e('Alquilable'); ?></label>
    <input class="checkbox" name="rentable" type="checkbox" id="rentable" <?php echo e((isset($producttype->rentable) && $producttype->rentable == 1)?'checked="checked"':''); ?>" >
    <?php echo $errors->first('rentable', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
</div>
