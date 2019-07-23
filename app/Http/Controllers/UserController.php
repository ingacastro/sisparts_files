<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\User;
use IParts\Employee;
use Illuminate\Support\Facades\Log;
use IParts\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function getList(Request $request)
    {   
        $logged_admin_id = Auth::user()->id;
        if($request->ajax()) {

            $users = User::select('users.id', 'employees.number', 'employees.buyer_number', 'employees.seller_number',
            'users.name', 'users.email', 'roles.name as role')
            ->leftJoin('employees', 'employees.users_id', 'users.id')
            ->join('model_has_roles', 'model_id', 'users.id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where('users.id', '!=', $logged_admin_id)->get();

            return Datatables::of($users)
                  ->addColumn('actions', function($user) {
                    return '<a href="' . config('app.url') . '/user/'. $user->id . '/edit" class="btn btn-circle btn-icon-only default"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-circle btn-icon-only red"
                            onclick="deleteModel(event, ' . $user->id . ')"><i class="fa fa-times"></i></a>';
                  })
                  ->rawColumns(['actions' => 'actions'])
                  ->make(true);
        }
        abort(403, 'Unauthorized action');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $employee = new Employee();
        $selects_data = $this->getSelectsData();
        return view('user.create_update', compact('user', 'employee', 'selects_data'))
        ->with('role_id', null);
    }

    private function getSelectsData()
    {
        $roles = Role::pluck('name', 'id');
        return ['roles' => $roles];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user_data = $request->get('user');
        $user_data['password'] = bcrypt($user_data['password']);
        $role_name = Role::find($request->get('role_id'))->name;
        $employee_data = $request->get('employee');

        try {
            DB::transaction(function() use ($user_data, $role_name, $employee_data) {
                $user = User::create($user_data);
                $user->assignRole($role_name);
                $employee_data['users_id'] = $user->id;
                Employee::create($employee_data);
            });
            $request->session()->flash('message', 'Usuario creado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->WithErrors($e->getMessage());
        }

        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $employee = $user->employee;
        $selects_data = $this->getSelectsData();
        $role_id = $user->roles->first()->id;
        return view('user.create_update', compact('user', 'employee', 'selects_data', 'role_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user_data = $request->get('user');

        if(empty($user_data['password']))
            unset($user_data['password']);
        else
            $user_data['password'] = bcrypt($user_data['password']);
        
        $role_name = Role::find($request->get('role_id'))->name;
        $employee_data = $request->get('employee');

        try {
            $user = User::find($id);
            DB::transaction(function() use ($user_data, $role_name, $employee_data, $user) {
                $user->fill($user_data)->update();
                $user->syncRoles([$role_name]);
                $user->employee->fill($employee_data)->update();
            });
            $request->session()->flash('message', 'Usuario actualizado correctamente.');
        } catch(\Exception $e) {
            return redirect()->back()->WithErrors($e->getMessage());
        }

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            DB::transaction(function() use ($user) {
                $user->syncPermissions(); //deletes all the direct user's permissions
                $user->syncRoles(); //deletes all the user's roles
                $user->delete();
            });
            Session::flash('message', 'Usuario eliminado correctamente.');
        } catch(\Exception $e) {
            back()->withErrors($e->getMessage());
        }
    }
}
