<?php

namespace app\Http\Controllers;

use app\Http\Controllers\Controller;
use app\Models\Role;
use app\Models\User;
use app\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
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
            $roles = Role::where('name', 'LIKE', "%$keyword%")->orWhere('label', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $roles = Role::latest()->paginate($perPage);
        }
        $title      = 'Listado de roles';
        $modelName  = 'Rol';
        $controller = 'roles';

        return view('roles.index', compact('roles', 'title','modelName','controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $permissions = Permission::select('id', 'name', 'label')->get()->pluck('id','label', 'name');
        $title      = 'Nuevo rol';
        $modelName  = 'Roles';
        $controller = 'roles';


        return view('roles.create', compact('permissions','title','modelName','controller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $role = Role::create($request->all());
        $role->permissions()->detach();

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission_name) {
                $permission = Permission::whereName($permission_name)->first();
                $role->givePermissionTo($permission);
            }
        }

        return redirect('roles')->with('flash_message', 'Rol creado!');
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
        $role = Role::findOrFail($id);
        $title      = 'Ver rol';
        $modelName  = 'Roles';
        $controller = 'roles';

        return view('roles.show', compact('role', 'title','modelName','controller'));
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
        $role = Role::findOrFail($id);
        $permissions = Permission::select('id', 'name', 'label')->get()->pluck('id','label', 'name');

        $title      = 'Editar rol';
        $modelName  = 'Roles';
        $controller = 'roles';

        return view('roles.edit', compact('role', 'permissions','title','modelName','controller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);

        $role = Role::findOrFail($id);
        $role->update($request->all());

        $role->permissions()->detach();

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission_name) {
                $permission = Permission::whereName($permission_name)->first();
                $role->givePermissionTo($permission);
            }
        }

        return redirect('roles')->with('flash_message', 'Role actualizado!');
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
        Role::destroy($id);

        return redirect('roles')->with('flash_message', 'Role deleted!');
    }
}
