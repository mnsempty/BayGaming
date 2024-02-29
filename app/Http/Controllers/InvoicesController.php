<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\InvoicePaid;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    public function createInvoice($orderId)
    {

        try {
            DB::beginTransaction();
            // Buscar la orden por ID
            $order = Order::findOrFail($orderId);

            $invoice = new Invoice;
            $invoice->orders_id = $order->id;
            $invoice->date = now();
            $invoice->subtotal = $order->subtotal;
            $invoice->total = $order->total;
            // Guardar la factura en la base de datos
            $invoice->save();

            DB::commit();

            return redirect()->route('landing')->with('success', 'Pedido y factura creada');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('landing')->withErrors(['message' => 'Error al crear la factura.' . $e->getMessage()]);
        }
    }
    //todo check
    public function sendInvoice($orderId)
    {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($orderId);
            if (auth()->id() !== $order->users_id) {
                // Enviar correo electrónico de notificación de intento de conseguir info pedidos no tenga el user
                //todo mail a nuestro mail advirtiendo de un actividades ilícitas
                //Mail::to('baygaming@thunder.com')->send(new \App\Mail\AuthorizationErrorMail());

                throw new AuthorizationException('No tienes permiso para enviar esta factura.');
            }

            $invoice = $order->invoice;
            $order->user->notify(new InvoicePaid($invoice));

            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'mail enviado');
        } catch (\exception $e) {
            DB::rollBack();
            $errorMessage = 'Error al enviar la factura en la línea ' . $e->getLine() . ': ' . $e->getMessage();
            return back()->withErrors(['message' => $errorMessage]);
        }
    }
}
