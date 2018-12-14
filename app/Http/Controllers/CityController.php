<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\City;
use app\Models\Province;

class CityController extends Controller
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
            $cities = City::where('city', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $cities  = City::latest()
                ->paginate($perPage);
        }

        $title      = 'Listado de ciudades';
        $modelName  = 'ciudad';
        $controller = 'cities';

        return view('cities/index',compact(
            'cities',
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
        $title      = 'Editar una ciudad';
        $modelName  = 'ciudad';
        $controller = 'cities';
        $provinces = Province::pluck('province','id');
        

        return view('cities.create',compact( 'title', 'modelName', 'controller', 'provinces'));
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
        City::create($requestData);

        return redirect('cities')->with('flash_message', 'ciudad creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un ciudad';
        $modelName  = 'ciudad';
        $controller = 'cities';

        $city = City::findOrFail($id);
        $provinces = Province::pluck('province','id');
        return view('cities.show', compact('city','title', 'modelName', 'controller','provinces'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un ciudad';
        $modelName  = 'ciudad';
        $controller = 'cities';

        $city = City::findOrFail($id);
        $provinces = Province::pluck('province','id');

        return view('cities.edit', compact('city','title', 'modelName', 'controller','provinces'));
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
       
        $city = City::findOrFail($id);
        $city->update($requestData);

        return redirect('cities')->with('flash_message', 'ciudad actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        City::destroy($id);

        return redirect('cities')->with('flash_message', 'ciudad eliminado!');
    }
}
