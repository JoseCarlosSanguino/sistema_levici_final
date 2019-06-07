<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>  
<!-- Es este o el que está en layout/app.blade.php-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->


<div class="form-group">
    
    <div class="col-xs-2">
        {!! Form::label('number','Número:'); !!}
    </div>
    <div class="col-xs-2">
        {!! Form::text('number', '',['readonly' => 'readonly', 'class'=>'form-control']); !!}
        {!! Form::hidden('operationtype_id' , $operationtype_id, ['id' => 'operationtype_id']) !!}
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
        {!! Form::label('customer','Cliente:'); !!}
    </div>
    <div class="col-xs-4">
        {!! Form::text('customer_ac', '',['id'=>'customer_ac', 'autocomplete' => 'off' ,'class'=>'typeahead form-control']); !!}
        {!! Form::hidden('customer_id', '', ['id' => 'customer_id']) !!}
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
    <div class="col-xs-2">
        {!! Form::label('order_number', 'Orden de retiro:'); !!}
    </div>
    <div class="col-xs-2">
        {!! Form::text('order_number', isset($sale->order_number) ? $sale->order_number : '',['class'=>'form-control']);!!}
    </div>
</div>
<br>
<h4>Detalle</h4>
<br>
<div class="form-group">
    <div class="col-xs-1">
        {!! Form::label('product','Tipo de cilindro:'); !!}
    </div>
    <div class="col-xs-4" style="width:80%">
        {!! Form::text('prod_ac', '',[ 'id' => 'prod_ac', 'autocomplete' => 'off' , 'class'=>'typeahead form-control']); !!}

        {!! Form::hidden('prod_id'               , '', ['id' => 'prod_id']) !!}
        {!! Form::hidden('prod_cylindertype_id'  , '', ['id' => 'prod_cylindertype_id']) !!}
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
                <th>#</th><th>Código</th><th>Tipo Cilindro</th><th>Capacidad</th><th>Observaciones</th><th></th>
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
            <tr>
                <td width="70%" align="right"><b>CANTIDAD</b></td>
                <td id="tdTotal" style="font-size: 16px; font-weight: bold"></td>
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
    var cylinders = [];

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
            $("#number").val(data);
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
        
            $.get(path_cylinder, {'status_id':11, cylindertype_id: $("#prod_cylindertype_id").val(), customer_id : $("#customer_id").val() } , function (data) {
                $("#tableCylinder tbody").empty();
                $.each(data, function(i, item) {
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

        }
    });

    $("#tableCylinder").on("click",".add", function(e){
        e.preventDefault();
        var cylinderid  = $(this).closest('tr').attr('id');
        var code        = $(this).closest('tr').find(".code").text();
        var capacity    = $(this).closest('tr').find(".capacity").text();
        var obs         = $(this).closest('tr').find(".obs").text();
        var cylindertype= $(this).closest('tr').find(".cylindertype").text();

        var line = "<tr id='tr"+numerador+"'>"+
                "<td>"+numerador+
                "<input type='hidden' name='product_id[]' value='"+$("#prod_id").val()+"'/>"+
                "<input type='hidden' id='cylinder_id' name='cylinder_id[]' value='"+cylinderid+"'/>"+
                "</td>"+
                "<td>"+code+"</td>"+
                "<td>"+cylindertype+")</td>"+
                "<td>"+capacity+"</td>"+
                "<td>"+obs+"</td>"+
                "<td><a href='#' class='del btn btn-danger' ><i class='fa fa-minus' aria-hidden='true'></i></a> </td>"+
                "</tr>";

        total++;
        numerador++;
        $("#tdTotal").html(total); 

        $("#productDetail tbody").append(line); 

        $(this).parents("tr").remove();
        cylinders.push(parseInt(cylinderid));

    });


    
    /**
     * delete item and cylinder
     */
    $("#productDetail").on("click", ".del", function(e){
        e.preventDefault();

        var cyl_id = $(this).closest('tr').find("td input[id='cylinder_id']").val();
        cylinders.splice( $.inArray(cyl_id, cylinders), 1 );

        $(this).parents("tr").remove();
        total--;
        numerador--;
        $("#tdTotal").html(total); 
    });

    $("#cylinderModal").on("hidden.bs.modal", function () {
        $("#prod_ac").focus();
        cleanProductElement();
    });


    /**
     *autocomplete de customer
     */
    var path_c = "{{ route('customerAutocomplete') }}";
    $('#customer_ac').typeahead({
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
            $("#customer_id").val(item.id);
            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#customer_ac').val() == ''){
            $('#customer_id').val('');
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
            return $.get(path_p, {'only_cylinder':true, query: query }, function (data) {
                return process(data);
            });
        },
        updater: function(item){
            var cyltype = [];
            $.each(item.cylindertypes, function(i,ct){
                cyltype.push(ct.id);
            });
            $("#prod_id").val(item.id);
            $("#prod_cylindertype_id").val(cyltype.join(','));

            return item.name;
        }
    }).on('focusout',function(event){ 
        if($('#prod_ac').val() == ''){
            $('#prod_id').val('');
        }
    });

    function cleanProductElement(){
        $("#prod_ac").val('');
        $("#prod_id").val('');
        $("#prod_cylindertype_id").val('');
    }

</script>
