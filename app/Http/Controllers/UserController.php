<?php

namespace App\Http\Controllers;

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
        return view('users.form');
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
            'is_signatory' => 'boolean',
            'is_admin' => 'boolean',
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
        return view('users.form', compact('user'));
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
            'is_signatory' => 'boolean',
            'is_admin' => 'boolean',
        ]);

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
