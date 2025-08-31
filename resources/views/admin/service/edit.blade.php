<x-admin-layout>
    <div class="container mt-5" style="max-width: 720px;">
        <h2 class="mb-4 fw-semibold text-dark text-center">Modifica {{ $service->name }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="my-4">
            <div id="dropzone-container"
                style="{{ isset($service->images) && count($service->images) >= 2 ? 'display:none;' : '' }}">
                <h5 class="mt-5">Carica immagini</h5>
                <form action="{{ route('dashboard.services.upload.images', $service->id) }}" method="POST"
                    enctype="multipart/form-data" class="dropzone" id="dropzone-form">
                    @csrf
                </form>
            </div>

            <!-- Contenitore unico per tutte le immagini -->
            <div id="all-images" class="row mt-2">
                @if (!empty($service->images) && is_iterable($service->images))
                    @foreach ($service->images as $index => $image)
                        <div class="col-6 existing-image">
                            <div class="edit-service-img shadow rounded"
                                style="background-image: url('{{ isset($image) ? asset('storage/' . ltrim(preg_replace('#^/?storage/#', '', $image), '/')) : asset('images/default1.jpg') }}')">
                                <span data-index="{{ $index }}" data-image="{{ $image }}"
                                    class="material-symbols-outlined delete-icon">
                                    delete
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <form action="{{ route('dashboard.services.update', $service->id) }}" method="POST"
            class="p-4 border rounded shadow-sm bg-white">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" id="name" value="{{ old('name', $service->name) }}" name="name"
                    class="form-control form-control-lg" placeholder="Es. Room Service" required>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icona (classe <a href="https://fonts.google.com/icons"
                        target="_blank">Google Icon</a> )</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon', $service->icon) }}"
                    class="form-control form-control-lg" placeholder="Es. fa-solid fa-bell">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="4" class="form-control form-control-lg"
                    placeholder="Scrivi una descrizione del servizio...">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="available" id="available" value="1"
                    {{ old('available', $service->available) ? 'checked' : '' }}>
                <label class="form-check-label" for="available">Disponibile</label>
            </div>

            <label for="menu_items">Menu Items:</label>
            <select name="menu_item_ids[]" multiple>
                @foreach ($menuItems as $item)
                    <option value="{{ $item->id }}"
                        {{ isset($service) && $service->menu_items->contains($item->id) ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard.services.index') }}" class="text-secondary text-decoration-none">
                    ← Torna ai servizi
                </a>
                <button type="submit" class="btn btn-dark px-4 py-2">Salva</button>
            </div>
        </form>
    </div>

    @section('scripts')
        <script>
            Dropzone.options.dropzoneForm = {
                paramName: 'file',
                maxFilesize: 5,
                maxFiles: 2,
                uploadMultiple: false,
                parallelUploads: 1,
                acceptedFiles: 'image/*',
                dictDefaultMessage: 'Trascina qui le immagini o clicca per caricarle',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    console.log("Immagine caricata con successo");
                    // Rimuovi il file dalla dropzone dopo il caricamento
                    this.removeFile(file);
                },
                error: function(file, response) {
                    console.log("Errore nel caricamento");
                },
                queuecomplete: function() {
                    // Aggiorna solo le nuove immagini
                    refreshImages();
                }
            };

            // Funzione per aggiornare le immagini
            function refreshImages() {
                fetch(`/dashboard/services/{{ $service->id }}/images`)
                    .then(res => {
                        if (!res.ok) throw new Error('Network response was not ok');
                        return res.json();
                    })
                    .then(data => {
                        const container = document.getElementById("all-images");

                        // Trova le immagini esistenti nel DOM
                        const existingImages = [];
                        container.querySelectorAll('.existing-image').forEach(el => {
                            const img = el.querySelector('.delete-icon').getAttribute('data-image');
                            existingImages.push(img);
                        });

                        // Aggiungi solo le nuove immagini
                        data.images.forEach((image, index) => {
                            if (!existingImages.includes(image)) {
                                const newImageHtml = `
                                <div class="col-6 new-image">
                                    <div class="edit-service-img shadow rounded" 
                                         style="background-image: url('${image ? '/' + image : '/images/default1.jpg'}')">
                                        <span data-index="${index}" 
                                              data-image="${image}" 
                                              class="material-symbols-outlined delete-icon">
                                            delete
                                        </span>
                                    </div>
                                </div>
                            `;
                                container.insertAdjacentHTML('beforeend', newImageHtml);
                            }
                        });

                        toggleDropzone();
                    })
                    .catch(err => console.error("Errore fetch immagini:", err));
            }

            // Event delegation per gestire i click sui delete icons
            $(document).on('click', '.delete-icon', function() {
                const image = $(this).data('image');
                const serviceId = @json($service->id);
                const $imgContainer = $(this).closest('.col-6');

                if (!confirm('Sei sicuro di voler eliminare questa immagine?')) return;

                $.ajax({
                    url: `/dashboard/services/${serviceId}/delete-images`,
                    type: 'DELETE',
                    data: JSON.stringify({
                        image: image
                    }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            $imgContainer.remove();
                            toggleDropzone();
                        } else {
                            alert('Errore nell\'eliminazione dell\'immagine');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Errore nella chiamata AJAX: ' + error);
                    }
                });
            });

            // Toggle Dropzone visibility
            function toggleDropzone() {
                const totalImages = document.querySelectorAll('.edit-service-img').length;
                const dropzoneContainer = document.getElementById("dropzone-container");

                if (totalImages >= 2) {
                    dropzoneContainer.style.display = "none";
                } else {
                    dropzoneContainer.style.display = "block";
                }
            }

            // Inizializza al load
            document.addEventListener("DOMContentLoaded", toggleDropzone);
        </script>
    @endsection
</x-admin-layout>
