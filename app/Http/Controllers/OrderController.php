<?php

namespace App\Http\Controllers;

use EAguad\Exception\AlreadyApprovedException;
use EAguad\Exception\AlreadyRejectedException;
use EAguad\Exception\OrderNotApprovedException;
use EAguad\Exception\ReviewerDoesNotBelongToCostCentreException;
use EAguad\Exception\UserIsNotSignatoryException;
use EAguad\Model\CostCentre;
use EAguad\Model\Order;
use EAguad\Model\Provider;
use EAguad\Services\OrderService;
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
        $statusSelect = [
            OrderService::STATUS_PENDING => __(OrderService::STATUS_PENDING),
            OrderService::STATUS_APPROVED => __(OrderService::STATUS_APPROVED),
            OrderService::STATUS_REJECTED => __(OrderService::STATUS_REJECTED),
            OrderService::STATUS_SIGNED => __(OrderService::STATUS_SIGNED),
        ];
        return view('orders.form', compact(['costCentres', 'statusSelect']));
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
            'code' => 'required|max:191|unique:orders',
            'cost_centre_id' => 'required|exists:cost_centres,id',
            'provider_cardcode' => 'required|exists:providers,cardcode'
        ]);

        $provider = Provider::whereCardcode($request->get("provider_cardcode"))->firstOrFail();

        $input = [
            'file' => $request->get('file'),
            'code' => $request->get('code'),
            'cost_centre_id' => $request->get('cost_centre_id'),
            'user_id' => auth()->user()->id,
            'provider_id' => $provider->id
        ];

        $order = Order::create($input);

        $order->addMedia($request->file('file'))
            ->toMediaCollection();

        session()->flash('success');

        return redirect()->route('orders.edit', $order->id);
    }

    /**
     * @param Request $request
     * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\DataTables
     * @throws \Exception
     */
    public function datatables(Request $request)
    {
        return datatables(Order::with('user', 'provider'))
            ->toJson();
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
        $statusSelect = [
            OrderService::STATUS_PENDING => __(OrderService::STATUS_PENDING),
            OrderService::STATUS_APPROVED => __(OrderService::STATUS_APPROVED),
            OrderService::STATUS_REJECTED => __(OrderService::STATUS_REJECTED),
            OrderService::STATUS_SIGNED => __(OrderService::STATUS_SIGNED),
        ];
        return view('orders.form', compact(['order', 'costCentres', 'statusSelect']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \EAguad\Model\Order $order
     * @return \Illuminate\Http\Response
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function update(Request $request, Order $order)
    {
        $user = auth()->user();
        $request->validate([
            'file' => 'nullable|file|max:' . env('MAX_FILE_SIZE', 5000),
            'code' => 'required|max:191|unique:orders,code,' . $order->id,
            'cost_centre_id' => 'required|exists:cost_centres,id',
            'status' => 'sometimes',
        ]);

        $newStatus = $request->get('status');

        $input = [
            'code' => $request->get('code'),
            'cost_centre_id' => $request->get('cost_centre_id'),
            'user_id' => auth()->user()->id,
        ];

        $order->update($input);

        if ($newStatus && $order->status !== $newStatus) {
            try {
                OrderService::changeStatus($order, $newStatus);
            } catch (AlreadyApprovedException $e) {
                session()->flash('error');
                session()->flash('message', 'La orden ya está aprobada.');
                return redirect()->route('orders.edit', $order->id);
            } catch (AlreadyRejectedException $e) {
                session()->flash('error');
                session()->flash('message', 'La orden ya está rechazada.');
                return redirect()->route('orders.edit', $order->id);
            } catch (OrderNotApprovedException $e) {
                session()->flash('error');
                session()->flash('message', 'La orden no está aprobada.');
                return redirect()->route('orders.edit', $order->id);
            } catch (ReviewerDoesNotBelongToCostCentreException $e) {
                session()->flash('error');
                session()->flash('message', 'No tienes permisos suficientes para aprobar órdenes.');
                return redirect()->route('orders.edit', $order->id);
            } catch (UserIsNotSignatoryException $e) {
                session()->flash('error');
                session()->flash('message', 'No tienes permisos suficientes para visar órdenes.');
                return redirect()->route('orders.edit', $order->id);
            } catch (\StatusNotValidException $e) {
                session()->flash('error');
                session()->flash('message', 'El estado seleccionado no existe.');
                return redirect()->route('orders.edit', $order->id);
            }
        }

        if ($request->file('file')) {
            if ($order->getFirstMedia()) {
                $order->getFirstMedia()->delete();
            }

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
