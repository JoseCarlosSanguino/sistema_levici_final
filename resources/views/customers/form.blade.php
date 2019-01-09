<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="control-label">{{ 'Razón Social' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ $customer->name or ''}}" >
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('cuit') ? 'has-error' : ''}}">
    <label for="cuit" class="control-label">{{ 'Cuit' }}</label>
    <input class="form-control" name="cuit" type="text" id="cuit" value="{{ $customer->cuit or ''}}" >
    {!! $errors->first('cuit', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
    <label for="address" class="control-label">{{ 'Dirección' }}</label>
    <input class="form-control" name="address" type="text" id="address" value="{{ $customer->address or ''}}" >
    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('telephone') ? 'has-error' : ''}}">
    <label for="telephone" class="control-label">{{ 'Teléfono' }}</label>
    <input class="form-control" name="telephone" type="text" id="telephone" value="{{ $customer->telephone or ''}}" >
    {!! $errors->first('telephone', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('web') ? 'has-error' : ''}}">
    <label for="web" class="control-label">{{ 'Página web' }}</label>
    <input class="form-control" name="web" type="text" id="web" value="{{ $customer->web or ''}}" >
    {!! $errors->first('web', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ $customer->email or ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('ivacondition_id') ? 'has-error' : ''}}">
    <label for="ivacondition_id" class="control-label">{{ 'Condición de IVA' }}</label>
    <select name="ivacondition_id" class="form-control" id="ivacondition_id" >
    @foreach ($ivaconditions as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($customer->ivacondition_id) && $customer->ivacondition_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('ivacondition_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('markup') ? 'has-error' : ''}}">
    <label for="markup" class="control-label">{{ 'Margen de ganancia' }}</label>
    <input class="form-control" type="number" name="markup" type="text" id="markup" value="{{ $customer->markup or '0'}}" >
    {!! $errors->first('markup', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('observation') ? 'has-error' : ''}}">
    <label for="observation" class="control-label">{{ 'Observaciones' }}</label>
    <input class="form-control" name="observation" type="text" id="observation" value="{{ $customer->observation or ''}}" >
    {!! $errors->first('observation', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('province_id') ? 'has-error' : ''}}">
    <label for="province_id" class="control-label">{{ 'Provincia' }}</label>
    <select name="province_id" class="form-control" id="province_id" >
    @foreach ($provinces as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($customer->province_id) && $customer->province_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('province_id', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('city_id') ? 'has-error' : ''}}">
    <label for="city_id" class="control-label">{{ 'Ciudad' }}</label>
    <select name="city_id" class="form-control" id="city_id" >
    </select>
    {!! $errors->first('city_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Crear' }}">
</div>


<script type="text/javascript">

    var path_city = "{{ route('cityJson') }}";
    var city_initial_val = {{ $customer->city_id or ''}}

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