<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Cylinder;
use app\Models\Cylindertype;
use app\Models\Cylindermove;
use app\Models\Provider;
use app\Models\Customer;
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
        $customers = Customer::where('persontype_id',1)->pluck('name','id');
        return view('cylinders.create',compact( 
            'title', 
            'modelName', 
            'controller',
            'unittypes',
            'cylindertypes',
            'providers',
            'customers'
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
        if(is_null($request->input('customer_id')))
        {
            $requestData['status_id'] = Cylinder::STATUS['DISPONIBLE'];
        }
        else
        {
            $requestData['status_id'] = Cylinder::STATUS['EN CLIENTE'];
        }
        $cyl = Cylinder::create($requestData);

        if(!is_null($request->input('customer_id')))
        {
            //mov
            $cylmove = NEW Cylindermove([
                'person_id'  => $request->input('customer_id'),
                'movetype_id'=> Cylindermove::MOVETYPE['ENVIO_A_CLIENTE'],
                'date_of'    => date('d/m/Y H:i:s')
            ]);
            $cyl->moves()->save($cylmove);
        }


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
        $customers = Customer::where('persontype_id',1)->pluck('name','id');
        return view('cylinders.edit', compact(
            'cylinder',
            'title', 
            'modelName', 
            'controller', 
            'unittypes',
            'cylindertypes',
            'providers',
            'customers'));
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

        //default query

        $select = "select c.id,  c.code, c.external_code, ct.capacity, ct.cylindertype, COALESCE(c.observation,'') as observation ";
        $from = "from cylinders c join cylindertypes ct on (c.cylindertype_id = ct.id) ";
        $where = "where c.deleted_at is null and c.cylindertype_id IN (".$request->input('cylindertype_id').") ";

        if(!is_null($request->input('status_id')))
        {
            $where .= ' and c.status_id in ('.$request->input('status_id').') ';
        }
        else
        {
            $where .= ' and c.status_id in (10) ';
        }

        if(!is_null($request->input('customer_id')))
        {
            $select .= " ,max(m.date_of) fecha "; 
            $from .= " join cylindermoves m on (m.cylinder_id = c.id and m.person_id = ".$request->input('customer_id').") ";
            $where .=" group by 1,2,3,4,5,6";
        }
        $query = $select . $from . $where;

        $data = DB::select($query);

        return response()->json($data);
    }


}
