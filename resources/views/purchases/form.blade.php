
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<!-- Es este o el que está en layout/app.blade.php-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->


<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('Tipo','Tipo de documento:'); !!}
    </div>
    <div class="col-xs-3">
        {!! Form::select('operationtype_id', $operationtypes,1,['id' => 'operationtype_id', 'class'=>'form-control', 'placeholder'=>'Tipo de documento']); !!}
    </div>
</div>

<div class="form-group">
    
    <div class="col-xs-2">
        {!! Form::label('number','Número:'); !!}
    </div>
    <div class="col-xs-3">
        {!! Form::text('number', isset($number)?$number:'',['id'=> 'number', 'class'=>'form-control']); !!}
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
        {!! Form::label('provider','Proveedor:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('provider_ac', isset($remito->provider->name)?$remito->provider->name:'',['id'=>'provider_ac', 'autocomplete' => 'off' ,'class'=>'typeahead form-control']); !!}
        {!! Form::hidden('provider_id', isset($remito->provider_id)?$remito->provider_id:'', ['id' => 'provider_id']) !!}
        {!! Form::hidden('ivacondition_id', isset($remito->provider->ivacondition_id)?$remito->provider->ivacondition_id:'', ['id' => 'ivacondition_id']) !!}
        {!! Form::hidden('markup', isset($remito->provider->markup)?$remito->provider->markup:0, ['id' => 'markup']) !!}

        
    </div>
</div>
</br>

<div class="form-group">
    <div class="col-xs-2">
        {!! Form::label('observation', 'Observaciones:'); !!}
    </div>
    <div class="col-xs-10">
        {!! Form::text('observation', isset($remito->id)?'Remito nº: ' . $remito->operation->fullnumber: '',['class'=>'form-control']);!!}
    </div>
</div>
<br>
<h4>Detalle</h4>
<br>
<div class="form-group">
    <div class="col-xs-1">
        {!! Form::label('product','Artículo:'); !!}
    </div>
    <div class="col-xs-3" style="width:30%">
        {!! Form::text('prod_ac', '',[ 'id' => 'prod_ac', 'autocomplete' => 'off' , 'class'=>'typeahead form-control']); !!} 

        {!! Form::hidden('prod_id'              , '', ['id' => 'prod_id']) !!}
        {!! Form::hidden('prod_code'            , '', ['id' => 'prod_code']) !!}
        {!! Form::hidden('prod_product'         , '', ['id' => 'prod_product']) !!}
        {!! Form::hidden('prod_description'     , '', ['id' => 'prod_description']) !!}
        {!! Form::hidden('prod_ivatype'         , '', ['id' => 'prod_ivatype']) !!}
        {!! Form::hidden('prod_cylindertype_id' , '', ['id' => 'prod_cylindertype_id']) !!}
    </div>

    <div class="col-xs-1">
        {!! Form::label('price','Costo:'); !!}
    </div>
    <div class="col-xs-1"  style="width:10%" >
        {!! Form::number('cost', '',[ 'id' => 'cost', 'class'=>'form-control','step' => '0.1', 'min' => '0']); !!}
    </div>
    <div class="col-xs-1">
        {!! Form::label('quantity','Cantidad:'); !!}
    </div>
    <div class="col-xs-1" style="width:8%" >
        {!! Form::number('quantity', '',[ 'id' => 'quantity', 'class'=>'form-control','step' => '0.1', 'min' => '0']); !!}
    </div>
    <div class="col-xs-1">
        {!! Form::label('price_vta','Precio:'); !!}
    </div>
    <div class="col-xs-1"  style="width:10%" >
        {!! Form::number('price', '',[ 'id' => 'price', 'class'=>'form-control','step' => '0.1', 'min' => '0']); !!}
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
            
        </tbody>
    </table>
</div>
</br>
<div class="table-responsive">
    <table class="table" id="totalDetail">
        <tbody>
            {!! Form::hidden('amount', isset($total)?$total: 0, ['id'=>'amount']) !!}
            {!! Form::hidden('discount', isset($discount)?$discount: 0, ['id'=>'discount']) !!}
            {!! Form::hidden('iva105', isset($iva105)?$iva105: 0, ['id'=>'iva105']) !!}
            {!! Form::hidden('iva21', isset($iva21)?$iva21: 0, ['id'=>'iva21']) !!}
            {!! Form::hidden('remito_id', isset($remito->id)?$remito->id: '', ['id'=>'iva21']) !!}
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
    <input class="btn btn-primary" type="submit" value="Crear">
</div>


<div class="modal fade" id="cylinderModal" tabindex="-1" role="dialog" aria-labelledby="Elección de cilindro">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;        </span></button>
                <h4 class="modal-title" id="myModalLabel">Elegir cilindro</h4>
            </div>
            <div class="modal-body">
                <table class="table" id="tableCylinder">
                    <thead>
                        <tr>
                            <th>Código</th><th>Capacidad</th><th>Tipo</th><th>Obs</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

    var numerador = 1;
    var total = 0;
    var iva105= 0;
    var iva21 = 0;
    var desc  = 0;
    var pathNextNumber = "{{ route('nextSaleNumber') }}";
    var cylinders=[];

    $(function(){
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            language: "es",
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd/mm/yy'
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
            var path_cylinder = "{{ route('cylinderJson') }}";
            if($("#prod_cylindertype_id").val() > 0 || $("#prod_cylindertype_id").val() != ''){

                $.get(path_cylinder, { cylindertype_id: $("#prod_cylindertype_id").val() , status_id: '12'} , function (data) {
                    $("#tableCylinder tbody").empty();
                    $.each(data, function(i, item) {
                        console.log(cylinders);
                        console.log(item.id);
                        console.log($.inArray(item.id, cylinders) );
                        if($.inArray(item.id, cylinders) < 0){
                            var line = "<tr id="+item.id+"><td class='code'>"+item.code+"</td>"+
                                "<td class='capacity'>"+item.capacity+"</td>"+
                                "<td class='cylindertype'>"+item.cylindertype+"</td>"+
                                "<td class='obs'>"+item.observation+"</td>"+
                                "<td><a href='#' id="+item.id+" class='add btn btn-success' ><i class='fa fa-plus' aria-hidden='true'></i></a> </td></tr>";
                            $("#tableCylinder tbody").append(line);
                        }
                    });
                });

                $("#cylinderModal").modal('show');

            }else{

                var price = parseFloat( $("#cost").val()).toFixed(2) ;
                var quant = parseFloat( $("#quantity").val()).toFixed(2);

                var subt  = price * quant;
                var iva_p = parseFloat( $("#prod_ivatype").val() ).toFixed(2);
                var iva   = ( subt / 100 ) * iva_p;
                var iva_1 = 0;
                var iva_2 = 0;

                total   = parseFloat(parseFloat(total) + subt + iva).toFixed(2);

                if($("#prod_ivatype").val() == '21.00'){
                    iva21= parseFloat(parseFloat(iva21) + iva).toFixed(2);
                    iva_2 = iva;
                }else{
                    iva105= parseFloat(parseFloat(iva105) + iva).toFixed(2);
                    iva_1 = iva;
                }


                var line = "<tr>"+
                        "<td>"+numerador+
                        "<input type='hidden' name='product_id[]' value='"+$("#prod_id").val()+"'/>"+
                        "<input type='hidden' name='product_quantity[]' value='"+quant+"'/>"+
                        "<input type='hidden' name='product_price[]' value='"+price+"'/>"+
                        "<input type='hidden' name='product_price_vta[]' value='"+$("#price").val()+"'/>"+
                        "<input type='hidden' id='subtotal' name='subtotal' value='"+subt+"'/>"+
                        "<input type='hidden' id='prod_total' name='prod_total' value='"+parseFloat(subt+iva)+"'/>"+
                        "<input type='hidden' id='prod_iva21' name='prod_iva21' value='"+iva_2+"'/>"+
                        "<input type='hidden' id='prod_iva105' name='prod_iva105' value='"+iva_1+"'/>"+
                        "</td>"+
                        "<td>"+$("#prod_code").val()+"</td>"+
                        "<td>"+$("#prod_product").val()+"</td>"+
                        "<td>"+addCommas(price)+"</td>"+
                        "<td>"+quant+"</td>"+
                        "<td>"+addCommas(subt)+"</td>"+
                        "<td><a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'></i></a> </td>"+
                        "</tr>";

                $("#tdIva105").html(addCommas(iva105));
                $("#iva105").val(iva105);
                $("#tdIva21").html(addCommas(iva21));
                $("#iva21").val(iva21);
                $("#tdDescuento").html(addCommas(desc));
                $("#discount").val(desc);
                $("#tdTotal").html(addCommas(total));
                $("#amount").val(addCommas(total));

                $("#productDetail tbody").append(line); 
                cleanProductElement();
                numerador++;
                $("#prod_ac").focus();
            }
        }
    });

    $("#tableCylinder").on("click",".add", function(e){
        e.preventDefault();
        var cylinderid  = $(this).closest('tr').attr('id');
        var code        = $(this).closest('tr').find(".code").text();
        var capacity    = $(this).closest('tr').find(".capacity").text();
        var obs         = $(this).closest('tr').find(".obs").text();
        var cylindertype= $(this).closest('tr').find(".cylindertype").text();

        var price = parseFloat( $("#cost").val()).toFixed(2) ;

        var subt  = price * capacity;
        var iva_p = parseFloat( $("#prod_ivatype").val() ).toFixed(2);
        var iva   = ( subt / 100 ) * iva_p;
        var iva_1 = 0;
        var iva_2 = 0;

        total   = parseFloat(parseFloat(total) + subt + iva).toFixed(2);

        if($("#prod_ivatype").val() == '21.00'){
            iva21= parseFloat(parseFloat(iva21) + iva).toFixed(2);
            iva_2 = iva;
        }else{
            iva105= parseFloat(parseFloat(iva105) + iva).toFixed(2);
            iva_1 = iva;
        }


        var line = "<tr id='tr"+numerador+"'>"+
            "<td>"+numerador+
            "<input type='hidden' name='product_id[]' value='"+$("#prod_id").val()+"'/>"+
            "<input type='hidden' name='product_quantity[]' value='"+parseFloat(capacity)+"'/>"+
            "<input type='hidden' name='product_price[]' value='"+price+"'/>"+
            "<input type='hidden' name='product_price_vta[]' value='"+$("#price").val()+"'/>"+
            "<input type='hidden' id='cylinder_id' name='cylinder_id[]' value='"+cylinderid+"'/>"+
            "<input type='hidden' id='subtotal' name='subtotal' value='"+subt+"'/>"+
            "<input type='hidden' id='prod_total' name='prod_total' value='"+parseFloat(subt+iva)+"'/>"+
            "<input type='hidden' id='prod_iva21' name='prod_iva21' value='"+iva_2+"'/>"+
            "<input type='hidden' id='prod_iva105' name='prod_iva105' value='"+iva_1+"'/>"+
            "</td>"+
            "<td>"+$("#prod_code").val()+"</td>"+
            "<td>"+$("#prod_product").val()+" " + cylindertype + "(Cod: " + code + ")</td>"+
            "<td>"+addCommas(price)+"</td>"+
            "<td>"+capacity+"</td>"+
            "<td>"+addCommas(price*parseFloat(capacity).toFixed(2))+"</td>"+
            "<td><a href='#' class='del btn btn-danger' ><i class='fa fa-minus' aria-hidden='true'></i></a> </td>"+
            "</tr>";

        $("#tdIva105").html(addCommas(iva105));
        $("#iva105").val(iva105);
        $("#tdIva21").html(addCommas(iva21));
        $("#iva21").val(iva21); 
        $("#tdDescuento").html(addCommas(desc));
        $("#discount").val(desc); 
        $("#tdTotal").html(addCommas(total));
        $("#amount").val(addCommas(total));

        $("#productDetail tbody").append(line); 

        $(this).parents("tr").remove();
        cylinders.push(parseInt(cylinderid));

    });


    /**
     * delete item
     */
    $("#productDetail").on("click", ".del", function(e){
        e.preventDefault();


        var i21 = $(this).closest('tr').find("td input[id='prod_iva21']").val();
        iva21 = (parseFloat(iva21) - parseFloat(i21)).toFixed(2);
        $("#tdIva21").html(addCommas(iva21));
        $("#iva21").val(iva21); 

        var i105 = $(this).closest('tr').find("td input[id='prod_iva105']").val();
        iva105 = (parseFloat(iva105) - parseFloat(i105)).toFixed(2);
        $("#tdIva105").html(addCommas(iva105));
        $("#iva105").val(iva105);

        var subt = $(this).closest('tr').find("td input[id='prod_total']").val();
        total = (parseFloat(total) - parseFloat(subt)).toFixed(2);
        $("#tdTotal").html(addCommas(total));
        $("#amount").val(total); 


        var cyl_id = $(this).closest('tr').find("td input[id='cylinder_id']").val();
        if(cyl_id != null){
            cylinders.splice( $.inArray(cyl_id, cylinders), 1 );
        }

        $(this).parents("tr").remove();
    });


    $("#cylinderModal").on("hidden.bs.modal", function () {
        $("#prod_ac").focus();
        cleanProductElement();
    });


    /**
     *autocomplete de provider
     */
    var path_c = "{{ route('providerAutocomplete') }}";
    $('#provider_ac').typeahead({
        minLength: 3,
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
            $("#provider_id").val(item.id);
            $("#ivacondition_id").val(item.ivacondition_id);
            $("#markup").val(item.markup);

            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#provider_ac').val() == ''){
            $('#provider_id').val('');
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
            var cyltype = [];
            $.each(item.cylindertypes, function(i,ct){
                cyltype.push(ct.id);
            });
            $("#prod_id").val(item.id);
            $("#prod_product").val(item.product);
            $("#prod_code").val(item.code);
            $("#prod_description").val(item.description);
            $("#prod_ivatype").val(item.ivatype.percent);
            $("#prod_cylindertype_id").val(cyltype.join(','));
            $("#cost").val(item.cost);
            $("#stock").val(item.stock);

            $("#quantity").val(0);
            $("#quantity").attr({
                'max' : item.stock
            });
            calcPrice();
            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#prod_ac').val() == ''){
            $('#prod_id').val('');
        }
    });

    $("#cost").change(function(){
        calcPrice();
    });

    function calcPrice()
    {
        var cost = $("#cost").val();
        var markup = $("#markup").val();

        var price = parseFloat(cost) + (parseFloat(cost) / 100 * parseFloat(markup));
        $("#price").val(price);
    }

    $("#operationtype_id").change(function(){
        if($("#operationtype_id").val() >= 1 && $("#number").val() != ''){
            $("#btnSubmit").removeAttr('disabled');
        }else        {
            $("#btnSubmit").attr('disabled','disabled');
        }
    });

    $("#operationtype_id").change(function(){
       if($("#operationtype_id").val() >= 1 && $("#number").val() != ''){
            $("#btnSubmit").removeAttr('disabled');
        }else        {
            $("#btnSubmit").attr('disabled','disabled');
        } 
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