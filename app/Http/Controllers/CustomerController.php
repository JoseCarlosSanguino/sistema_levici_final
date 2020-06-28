<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Customer;
use app\Models\Province;
use app\Models\Ivacondition;
use app\Models\Sale;
use app\Models\Operation;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $customers = Customer::where('name', 'LIKE', "%$keyword%")
                ->orWhere('cuit', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $customers  = Customer::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de clientes';
        $modelName  = 'Cliente';
        $controller = 'customers';

        return view('customers.index',compact('customers', 'title', 'modelName', 'controller'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title      = 'Editar un Cliente';
        $modelName  = 'cliente';
        $controller = 'customers';
        $provinces = Province::orderBy('province')->pluck('province','id');
        $ivaconditions = Ivacondition::pluck('ivacondition','id');

        return view('customers.create',compact( 'title', 'modelName', 'controller','ivaconditions','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $requestData['persontype_id'] = 1;

        $validatedData = $request->validate([
            'cuit' => 'required|max:13|unique:persons,cuit,persontype_id=1',
            'name' => 'required',
        ]);

        Customer::create($requestData);

        return redirect('customers')->with('flash_message', 'Cliente creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un cliente';
        $modelName  = 'cliente';
        $controller = 'customers';

        $customer = Customer::findOrFail($id);
        $sales = Sale::where('customer_id', $customer->id)->get();

        return view('customers.show', compact('customer','title', 'modelName', 'controller', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un cliente';
        $modelName  = 'cliente';
        $controller = 'customers';

        $customer = Customer::findOrFail($id);
        $provinces = Province::pluck('province','id');
        $ivaconditions = Ivacondition::pluck('ivacondition','id');

        return view('customers.edit', compact('customer','title', 'modelName', 'controller','ivaconditions', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $validatedData = $request->validate([
            'cuit' => 'required|max:13',
            'name' => 'required',
        ]);
        
        $Customer = Customer::findOrFail($id);
        $Customer->update($requestData);

        return redirect('customers')->with('flash_message', 'Cliente actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Customer::destroy($id);

        return redirect('customers')->with('flash_message', 'Cliente eliminado!');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Customer::select("id","name", "ivacondition_id", "markup")
            ->where('persontype_id',1)
            ->where("name","LIKE","%{$request->input('query')}%")
            ->get();
        return response()->json($data);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function ctacte(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        $where = '';
        if (!empty($keyword)) 
        {
            $where = 'and c.name like "%'.$keyword.'%" or c.cuit like "%'.$keyword.'%"';
        }

        $query = 'select sum(if(operationtype_id=15, amount*-1, if(operationtype_id=16, amount*-1, amount))) monto, count(o.id) cant, customer_id, c.name, c.cuit ';
        $query.= 'From operations o join sales s on (s.operation_id = o.id) join persons c on (c.id = s.customer_id) ';
        $query.= 'where operationtype_id in (1,2,15,16) and status_id in (1) ';
        $query.= $where; 
        $query.= 'group by s.customer_id, c.name, c.cuit order by monto desc ';

        $rows = DB::select($query);

        $title      = 'Listado de cuentas corrientes';
        $modelName  = 'Cliente';
        $controller = 'customers';

        return view('customers.ctacte',compact('customers', 'title', 'modelName', 'controller','rows'));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function detallectacte($id)
    {
        
        $operations = Sale::whereHas("operation", function($q){
                $q->wherein('operationtype_id',[1,2,3, 15,16,17,18]);
                $q->wherein('status_id', [1,2]);
            })
            ->where('customer_id',$id)
            ->with(['customer','operation'])
            ->latest()
            ->get();

        $title      = 'Facturas pendientes';
        $modelName  = 'Cliente';
        $controller = 'customers';

        return view('customers.detallectacte',compact('customers', 'title', 'modelName', 'controller','operations'));
    }

    public function ctactepdf($id)
    {
        $operations = Sale::whereHas("operation", function($q){
            $q->wherein('operationtype_id',[1,2,3, 15,16,17,18]);
            $q->wherein('status_id', [1,2]);
        })
            ->where('customer_id',$id)
            ->with(['customer','operation'])
            ->latest()
            ->get();

        $data = [
            'operations' => $operations
        ];

        $pdf = \PDF::loadView('customers.ctactepdf', $data);

        return $pdf->stream('Detalle-Cuenta-Corriente-'.$data['operations'][0]->customer->name.'.pdf');
    }
}
