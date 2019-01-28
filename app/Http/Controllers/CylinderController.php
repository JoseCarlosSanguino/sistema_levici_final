<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Cylinder;
use app\Models\Cylindertype;
use app\Models\Provider;
use DB;

class CylinderController extends Controller
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
            $cylinders = Cylinder::where('code', 'LIKE', "%$keyword%")
                ->orWhere('external_code', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        }
        else
        {
            $cylinders  = Cylinder::latest()->paginate($perPage);
        }

        $title      = 'Listado de cilindros';
        $modelName  = 'Cilindro';
        $controller = 'cylinders';

        return view('cylinders.index',compact('cylinders', 'title', 'modelName', 'controller'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title      = 'Editar un cilindro';
        $modelName  = 'Cilindro';
        $controller = 'cylinders';
        $cylindertypes = Cylindertype::pluck('cylindertype','id');
        $providers = Provider::where('persontype_id',2)->pluck('name','id');
        return view('cylinders.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'unittypes',
            'cylindertypes',
            'providers'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code'          => 'required|unique:cylinders|max:32',
            ]);
    
    	$requestData = $request->all();
    	$requestData['status_id'] = Cylinder::STATUS['DISPONIBLE'];
        Cylinder::create($requestData);

        return redirect('cylinders')->with('flash_message', 'Cilindro creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $title      = 'Ver detalle de un cilindro';
        $modelName  = 'Cilindro';
        $controller = 'cylinders';

        $cylinder = Cylinder::findOrFail($id);

        return view('cylinders.show', compact('cylinder','title', 'modelName', 'controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $title      = 'Editar un cilindro';
        $modelName  = 'Cilindro';
        $controller = 'cylinders';

        $cylinder = Cylinder::findOrFail($id);
        $cylindertypes = Cylindertype::pluck('cylindertype','id');
        $providers = Provider::where('persontype_id',2)->pluck('name','id');
        return view('cylinders.edit', compact(
            'cylinder',
            'title', 
            'modelName', 
            'controller', 
            'unittypes',
            'cylindertypes',
            'providers'));
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
        $cylinder = Cylinder::findOrFail($id);
        $cylinder->update($requestData);

        return redirect('cylinders')->with('flash_message', 'Cilindro actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Cylinder::destroy($id);

        return redirect('cylinders')->with('flash_message', 'Cilindro eliminado!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        if(!is_null($request->input('status_id')))
        {
            $status_where = ' and c.status_id in ('.$request->input('status_id').')';
        }
        else
        {
            $status_where = ' and c.status_id in (10)';
        }

        $query = "select c.id,  c.code, c.external_code, ct.capacity, ct.cylindertype, COALESCE(c.observation,'') as observation ";
        $query.= "from cylinders c join cylindertypes ct on (c.cylindertype_id = ct.id) ";
        $query.= "where c.cylindertype_id IN (".$request->input('cylindertype_id').") ";
        $query.= $status_where;

        $data = DB::select($query);
        
        /*
        $data = Cylinder::select("id","code","external_code","expiration","observation")
            ->with(['cylindertype' => function ($query) {
                        $query->select(['capacity', 'cylindertype']);
                    }])
            ->wherein("cylindertype_id",explode(',',$request->input('cylindertype_id')))
            ->where("status_id", Cylinder::STATUS['DISPONIBLE'])
            ->get();
        */


        return response()->json($data);
    }


}
