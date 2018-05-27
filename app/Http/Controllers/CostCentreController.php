<?php

namespace App\Http\Controllers;

use EAguad\Model\CostCentre;
use Illuminate\Http\Request;

class CostCentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costcentres = CostCentre::get();
        return view('costCentres.index', ['costCentres' => $costcentres]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('costCentres.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
           'name' => 'required|max:200'
        ]);

        $costcentre = CostCentre::create($input);

        return redirect()->route('costcentres.edit', $costcentre->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \EAguad\Model\CostCentre  $costcentre
     * @return \Illuminate\Http\Response
     */
    public function show(CostCentre $costcentre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \EAguad\Model\CostCentre  $costcentre
     * @return \Illuminate\Http\Response
     */
    public function edit(CostCentre $costcentre)
    {
        return view('costcentres.form', ['costCentre' => $costcentre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \EAguad\Model\CostCentre  $costcentre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostCentre $costcentre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \EAguad\Model\CostCentre  $costcentre
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCentre $costcentre)
    {
        //
    }
}
