<?php

namespace app\Http\Controllers;

use app\Http\Controllers\Controller;
use app\Models\Role;
use app\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
            $users = User::where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }
        foreach($users as $user){
            $arr_role = [];
            foreach($user->roles as $role){
                array_push($arr_role, $role->name);
            }
            $user->roles_concat = implode(', ',$arr_role);
        }
        $title      = 'Listado de usuarios';
        $modelName  = 'Usuarios';
        $controller = 'users';

        return view('users.index', compact('users', 'title','modelName','controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $roles = Role::select('id', 'name','label')->get();
        $roles = $roles->pluck('label','name', 'id');

        $title      = 'Listado de usuarios';
        $modelName  = 'Usuarios';
        $controller = 'users';

        return view('users.create', compact('roles', 'title','modelName','controller'));
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
        $this->validate(
            $request,
            [
                'name'      => 'required',
                'email'     => 'required|string|max:255|email|unique:users',
                'password'  => 'required',
                'roles'     => 'required'
            ]
        );

        $data = $request->except('password');
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('users')->with('flash_message', 'User added!');
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
        $user = User::findOrFail($id);

        $title      = 'Listado de usuarios';
        $modelName  = 'Usuarios';
        $controller = 'users';

        $arr_role = [];
        foreach($user->roles as $role){
            array_push($arr_role, $role->name);
        }
        $user->roles_concat = implode($arr_role);

        return view('users.show', compact('user', 'title','modelName','controller'));
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
        $roles = Role::select('id', 'name','label')->get();
        $roles = $roles->pluck('label','name', 'id');

        $user = User::with('roles')->select('id', 'name', 'email')->findOrFail($id);
        $user_roles = [];
        foreach ($user->roles as $role) {
            $user_roles[] = $role->name;
        }

        $title      = 'Listado de usuarios';
        $modelName  = 'Usuarios';
        $controller = 'users';


        return view('users.edit', compact('user', 'roles', 'user_roles','title','modelName','controller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users,email,' . $id,
                'roles' => 'required'
            ]
        );

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);

        $user->roles()->detach();
        foreach ($request->roles as $role) {
            $user->assignRole($role);
        }

        return redirect('users')->with('flash_message', 'User updated!');
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
        User::destroy($id);

        return redirect('users')->with('flash_message', 'User deleted!');
    }
}
