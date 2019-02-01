
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<!-- Es este o el que está en layout/app.blade.php-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->
@php echo isset($e)?$e->getMessage():''; @endphp

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('Tipo','Tipo de documento:'); !!}
    </div>
    <div class="col-xs-3">
        {!! Form::select('groupoperationtype_id', $groupoperationtypes,1,['id' => 'groupoperationtype_id', 'class'=>'form-control', 'placeholder'=>'Tipo de documento']); !!}
    </div>
</div>

<div class="form-group">
    
    <div class="col-xs-2">
        {!! Form::label('number','Número:'); !!}
    </div>
    <div class="col-xs-3">
        {!! Form::text('number', isset($number)?$number:'',['readonly' => 'readonly', 'class'=>'form-control']); !!}
        {!! Form::hidden('operationtype_id' , isset($operationtype_id)?$operationtype_id:'', ['id' => 'operationtype_id']) !!}
    </div>
</div>

<div class="form-group">

    <div class="col-xs-2">
        {!! Form::label('date','Fecha:'); !!}
    </div>
    <div class="col-xs-2">
        {!! Form::text('date_of', isset($sale->date_of) ? $sale->date_of : date('d/m/Y'),['class'=>'form-control datepicker']); !!}
    </div>
</div>
</br>

<div class="form-group">

    <div class="col-xs-2">
        {!! Form::label('condition', 'Condición:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::label('condition', 'Contado'); !!}&nbsp;&nbsp;
        {{ Form::radio('conditions', 'contado' , false) }}&nbsp;&nbsp;&nbsp;&nbsp;
        {!! Form::label('condition', 'Cuenta Corriente'); !!}&nbsp;&nbsp;
        {{ Form::radio('conditions', 'cta cte' , true) }}
    </div>
</div>
</br>
<div class="form-group">
    
    <div class="col-xs-2">
        {!! Form::label('customer','Cliente:'); !!}
    </div>
    <div class="col-xs-3">
        {!! Form::text('customer_ac', isset($sale->customer->name)?$sale->customer->name:'',['id'=>'customer_ac', 'autocomplete' => 'off' ,'class'=>'typeahead form-control']); !!}
        {!! Form::hidden('customer_id', isset($sale->customer_id)?$sale->customer_id:'', ['id' => 'customer_id']) !!}
        {!! Form::hidden('ivacondition_id', isset($sale->customer->ivacondition_id)?$sale->customer->ivacondition_id:'', ['id' => 'ivacondition_id']) !!}
        {!! Form::hidden('markup', isset($sale->customer->markup)?$sale->customer->markup:0, ['id' => 'markup']) !!}

        
    </div>
</div>
</br>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('observation', 'Observaciones:'); !!}
    </div>
    <div class="col-xs-10">
        {!! Form::text('observation', (isset($sale->operation->operationtype_id) && $sale->operation->operationtype_id == 13)?$sale->operation->fullnumber:'',['class'=>'form-control']);!!}
    </div>
</div>
<br>
<h4>Detalle</h4>
<br>
<div class="form-group">
    <div class="col-xs-1"  style="width:6%" >
        {!! Form::label('product','Artículo:'); !!}
    </div>
    <div class="col-xs-4" style="width:26%">
        {!! Form::text('prod_ac', '',[ 'disabled' => 'disabled', 'id' => 'prod_ac', 'autocomplete' => 'off' , 'class'=>'typeahead form-control']); !!} 

        {!! Form::hidden('prod_id'          , '', ['id' => 'prod_id']) !!}
        {!! Form::hidden('prod_code'        , '', ['id' => 'prod_code']) !!}
        {!! Form::hidden('prod_product'     , '', ['id' => 'prod_product']) !!}
        {!! Form::hidden('prod_description' , '', ['id' => 'prod_description']) !!}
        {!! Form::hidden('prod_ivatype'     , '', ['id' => 'prod_ivatype']) !!}
    </div>
    <div class="col-xs-1" style="width:4%">
        {!! Form::label('stock','Stock:'); !!}
    </div>
    <div class="col-xs-1" style="width:8%">
        {!! Form::text('stock', '',[ 'id' => 'stock', 'readonly'=> 'readonly', 'class'=>'form-control']); !!}
    </div>
    <div class="col-xs-1" style="width:5%">
        {!! Form::label('price','Precio:'); !!}
    </div>
    <div class="col-xs-1"  style="width:10%" >
        {!! Form::number('price', '',[ 'id' => 'price', 'class'=>'form-control','step' => '0.1', 'min' => '0']); !!}
    </div>
    <div class="col-xs-1" style="width:5%">
        {!! Form::label('disc','Desc:'); !!}
    </div>
    <div class="col-xs-1"  style="width:10%" >
        {!! Form::number('disc', '',[ 'id' => 'disc', 'class'=>'form-control', 'value' => 0, 'step' => '0.1', 'min' => '0']); !!}
    </div>
    <div class="col-xs-1" style="width:6%">
        {!! Form::label('quantity','Cantidad:'); !!}
    </div>
    <div class="col-xs-1" style="width:10%" >
        {!! Form::number('quantity', '',[ 'id' => 'quantity', 'class'=>'form-control','step' => '0.1', 'min' => '0']); !!}
    </div>
    <div class="col-xs-1" style="width:5%">
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
            @if(isset($sale->id))
                @php 
                    $total = 0;
                    $iva21 = 0;
                    $iva105= 0;
                    $discount= 0;

                    $numerador=1;

                @endphp
                @foreach($sale->operation->products as $prod)
                    @php    
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
                        $prod_t = round($subt + $iva,2);

                        if($sale->customer->ivacondition_id != 1)
                        {
                            $subt = $prod_t;
                        }

                    @endphp
                    <tr>
                        <td>{{$numerador}}
                        <input type='hidden' name='product_id[]' value='{{$prod->id}}'/>
                        <input type='hidden' name='product_quantity[]' value='{{$prod->pivot->quantity}}'/>
                        <input type='hidden' name='product_price[]' value='{{$prod->pivot->price}}'/>
                        <input type='hidden' name='prod_iva21[]' value='{{$iva21 or ''}}'/>
                        <input type='hidden' name='prod_iva105[]' value='{{$iva105 or ''}}'/>
                        <input type='hidden' name='product_total[]' id='prod_subtotal' value='{{$subt}}'/>
                        <input type='hidden' name='product_subtotal[]' id='prod_total' value='{{$prod_t}}'/>
                        </td>
                    <td>{{$prod->code}}</td>
                    <td>{{$prod->product}}</td>
                    <td>{{$new_price}}</td>
                    <td>{{$prod->pivot->quantity}}</td>
                    <td>{{$subt }}</td>
                    <td><a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'></i></a> </td>
                    </tr>
                    {{$numerador++}}

                @endforeach
            @endif
            
        </tbody>
    </table>
</div>
</br>
<div class="table-responsive">
    {!! Form::hidden('amount', isset($total)?$total: 0, ['id'=>'amount']) !!}
    {!! Form::hidden('discount', isset($discount)?$discount: 0, ['id'=>'discount']) !!}
    {!! Form::hidden('iva105', isset($iva105)?$iva105: 0, ['id'=>'iva105']) !!}
    {!! Form::hidden('iva21', isset($iva21)?$iva21: 0, ['id'=>'iva21']) !!}
    {!! Form::hidden('remito_id', isset($remito_id)?$remito_id: '', ['id'=>'remito_id']) !!}
    <table class="table" id="totalDetail">
        <tbody>
            <tr>
                <td width="70%" align="right"><b>IVA 10,5%</b></td>
                <td id="tdIva105" style="font-size: 16px; font-weight: bold">{{$iva105 or 0}}</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>IVA 21%</b></td>
                <td id="tdIva21" style="font-size: 16px; font-weight: bold">{{$iva21 or 0}}</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>Descuento</b></td>
                <td id="tdDescuento" style="font-size: 16px; font-weight: bold">0</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>TOTAL</b></td>
                <td id="tdTotal" style="font-size: 16px; font-weight: bold">{{$total or 0}}</td>
            </tr>
        </tbody>
    </table>
</div>
</br>

<div class="form-group">
    <input id="btnCrear" disabled='disabled' class="btn btn-primary" type="submit" value="Crear">
</div>

<script type="text/javascript">

    var numerador = {{$numerador or 1}};
    var total = {{$total or 0}};
    var iva105= {{$iva105 or 0}};
    var iva21 = {{$iva21 or 0}};
    var desc  = {{$discount or 0}};
    var pathNextNumber = "{{ route('nextSaleNumber') }}";

    $(function(){
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            language: "es",
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd/mm/yy'
        });

        $.get(pathNextNumber, { group_id : {{ $groupoperationtype_id or 0 }}, ivacondition_id : {{$ivacondition_id or 0}} } , function (data) {
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
            var disc  = parseFloat( $("#disc").val()).toFixed(2);

            if(!(disc > 0)) disc = 0;

            var ivacondition_id = $("#ivacondition_id").val();

            var discount = parseFloat(price * (disc / 100) * quant); //descuento

            desc = parseFloat(desc + discount);

            var subt  = (price - discount) * quant; //sin iva
            var inter = ( subt / 100 ) * markup; //sin iva
            subt = subt + inter; //sin iva
            var iva_p = parseFloat( $("#prod_ivatype").val() ).toFixed(2);
            var iva   = ( subt / 100 ) * iva_p; //este es el iva
            var prod_t= subt + iva;

            total   = parseFloat(total) + subt + iva;
            if(ivacondition_id != 1){
                subt = prod_t;
            }
            
            var iva_tmp21 = 0;
            var iva_tmp105 = 0;

            if(ivacondition_id == 1){

                if($("#prod_ivatype").val() == '21.00'){
                    iva21= parseFloat(parseFloat(iva21) + iva).toFixed(2);
                    iva_tmp21 = iva;
                }else{
                    iva105= parseFloat(parseFloat(iva105) + iva).toFixed(2);
                    iva_tmp105 = iva;
                }
            }
            
            var line = "<tr>"+
                    "<td>"+numerador+
                    "<input type='hidden' name='product_id[]' value='"+$("#prod_id").val()+"'/>"+
                    "<input type='hidden' name='product_quantity[]' value='"+$("#quantity").val()+"'/>"+
                    "<input type='hidden' name='product_price[]' value='"+$("#price").val()+"'/>"+
                    "<input type='hidden' name='product_discount[]' id='product_discount' value='"+discount+"'/>"+
                    "<input type='hidden' name='prod_iva21[]' id='prod_iva21' value='"+iva_tmp21+"'/>"+
                    "<input type='hidden' name='prod_iva105[]' id='prod_iva105' value='"+iva_tmp105+"'/>"+
                    "<input type='hidden' name='product_total[]' id='prod_subtotal' value='"+subt+"'/>"+
                    "<input type='hidden' name='product_subtotal[]' id='prod_total' value='"+prod_t+"'/>"+
                    "</td>"+
                    "<td>"+$("#prod_code").val()+"</td>"+
                    "<td>"+$("#prod_product").val()+"</td>"+
                    "<td>"+$("#price").val()+"</td>"+
                    "<td>"+$("#quantity").val()+"</td>"+
                    "<td>"+subt.toFixed(2)+"</td>"+
                    "<td><a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'></i></a> </td>"+
                    "</tr>";

            $("#tdIva105").html(iva105);
            $("#iva105").val(iva105);
            $("#tdIva21").html(iva21); 
            $("#iva21").val(iva21); 
            $("#tdDescuento").html(desc.toFixed(2)); 
            $("#discount").val(desc); 
            $("#tdTotal").html(total.toFixed(2)); 
            $("#amount").val(total); 

            $("#productDetail tbody").append(line); 
            cleanProductElement();
            $("#btnCrear").prop('disabled', false);
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

        var disc_p = $(this).closest('tr').find("td input[id='product_discount']").val();
        desc = (parseFloat(desc) - parseFloat(disc_p)).toFixed(2);
        $("#tdDescuento").html(desc); 
        $("#discount").val(desc); 

        var subt = $(this).closest('tr').find("td input[id='prod_total']").val();
        total = (parseFloat(total) - parseFloat(subt)).toFixed(2);
        $("#tdTotal").html(total); 
        $("#amount").val(total); 

        $(this).parents("tr").remove();
    });


    /**
     *autocomplete de customer
     */
    var path_c = "{{ route('customerAutocomplete') }}";
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
            $("#prod_ac").prop( "disabled", false );
            $("#productDetail tbody").empty();
            $("#btnCrear").prop( "disabled", true );

            iva21 = 0;
            iva105= 0;
            total = 0;
            desc  = 0;
            $("#tdTotal").html(total); 
            $("#tdIva21").html(iva21); 
            $("#tdIva105").html(iva105); 
            $("#tdDescuento").html(desc); 

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
    var path_p = "{{ route('productAutocomplete') }}";
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
        $("#disc").val(0);
    }

</script>