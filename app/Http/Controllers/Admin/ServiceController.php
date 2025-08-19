<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\ServiceMenuItem;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all(); // prendi tutti i servizi
        return view('admin.service.index', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        $menuItems = ServiceMenuItem::all(); // tutti i menu items
        return view('admin.service.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'available' => 'nullable|boolean',
            'images.*' => 'nullable|image|max:5120', // max 5MB
        ]);

        // Se checkbox non selezionata
        $data['available'] = $request->has('available') ? true : false;

        $service = Service::create($data);

        $disk = 'public';
        $finalImages = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            // Limitiamo a 2 immagini max
            $images = array_slice($images, 0, 2);

            foreach ($images as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs("services/{$service->id}", $filename, $disk);
                $finalImages[] = $path;
            }
        }

        // Salviamo i path delle immagini nell'array 'images' (assumendo che la colonna 'images' sia JSON)
        $service->images = $finalImages;
        $service->save();
        if ($request->has('menu_item_ids')) {
            $service->menu_items()->sync($request->menu_item_ids);
        }
        return redirect()->route('services.menu-items.create', $service->id)
            ->with('success', 'Service creato! Ora aggiungi le voci menu.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Service $service) {}



    /**
     * Update the specified resource in storage.
     */
    public function edit(Service $service)
    {
        $menuItems = ServiceMenuItem::all();
        return view('admin.service.edit', compact('service', 'menuItems'));
    }
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'available' => 'nullable|boolean',
        ]);

        $data['available'] = $request->has('available');

        $service = Service::findOrFail($id);
        $service->update($data);

        // aggiorna menu items
        if ($request->has('menu_item_ids')) {
            $service->menu_items()->sync($request->menu_item_ids);
        } else {
            $service->menu_items()->sync([]);
        }

        return redirect()
            ->route('dashboard.services.edit', $service->id)
            ->with('success', 'Servizio aggiornato con successo!');
    }

    public function uploadImages(Request $request, $id)
    {

        $request->validate([
            'file' => 'required|image|max:5120',
        ]);

        $file = $request->file('file');
        $folder = "services/{$id}";
        $disk = 'public';

        // Ottieni il servizio
        $service = Service::findOrFail($id);

        // Se già ci sono 2 immagini, svuota tutto
        if (count($service->images ?? []) >= 2) {
            // Elimina i file esistenti
            foreach ($service->images as $imagePath) {
                Storage::disk($disk)->delete($imagePath);
            }
            $service->images = []; // reset
        }

        // Salva il nuovo file
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, $disk);

        // Aggiungi il nuovo path all’array
        $images = $service->images ?? [];
        $images[] = $path;

        $service->images = $images;
        $service->save();

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => asset("storage/$path"),
        ]);
    }

    public function deleteImage(Request $request, Service $service)
    {
        $imgToDelete = $request->input('image');

        // rimuovi immagine dall'array immagini
        $images = $service->images;
        if (($key = array_search($imgToDelete, $images)) !== false) {
            unset($images[$key]);
            $images = array_values($images); // reindicizza
            $service->images = $images;
            $service->save();

            // Cancella file fisico
            $parsedUrl = parse_url($imgToDelete, PHP_URL_PATH);
            $storagePath = \Illuminate\Support\Str::after($parsedUrl, '/storage/');

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            } else {
                return response()->json(['error' => 'File non trovato: ' . $storagePath], 404);
            }

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
    public function imagesList($id)
    {

        $service = Service::findOrFail($id);
        // Se $service->images è un array di path relativi, es:
        $images = $service->images; // es: ["storage/services/img1.jpg", "storage/services/img2.jpg"]

        return response()->json(['images' => $images]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);

        // cancella le immagini dal filesystem
        $disk = 'public';
        $folder = "services/{$service->id}";

        if ($service->images && is_array($service->images)) {
            foreach ($service->images as $imagePath) {
                if (Storage::disk($disk)->exists($imagePath)) {
                    Storage::disk($disk)->delete($imagePath);
                }
            }
        }
        // Cancella la cartella del servizio e tutto il suo contenuto
        if (Storage::disk($disk)->exists($folder)) {
            Storage::disk($disk)->deleteDirectory($folder);
        }
        // elimina il record
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Servizio eliminato con successo');
    }
}
