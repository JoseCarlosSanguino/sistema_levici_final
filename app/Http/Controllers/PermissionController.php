<?php

namespace App\Http\Controllers;

use app\Http\Controllers\Controller;
use app\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $permissions = Permission::where('name', 'LIKE', "%$keyword%")->orWhere('label', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $permissions = Permission::latest()->paginate($perPage);
        }
        $title = 'Listado de Permisos';
        $modelName = 'Permiso';
        $controller = 'permissions';

        return view('permissions.index', compact('permissions','title','modelName','controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $title = 'Listado de Permisos';
        $modelName = 'Permiso';
        $controller = 'permissions';

        return view('permissions.create',compact('title','modelName','controller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Permission::create($request->all());

        return redirect('permissions')->with('flash_message', 'Permiso creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        $title = 'Ver Permiso';
        $modelName = 'Permiso';
        $controller = 'permissions';

        return view('permissions.show', compact('permission','title','modelName','controller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $title = 'Editar permiso';
        $modelName = 'Permiso';
        $controller = 'permissions';

        return view('permissions.edit', compact('permission','title','modelName','controller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return redirect('permissions')->with('flash_message', 'Permiso actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        Permission::destroy($id);

        return redirect('permissions')->with('flash_message', 'Permiso eliminado!');
    }
}
