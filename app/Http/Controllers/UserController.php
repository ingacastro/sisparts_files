<?php

namespace IParts\Http\Controllers;

use Illuminate\Http\Request;
use IParts\User;
use IParts\Employee;
use Illuminate\Support\Facades\Log;
use IParts\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
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
        if($request->ajax()) {
            return Datatables::of(User::where('name', '!=', 'admin'))
                  ->addColumn('actions', function($user) {
                    return '<a href="/user/'. $user->id . '/edit" class="btn btn-circle btn-icon-only default"><i class="fa fa-edit"></i></a>
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
        return view('user.create_update', compact('user', 'employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $employee_data = $request->get('employee');

        try {
            DB::transaction(function() use ($request, $employee_data) {
                $user = User::create($request->get('user'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
