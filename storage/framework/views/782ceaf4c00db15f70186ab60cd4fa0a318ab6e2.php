
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<!-- Es este o el que está en layout/app.blade.php-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->
<?php echo isset($e)?$e->getMessage():''; ?>

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('Tipo','Tipo de documento:');; ?>

    </div>
    <div class="col-xs-3">
        <?php echo Form::select('groupoperationtype_id', $groupoperationtypes,1,['id' => 'groupoperationtype_id', 'class'=>'form-control', 'placeholder'=>'Tipo de documento']);; ?>

    </div>
</div>

<div class="form-group">
    
    <div class="col-xs-2">
        <?php echo Form::label('number','Número:');; ?>

    </div>
    <div class="col-xs-3">
        <?php echo Form::text('number', isset($number)?$number:'',['readonly' => 'readonly', 'class'=>'form-control']);; ?>

        <?php echo Form::hidden('operationtype_id' , isset($operationtype_id)?$operationtype_id:'', ['id' => 'operationtype_id']); ?>

    </div>
</div>

<div class="form-group">

    <div class="col-xs-2">
        <?php echo Form::label('date','Fecha:');; ?>

    </div>
    <div class="col-xs-2">
        <?php echo Form::text('date_of', isset($sale->date_of) ? $sale->date_of : date('d/m/Y'),['class'=>'form-control datepicker']);; ?>

    </div>
</div>
</br>

<div class="form-group">

    <div class="col-xs-2">
        <?php echo Form::label('condition', 'Condición:');; ?>

    </div>
    <div class="col-xs-4">
        <?php echo Form::label('condition', 'Contado');; ?>&nbsp;&nbsp;
        <?php echo e(Form::radio('conditions', 'contado' , false)); ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo Form::label('condition', 'Cuenta Corriente');; ?>&nbsp;&nbsp;
        <?php echo e(Form::radio('conditions', 'cta cte' , true)); ?>

    </div>
</div>
</br>
<div class="form-group">
    
    <div class="col-xs-2">
        <?php echo Form::label('customer','Cliente:');; ?>

    </div>
    <div class="col-xs-3">
        <?php echo Form::text('customer_ac', isset($sale->customer->name)?$sale->customer->name:'',['id'=>'customer_ac', 'autocomplete' => 'off' ,'class'=>'typeahead form-control']);; ?>

        <?php echo Form::hidden('customer_id', isset($sale->customer_id)?$sale->customer_id:'', ['id' => 'customer_id']); ?>

        <?php echo Form::hidden('ivacondition_id', isset($sale->customer->ivacondition_id)?$sale->customer->ivacondition_id:'', ['id' => 'ivacondition_id']); ?>

        <?php echo Form::hidden('markup', isset($sale->customer->markup)?$sale->customer->markup:0, ['id' => 'markup']); ?>


        
    </div>
</div>
</br>

<div class="form-group">
    <div class="col-xs-2">
        <?php echo Form::label('observation', 'Observaciones:');; ?>

    </div>
    <div class="col-xs-10">
        <?php echo Form::text('observation', (isset($sale->operation->operationtype_id) && $sale->operation->operationtype_id == 13)?$sale->operation->fullnumber:'',['class'=>'form-control']);; ?>

    </div>
</div>
<br>
<h4>Detalle</h4>
<br>
<div class="form-group">
    <div class="col-xs-1">
        <?php echo Form::label('product','Artículo:');; ?>

    </div>
    <div class="col-xs-4" style="width:30%">
        <?php echo Form::text('prod_ac', '',[ 'id' => 'prod_ac', 'autocomplete' => 'off' , 'class'=>'typeahead form-control']);; ?> 

        <?php echo Form::hidden('prod_id'          , '', ['id' => 'prod_id']); ?>

        <?php echo Form::hidden('prod_code'        , '', ['id' => 'prod_code']); ?>

        <?php echo Form::hidden('prod_product'     , '', ['id' => 'prod_product']); ?>

        <?php echo Form::hidden('prod_description' , '', ['id' => 'prod_description']); ?>

        <?php echo Form::hidden('prod_ivatype'     , '', ['id' => 'prod_ivatype']); ?>

    </div>
    <div class="col-xs-1">
        <?php echo Form::label('stock','Stock:');; ?>

    </div>
    <div class="col-xs-1">
        <?php echo Form::number('stock', '',[ 'id' => 'stock', 'readonly'=> 'readonly', 'class'=>'form-control']);; ?>

    </div>
    <div class="col-xs-1">
        <?php echo Form::label('price','Precio:');; ?>

    </div>
    <div class="col-xs-1"  style="width:11%" >
        <?php echo Form::number('price', '',[ 'id' => 'price', 'class'=>'form-control','step' => '0.1', 'min' => '0']);; ?>

    </div>
    <div class="col-xs-1">
        <?php echo Form::label('quantity','Cantidad:');; ?>

    </div>
    <div class="col-xs-1" style="width:9%" >
        <?php echo Form::number('quantity', '',[ 'id' => 'quantity', 'class'=>'form-control','step' => '0.1', 'min' => '0']);; ?>

    </div>
    <div class="col-xs-1">
        <a href="#" id="addProductToDetail" class="btn btn-success" >
            <i class="fa fa-plus" aria-hidden="true"></i> 
        </a>    
    </div>
</div>
<br>

<div class="table-responsive">
    <table class="table" id="productDetail">
        <thead>
            <tr>
                <th>#</th><th>Código</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th></th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($sale->id)): ?>
                <?php 
                    $total = 0;
                    $iva21 = 0;
                    $iva105= 0;

                    $numerador=1;

                ?>
                <?php $__currentLoopData = $sale->operation->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php    
                        $new_price = (floatval($prod->pivot->price) / 100 * floatval($sale->customer->markup) ) + floatval($prod->pivot->price);
                        $subt = $new_price * floatval($prod->pivot->quantity);

                        $iva = floatval($prod->ivatype->percent) * ($subt / 100);
                        if($prod->ivatype->percent == '21.00')
                        {
                            $iva21 = round($iva21 + $iva,2);
                        }
                        else
                        {
                            $iva105 = round($iva105 + $iva,2);
                        }

                        $total = round($total + $subt + $iva,2);

                    ?>
                    <tr>
                        <td><?php echo e($numerador); ?>

                        <input type='hidden' name='product_id[]' value='<?php echo e($prod->id); ?>'/>
                        <input type='hidden' name='product_quantity[]' value='<?php echo e($prod->pivot->quantity); ?>'/>
                        <input type='hidden' name='product_price[]' value='<?php echo e($prod->pivot->price); ?>'/>
                        </td>
                    <td><?php echo e($prod->code); ?></td>
                    <td><?php echo e($prod->product); ?></td>
                    <td><?php echo e($new_price); ?></td>
                    <td><?php echo e($prod->pivot->quantity); ?></td>
                    <td><?php echo e($subt); ?></td>
                    <td><a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'></i></a> </td>
                    </tr>
                    <?php echo e($numerador++); ?>


                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
        </tbody>
    </table>
</div>
</br>
<div class="table-responsive">
    <?php echo Form::hidden('amount', isset($total)?$total: 0, ['id'=>'amount']); ?>

    <?php echo Form::hidden('discount', isset($discount)?$discount: 0, ['id'=>'discount']); ?>

    <?php echo Form::hidden('iva105', isset($iva105)?$iva105: 0, ['id'=>'iva105']); ?>

    <?php echo Form::hidden('iva21', isset($iva21)?$iva21: 0, ['id'=>'iva21']); ?>

    <?php echo Form::hidden('remito_id', isset($sale->id)?$sale->id: '', ['id'=>'iva21']); ?>

    <table class="table" id="totalDetail">
        <tbody>
            <tr>
                <td width="70%" align="right"><b>IVA 10,5%</b></td>
                <td id="tdIva105" style="font-size: 16px; font-weight: bold"><?php echo e(isset($iva105) ? $iva105 : 0); ?></td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>IVA 21%</b></td>
                <td id="tdIva21" style="font-size: 16px; font-weight: bold"><?php echo e(isset($iva21) ? $iva21 : 0); ?></td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>Descuento</b></td>
                <td id="tdDescuento" style="font-size: 16px; font-weight: bold">0</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>TOTAL</b></td>
                <td id="tdTotal" style="font-size: 16px; font-weight: bold"><?php echo e(isset($total) ? $total : 0); ?></td>
            </tr>
        </tbody>
    </table>
</div>
</br>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="<?php echo e($formMode === 'edit' ? 'Actualizar' : 'Crear'); ?>">
</div>

<script type="text/javascript">

    var numerador = <?php echo e(isset($numerador) ? $numerador : 1); ?>;
    var total = <?php echo e(isset($total) ? $total : 0); ?>;
    var iva105= <?php echo e(isset($iva105) ? $iva105 : 0); ?>;
    var iva21 = <?php echo e(isset($iva21) ? $iva21 : 0); ?>;
    var desc  = <?php echo e(isset($discount) ? $discount : 0); ?>;
    var pathNextNumber = "<?php echo e(route('nextSaleNumber')); ?>";

    $(function(){
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            language: "es",
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd/mm/yy'
        });

        $.get(pathNextNumber, { group_id : <?php echo e(isset($groupoperationtype_id) ? $groupoperationtype_id : 0); ?>, ivacondition_id : <?php echo e(isset($ivacondition_id) ? $ivacondition_id : 0); ?> } , function (data) {
            $("#number").val(data.number);
            $("#operationtype_id").val(data.operationtype_id);
        });

    });

    $('form input').on('keypress', function(e) {
        return e.which !== 13;
    });


    /**
     * Add product to table
     */
    $("#addProductToDetail").click(function(e){
        e.preventDefault();
        
        if($("#prod_id").val() > 0)
        {
            var markup= parseFloat( $("#markup").val()).toFixed(2);
            var price = parseFloat( $("#price").val()).toFixed(2) ;
            var quant = parseFloat( $("#quantity").val()).toFixed(2);

            var subt  = price * quant;
            var inter = ( subt / 100 ) * markup;
            subt = subt + inter;
            var iva_p = parseFloat( $("#prod_ivatype").val() ).toFixed(2);
            var iva   = ( subt / 100 ) * iva_p;
            total   = parseFloat(total) + subt + iva;
            var iva_tmp21 = 0;
            var iva_tmp105 = 0;

            if($("#prod_ivatype").val() == '21.00'){
                iva21= parseFloat(parseFloat(iva21) + iva).toFixed(2);
                iva_tmp21 = iva;
            }else{
                iva105= parseFloat(parseFloat(iva105) + iva).toFixed(2);
                iva_tmp105 = iva;
            }
            
            var line = "<tr>"+
                    "<td>"+numerador+
                    "<input type='hidden' name='product_id[]' value='"+$("#prod_id").val()+"'/>"+
                    "<input type='hidden' name='product_quantity[]' value='"+$("#quantity").val()+"'/>"+
                    "<input type='hidden' name='product_price[]' value='"+$("#price").val()+"'/>"+
                    "<input type='hidden' name='prod_iva21[]' id='prod_iva21' value='"+iva_tmp21+"'/>"+
                    "<input type='hidden' name='prod_iva105[]' id='prod_iva105' value='"+iva_tmp105+"'/>"+
                    "<input type='hidden' name='product_total[]' id='prod_subtotal' value='"+subt+"'/>"+
                    "<input type='hidden' name='product_subtotal[]' id='prod_total' value='"+(subt+iva)+"'/>"+
                    "</td>"+
                    "<td>"+$("#prod_code").val()+"</td>"+
                    "<td>"+$("#prod_product").val()+"</td>"+
                    "<td>"+$("#price").val()+"</td>"+
                    "<td>"+$("#quantity").val()+"</td>"+
                    "<td>"+subt+"</td>"+
                    "<td><a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'></i></a> </td>"+
                    "</tr>";

            $("#tdIva105").html(iva105); 
            $("#iva105").val(iva105);
            $("#tdIva21").html(iva21); 
            $("#iva21").val(iva21); 
            $("#tdDescuento").html(desc); 
            $("#discount").val(desc); 
            $("#tdTotal").html(total); 
            $("#amount").val(total); 

            $("#productDetail tbody").append(line); 
            cleanProductElement();
            numerador++;
            $("#prod_ac").focus();
        }
    });

    /**
     * delete item
     */
    $("#productDetail").on("click", ".del", function(e){
        e.preventDefault();

        var i21 = $(this).closest('tr').find("td input[id='prod_iva21']").val();
        iva21 = (parseFloat(iva21) - parseFloat(i21)).toFixed(2);
        $("#tdIva21").html(iva21); 
        $("#iva21").val(iva21); 

        var i105 = $(this).closest('tr').find("td input[id='prod_iva105']").val();
        iva105 = (parseFloat(iva105) - parseFloat(i105)).toFixed(2);
        $("#tdIva105").html(iva105); 
        $("#iva105").val(iva105);

        var subt = $(this).closest('tr').find("td input[id='prod_total']").val();
        total = (parseFloat(total) - parseFloat(subt)).toFixed(2);
        $("#tdTotal").html(total); 
        $("#amount").val(total); 

        $(this).parents("tr").remove();
    });


    /**
     *autocomplete de customer
     */
    var path_c = "<?php echo e(route('customerAutocomplete')); ?>";
    $('#customer_ac').typeahead({
        minLength: 4,
        hint: true,
        highlight: true,  
        freeInput: false,
        autoselect: 'first',
        source:  function (query, process) {
            return $.get(path_c, { query: query }, function (data) {
                return process(data);
            });
        },
        updater: function(item){
            $("#customer_id").val(item.id);
            $("#ivacondition_id").val(item.ivacondition_id);
            $("#markup").val(item.markup);

            var group_id = $("#groupoperationtype_id").val();

            $.get(pathNextNumber, { group_id : group_id, ivacondition_id : item.ivacondition_id } , function (data) {
                $("#number").val(data.number);
                $("#operationtype_id").val(data.operationtype_id);
            });
            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#customer_ac').val() == ''){
            $('#customer_id').val('');
            $("#ivacondition_id").val();
            $("#markup").val();
        }
    });

    /**
     *autocomplete de product
     */
    var path_p = "<?php echo e(route('productAutocomplete')); ?>";
    $('#prod_ac').typeahead({
        minLength: 3,
        hint: true,
        highlight: true,  
        freeInput: false,
        autoselect: 'first',
        source:  function (query, process) {
            return $.get(path_p, { query: query }, function (data) {
                return process(data);
            });
        },
        updater: function(item){

            $("#prod_id").val(item.id);
            $("#prod_product").val(item.product);
            $("#prod_code").val(item.code);
            $("#prod_description").val(item.description);
            $("#prod_ivatype").val(item.ivatype.percent);
            $("#price").val(item.price);
            $("#stock").val(item.stock);

            $("#quantity").val(0);
            $("#quantity").attr({
                'max' : item.stock
            });

            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#prod_ac').val() == ''){
            $('#prod_id').val('');
        }
    });


    $("#groupoperationtype_id").change(function(){

        var ivacondition_id = $("#ivacondition_id").val();
        var group_id = $("#groupoperationtype_id").val();

        $.get(pathNextNumber, { group_id : group_id, ivacondition_id : ivacondition_id } , function (data) {
            $("#number").val(data.number);
            $("#operationtype_id").val(data.operationtype_id);  
        });
    });

    function cleanProductElement(){
        $("#prod_id").val('');
        $("#prod_product").val('');
        $("#prod_code").val('');
        $("#prod_description").val('');
        $("#prod_cylindertype_id").val('');
        $("#price").val('');
        $("#stock").val('');
        $("#quantity").val('');
        $("#prod_ac").val('');
    }

</script>