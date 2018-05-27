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
        ]);

        $input['password'] = \Hash::make($input['password']);
        $user = User::create($input);

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
        ]);

        if ($request->get('password')) {
            $input['password'] = \Hash::make($request->get('password'));
        }

        $user->update($input);
        session()->flash('success');

        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \EAguad\Model\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
