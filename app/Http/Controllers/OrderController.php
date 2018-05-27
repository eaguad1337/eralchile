<?php

namespace App\Http\Controllers;

use EAguad\Model\CostCentre;
use EAguad\Model\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::simplePaginate(15);
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costCentres = CostCentre::get();
        return view('orders.form', ['costCentres' => $costCentres]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:' . env('MAX_FILE_SIZE', 5000),
            'code' => 'required|max:191',
            'cost_centre_id' => 'required|exists:cost_centres,id'
        ]);

        $input = [
            'file' => $request->get('file'),
            'code' => $request->get('code'),
            'cost_centre_id' => $request->get('cost_centre_id'),
            'user_id' => auth()->user()->id
        ];

        $order = Order::create($input);

        $order->addMedia($request->file('file'))
            ->toMediaCollection();

        session()->flash('success');

        return redirect()->route('orders.edit', $order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \EAguad\Model\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \EAguad\Model\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $costCentres = CostCentre::get();
        return view('orders.form', compact(['order', 'costCentres']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \EAguad\Model\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'file' => 'nullable|file|max:' . env('MAX_FILE_SIZE', 5000),
            'code' => 'required|max:191',
            'cost_centre_id' => 'required|exists:cost_centres,id'
        ]);

        $input = [
            'code' => $request->get('code'),
            'cost_centre_id' => $request->get('cost_centre_id'),
            'user_id' => auth()->user()->id
        ];

        $order = Order::create($input);

        if ($request->file('file')) {
            $order->getFirstMedia()->delete();

            $order->addMedia($request->file('file'))
                ->toMediaCollection();
        }

        session()->flash('success');

        return redirect()->route('orders.edit', $order->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \EAguad\Model\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
