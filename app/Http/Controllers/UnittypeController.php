<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Unittype;

class UnittypeController extends Controller
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
            $unittypes = Unittype::where('unittype', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $unittypes  = Unittype::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de tipos de Unidad';
        $modelName  = 'tipo de Unidad';
        $controller = 'unittypes';

        return view('unittypes.index',compact(
            'unittypes',
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
        $title      = 'Editar una tipo de Unidad';
        $modelName  = 'Tipo de Unidad';
        $controller = 'unittypes';
        

        return view('unittypes.create',compact( 'title', 'modelName', 'controller'));
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
        Unittype::create($requestData);

        return redirect('unittypes')->with('flash_message', 'Tipo de Unidad creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un tipo de Unidad';
        $modelName  = 'Tipo de Unidad';
        $controller = 'unittypes';

        $unittype = Unittype::findOrFail($id);
        return view('unittypes.show', compact('unittype','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un tipo de Unidad';
        $modelName  = 'tipo de Unidad';
        $controller = 'unittypes';

        $unittype = Unittype::findOrFail($id);

        return view('unittypes.edit', compact('unittype','title', 'modelName', 'controller'));
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
       
        $unittype = Unittype::findOrFail($id);
        $unittype->update($requestData);

        return redirect('unittypes')->with('flash_message', 'Tipo de Unidad actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Unittype::destroy($id);

        return redirect('unittypes')->with('flash_message', 'Tipo de Unidad eliminado!');
    }
}
