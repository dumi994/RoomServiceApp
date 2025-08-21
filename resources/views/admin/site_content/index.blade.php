<x-admin-layout>
    <section class="content">
        <div class="container-fluid">
            <h1>Gestione Contenuti Sito</h1>

            {{-- Messaggi di successo --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Nav Tabs --}}
            <ul class="nav nav-tabs" id="contentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home-content" role="tab"
                        aria-controls="home-content" aria-selected="true">Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="page-tab" data-toggle="tab" href="#page-content" role="tab"
                        aria-controls="page-content" aria-selected="false">Page</a>
                </li>
            </ul>

            {{-- Form --}}
            <form
                action="{{ isset($site_data) && $site_data && $site_data->id ? route('dashboard.edit-site.update', $site_data->id) : route('dashboard.edit-site.store') }}"
                method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                @if (isset($site_data) && $site_data && $site_data->id)
                    @method('PUT')
                @endif

                <div class="tab-content" id="contentTabsContent">
                    {{-- HOME TAB --}}
                    <div class="tab-pane fade show active px-5" id="home-content" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-2 mt-3">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control">
                                @if (isset($site_data) && $site_data->logo)
                                    <div class="mt-2">
                                        <small>Logo attuale:</small><br>
                                        <img src="{{ asset('storage/' . $site_data->logo) }}" alt="Logo"
                                            style="max-width: 100px; max-height: 50px;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <label for="home_title">Home Title</label>
                                <input name="home_title" id="home_title"
                                    class="form-control col-12">{{ old('home_title', $site_data->home_title ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-5">
                                <label for="home_title_en">Home Title EN</label>
                                <input name="home_title_en" id="home_title_en"
                                    class="form-control col-12">{{ old('home_title_en', $site_data->home_title_en ?? '') }}</textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <label for="home_button">Home Button</label>
                                <textarea name="home_button" id="home_button" class="form-control col-12">{{ old('home_button', $site_data->home_button ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="home_button_en">Home Button EN</label>
                                <textarea name="home_button_en" id="home_button_en" class="form-control col-12">{{ old('home_button_en', $site_data->home_button_en ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6 mt-3">
                                <label for="home_bg_images">Home Background Images (multiple)</label>
                                <input type="file" name="home_bg_images[]" id="home_bg_images" class="form-control"
                                    multiple>
                                @if (isset($site_data) && $site_data->home_bg_images)
                                    <div class="mt-2">
                                        <small>Immagini attuali:</small><br>
                                        @php
                                            $images = is_string($site_data->home_bg_images)
                                                ? json_decode($site_data->home_bg_images, true)
                                                : $site_data->home_bg_images;
                                        @endphp
                                        @if (is_array($images))
                                            @foreach ($images as $image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="Background"
                                                    style="max-width: 80px; max-height: 60px; margin-right: 5px;">
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PAGE TAB --}}
                    <div class="tab-pane fade" id="page-content" role="tabpanel" aria-labelledby="page-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_title">Page Header Title</label>
                                <textarea name="page_header_title" id="page_header_title" class="form-control col-12">{{ old('page_header_title', $site_data->page_header_title ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_title_en">Page Header Title EN</label>
                                <textarea name="page_header_title_en" id="page_header_title_en" class="form-control col-12">{{ old('page_header_title_en', $site_data->page_header_title_en ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_subtitle">Page Header Subtitle</label>
                                <textarea name="page_header_subtitle" id="page_header_subtitle" class="form-control col-12">{{ old('page_header_subtitle', $site_data->page_header_subtitle ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_subtitle_en">Page Header Subtitle EN</label>
                                <textarea name="page_header_subtitle_en" id="page_header_subtitle_en" class="form-control col-12">{{ old('page_header_subtitle_en', $site_data->page_header_subtitle_en ?? '') }}</textarea>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="page_default_images">Page Default Images (multiple)</label>
                                <input type="file" name="page_default_images[]" id="page_default_images"
                                    class="form-control" multiple>
                                @if (isset($site_data) && $site_data->page_default_images)
                                    <div class="mt-2">
                                        <small>Immagini attuali:</small><br>
                                        @php
                                            $images = is_string($site_data->page_default_images)
                                                ? json_decode($site_data->page_default_images, true)
                                                : $site_data->page_default_images;
                                        @endphp
                                        @if (is_array($images))
                                            @foreach ($images as $image)
                                                <img src="{{ asset('storage/' . $image) }}" alt="Default"
                                                    style="max-width: 80px; max-height: 60px; margin-right: 5px;">
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="page_h1">Page H1</label>
                                <textarea name="page_h1" id="page_h1" class="form-control col-12">{{ old('page_h1', $site_data->page_h1 ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_h1_en">Page H1 EN</label>
                                <textarea name="page_h1_en" id="page_h1_en" class="form-control col-12">{{ old('page_h1_en', $site_data->page_h1_en ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="page_description">Page Description</label>
                                <textarea name="page_description" id="page_description" class="form-control col-12">{{ old('page_description', $site_data->page_description ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="page_description_en">Page Description EN</label>
                                <textarea name="page_description_en" id="page_description_en" class="form-control col-12">{{ old('page_description_en', $site_data->page_description_en ?? '') }}</textarea>
                            </div>
                        </div>
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="page_service_name">Page Service Name</label>
                                <textarea name="page_service_name" id="page_service_name" class="form-control col-12">{{ old('page_service_name', $site_data->page_service_name ?? '') }}</textarea>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="page_service_name_en">Page Service Name EN</label>
                                <textarea name="page_service_name_en" id="page_service_name_en" class="form-control col-12">{{ old('page_service_name_en', $site_data->page_service_name_en ?? '') }}</textarea>
                            </div>
                            <div class="col-6">
                                <label for="page_bg_image">Page Background Image</label>
                                <input type="file" name="page_bg_image" id="page_bg_image" class="form-control">
                                @if (isset($site_data) && $site_data->page_bg_image)
                                    <div class="mt-2">
                                        <small>Immagine attuale:</small><br>
                                        <img src="{{ asset('storage/' . $site_data->page_bg_image) }}"
                                            alt="Page Background" style="max-width: 100px; max-height: 75px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    {{ isset($site_data) && $site_data->id ? 'Aggiorna' : 'Crea' }}
                </button>
            </form>
        </div>
    </section>
</x-admin-layout>
