<x-admin-layout>
    <section class="content">
        <div class="container-fluid">
            <h1>Gestione Contenuti Sito</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            {{-- Form - USA SEMPRE STORE --}}
            <form action="{{ route('dashboard.edit-site.store') }}" method="POST" enctype="multipart/form-data"
                class="mt-3">
                @csrf
                {{-- RIMOSSO @method('PUT') --}}

                <div class="tab-content" id="contentTabsContent">
                    {{-- HOME TAB --}}
                    <div class="tab-pane fade show active px-5" id="home-content" role="tabpanel"
                        aria-labelledby="home-tab">

                        {{-- LOGO SECTION --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="logo" class="form-label font-weight-bold">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control">

                                @if (isset($site_data) && $site_data->logo)
                                    <div class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <img src="{{ asset('storage/' . $site_data->logo) }}" alt="Logo"
                                                class="img-thumbnail" style="max-width: 150px; max-height: 100px;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                                data-type="logo" data-image="{{ $site_data->logo }}">
                                                <i class="fa fa-trash"></i> Elimina Logo
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="home_title">Home Title</label>
                                <textarea name="home_title" id="home_title" class="form-control">{{ old('home_title', $site_data->home_title ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="home_title_en">Home Title EN</label>
                                <textarea name="home_title_en" id="home_title_en" class="form-control">{{ old('home_title_en', $site_data->home_title_en ?? '') }}</textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <label for="home_button">Home Button</label>
                                <textarea name="home_button" id="home_button" class="form-control">{{ old('home_button', $site_data->home_button ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="home_button_en">Home Button EN</label>
                                <textarea name="home_button_en" id="home_button_en" class="form-control">{{ old('home_button_en', $site_data->home_button_en ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- HOME BACKGROUND IMAGES --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="home_bg_images" class="form-label font-weight-bold">Home Background
                                    Images</label>
                                <input type="file" name="home_bg_images[]" id="home_bg_images" class="form-control"
                                    multiple>

                                @if (isset($site_data) && $site_data->home_bg_images)
                                    <div class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                        <h6>Immagini attuali:</h6>
                                        <div class="row" id="home-bg-images-container">
                                            @php
                                                $images = is_string($site_data->home_bg_images)
                                                    ? json_decode($site_data->home_bg_images, true)
                                                    : $site_data->home_bg_images;
                                            @endphp
                                            @if (is_array($images))
                                                @foreach ($images as $index => $image)
                                                    <div class="col-md-4 col-sm-6 mb-3">
                                                        <div class="card">
                                                            <img src="{{ asset('storage/' . $image) }}" alt="Background"
                                                                class="card-img-top"
                                                                style="height: 120px; object-fit: cover;">
                                                            <div class="card-body p-2 text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm delete-image-btn"
                                                                    data-type="home_bg_images"
                                                                    data-image="{{ $image }}"
                                                                    data-index="{{ $index }}">
                                                                    <i class="fa fa-trash"></i> Elimina
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- PAGE TAB --}}
                    <div class="tab-pane fade px-5" id="page-content" role="tabpanel" aria-labelledby="page-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_title">Page Header Title</label>
                                <textarea name="page_header_title" id="page_header_title" class="form-control">{{ old('page_header_title', $site_data->page_header_title ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_title_en">Page Header Title EN</label>
                                <textarea name="page_header_title_en" id="page_header_title_en" class="form-control">{{ old('page_header_title_en', $site_data->page_header_title_en ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_subtitle">Page Header Subtitle</label>
                                <textarea name="page_header_subtitle" id="page_header_subtitle" class="form-control">{{ old('page_header_subtitle', $site_data->page_header_subtitle ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_header_subtitle_en">Page Header Subtitle EN</label>
                                <textarea name="page_header_subtitle_en" id="page_header_subtitle_en" class="form-control">{{ old('page_header_subtitle_en', $site_data->page_header_subtitle_en ?? '') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- PAGE DEFAULT IMAGES --}}
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="page_default_images" class="form-label font-weight-bold">Page Default
                                    Images</label>
                                <input type="file" name="page_default_images[]" id="page_default_images"
                                    class="form-control" multiple>

                                @if (isset($site_data) && $site_data->page_default_images)
                                    <div class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                        <h6>Immagini attuali:</h6>
                                        <div class="row" id="page-default-images-container">
                                            @php
                                                $images = is_string($site_data->page_default_images)
                                                    ? json_decode($site_data->page_default_images, true)
                                                    : $site_data->page_default_images;
                                            @endphp
                                            @if (is_array($images))
                                                @foreach ($images as $index => $image)
                                                    <div class="col-md-4 col-sm-6 mb-3">
                                                        <div class="card">
                                                            <img src="{{ asset('storage/' . $image) }}"
                                                                alt="Default" class="card-img-top"
                                                                style="height: 120px; object-fit: cover;">
                                                            <div class="card-body p-2 text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm delete-image-btn"
                                                                    data-type="page_default_images"
                                                                    data-image="{{ $image }}"
                                                                    data-index="{{ $index }}">
                                                                    <i class="fa fa-trash"></i> Elimina
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="page_h1">Page H1</label>
                                <textarea name="page_h1" id="page_h1" class="form-control">{{ old('page_h1', $site_data->page_h1 ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_h1_en">Page H1 EN</label>
                                <textarea name="page_h1_en" id="page_h1_en" class="form-control">{{ old('page_h1_en', $site_data->page_h1_en ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="page_description">Page Description</label>
                                <textarea name="page_description" id="page_description" class="form-control">{{ old('page_description', $site_data->page_description ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="page_description_en">Page Description EN</label>
                                <textarea name="page_description_en" id="page_description_en" class="form-control">{{ old('page_description_en', $site_data->page_description_en ?? '') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-3">

                        {{-- PAGE BACKGROUND IMAGE --}}
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="page_bg_image" class="form-label font-weight-bold">Page Background
                                    Image</label>
                                <input type="file" name="page_bg_image" id="page_bg_image" class="form-control">

                                @if (isset($site_data) && $site_data->page_bg_image)
                                    <div class="mt-3 p-3 border rounded" style="background-color: #f8f9fa;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <img src="{{ asset('storage/' . $site_data->page_bg_image) }}"
                                                alt="Page Background" class="img-thumbnail"
                                                style="max-width: 200px; max-height: 150px;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image-btn"
                                                data-type="page_bg_image"
                                                data-image="{{ $site_data->page_bg_image }}">
                                                <i class="fa fa-trash"></i> Elimina Immagine
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="page_service_name">Page Service Name</label>
                                <textarea name="page_service_name" id="page_service_name" class="form-control">{{ old('page_service_name', $site_data->page_service_name ?? '') }}</textarea>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="page_service_name_en">Page Service Name EN</label>
                                <textarea name="page_service_name_en" id="page_service_name_en" class="form-control">{{ old('page_service_name_en', $site_data->page_service_name_en ?? '') }}</textarea>
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

    @section('scripts')
        <script>
            (function($) {
                // Evita errori se qualche script chiama .sortable() senza jQuery UI
                if (!$.fn.sortable) {
                    $.fn.sortable = function() {
                        return this;
                    };
                }

                // Header CSRF per tutte le chiamate AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).on('click', '.delete-image-btn', function(e) {
                    e.preventDefault();

                    if (!confirm('Sei sicuro di voler eliminare questa immagine?')) return;

                    const $btn = $(this);
                    const imageType = $btn.data(
                        'type'); // 'logo' | 'page_bg_image' | 'home_bg_images' | 'page_default_images'
                    const imagePath = $btn.data('image') || '';
                    const imageIndex = ($btn.data('index') !== undefined) ? $btn.data('index') : '';

                    // UI: disabilita bottone durante la richiesta
                    const oldHtml = $btn.html();
                    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Eliminando...');

                    // COSTRUISCO QUERYSTRING (alcuni server ignorano il body nei DELETE)
                    const baseUrl = '{{ route('dashboard.edit-site.delete-image') }}';
                    const qs = new URLSearchParams({
                        type: imageType,
                        image: imagePath,
                        index: imageIndex
                    }).toString();

                    $.ajax({
                        url: baseUrl + '?' + qs,
                        type: 'DELETE',
                        success: function(response) {
                            if (response && response.success) {
                                // Rimuovi l'elemento dal DOM
                                if (imageType === 'logo' || imageType === 'page_bg_image') {
                                    $btn.closest('.border').fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                } else {
                                    $btn.closest('.col-md-4, .col-sm-6').fadeOut(300, function() {
                                        $(this).remove();
                                    });
                                }
                                showAlert('Immagine eliminata con successo!', 'success');
                            } else {
                                showAlert(response && response.message ? response.message :
                                    'Errore nell\'eliminazione dell\'immagine', 'danger');
                                $btn.prop('disabled', false).html(oldHtml);
                            }
                        },
                        error: function(xhr) {
                            let msg = 'Errore nella chiamata AJAX.';
                            try {
                                const json = xhr.responseJSON;
                                if (json && json.message) msg = json.message;
                            } catch (e) {}
                            showAlert(msg, 'danger');
                            $btn.prop('disabled', false).html(oldHtml);
                        }
                    });
                });

                function showAlert(message, type) {
                    const alertHtml = `
      <div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>`;
                    $('.container-fluid h1').after(alertHtml);
                    setTimeout(() => {
                        $('.alert').fadeOut();
                    }, 4000);
                }
            })(jQuery);
        </script>
    @endsection

</x-admin-layout>
