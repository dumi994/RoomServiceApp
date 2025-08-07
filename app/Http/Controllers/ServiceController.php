<?php

namespace App\Http\Controllers;

use App\Models\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        die($request->all());
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
    public function show(Service $service) {}



    /**
     * Update the specified resource in storage.
     */
    public function edit(Service $service)
    {
        return view('admin.service.edit', compact('service'));
    }
    public function update(Request $request, string $id)
    {
        //
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
        //
    }
}
