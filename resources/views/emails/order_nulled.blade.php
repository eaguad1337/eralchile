<p>Hola {{$order->user->name}}, </p>
<p></p>
<p>Tu orden número {{ $order->code }} ha sido <b>anulada</b>.</p>
<p>Puedes revisar el detalle en <a href="{{ route('orders.edit', $order->id) }}">{{ route('orders.edit', $order->id) }}</a></p>
<p></p>
<p></p>
<p><b>ERAL</b></p>
