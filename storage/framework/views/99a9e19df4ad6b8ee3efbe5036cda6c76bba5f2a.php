
<?php echo Form::hidden('redirects_to', URL::previous()); ?>

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('Codigo','Código:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::text('code', isset($product->code) ? $product->code : '',['class'=>'form-control']);; ?>

    </div>
</div>

<div class="form-group">
     <div class="col-xs-2">
        <?php echo Form::label('product','Producto:');; ?>

    </div>
    <div class="col-xs-10">
        <?php echo Form::text('product', isset($product->product) ? $product->product : '',['class'=>'form-control']);; ?>

    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('description', 'Descripción:');; ?>

    </div>
    <div class="col-xs-10">
        <?php echo Form::text('description', isset($product->description) ? $product->description : '',['class'=>'form-control']);; ?>

    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('expiration', 'Vencimiento:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::text('expiration', isset($product->expiration) ? $product->expiration : '',['class'=>'form-control datepicker']);; ?>

    </div>
</div>

<br>
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('producttype','Tipo:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('producttype_id', $producttypes, isset($product->producttype_id) ? $product->producttype_id : '',['class'=>'form-control']);; ?>

    </div>
    <div class="col-xs-2">
        <?php echo Form::label('trademark','Marca:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('trademark_id', $trademarks, isset($product->trademark_id) ? $product->trademark_id : '',['class'=>'form-control', 'placeholder'=>'Marca']);; ?>

    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('ivatype','Tipo IVA:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('ivatype_id', $ivatypes, isset($product->ivatype_id) ? $product->ivatype_id : '',['class'=>'form-control', 'placeholder'=>'Tipo de IVA']);; ?>

    </div>
</div>
<br>
<!--
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('cylindertype_id','Tipo de cilindro:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('cylindertype_id', $cylindertypes, isset($product->cylindertype_id) ? $product->cylindertype_id : '',['class'=>'form-control', 'placeholder'=>'Tipo de cilindro']);; ?>

    </div>
</div>
-->

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('cylindertypes','Tipos de cilindros:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('cylindertypes[]', $cylindertypes, isset($product) ? $product->cylindertypes->pluck('id') : [], ['class' => 'form-control', 'multiple' => true]); ?>

        <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

    </div>
</div>
<br>


<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('unittype','Medida:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('unittype_id', $unittypes, isset($product->unittype_id) ? $product->unittype_id : '',['class'=>'form-control']);; ?>

    </div>
</div>


<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('min_stock','Stock Min:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::number('min_stock', isset($product->min_stock) ? $product->min_stock : '',['class'=>'form-control']);; ?>

    </div>

    <div class="col-xs-2">
        <?php echo Form::label('max_stock','Stock Max:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::number('max_stock', isset($product->max_stock) ? $product->max_stock : '',['class'=>'form-control']);; ?>

    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('position','Posición:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::text('position', isset($product->position) ? $product->position : '',['class'=>'form-control']);; ?>

    </div>
</div>
<br>

<?php if(in_array(1 ,$role)): ?>
    <div class="form-group">
        <div class="col-xs-2">
            <?php echo Form::label('stock','Stock:');; ?>

        </div>
        <div class="col-xs-4">
            <?php echo Form::number('stock', isset($product->stock) ? $product->stock : 0,['class'=>'form-control']);; ?>

        </div>

    </div>
    <br>

    <div class="form-group">
        <div class="col-xs-2">
            <?php echo Form::label('price','Precio:');; ?>

        </div>
        <div class="col-xs-4">
            <?php echo Form::number('price', isset($product->price) ? $product->price : 0,['step' => '0.01','class'=>'form-control']);; ?>

        </div>

        <div class="col-xs-2">
            <?php echo Form::label('last_price','Último precio:');; ?>

        </div>
        <div class="col-xs-4">
            <?php echo Form::number('last_price', isset($product->last_price) ? $product->last_price : 0,['step' => '0.01', 'class'=>'form-control']);; ?>

        </div>
    </div>
    <br>

    <div class="form-group">
        <div class="col-xs-2">
            <?php echo Form::label('cost','Costo:');; ?>

        </div>
        <div class="col-xs-4">
            <?php echo Form::number('cost', isset($product->cost) ? $product->cost : 0,['step' => '0.01','class'=>'form-control']);; ?>

        </div>

        <div class="col-xs-2">
            <?php echo Form::label('last_cost','Último costo:');; ?>

        </div>
        <div class="col-xs-4">
            <?php echo Form::number('last_cost', isset($product->last_cost) ? $product->last_cost : 0,['step' => '0.01','class'=>'form-control']);; ?>

        </div>
    </div>
    <br>
<?php endif; ?>
<!-- end if -->

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('providers','Proveedores:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::select('providers[]', $providers, isset($product) ? $product->providers->pluck('id') : [], ['class' => 'form-control', 'multiple' => true]); ?>

        <?php echo $errors->first('name', '<p class="help-block">:message</p>'); ?>

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