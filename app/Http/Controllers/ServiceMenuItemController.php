<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceMenuItem;

class ServiceMenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$menuItems = ServiceMenuItem::all(); // prendi tutti i servizi
        $menuItems = ServiceMenuItem::with('service')->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Service $service)
    {
        return view('admin.menu.create', compact('service'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Service $service)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $service->menu_items()->create($data);

        return redirect()->route('services.menu-items.create', $service->id)
            ->with('success', 'Voce menu aggiunta!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceMenuItem $menu)
    {
        $services = Service::all();
        return view('admin.menu.edit', compact('menu', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceMenuItem $menu)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'service_id' => 'required|exists:services,id',
        ]);

        $menu->update($data);

        return redirect()->route('menu.index')->with('success', 'Voce menu aggiornata!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
