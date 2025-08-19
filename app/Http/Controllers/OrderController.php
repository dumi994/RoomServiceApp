<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    return view('admin.index');
  }

  /**
   * Store a newly created resource in storage.
   */
  // OrderController.php
  public function store(Request $request)
  {
    /* \Log::info('STORE CALLED', $request->all());
    dd('Entrato nel controller!', $request->all()); */
    $validated = $request->validate([
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'room_number' => 'required|string|max:10',
      'order_details' => 'required|string',
    ]);

    $order = Order::create([
      'first_name' => $validated['first_name'],
      'last_name' => $validated['last_name'],
      'room_number' => $validated['room_number'],
      'order_details' => $validated['order_details'],
      'status' => 'sent', // Status iniziale
    ]);

    // Redirect alla pagina show dell'ordine
    return redirect()->route('orders.show', $order)
      ->with('success', 'Ordine inviato con successo!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $order = Order::findOrFail($id);
    // dd($order);
    return view('orders.show', compact('order'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {

    $request->validate([
      'status' => 'required'
    ]);
    // Trova l'ordine per ID, oppure fallisci con errore 404
    $order = \DB::table('orders')->where('id', $id)->first();
    if (!$order) {
      return response()->json(['error' => 'Ordine non trovato'], 404);
    }

    // Aggiorna lo status (con query builder serve update diretto)
    \DB::table('orders')->where('id', $id)->update([
      'status' => $request->status
    ]);

    // Risposta JSON di successo
    return response()->json([
      'message' => 'Status aggiornato con successo',
      'order_id' => $id,
      'new_status' => $request->status
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
  public function getOrder(string $id)
  {
    $order = Order::findOrFail($id);
    return response()->json(
      $order
    );
  }
  // OrderController.php
  public function getStatus(Order $order)
  {
    // Ricarica l'ordine dal database per avere i dati più aggiornati
    $order->refresh();

    return response()->json([
      'order_id' => $order->id,
      'status' => $order->status, // Status REALE dal database
      'status_text' => $this->getStatusText($order->status),
      'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
      'created_at' => $order->created_at->format('Y-m-d H:i:s')
    ]);
  }

  private function getStatusText($status)
  {
    switch ($status) {
      case 'sent':
      case 'pending':
      case 'received':
        return 'Ordine ricevuto';

      case 'processing':
      case 'in_preparation':
      case 'preparing':
        return 'In preparazione';

      case 'completed':
      case 'delivered':
      case 'ready':
        return 'Consegnato';

      default:
        return 'Status: ' . $status;
    }
  }
}
