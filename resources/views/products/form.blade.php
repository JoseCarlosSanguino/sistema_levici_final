
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('Codigo','Código:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('code', isset($product->code) ? $product->code : '',['class'=>'form-control']); !!}
    </div>

    <div class="col-xs-2">
        {!! Form::label('product','Producto:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('product', isset($product->product) ? $product->product : '',['class'=>'form-control']); !!}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('description', 'Descripción:'); !!}
    </div>
    <div class="col-xs-10">
        {!! Form::text('description', isset($product->description) ? $product->description : '',['class'=>'form-control']);!!}
    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('expiration', 'Vencimiento:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('expiration', isset($product->expiration) ? $product->expiration : '',['class'=>'form-control datepicker']);!!}
    </div>
</div>

<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('producttype','Tipo:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('producttype_id', $producttypes, isset($product->producttype_id) ? $product->producttype_id : '',['class'=>'form-control']); !!}
    </div>
    <div class="col-xs-2">
        {!! Form::label('trademark','Marca:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('trademark_id', $trademarks, isset($product->trademark_id) ? $product->trademark_id : '',['class'=>'form-control', 'placeholder'=>'Marca']); !!}
    </div>
</div>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('ivatype','Tipo IVA:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('ivatype_id', $ivatypes, isset($product->ivatype_id) ? $product->ivatype_id : '',['class'=>'form-control', 'placeholder'=>'Tipo de IVA']); !!}
    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('unittype','Medida:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('unittype_id', $unittypes, isset($product->unittype_id) ? $product->unittype_id : '',['class'=>'form-control']); !!}
    </div>
</div>


<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('min_stock','Stock Min:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::number('min_stock', isset($product->min_stock) ? $product->min_stock : '',['class'=>'form-control']); !!}
    </div>

    <div class="col-xs-2">
        {!! Form::label('max_stock','Stock Max:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::number('max_stock', isset($product->max_stock) ? $product->max_stock : '',['class'=>'form-control']); !!}
    </div>
</div>
<br>
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('position','Posición:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('position', isset($product->position) ? $product->position : '',['class'=>'form-control']); !!}
    </div>
</div>
<br>

@if($formMode === 'edit')
    <div class="form-group">
        <div class="col-xs-2">
            {!! Form::label('stock','Stock:'); !!}
        </div>
        <div class="col-xs-4">
            {!! Form::number('stock', isset($product->stock) ? $product->stock : 0,['class'=>'form-control']); !!}
        </div>

    </div>
    <br>

    <div class="form-group">
        <div class="col-xs-2">
            {!! Form::label('price','Precio:'); !!}
        </div>
        <div class="col-xs-4">
            {!! Form::number('price', isset($product->price) ? $product->price : 0,['class'=>'form-control']); !!}
        </div>

        <div class="col-xs-2">
            {!! Form::label('last_price','Último precio:'); !!}
        </div>
        <div class="col-xs-4">
            {!! Form::number('last_price', isset($product->last_price) ? $product->last_price : 0,['class'=>'form-control']); !!}
        </div>
    </div>
    <br>

    <div class="form-group">
        <div class="col-xs-2">
            {!! Form::label('cost','Costo:'); !!}
        </div>
        <div class="col-xs-4">
            {!! Form::number('cost', isset($product->cost) ? $product->cost : 0,['class'=>'form-control']); !!}
        </div>

        <div class="col-xs-2">
            {!! Form::label('last_cost','Último costo:'); !!}
        </div>
        <div class="col-xs-4">
            {!! Form::number('last_cost', isset($product->last_cost) ? $product->last_cost : 0,['class'=>'form-control']); !!}
        </div>
    </div>
    <br>
    

@endif
<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('providers','Proveedores:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('providers[]', $providers, isset($product) ? $product->providers->pluck('id') : [], ['class' => 'form-control', 'multiple' => true]) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
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