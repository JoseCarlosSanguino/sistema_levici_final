<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Trademark;

class TrademarkController extends Controller
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
            $trademarks = trademark::where('trademark', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $trademarks  = trademark::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de marca';
        $modelName  = 'marca';
        $controller = 'trademarks';

        return view('trademarks/index',compact(
            'trademarks',
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
        $title      = 'Editar una marca';
        $modelName  = 'Marca';
        $controller = 'trademarks';
        $trademarks = trademark::pluck('trademark','id');

        return view('trademarks.create',compact( 'title', 'modelName', 'controller'));
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
        trademark::create($requestData);

        return redirect('trademarks')->with('flash_message', 'Marca creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un marca';
        $modelName  = 'Marca';
        $controller = 'trademarks';

        $trademark = trademark::findOrFail($id);
        return view('trademarks.show', compact('trademark','title', 'modelName', 'controller'));
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
        $modelName  = 'Marca';
        $controller = 'trademarks';

        $trademark = trademark::findOrFail($id);

        return view('trademarks.edit', compact('trademark','title', 'modelName', 'controller'));
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
       
        $trademark = trademark::findOrFail($id);

        $trademark->update($requestData);
        return redirect('trademarks')->with('flash_message', 'Marca actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        trademark::destroy($id);

        return redirect('trademarks')->with('flash_message', 'Marca eliminado!');
    }
}
