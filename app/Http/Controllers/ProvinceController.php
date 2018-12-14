<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Province;

class ProvinceController extends Controller
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
            $provinces = Province::where('province', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $provinces  = Province::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de provincas';
        $modelName  = 'provincia';
        $controller = 'provinces';

        return view('provinces/index',compact(
            'provinces',
            'title', 'modelName', 'controller'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title      = 'Editar una provincia';
        $modelName  = 'Provincia';
        $controller = 'provinces';
        $provinces = Province::pluck('province','id');

        return view('provinces.create',compact( 'title', 'modelName', 'controller'));
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
        Province::create($requestData);

        return redirect('provinces')->with('flash_message', 'Provincia creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un provincia';
        $modelName  = 'Provincia';
        $controller = 'provinces';

        $province = Province::findOrFail($id);
        return view('provinces.show', compact('province','title', 'modelName', 'controller'));
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
        $modelName  = 'Provincia';
        $controller = 'provinces';

        $province = Province::findOrFail($id);

        return view('provinces.edit', compact('province','title', 'modelName', 'controller'));
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
       
        $province = Province::findOrFail($id);

        $province->update($requestData);
        return redirect('provinces')->with('flash_message', 'Provincia actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Province::destroy($id);

        return redirect('provinces')->with('flash_message', 'Provincia eliminado!');
    }
}
