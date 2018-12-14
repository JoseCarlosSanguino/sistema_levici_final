<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Cylindertype;

class CylindertypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) 
        {
            $cylindertypes = Cylindertype::where('Cylindertype', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $cylindertypes  = Cylindertype::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de tipos de Cilindro';
        $modelName  = 'tipo de Cilindro';
        $controller = 'cylindertypes';

        return view('cylindertypes.index',compact(
            'cylindertypes',
            'title', 'modelName', 'controller'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title      = 'Editar una tipo de Cilindro';
        $modelName  = 'Tipo de Cilindro';
        $controller = 'cylindertypes';
        

        return view('cylindertypes.create',compact( 'title', 'modelName', 'controller'));
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
        Cylindertype::create($requestData);

        return redirect('cylindertypes')->with('flash_message', 'Tipo de Cilindro creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un tipo de Cilindro';
        $modelName  = 'Tipo de Cilindro';
        $controller = 'cylindertypes';

        $cylindertype = Cylindertype::findOrFail($id);
        return view('cylindertypes.show', compact('cylindertype','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un tipo de Cilindro';
        $modelName  = 'tipo de Cilindro';
        $controller = 'cylindertypes';

        $cylindertype = Cylindertype::findOrFail($id);

        return view('cylindertypes.edit', compact('cylindertype','title', 'modelName', 'controller'));
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
       
        $cylindertype = Cylindertype::findOrFail($id);
        $cylindertype->update($requestData);

        return redirect('cylindertypes')->with('flash_message', 'Tipo de Cilindro actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Cylindertype::destroy($id);

        return redirect('cylindertypes')->with('flash_message', 'Tipo de Cilindro eliminado!');
    }
}
