<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Ivatype;

class IvatypeController extends Controller
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
            $ivatypes = Ivatype::where('ivatype', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $ivatypes  = Ivatype::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de tipos de IVA';
        $modelName  = 'ivatype';
        $controller = 'ivatypes';

        return view('ivatypes/index',compact(
            'ivatypes',
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
        $title      = 'Editar una tipo de IVA';
        $modelName  = 'Tipo de iva';
        $controller = 'ivatypes';

        return view('ivatypes.create',compact( 'title', 'modelName', 'controller'));
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
        Ivatype::create($requestData);

        return redirect('ivatypes')->with('flash_message', 'Tipo de IVA creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle tipo de IVA';
        $modelName  = 'Tipo de IVA';
        $controller = 'ivatypes';

        $ivatype = Ivatype::findOrFail($id);
        return view('ivatypes.show', compact('ivatype','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un tipo de IVA';
        $modelName  = 'Tipo de IVA';
        $controller = 'ivatypes';

        $ivatype = Ivatype::findOrFail($id);

        return view('ivatypes.edit', compact('ivatype','title', 'modelName', 'controller'));
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
       
        $ivatype = Ivatype::findOrFail($id);
        $ivatype->update($requestData);

        return redirect('ivatypes')->with('flash_message', 'Tipo de IVA actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Ivatype::destroy($id);

        return redirect('ivatypes')->with('flash_message', 'Tipo de IVA eliminado!');
    }
}
