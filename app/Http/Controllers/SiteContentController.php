<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $site_data = SiteContent::first();

        return view('admin.site_content.index', compact('site_data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Passo null, così la view capisce che è creazione
        $site_data = null;
        return view('admin.site_content.index', compact('site_data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validazione
        $validator = Validator::make($request->all(), [
            'home_title' => 'nullable|string|max:500',
            'home_title_en' => 'nullable|string|max:500',
            'home_button' => 'nullable|string|max:100',
            'home_button_en' => 'nullable|string|max:100',
            'page_header_title' => 'nullable|string|max:500',
            'page_header_title_en' => 'nullable|string|max:500',
            'page_header_subtitle' => 'nullable|string|max:500',
            'page_header_subtitle_en' => 'nullable|string|max:500',
            'page_h1' => 'nullable|string|max:200',
            'page_h1_en' => 'nullable|string|max:200',
            'page_description' => 'nullable|string',
            'page_description_en' => 'nullable|string',
            'page_service_name' => 'nullable|string|max:200',
            'page_service_name_en' => 'nullable|string|max:200',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'home_bg_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'page_bg_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'page_default_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Trova il primo record o crea nuovo
            $content = SiteContent::first();
            if (!$content) {
                $content = new SiteContent();
            }

            // Aggiorna i campi di testo
            $content->fill($request->only([
                'home_title',
                'home_title_en',
                'home_button',
                'home_button_en',
                'page_header_title',
                'page_header_title_en',
                'page_header_subtitle',
                'page_header_subtitle_en',
                'page_h1',
                'page_h1_en',
                'page_description',
                'page_description_en',
                'page_service_name',
                'page_service_name_en'
            ]));

            // Gestione immagini
            $this->handleImageUploads($request, $content);

            $content->save();

            $message = $content->wasRecentlyCreated ?
                'Contenuto creato correttamente!' :
                'Contenuto aggiornato correttamente!';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Errore durante il salvataggio: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        // Prendi il primo record o null
        $site_data = SiteContent::first();
        return view('admin.site_content.index', compact('site_data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Reindirizza al metodo store che gestisce sia create che update
        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $content = SiteContent::findOrFail($id);

            // Elimina tutte le immagini associate
            $this->deleteAllImages($content);

            $content->delete();

            return redirect()->route('admin.site-content.index')
                ->with('success', 'Contenuto eliminato correttamente!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Errore durante l\'eliminazione: ' . $e->getMessage());
        }
    }

    /**
     * Gestisce l'upload di tutte le immagini
     */
    private function handleImageUploads(Request $request, SiteContent $content)
    {
        $disk = 'public';

        // LOGO
        if ($request->hasFile('logo')) {
            // Elimina il vecchio logo se esiste
            if ($content->logo && Storage::disk($disk)->exists($content->logo)) {
                Storage::disk($disk)->delete($content->logo);
            }

            $content->logo = $this->storeImage(
                $request->file('logo'),
                'site_data/logo',
                $disk
            );
        }

        // BACKGROUND HOME (multipli)
        if ($request->hasFile('home_bg_images')) {
            // Elimina le vecchie immagini se esistono
            if ($content->home_bg_images) {
                $oldImages = json_decode($content->home_bg_images, true) ?: [];
                foreach ($oldImages as $oldImage) {
                    if (Storage::disk($disk)->exists($oldImage)) {
                        Storage::disk($disk)->delete($oldImage);
                    }
                }
            }

            $homeImages = [];
            foreach ($request->file('home_bg_images') as $file) {
                $homeImages[] = $this->storeImage($file, 'site_data/home_bg_images', $disk);
            }
            $content->home_bg_images = json_encode($homeImages);
        }

        // PAGE BG IMAGE (singolo)
        if ($request->hasFile('page_bg_image')) {
            // Elimina la vecchia immagine se esiste
            if ($content->page_bg_image && Storage::disk($disk)->exists($content->page_bg_image)) {
                Storage::disk($disk)->delete($content->page_bg_image);
            }

            $content->page_bg_image = $this->storeImage(
                $request->file('page_bg_image'),
                'site_data/page_bg',
                $disk
            );
        }

        // PAGE DEFAULT IMAGES (multipli)
        if ($request->hasFile('page_default_images')) {
            // Elimina le vecchie immagini se esistono
            if ($content->page_default_images) {
                $oldImages = json_decode($content->page_default_images, true) ?: [];
                foreach ($oldImages as $oldImage) {
                    if (Storage::disk($disk)->exists($oldImage)) {
                        Storage::disk($disk)->delete($oldImage);
                    }
                }
            }

            $defaultImages = [];
            foreach ($request->file('page_default_images') as $file) {
                $defaultImages[] = $this->storeImage($file, 'site_data/page_default_images', $disk);
            }
            $content->page_default_images = json_encode($defaultImages);
        }
    }

    /**
     * Salva un'immagine e restituisce il path
     */
    private function storeImage($file, $folder, $disk)
    {
        // Genera un nome file unico per evitare conflitti
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs($folder, $filename, $disk);
    }

    /**
     * Elimina tutte le immagini associate al contenuto
     */
    private function deleteAllImages(SiteContent $content)
    {
        $disk = 'public';

        // Logo
        if ($content->logo && Storage::disk($disk)->exists($content->logo)) {
            Storage::disk($disk)->delete($content->logo);
        }

        // Home background images
        if ($content->home_bg_images) {
            $images = json_decode($content->home_bg_images, true) ?: [];
            foreach ($images as $image) {
                if (Storage::disk($disk)->exists($image)) {
                    Storage::disk($disk)->delete($image);
                }
            }
        }

        // Page background image
        if ($content->page_bg_image && Storage::disk($disk)->exists($content->page_bg_image)) {
            Storage::disk($disk)->delete($content->page_bg_image);
        }

        // Page default images
        if ($content->page_default_images) {
            $images = json_decode($content->page_default_images, true) ?: [];
            foreach ($images as $image) {
                if (Storage::disk($disk)->exists($image)) {
                    Storage::disk($disk)->delete($image);
                }
            }
        }
    }
}
