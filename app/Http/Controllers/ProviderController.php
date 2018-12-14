<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Provider;
use app\Models\Province;
use app\Models\Ivacondition;

class ProviderController extends Controller
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
            $providers = Provider::where('persontype_id', '=', 2)
                ->where('name', 'LIKE', "%$keyword%")
                ->orWhere('cuit', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $providers  = Provider::where('persontype_id', '=', 2)
                ->latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de proveedores';
        $modelName  = 'Proveedor';
        $controller = 'providers';

        return view('providers.index',compact('providers', 'title', 'modelName', 'controller'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title      = 'Editar un proveedor';
        $modelName  = 'Proveedor';
        $controller = 'providers';
        $provinces = Province::pluck('province','id');
        $ivaconditions = Ivacondition::pluck('ivacondition','id');

        return view('providers.create',compact( 'title', 'modelName', 'controller','ivaconditions','provinces'));
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
        Provider::create($requestData);

        return redirect('providers')->with('flash_message', 'Proveedor creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un proveedor';
        $modelName  = 'Proveedor';
        $controller = 'providers';

        $provider = Provider::findOrFail($id);
        return view('providers.show', compact('provider','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un proveedor';
        $modelName  = 'Proveedor';
        $controller = 'providers';

        $provider = Provider::findOrFail($id);
        $provinces = Province::pluck('province','id');
        $ivaconditions = Ivacondition::pluck('ivacondition','id');

        return view('providers.edit', compact('provider','title', 'modelName', 'controller', 'ivaconditions','provinces'));
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
        
        $provider = Provider::findOrFail($id);
        $provider->update($requestData);

        return redirect('providers')->with('flash_message', 'Proveedor actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Provider::destroy($id);

        return redirect('providers')->with('flash_message', 'Proveedor eliminado!');
    }
}
