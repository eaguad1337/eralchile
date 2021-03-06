<?php

namespace App\Http\Controllers;

use EAguad\Enum\UserRole;
use EAguad\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::simplePaginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = UserRole::getAll();
        return view('users.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'email' => 'email|required',
            'permission_view' => 'boolean',
            'permission_signatory' => 'boolean',
            'permission_approver' => 'boolean',
            'permission_admin' => 'boolean',
            'permission_create' => 'boolean',
        ]);

        $input['is_active'] = $request->get('is_active', false);

        $input['password'] = \Hash::make($input['password']);
        $user = User::create($input);

        session()->flash('success');

        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \EAguad\Model\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \EAguad\Model\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = UserRole::getAll();
        return view('users.form', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \EAguad\Model\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'email|required',
            'permission_view' => 'boolean',
            'permission_signatory' => 'boolean',
            'permission_approver' => 'boolean',
            'permission_admin' => 'boolean',
            'permission_create' => 'boolean',
        ]);

        $input['permission_view'] = $request->has('permission_view');
        $input['permission_signatory'] = $request->has('permission_signatory');
        $input['permission_approver'] = $request->has('permission_approver');
        $input['permission_admin'] = $request->has('permission_admin');
        $input['permission_create'] = $request->has('permission_create');

        $input['is_active'] = $request->get('is_active', false);

        if ($request->get('password')) {
            $input['password'] = \Hash::make($request->get('password'));
        }

        $user->update($input);
        session()->flash('success');

        return redirect()->route('users.edit', $user->id);
    }

    /**
     * @param  \EAguad\Model\User $userw
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        return response()->json(['success' => true]);
    }
}
