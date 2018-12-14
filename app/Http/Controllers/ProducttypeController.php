<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Producttype;

class ProducttypeController extends Controller
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
            $producttypes = Producttype::where('producttype', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $producttypes  = Producttype::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de tipos de productos';
        $modelName  = 'tipo de producto';
        $controller = 'producttypes';

        return view('producttypes/index',compact(
            'producttypes',
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
        $title      = 'Editar una tipo de producto';
        $modelName  = 'Tipo de producto';
        $controller = 'producttypes';
        

        return view('producttypes.create',compact( 'title', 'modelName', 'controller'));
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
        Producttype::create($requestData);

        return redirect('producttypes')->with('flash_message', 'Tipo de producto creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un tipo de producto';
        $modelName  = 'Tipo de producto';
        $controller = 'producttypes';

        $producttype = Producttype::findOrFail($id);
        return view('producttypes.show', compact('producttype','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un tipo de producto';
        $modelName  = 'tipo de producto';
        $controller = 'producttypes';

        $producttype = Producttype::findOrFail($id);

        return view('producttypes.edit', compact('producttype','title', 'modelName', 'controller'));
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
       
        $producttype = Producttype::findOrFail($id);
        $producttype->update($requestData);

        return redirect('producttypes')->with('flash_message', 'Tipo de producto actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Producttype::destroy($id);

        return redirect('producttypes')->with('flash_message', 'Tipo de producto eliminado!');
    }
}
