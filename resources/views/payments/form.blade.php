<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <div class="form-group">
        
        <div class="col-xs-2">
            {!! Form::label('payment_number','Número:'); !!}
        </div>
        <div class="col-xs-2">
            {!! Form::text('payment_number', '',['readonly' => 'readonly', 'class'=>'form-control']); !!}
            {!! Form::hidden('operationtype_id' , $operationtype_id, ['id' => 'operationtype_id']) !!}
        </div>
    </div>

    <div class="form-group">

        <div class="col-xs-2">
            {!! Form::label('date_of','Fecha:'); !!}
        </div>
        <div class="col-xs-2">
            {!! Form::text('date_of', date('d/m/Y'),['class'=>'form-control datepicker']); !!}
        </div>
    </div>
    </br>
    <div class="form-group">
        
        <div class="col-xs-2">
            {!! Form::label('person',($operationtype_id == 11)?'Cliente:':'Proveedor:'); !!}
        </div>
        <div class="col-xs-4">
            {!! Form::text('person_ac', '',['id'=>'person_ac', 'autocomplete' => 'off' ,'class'=>'typeahead form-control']); !!}
            {!! Form::hidden('person_id', '', ['id' => 'person_id']) !!}
        </div>
    </div>
    </br>

    <div class="form-group">
        <div class="col-xs-2">
            {!! Form::label('observation', 'Observaciones:'); !!}
        </div>
        <div class="col-xs-10">
            {!! Form::text('observation', isset($sale->operation->observation) ? $sale->operation->observation : '',['class'=>'form-control']);!!}
        </div>
    </div>
    <br>

<div class="form-group">
    <div class="col-xs-6">
    	{!! Form::label('fact','Facturas pendientes'); !!}
    	<div class="table-responsive">
    	    <table class="table" id="facturaDetail">
    	        <thead>
    	            <tr>
    	                <th>Fecha</th><th>Número</th><th class="text-right">Total</th><th class="text-right">Pendiente</th><th class="text-right">A cancelar</th>
    	            </tr>
    	        </thead>
    	        <tbody>
    	            
    	        </tbody>
    	    </table>
    	</div>
    	</br>
    </div>
    <div class="col-xs-6">
        {!! Form::label('form','FORMAS DE PAGO'); !!}
        <br>
        <br>

        <div class="form-group">

            <div class="col-xs-2">
                {!! Form::label('cash','Efectivo:'); !!}
            </div>
            <div class="col-xs-4">
                {!! Form::number('cash', '',['step' => '0.01', 'class'=>'form-control']); !!}
            </div>
        

            <div class="col-xs-2">
                {!! Form::label('debit','Débito:'); !!}
            </div>
            <div class="col-xs-4">
                {!! Form::number('debit', '',['step' => '0.01', 'class'=>'form-control']); !!}
            </div>
        </div>
        </br>


        {!! Form::label('check','Cheques'); !!}
        <div class="table-responsive">
            <table class="table" id="chequeDetail">
                <thead>
                    <tr>
                        <th>Número</th><th>Fecha</th><th>Banco</th><th>Tipo</th><th class="text-right">Monto</th><th><a href='#' id="btnCheque" class='add btn btn-success' ><i class='fa fa-plus' aria-hidden='true'></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        </br>

        {!! Form::label('trans','Transferencias'); !!}
        <div class="table-responsive">
            <table class="table" id="transferDetail">
                <thead>
                    <tr>
                        <th>Número</th><th>Fecha</th><th>Banco</th><th>Detalle</th><th class="text-right">Monto</th><th><a href='#' id="btnTransfer" class='add btn btn-success' ><i class='fa fa-plus' aria-hidden='true'></i></a></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>

        </br>
    </div>
</div>
</br>


<div class="table-responsive">
    {!! Form::hidden('payment_amount', 0, ['id'=>'payment_amount']) !!}
    <table class="table" id="totalDetail">
        <tbody>
            <tr>
                <td width="70%" align="right"><b>Cheques</b></td>
                <td id="tdCheque" style="font-size: 16px; font-weight: bold">0</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>Transferencia</b></td>
                <td id="tdTransfer" style="font-size: 16px; font-weight: bold">0</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>Efect y deb</b></td>
                <td id="tdCash" style="font-size: 16px; font-weight: bold">0</td>
            </tr>
            <tr>
                <td width="70%" align="right"><b>TOTAL</b></td>
                <td id="tdTotal" style="font-size: 16px; font-weight: bold">0</td>
            </tr>
        </tbody>
    </table>
</div>
</br>

<div class="modal fade" id="chequeModalAlta" tabindex="-1" role="dialog" aria-labelledby="Nuevo cheque">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;        </span></button>
                <h4 class="modal-title" id="myModalLabel">Nuevo cheque</h4>
            </div>
            <div class="modal-body">
                @include ('paychecks.form')
            </div>
            <div class="modal-footer">
                <button type="button" id="btnNewPaycheck" class="btn btn-success" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chequeModalBuscar" tabindex="-1" role="dialog" aria-labelledby="Elección de cheques">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;        </span></button>
                <h4 class="modal-title" id="myModalLabel">Elegir un cheque</h4>
            </div>
            <div class="modal-body">
                <table class="table" id="tablePaycheck">
                    <thead>
                        <tr>
                            <th>Número</th><th>Fecha</th><th>Monto</th><th>Banco</th><th>Propietario</th><th>Tipo</th>
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

<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="Nueva transferencia">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;        </span></button>
                <h4 class="modal-title" id="myModalLabel">Nueva transferencia</h4>
            </div>
            <div class="modal-body">
                @include ('payments.transfer_modal')
            </div>
            <div class="modal-footer">
                <button type="button" id="btnNewTransfer" class="btn btn-success" data-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<br>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="Crear">
</div>

<script type="text/javascript">


    var paycheckTotal = parseFloat(0);
    var transferTotal = parseFloat(0);
    var cashDebTotal = parseFloat(0);
    var total = parseFloat(0);
    var paychecks = [];


	 $(function(){
        $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            language: "es",
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd/mm/yy'
        });

        var path = "{{ route('nextNumber') }}";
        $.get(path, { operationtype_id: {{ $operationtype_id }} } , function (data) {
            $("#payment_number").val(data);
        });
    });

    $('form input').on('keypress', function(e) {
        return e.which !== 13;
    });

    /**
     *autocomplete de customer
     */
    
    if({{$operationtype_id}} == 11){
        var path_c = "{{ route('customerAutocomplete') }}";
        var pathFact = "{{ route('saleJson') }}";
    }else{
        var path_c = "{{ route('providerAutocomplete') }}";
        var pathFact = "{{ route('purchaseJson') }}";
    }
    

    $('#person_ac').typeahead({
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
            $("#person_id").val(item.id);

            //busco las facturas
            $("#facturaDetail tbody").empty();

            if({{$operationtype_id}} == 11){
                var status = "1,2";
            }else{
               var status = "4,5";
            }
            
        	$.get(pathFact, {order: 'asc', person_id: item.id, status_id: status } , function (data) {
        		$.each(data, function(i, sale){
        			var residue=parseFloat(sale.operation.amount);
        			if(sale.operation.status_id == 2 || sale.operation.status_id == 5){
        				$.each(sale.payments, function(x,rec){
        					residue = parseFloat(rec.pivot.residue);
        				});
        			}
        			var number = sale.operation.operationtype.letter + ('0000' + sale.operation.operationtype.pointofsale).slice(-4) + '-'+ ('00000000' + sale.operation.number).slice(-8);
        			var line = "<tr>"+
        					"<td>"+sale.operation.dateof+
                            "<input type='hidden' id='fact_id' name='fact_id[]' value='"+sale.id+"'>"+
                            "<input type='hidden' id='fact_residue' name='fact_residue[]' value='"+residue+"'>"+
                            "<input type='hidden' id='fact_canceled' name='fact_canceled[]' value='0'>"+
                            "</td>"+
        					"<td>"+number+"</td>"+
        					"<td align='right'>"+sale.operation.amount+"</td>"+
        					"<td id='residue' align='right'>"+residue.toFixed(2)+"</td>"+
        					"<td align='right' id='canceled'>0"+
                            "</td>"+
    					"</tr>";

    				$("#facturaDetail tbody").append(line);
        		});
           	});

            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#person_ac').val() == ''){
            $('#person_id').val('');
        }
    });


    $("#btnCheque").click(function(e){
        e.preventDefault();
        if({{$operationtype_id}} == 11){
            $("#chequeModalAlta").modal('show');
        }else{
            var pathCheque = "{{ route('paycheckJson') }}";
            $.get(pathCheque, { status_id: 16 } , function (data) {

                $("#tablePaycheck tbody").empty();
                    $.each(data, function(i, item) {
                        if($.inArray(item.id, paychecks) < 0){
                            var line = "<tr id="+item.id+"><td class='number'>"+item.number+"</td>"+
                                "<td class='paymentdate'>"+item.paymentdate+"</td>"+
                                "<td class='amount'>"+item.amount+"</td>"+
                                "<td class='bank'>"+item.bank+"</td>"+
                                "<td class='owner_name'>"+item.owner_name+"</td>"+
                                "<td class='type'>"+item.type+"</td>"+
                                "<td><a href='#' id="+item.id+" class='add btn btn-success' ><i class='fa fa-plus' aria-hidden='true'></i></a> </td></tr>";
                            $("#tablePaycheck tbody").append(line);
                        }
                    });
            });


            $("#chequeModalBuscar").modal('show');
        }
    });

    $("#tablePaycheck").on("click",".add", function(e){
        e.preventDefault();
        var paycheckid  = $(this).closest('tr').attr('id');
        var number      = $(this).closest('tr').find(".number").text();
        var bank_name   = $(this).closest('tr').find(".bank").text();
        var paymentdate = $(this).closest('tr').find(".paymentdate").text();
        var amount      = parseFloat($(this).closest('tr').find(".amount").text());
        var type        = $(this).closest('tr').find(".type").text();

        var line = "<tr>"+
                        "<td>"+number+
                        "</td>"+
                        "<td>"+paymentdate+"</td>"+
                        "<td>"+bank_name+"</td>"+
                        "<td>"+type+"</td>"+
                        "<td align='right'>"+amount+"</td>"+
                        "<td>"+
                            "<input type='hidden' name='cheque_id[]' id='cheque_id' value='"+paycheckid+"'></input>"+
                            "<input type='hidden' name='cheque_amount_ex' id='cheque_amount' value='"+amount+"'></input>"+
                            "<a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'> </i></a>"+
                        "</td>"+
                    "</tr>";

        $("#chequeDetail tbody").append(line);

        paycheckTotal = paycheckTotal + amount;
        total = total + amount;

        descontarFactura();

        $(this).parents("tr").remove();
        paychecks.push(parseInt(paycheckid));

        $("#tdTotal").html(total); 
        $("#tdCheque").html(paycheckTotal); 

    });

    $("#btnNewPaycheck").click(function(e){
        e.preventDefault();
        var number = $("#chequeModalAlta #number").val();
        var amount = parseFloat($("#chequeModalAlta #amount").val());
        var type = $("#chequeModalAlta #type").val();
        var paymentdate = $("#chequeModalAlta #paymentdate").val();
        var expiration = $("#chequeModalAlta #expiration").val();
        var owner_name = $("#chequeModalAlta #owner_name").val();
        var owner_cuit = $("#chequeModalAlta #owner_cuit").val();
        var observation = $("#chequeModalAlta #observation").val();
        var bank_id = $("#chequeModalAlta #bank_id").val();
        var branch = $("#chequeModalAlta #branch").val();
        var bank_text = '';
        if(bank_id > 0){
            bank_text = $("#chequeModalAlta #bank_id option:selected").text();
        }

        var line = "<tr>"+
                        "<td>"+number+
                        "</td>"+
                        "<td>"+paymentdate+"</td>"+
                        "<td>"+bank_text+"</td>"+
                        "<td>"+type+"</td>"+
                        "<td align='right'>"+amount+"</td>"+
                        "<td>"+
                            "<input type='hidden' name='cheque_number[]' id='cheque_number' value='"+number+"'></input>"+ 
                            "<input type='hidden' name='cheque_paymentdate[]' id='cheque_paymentdate' value='"+paymentdate+"'></input>"+
                            "<input type='hidden' name='cheque_expiration[]' id='cheque_expiration' value='"+expiration+"'></input>"+
                            "<input type='hidden' name='cheque_amount[]' id='cheque_amount' value='"+amount+"'></input>"+
                            "<input type='hidden' name='cheque_type[]' id='cheque_type' value='"+type+"'></input>"+
                            "<input type='hidden' name='cheque_owner_name[]' id='cheque_owner_name' value='"+owner_name+"'></input>"+
                            "<input type='hidden' name='cheque_owner_cuit[]' id='cheque_owner_cuit' value='"+owner_cuit+"'></input>"+
                            "<input type='hidden' name='cheque_observation[]' id='cheque_observation' value='"+observation+"'></input>"+
                            "<input type='hidden' name='cheque_bank_id[]' id='cheque_bank_id' value='"+bank_id+"'></input>"+
                            "<a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'> </i></a>"+
                        "</td>"+
                    "</tr>";

        $("#chequeDetail tbody").append(line);

        paycheckTotal = paycheckTotal + amount;
        total = total + amount;
        descontarFactura();

        $("#tdTotal").html(total.toFixed(2)); 
        $("#tdCheque").html(paycheckTotal.toFixed(2)); 

        $("#chequeModalAlta").find('input').val('');

    });

    /**
     * delete item
     */
    $("#chequeDetail").on("click", ".del", function(e){
        e.preventDefault();
        
        var subt = parseFloat($(this).closest('tr').find("td input[id='cheque_amount']").val());
        var idc = $(this).closest('tr').find("td input[id='cheque_id']").val();

        if(idc != null){
            paychecks.splice( $.inArray(idc, paychecks), 1 );
        }

        total = total - subt;
        paycheckTotal = paycheckTotal - subt;
        descontarFactura();
        
        $("#tdTotal").html(total); 
        $("#tdCheque").html(paycheckTotal); 
        

        $(this).parents("tr").remove();
    });


    $("#btnTransfer").click(function(e){
        e.preventDefault();
        $("#transferModal").modal('show');
    });


    $("#btnNewTransfer").click(function(e){
        e.preventDefault();
        var number = $("#transferModal #number").val();
        var amount = parseFloat($("#transferModal #amount").val());
        var date_of = $("#transferModal #date_of").val();
        var observation = $("#transferModal #observation").val();
        var bank_id = $("#transferModal #bank_id").val();
        var bank_text = '';
        if(bank_id > 0){
            bank_text = $("#transferModal #bank_id").text();
        }


        var line = "<tr>"+
                        "<td>"+number+"</td>"+
                        "<td>"+date_of+"</td>"+
                        "<td>"+bank_text+"</td>"+
                        "<td>"+observation+"</td>"+
                        "<td align='right'>"+amount+"</td>"+
                        "<td>"+
                            "<input type='hidden' name='transfer_number[]' id='transfer_number' value='"+number+"'></input>"+ 
                            "<input type='hidden' name='transfer_dateof[]' id='transfer_dateof' value='"+date_of+"'></input>"+
                            "<input type='hidden' name='transfer_amount[]' id='transfer_amount' value='"+amount+"'></input>"+
                            "<input type='hidden' name='transfer_observation[]' id='transfer_observation' value='"+observation+"'></input>"+
                            "<input type='hidden' name='transfer_bank_id[]' id='transfer_bank_id' value='"+bank_id+"'></input>"+

                            "<a href='#' class='del btn btn-danger' ><i class='add fa fa-minus' aria-hidden='true'> </i></a>"+
                        "</td>"+
                    "</tr>";

        $("#transferDetail tbody").append(line);

        transferTotal = transferTotal + amount;
        total = total + amount;
        descontarFactura();

        $("#tdTotal").html(total.toFixed(2)); 
        $("#tdTransfer").html(transferTotal.toFixed(2)); 

        $("#transferModal").find('input').val('');

    });


    /**
     * delete item
     */
    $("#transferDetail").on("click", ".del", function(e){
        e.preventDefault();
        
        var subt = parseFloat($(this).closest('tr').find("td input[id='transfer_amount']").val()).toFixed(2);
        total = total -subt;
        transferTotal = transferTotal - subt;
        $("#tdTotal").html(total); 
        $("#tdTransfer").html(transferTotal); 
        descontarFactura();

        $(this).parents("tr").remove();

    });

    $("#cash").change(function(){
        total = total - cashDebTotal;
        var efect = parseFloat($("#cash").val());
        if(!$.isNumeric(efect)) efect = parseFloat(0);
        var debit = parseFloat($("#debit").val());
        if(!$.isNumeric(debit)) debit = parseFloat(0);
        
        cashDebTotal = parseFloat(efect + debit);
        total = parseFloat(total) + cashDebTotal;

        $("#tdCash").html(cashDebTotal);
        $("#tdTotal").html(total); 
        descontarFactura();
    });

    $("#debit").change(function(){
        total = total - cashDebTotal;
        var efect = parseFloat($("#cash").val());
        if(!$.isNumeric(efect)) efect = parseFloat(0);
        var debit = parseFloat($("#debit").val());
        if(!$.isNumeric(debit)) debit = parseFloat(0);


        cashDebTotal = efect + debit;
        total = total + cashDebTotal;

        $("#tdCash").html(cashDebTotal);
        $("#tdTotal").html(total); 
        descontarFactura();
    });


    //calculo de rescuento de facturas
    function descontarFactura(){
        var total_tmp = total;
        $("#payment_amount").val(total);

        $('#facturaDetail tbody tr').each(function () {
            var residue = parseFloat($(this).find("td input[id=fact_residue]").val());

            if(total_tmp > 0){
                if(total_tmp >= residue){
                    $(this).find("td").eq(4).html(residue.toFixed(2));
                    $(this).find("td input[id=fact_canceled]").val(residue.toFixed(2));
                    total_tmp = total_tmp - residue;
                }else{
                    $(this).find("td").eq(4).html(total_tmp.toFixed(2));
                    $(this).find("td input[id=fact_canceled]").val(total_tmp.toFixed(2));
                    total_tmp = 0;
                }
            }else{
                $(this).find("td").eq(4).html(0);
                $(this).find("td [id=canceled]").html(0);
            }
        });

    };



</script>