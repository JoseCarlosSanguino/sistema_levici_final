<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Customer;
use app\Models\Province;
use app\Models\Ivacondition;

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
            $customers = Customer::where('persontype_id', '=', 1)
                ->where('name', 'LIKE', "%$keyword%")
                ->orWhere('cuit', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $customers  = Customer::where('persontype_id', '=', 1)
                ->latest()
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
        $provinces = Province::pluck('province','id');
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
        return view('customers.show', compact('customer','title', 'modelName', 'controller'));
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
}
