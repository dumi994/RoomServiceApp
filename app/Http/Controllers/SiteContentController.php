<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContent;

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
        $content = SiteContent::first();
        if (!$content) {
            $content = new SiteContent();
        }


        $content->home_title = $request->home_title;
        $content->home_title_en = $request->home_title_en;
        $content->home_button = $request->home_button;
        $content->home_button_en = $request->home_button_en;
        $content->page_header_title = $request->page_header_title;
        $content->page_header_title_en = $request->page_header_title_en;
        $content->page_header_subtitle = $request->page_header_subtitle;
        $content->page_header_subtitle_en = $request->page_header_subtitle_en;
        $content->page_h1 = $request->page_h1;
        $content->page_h1_en = $request->page_h1_en;
        $content->page_description = $request->page_description;
        $content->page_description_en = $request->page_description_en;
        $content->page_service_name = $request->page_service_name;
        $content->page_service_name_en = $request->page_service_name_en;
        $content->home_bg_images = $request->home_bg_images;
        $content->page_default_images = $request->page_default_images;


        //GESTIONE iMMAGINI
        $disk = 'public';

        //LOGO
        $logo_folder = "site_data/logo";

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs($logo_folder, $filename, $disk);
            $content->logo = $path;
        }


        //BACKGROUND HOME
        $home_bg_folder = "site_data/home_bg_images";
        if ($request->hasFile('home_bg_images')) {
            $homeImages = [];
            foreach ($request->file('home_bg_images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs($home_bg_folder, $filename, $disk);
                $homeImages[] = $path;
            }
            $content->home_bg_images = json_encode($homeImages);
        }

        // PAGE BG IMAGE (singolo file)
        $page_bg_folder = "site_data/page_bg";
        if ($request->hasFile('page_bg_image')) {
            $file = $request->file('page_bg_image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs($page_bg_folder, $filename, $disk);
            $content->page_bg_image = $path;
        }

        // PAGE DEFAULT IMAGES (array di file)
        $page_default_folder = "site_data/page_default_images";
        if ($request->hasFile('page_default_images')) {
            $default_paths = [];
            foreach ($request->file('page_default_images') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->storeAs($page_default_folder, $filename, $disk);
                $default_paths[] = $path;
            }
            $content->page_default_images = json_encode($default_paths);
        }
        $content->save();
        return redirect()->back()->with('success', 'Contenuto aggiornato correttamente!');
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
}
