<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContent;
use Illuminate\Support\Facades\Storage;

class SiteContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $site_data =  SiteContent::first();
        return view('admin.site_content.index', compact('site_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // passo null, così la view capisce che è creazione
        return view('admin.site_content.index')->with('site_data', null);
    }

    /**
     * Store a newly created resource in storage.
     */
    /*  public function store(Request $request)
    {
        dd($request->all());
    } */
    public function store(Request $request)
    {
        $content = SiteContent::first() ?: new SiteContent();

        // 🔹 Campi testuali
        $content->home_title              = $request->home_title;
        $content->home_title_en           = $request->home_title_en;
        $content->home_button             = $request->home_button;
        $content->home_button_en          = $request->home_button_en;
        $content->page_header_title       = $request->page_header_title;
        $content->page_header_title_en    = $request->page_header_title_en;
        $content->page_header_subtitle    = $request->page_header_subtitle;
        $content->page_header_subtitle_en = $request->page_header_subtitle_en;
        $content->page_h1                 = $request->page_h1;
        $content->page_h1_en              = $request->page_h1_en;
        $content->page_description        = $request->page_description;
        $content->page_description_en     = $request->page_description_en;
        $content->page_service_name       = $request->page_service_name;
        $content->page_service_name_en    = $request->page_service_name_en;

        $disk  = 'public';
        $limit = 2;

        // 🔹 LOGO (singolo - sostituisce se inviato)
        if ($request->hasFile('logo')) {
            if (!empty($content->logo) && Storage::disk($disk)->exists($content->logo)) {
                Storage::disk($disk)->delete($content->logo);
            }
            $file     = $request->file('logo');
            $filename = $file->getClientOriginalName();
            $path     = $file->storeAs('site_data/logo', $filename, $disk);
            $content->logo = $path;
        }

        // 🔹 PAGE BG IMAGE (singolo - sostituisce se inviato)
        if ($request->hasFile('page_bg_image')) {
            if (!empty($content->page_bg_image) && Storage::disk($disk)->exists($content->page_bg_image)) {
                Storage::disk($disk)->delete($content->page_bg_image);
            }
            $file     = $request->file('page_bg_image');
            $filename = $file->getClientOriginalName();
            $path     = $file->storeAs('site_data/page_bg', $filename, $disk);
            $content->page_bg_image = $path;
        }

        // helper inline per array immagini (append prima, poi replace)
        $processImages = function (?string $existingJson, array $uploadedFiles, string $folder) use ($disk, $limit) {
            $existing = json_decode($existingJson ?? '[]', true) ?: [];
            $existing = array_values(array_slice($existing, 0, $limit)); // normalizza max 2

            // 1) APPEND: riempi gli slot liberi fino a limit
            $remaining = $limit - count($existing);
            $appendFiles = array_slice($uploadedFiles, 0, $remaining);

            foreach ($appendFiles as $file) {
                $filename = $file->getClientOriginalName();
                $path     = $file->storeAs($folder, $filename, $disk);
                $existing[] = $path;
            }

            // 2) REPLACE: se avanzano file e array è pieno, sostituisci da slot 0
            $leftover = array_slice($uploadedFiles, $remaining);
            $idx = 0;
            foreach ($leftover as $file) {
                if ($idx >= $limit) break;
                // elimina il vecchio file nello slot che sostituiamo
                if (isset($existing[$idx]) && $existing[$idx] && Storage::disk($disk)->exists($existing[$idx])) {
                    Storage::disk($disk)->delete($existing[$idx]);
                }
                $filename = $file->getClientOriginalName();
                $path     = $file->storeAs($folder, $filename, $disk);
                $existing[$idx] = $path;
                $idx++;
            }

            // Assicura esattamente max 2
            $existing = array_values(array_slice($existing, 0, $limit));

            return json_encode($existing);
        };

        // 🔹 HOME BACKGROUND IMAGES (append prima, poi replace; MAX 2)
        if ($request->hasFile('home_bg_images')) {
            $files = $request->file('home_bg_images');
            $content->home_bg_images = $processImages($content->home_bg_images, $files, 'site_data/home_bg_images');
        }

        // 🔹 PAGE DEFAULT IMAGES (append prima, poi replace; MAX 2)
        if ($request->hasFile('page_default_images')) {
            $files = $request->file('page_default_images');
            $content->page_default_images = $processImages($content->page_default_images, $files, 'site_data/page_default_images');
        }

        // 🔹 Fallback NOT NULL
        if ($content->logo === null)               $content->logo = '';
        if ($content->page_bg_image === null)      $content->page_bg_image = '';
        if ($content->home_bg_images === null)     $content->home_bg_images = json_encode([]);
        if ($content->page_default_images === null) $content->page_default_images = json_encode([]);

        $content->save();

        return back()->with('success', 'Contenuto aggiornato correttamente!');
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
    public function edit()
    {
        // Prendi il primo record o null
        $content = SiteContent::first();

        return view('admin.site_content.form', compact('site_data'));
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

    public function deleteImage(Request $request)
    {
        try {
            $content = SiteContent::first();
            if (!$content) {
                return response()->json(['success' => false, 'message' => 'Contenuto non trovato'], 404);
            }

            $imageType  = $request->input('type');
            $imagePath  = $request->input('image');
            $imageIndex = $request->input('index');

            \Log::debug('deleteImage payload', compact('imageType', 'imagePath', 'imageIndex'));

            switch ($imageType) {
                case 'logo':
                    if ($content->logo && Storage::disk('public')->exists($content->logo)) {
                        Storage::disk('public')->delete($content->logo);
                    }
                    // Se colonna NOT NULL, NON usare null
                    $content->logo = ''; // <- stringa vuota
                    break;

                case 'page_bg_image':
                    if ($content->page_bg_image && Storage::disk('public')->exists($content->page_bg_image)) {
                        Storage::disk('public')->delete($content->page_bg_image);
                    }
                    $content->page_bg_image = ''; // <- stringa vuota
                    break;

                case 'home_bg_images':
                    $images = json_decode($content->home_bg_images, true) ?: [];
                    if (is_numeric($imageIndex) && isset($images[(int)$imageIndex])) {
                        $toDelete = $images[(int)$imageIndex];
                        if ($toDelete && Storage::disk('public')->exists($toDelete)) {
                            Storage::disk('public')->delete($toDelete);
                        }
                        unset($images[(int)$imageIndex]);
                        $images = array_values($images);
                        // se colonna NOT NULL, salva sempre JSON valido
                        $content->home_bg_images = json_encode($images ?: []);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Indice immagine non valido'], 422);
                    }
                    break;

                case 'page_default_images':
                    $images = json_decode($content->page_default_images, true) ?: [];
                    if (is_numeric($imageIndex) && isset($images[(int)$imageIndex])) {
                        $toDelete = $images[(int)$imageIndex];
                        if ($toDelete && Storage::disk('public')->exists($toDelete)) {
                            Storage::disk('public')->delete($toDelete);
                        }
                        unset($images[(int)$imageIndex]);
                        $images = array_values($images);
                        $content->page_default_images = json_encode($images ?: []);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Indice immagine non valido'], 422);
                    }
                    break;

                default:
                    return response()->json(['success' => false, 'message' => 'Tipo immagine non valido'], 422);
            }

            $dirty = $content->getDirty(); // utile per debug
            \Log::debug('deleteImage dirty', $dirty);

            $content->save();

            // opzionale: ritorna i nuovi valori per aggiornare la UI senza ricaricare
            return response()->json([
                'success' => true,
                'message' => 'Immagine eliminata con successo',
                'data' => [
                    'logo' => $content->logo,
                    'page_bg_image' => $content->page_bg_image,
                    'home_bg_images' => $content->home_bg_images,
                    'page_default_images' => $content->page_default_images,
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('deleteImage error', ['ex' => $e, 'line' => $e->getLine(), 'file' => $e->getFile()]);
            return response()->json(['success' => false, 'message' => 'Errore: ' . $e->getMessage()], 500);
        }
    }
}
