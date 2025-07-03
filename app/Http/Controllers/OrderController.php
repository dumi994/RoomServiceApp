<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'room_number' => 'required|string|max:50',
                'order_details' => 'required|string',
            ]);

            $order = Order::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'room_number' => $request->room_number,
                'order_details' => $request->order_details,
                'status' => $request->status
            ]);

            //return redirect()->route('services.index')->with('success', 'Ordine creato con successo!');
            return response()->json([
                'success' => true,
                'message' => 'Ordine creato con successo!',
                'order_id' => $order->id,
                'status' => $order->status  // Restituisci lo status
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Errore durante la creazione dell\'ordine: ' . $e->getMessage());
        }
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
        //
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
}
