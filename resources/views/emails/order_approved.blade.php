<p>Hola {{$order->user->name}}, </p>
<p></p>
<p>Tu orden número {{ $order->code }} ha sido <b>aprobada</b>.</p>
<p>Puedes revisar el detalle en {{ route('orders.view', $order->id) }}</p>
<p></p>
<p></p>
<p><b>ERAL</b></p>
