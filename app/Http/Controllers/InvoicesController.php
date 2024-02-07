<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    public function createAndSendInvoice($orderId)
    {

        try {
            DB::beginTransaction();
            // Buscar la orden por ID
            $order = Order::findOrFail($orderId);

            $invoice = new Invoice;
            $invoice->orders_id = $order->id;
            $invoice->date = now();
            $invoice->subtotal = $order->total;
            // Guardar la factura en la base de datos
            $invoice->save();

            // Notificar al usuario por correo electrónico
            $order->user->notify(new InvoicePaid($invoice));

            DB::commit();
            // Redirigir al usuario a la página de éxito
            return back()->with('success', 'mail enviado');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Error al crear la factura.'. $e->getMessage()]);
        }
    }

}
