<div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
    <label for="name" class="control-label"><?php echo e('Razón Social'); ?></label>
    <input class="form-control" name="name" type="text" id="name" value="<?php echo e(isset($customer->name) ? $customer->name : ''); ?>" >
    <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('cuit') ? 'has-error' : ''); ?>">
    <label for="cuit" class="control-label"><?php echo e('Cuit'); ?></label>
    <input class="form-control" name="cuit" type="text" id="cuit" value="<?php echo e(isset($customer->cuit) ? $customer->cuit : ''); ?>" >
    <?php echo $errors->first('cuit', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
    <label for="address" class="control-label"><?php echo e('Dirección'); ?></label>
    <input class="form-control" name="address" type="text" id="address" value="<?php echo e(isset($customer->address) ? $customer->address : ''); ?>" >
    <?php echo $errors->first('address', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('telephone') ? 'has-error' : ''); ?>">
    <label for="telephone" class="control-label"><?php echo e('Teléfono'); ?></label>
    <input class="form-control" name="telephone" type="text" id="telephone" value="<?php echo e(isset($customer->telephone) ? $customer->telephone : ''); ?>" >
    <?php echo $errors->first('telephone', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('web') ? 'has-error' : ''); ?>">
    <label for="web" class="control-label"><?php echo e('Página web'); ?></label>
    <input class="form-control" name="web" type="text" id="web" value="<?php echo e(isset($customer->web) ? $customer->web : ''); ?>" >
    <?php echo $errors->first('web', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <label for="email" class="control-label"><?php echo e('Email'); ?></label>
    <input class="form-control" name="email" type="text" id="email" value="<?php echo e(isset($customer->email) ? $customer->email : ''); ?>" >
    <?php echo $errors->first('email', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('ivacondition_id') ? 'has-error' : ''); ?>">
    <label for="ivacondition_id" class="control-label"><?php echo e('Condición de IVA'); ?></label>
    <select name="ivacondition_id" class="form-control" id="ivacondition_id" >
    <?php $__currentLoopData = $ivaconditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e((isset($customer->ivacondition_id) && $customer->ivacondition_id == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo $errors->first('ivacondition_id', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('markup') ? 'has-error' : ''); ?>">
    <label for="markup" class="control-label"><?php echo e('Margen de ganancia'); ?></label>
    <input class="form-control" type="number" name="markup" type="text" id="markup" value="<?php echo e(isset($customer->markup) ? $customer->markup : '0'); ?>" >
    <?php echo $errors->first('markup', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('observation') ? 'has-error' : ''); ?>">
    <label for="observation" class="control-label"><?php echo e('Observaciones'); ?></label>
    <input class="form-control" name="observation" type="text" id="observation" value="<?php echo e(isset($customer->observation) ? $customer->observation : ''); ?>" >
    <?php echo $errors->first('observation', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('province_id') ? 'has-error' : ''); ?>">
    <label for="province_id" class="control-label"><?php echo e('Provincia'); ?></label>
    <select name="province_id" class="form-control" id="province_id" >
    <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($optionKey); ?>" <?php echo e((isset($customer->province_id) && $customer->province_id == $optionKey) ? 'selected' : ''); ?>><?php echo e($optionValue); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
    <?php echo $errors->first('province_id', '<p class="help-block">:message</p>'); ?>

</div>

<div class="form-group <?php echo e($errors->has('city_id') ? 'has-error' : ''); ?>">
    <label for="city_id" class="control-label"><?php echo e('Ciudad'); ?></label>
    <select name="city_id" class="form-control" id="city_id" >
    </select>
    <?php echo $errors->first('city_id', '<p class="help-block">:message</p>'); ?>

</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
</div>


<script type="text/javascript">

    var path_city = "<?php echo e(route('cityJson')); ?>";
    var city_initial_val = <?php echo e(isset($customer->city_id) ? $customer->city_id : ''); ?>


    $(function(){
        
        if($("#province_id").val() >0 ){
            rellenarSelectCity();
        }
    });


    $("#province_id").change(function(){
        rellenarSelectCity();
    });

    function rellenarSelectCity(){
        return $.get(path_city, { province_id : $("#province_id").val() }, function (data) {
            $('#city_id').empty();
            $('#city_id').append('<option value="">Select ...</option>');
            $.each(data, function(k, v) {
                var option = new Option(v.city, v.id); 
                if(city_initial_val == v.id){
                    option.selected = true;
                }
                $('#city_id').append($(option));               
            });
        });
    }


</script>