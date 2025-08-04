<?php

namespace App\Http\Controllers;

use App\Models\Service;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('menu_items')->get();
        //return response()->json($services);
        //$services = Service::all();

        return view('services.index', compact('services'));
    }
    public function adminIndex()
    {
        $services = Service::all(); // prendi tutti i servizi
        return view('admin.service.index', compact('services'));
    }
    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        // $data = ... // se necessario
        return view('admin.service.create'); // puoi anche passare dati alla view
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'available' => 'required|boolean',
        ]);

        $service = Service::create($data);

        return redirect()->route('services.menu-items.create', $service->id)
            ->with('success', 'Service creato! Ora aggiungi le voci menu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
